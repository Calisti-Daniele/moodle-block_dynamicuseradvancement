<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace block_dynamicuseradvancement\output;

use renderable;
use templatable;
use renderer_base;
use moodle_url;
use core_user;
use stdClass;

/**
 * Calcola lo stato di avanzamento e lo trasforma in card con badge.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements renderable, templatable {
    /** @var string Componente per get_string. */
    const C = 'block_dynamicuseradvancement';

    /** @var stdClass Il corso. */
    protected stdClass $course;

    /** @var int Utente. */
    protected int $userid;

    /** @var stdClass Configurazione dell'istanza. */
    protected stdClass $config;

    /**
     * Costruttore.
     *
     * @param stdClass      $course Corso.
     * @param int           $userid Utente.
     * @param stdClass|null $config Configurazione.
     */
    public function __construct(stdClass $course, int $userid, ?stdClass $config = null) {
        $this->course = $course;
        $this->userid = $userid;
        $this->config = $config ?? new stdClass();
    }

    /**
     * Contesto per il template.
     *
     * @param renderer_base $output Renderer.
     * @return array<string, mixed>
     */
    public function export_for_template(renderer_base $output): array {
        $c = $this->config;
        $heading = !empty($c->title) ? format_string($c->title) : format_string($this->course->fullname);

        $milestones = $this->collect_milestones($c);
        if (empty($milestones)) {
            return ['empty' => true, 'heading' => $heading];
        }

        $total = count($milestones);
        $achieved = 0;
        foreach ($milestones as $m) {
            if ($m['done']) {
                $achieved++;
            }
        }
        $percent = (int)round(($achieved / $total) * 100);
        $iscomplete = ($achieved === $total);

        // Indice del primo traguardo non completato.
        $firstopen = null;
        foreach ($milestones as $i => $m) {
            if (!$m['done'] && $firstopen === null) {
                $firstopen = $i;
            }
        }

        // Card.
        $cards = [];
        foreach ($milestones as $i => $m) {
            if ($m['done']) {
                $state = 'done';
                $badge = get_string('badgedone', self::C);
            } else if ($i === $firstopen) {
                $state = 'current';
                $badge = get_string('badgecurrent', self::C);
            } else {
                $state = 'todo';
                $badge = get_string('badgetodo', self::C);
            }
            $cards[] = [
                'label'      => $m['label'],
                'detail'     => $m['detail'],
                'isaccess'   => ($m['type'] === 'access'),
                'isgrade'    => ($m['type'] === 'grade'),
                'iscert'     => ($m['type'] === 'cert'),
                'isdone'     => ($state === 'done'),
                'iscurrent'  => ($state === 'current'),
                'istodo'     => ($state === 'todo'),
                'badgelabel' => $badge,
                'url'        => $m['url'],
                'hasurl'     => ($state === 'current' && $m['url'] !== ''),
            ];
        }

        [$statustitle, $statussub] = $this->status_message($achieved, $total, $percent);

        // Scadenza.
        $certdate = $this->config->_certdate ?? null;
        $showexpiry = !empty($c->showexpiry) && !empty($certdate);
        $expirydata = [];
        if ($showexpiry) {
            $years = (int)($c->renewyears ?? 5);
            $expiry = strtotime("+{$years} years", $certdate);
            $days = (int)ceil(($expiry - time()) / DAYSECS);
            $expirydata = [
                'updatedue'   => get_string('updatedue', self::C, max(0, $days)),
                'updatevalid' => get_string('updatevaliduntil', self::C, userdate($expiry, '%d/%m/%Y')),
            ];
        }

        return array_merge([
            'heading'      => $heading,
            'iscomplete'   => $iscomplete,
            'percent'      => $percent,
            'statustitle'  => $statustitle,
            'statussub'    => $statussub,
            'cards'        => $cards,
            'gonow'        => get_string('gonow', self::C),
            'certobtained' => get_string('certobtained', self::C),
            'showexpiry'   => $showexpiry,
        ], $expirydata);
    }

    /**
     * Raccoglie i traguardi abilitati.
     *
     * @param stdClass $c Config.
     * @return array<int, array<string, mixed>>
     */
    protected function collect_milestones(stdClass $c): array {
        $milestones = [];

        if (!empty($c->showaccess)) {
            [$done, $detail] = $this->check_access();
            $milestones[] = [
                'type'   => 'access',
                'label'  => !empty($c->accesslabel) ? $c->accesslabel : get_string('cpaccess', self::C),
                'done'   => $done,
                'detail' => $detail,
                'url'    => (string)(new moodle_url('/course/view.php', ['id' => $this->course->id])),
            ];
        }

        if (!empty($c->showgrade)) {
            $cmid = (int)($c->gradecmid ?? 0);
            [$done, $detail] = $this->check_grade($cmid, (float)($c->gradethreshold ?? 0));
            $milestones[] = [
                'type'   => 'grade',
                'label'  => !empty($c->gradelabel) ? $c->gradelabel : get_string('cpexam', self::C),
                'done'   => $done,
                'detail' => $detail,
                'url'    => $this->cm_url($cmid),
            ];
        }

        if (!empty($c->showcert)) {
            $certid = (int)($c->certid ?? 0);
            $src = [
                'table'   => $c->certtable ?? 'simplecertificate_issues',
                'certcol' => $c->certcol ?? 'certificateid',
                'usercol' => $c->certusercol ?? 'userid',
                'datecol' => $c->certdatecol ?? 'timecreated',
            ];
            [$done, $detail, $certdate] = $this->check_certificate($certid, $src);
            $this->config->_certdate = $certdate;
            $milestones[] = [
                'type'   => 'cert',
                'label'  => !empty($c->certlabel) ? $c->certlabel : get_string('cpcertificate', self::C),
                'done'   => $done,
                'detail' => $detail,
                'url'    => $this->cert_url($certid),
            ];
        }

        return $milestones;
    }

    /**
     * Titolo e sottotitolo dello stato.
     *
     * @param int $achieved Completati.
     * @param int $total    Totali.
     * @param int $percent  Percentuale.
     * @return array{0: string, 1: string}
     */
    protected function status_message(int $achieved, int $total, int $percent): array {
        $user = core_user::get_user($this->userid, 'firstname');
        $firstname = $user ? $user->firstname : '';

        if ($achieved === $total) {
            return [get_string('statuscomplete', self::C), get_string('statuscompletesub', self::C)];
        }
        if ($achieved === 0) {
            $key = 'statusstart';
        } else if (($total - $achieved) === 1) {
            $key = 'statusalmost';
        } else {
            $key = 'statusprogress';
        }
        $sub = get_string(
            'progresssummary',
            self::C,
            ['done' => $achieved, 'total' => $total, 'percent' => $percent]
        );
        return [get_string($key, self::C, $firstname), $sub];
    }

    /**
     * Accesso al corso (con fallback sui log).
     *
     * @return array{0: bool, 1: string}
     */
    protected function check_access(): array {
        global $DB;
        $time = $DB->get_field(
            'user_lastaccess',
            'timeaccess',
            ['courseid' => $this->course->id, 'userid' => $this->userid]
        );
        if (empty($time) && $DB->get_manager()->table_exists('logstore_standard_log')) {
            $time = $DB->get_field_sql(
                "SELECT MIN(timecreated)
                   FROM {logstore_standard_log}
                  WHERE courseid = :courseid AND userid = :userid",
                ['courseid' => $this->course->id, 'userid' => $this->userid]
            );
        }
        if (!empty($time)) {
            return [true, userdate($time, '%d/%m/%Y')];
        }
        return [false, get_string('statuspending', self::C)];
    }

    /**
     * Voto >= soglia.
     *
     * @param int   $cmid      Course module id.
     * @param float $threshold Soglia.
     * @return array{0: bool, 1: string}
     */
    protected function check_grade(int $cmid, float $threshold): array {
        global $CFG;
        require_once($CFG->dirroot . '/lib/gradelib.php');

        if (empty($cmid)) {
            return [false, get_string('statusnotset', self::C)];
        }
        $cm = get_coursemodule_from_id('', $cmid, 0, false, IGNORE_MISSING);
        if (!$cm) {
            return [false, get_string('statusnotset', self::C)];
        }
        $grades = grade_get_grades($this->course->id, 'mod', $cm->modname, $cm->instance, $this->userid);
        $item = reset($grades->items);
        $grade = ($item && isset($item->grades[$this->userid])) ? $item->grades[$this->userid]->grade : null;
        if ($grade === null || $grade === '') {
            return [false, get_string('statuspending', self::C)];
        }
        $grade = (float)$grade;
        $grademax = ($item && isset($item->grademax)) ? (float)$item->grademax : 0.0;
        $detail = get_string(
            'gradedetail',
            self::C,
            ['grade' => format_float($grade, 1), 'max' => format_float($grademax, 1)]
        );
        return [$grade >= $threshold, $detail];
    }

    /**
     * Emissione attestato da una tabella configurabile (simplecertificate moddata).
     *
     * Tabella e colonne arrivano dalla configurazione dell'istanza. Vengono
     * validate rigorosamente (solo identificatori SQL sicuri) e verificate
     * nello schema del database prima di essere usate nella query, per
     * escludere ogni rischio di SQL injection.
     *
     * @param int                   $certid Istanza del certificato scelto.
     * @param array<string, string> $src    Origine dati: table, certcol, usercol, datecol.
     * @return array{0: bool, 1: string, 2: int|null} Stato, dettaglio, data emissione.
     */
    protected function check_certificate(int $certid, array $src): array {
        global $DB;

        if (empty($certid)) {
            return [false, get_string('statusnotset', self::C), null];
        }

        $table   = strtolower(trim((string)($src['table'] ?? '')));
        $certcol = strtolower(trim((string)($src['certcol'] ?? '')));
        $usercol = strtolower(trim((string)($src['usercol'] ?? '')));
        $datecol = strtolower(trim((string)($src['datecol'] ?? '')));

        // Solo identificatori SQL sicuri: lettera iniziale, poi lettere/numeri/underscore.
        $safe = '/^[a-z][a-z0-9_]*$/';
        foreach ([$table, $certcol, $usercol, $datecol] as $name) {
            if (!preg_match($safe, $name)) {
                return [false, get_string('statusnotavailable', self::C), null];
            }
        }

        // La tabella e le colonne devono esistere davvero.
        if (!$DB->get_manager()->table_exists($table)) {
            return [false, get_string('statusnotavailable', self::C), null];
        }
        $cols = $DB->get_columns($table);
        if (!isset($cols[$certcol]) || !isset($cols[$usercol]) || !isset($cols[$datecol])) {
            return [false, get_string('statusnotavailable', self::C), null];
        }

        // Identificatori gia' validati e presenti nello schema: interpolazione sicura.
        $from = '{' . $table . '}';
        $sql = "SELECT MIN($datecol) FROM $from WHERE $certcol = :cid AND $usercol = :uid";
        $date = $DB->get_field_sql($sql, ['cid' => $certid, 'uid' => $this->userid]);

        if (empty($date)) {
            return [false, get_string('statuspending', self::C), null];
        }
        $date = (int)$date;
        return [true, userdate($date, '%d/%m/%Y'), $date];
    }

    /**
     * URL di un'attivita' dato il cmid.
     *
     * @param int $cmid Course module id.
     * @return string
     */
    protected function cm_url(int $cmid): string {
        if (empty($cmid)) {
            return '';
        }
        $cm = get_coursemodule_from_id('', $cmid, 0, false, IGNORE_MISSING);
        if (!$cm) {
            return '';
        }
        return (string)(new moodle_url('/mod/' . $cm->modname . '/view.php', ['id' => $cm->id]));
    }

    /**
     * URL dell'attivita' attestato data l'istanza.
     *
     * @param int $certid Istanza simplecertificate.
     * @return string
     */
    protected function cert_url(int $certid): string {
        if (empty($certid)) {
            return '';
        }
        $cm = get_coursemodule_from_instance('simplecertificate', $certid, $this->course->id, false, IGNORE_MISSING);
        if (!$cm) {
            return '';
        }
        return (string)(new moodle_url('/mod/simplecertificate/view.php', ['id' => $cm->id]));
    }
}
