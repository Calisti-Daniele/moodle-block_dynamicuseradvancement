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

/**
 * Per-instance configuration form for the Dynamic User advancement block.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Instance configuration form.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_dynamicuseradvancement_edit_form extends block_edit_form {
    /**
     * Campi specifici di configurazione.
     *
     * @param MoodleQuickForm $mform Il form.
     * @return void
     */
    protected function specific_definition($mform): void {
        $courseid = (int)$this->page->course->id;
        $p = 'block_dynamicuseradvancement';

        $mform->addElement('header', 'duageneral', get_string('cfggeneral', $p));
        $mform->addElement('text', 'config_title', get_string('cfgtitle', $p));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->addHelpButton('config_title', 'cfgtitle', $p);

        // Traguardo: accesso al corso.
        $mform->addElement('header', 'duaaccess', get_string('cfgaccess', $p));
        $mform->addElement('advcheckbox', 'config_showaccess', get_string('cfgshow', $p));
        $mform->setDefault('config_showaccess', 1);
        $mform->addElement('text', 'config_accesslabel', get_string('cfglabel', $p));
        $mform->setType('config_accesslabel', PARAM_TEXT);
        $mform->setDefault('config_accesslabel', get_string('cpaccess', $p));
        $mform->hideIf('config_accesslabel', 'config_showaccess', 'notchecked');

        // Traguardo: verifica (voto >= soglia).
        $mform->addElement('header', 'duagrade', get_string('cfggrade', $p));
        $mform->addElement('advcheckbox', 'config_showgrade', get_string('cfgshow', $p));
        $mform->setDefault('config_showgrade', 1);
        $mform->addElement(
            'select',
            'config_gradecmid',
            get_string('cfggradeactivity', $p),
            $this->get_graded_activities($courseid)
        );
        $mform->hideIf('config_gradecmid', 'config_showgrade', 'notchecked');
        $mform->addElement('text', 'config_gradethreshold', get_string('cfgthreshold', $p));
        $mform->setType('config_gradethreshold', PARAM_FLOAT);
        $mform->setDefault('config_gradethreshold', 60);
        $mform->addHelpButton('config_gradethreshold', 'cfgthreshold', $p);
        $mform->hideIf('config_gradethreshold', 'config_showgrade', 'notchecked');
        $mform->addElement('text', 'config_gradelabel', get_string('cfglabel', $p));
        $mform->setType('config_gradelabel', PARAM_TEXT);
        $mform->setDefault('config_gradelabel', get_string('cpexam', $p));
        $mform->hideIf('config_gradelabel', 'config_showgrade', 'notchecked');

        // Traguardo: attestato (simplecertificate).
        $mform->addElement('header', 'duacert', get_string('cfgcert', $p));
        $mform->addElement('advcheckbox', 'config_showcert', get_string('cfgshow', $p));
        $mform->setDefault('config_showcert', 1);
        $mform->addElement(
            'select',
            'config_certid',
            get_string('cfgcertinstance', $p),
            $this->get_certificates($courseid)
        );
        $mform->hideIf('config_certid', 'config_showcert', 'notchecked');
        $mform->addElement('text', 'config_certlabel', get_string('cfglabel', $p));
        $mform->setType('config_certlabel', PARAM_TEXT);
        $mform->setDefault('config_certlabel', get_string('cpcertificate', $p));
        $mform->hideIf('config_certlabel', 'config_showcert', 'notchecked');

        // Origine dati dell'emissione (per installazioni con simplecertificate moddata).
        $mform->addElement('text', 'config_certtable', get_string('cfgcerttable', $p));
        $mform->setType('config_certtable', PARAM_ALPHANUMEXT);
        $mform->setDefault('config_certtable', 'simplecertificate_issues');
        $mform->addHelpButton('config_certtable', 'cfgcerttable', $p);
        $mform->hideIf('config_certtable', 'config_showcert', 'notchecked');

        $mform->addElement('text', 'config_certcol', get_string('cfgcertcol', $p));
        $mform->setType('config_certcol', PARAM_ALPHANUMEXT);
        $mform->setDefault('config_certcol', 'certificateid');
        $mform->addHelpButton('config_certcol', 'cfgcertcol', $p);
        $mform->hideIf('config_certcol', 'config_showcert', 'notchecked');

        $mform->addElement('text', 'config_certusercol', get_string('cfgcertusercol', $p));
        $mform->setType('config_certusercol', PARAM_ALPHANUMEXT);
        $mform->setDefault('config_certusercol', 'userid');
        $mform->addHelpButton('config_certusercol', 'cfgcertusercol', $p);
        $mform->hideIf('config_certusercol', 'config_showcert', 'notchecked');

        $mform->addElement('text', 'config_certdatecol', get_string('cfgcertdatecol', $p));
        $mform->setType('config_certdatecol', PARAM_ALPHANUMEXT);
        $mform->setDefault('config_certdatecol', 'timecreated');
        $mform->addHelpButton('config_certdatecol', 'cfgcertdatecol', $p);
        $mform->hideIf('config_certdatecol', 'config_showcert', 'notchecked');

        // Scadenza aggiornamento.
        $mform->addElement('header', 'duaexpiry', get_string('cfgexpiry', $p));
        $mform->addElement('advcheckbox', 'config_showexpiry', get_string('cfgshow', $p));
        $mform->setDefault('config_showexpiry', 1);
        $mform->addElement('text', 'config_renewyears', get_string('cfgrenewyears', $p));
        $mform->setType('config_renewyears', PARAM_INT);
        $mform->setDefault('config_renewyears', 5);
        $mform->addHelpButton('config_renewyears', 'cfgrenewyears', $p);
        $mform->hideIf('config_renewyears', 'config_showexpiry', 'notchecked');
    }

    /**
     * Attivita' valutate del corso.
     *
     * @param int $courseid Id del corso.
     * @return array<int, string>
     */
    protected function get_graded_activities(int $courseid): array {
        $options = [0 => get_string('cfgnone', 'block_dynamicuseradvancement')];
        $modinfo = get_fast_modinfo($courseid);
        foreach ($modinfo->get_cms() as $cm) {
            if (!$cm->uservisible) {
                continue;
            }
            $options[$cm->id] = format_string($cm->get_formatted_name()) . ' (' . $cm->modname . ')';
        }
        return $options;
    }

    /**
     * Istanze di simplecertificate del corso.
     *
     * @param int $courseid Id del corso.
     * @return array<int, string>
     */
    protected function get_certificates(int $courseid): array {
        global $DB;
        $options = [0 => get_string('cfgnone', 'block_dynamicuseradvancement')];
        if ($DB->get_manager()->table_exists('simplecertificate')) {
            $records = $DB->get_records_menu('simplecertificate', ['course' => $courseid], 'name', 'id,name');
            foreach ($records as $id => $name) {
                $options[$id] = format_string($name);
            }
        }
        return $options;
    }
}
