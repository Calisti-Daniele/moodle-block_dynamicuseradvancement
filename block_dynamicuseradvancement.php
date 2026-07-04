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
 * Block definition for the Dynamic User advancement block.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Dynamic User advancement: card-based training progress with status badges.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_dynamicuseradvancement extends block_base {

    /**
     * Inizializza il block impostandone il titolo.
     *
     * @return void
     */
    public function init(): void {
        $this->title = get_string('pluginname', 'block_dynamicuseradvancement');
    }

    /**
     * Consente la configurazione per-istanza.
     *
     * @return bool
     */
    public function instance_allow_config(): bool {
        return true;
    }

    /**
     * Applica un eventuale titolo personalizzato.
     *
     * @return void
     */
    public function specialization(): void {
        if (!empty($this->config->title)) {
            $this->title = format_string($this->config->title);
        }
    }

    /**
     * Genera il contenuto del block.
     *
     * @return stdClass|null
     */
    public function get_content(): ?stdClass {
        global $USER;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $course = $this->page->course;
        if (empty($course) || (int)$course->id === SITEID) {
            $this->content->text = get_string('notinacourse', 'block_dynamicuseradvancement');
            return $this->content;
        }

        $renderer = $this->page->get_renderer('block_dynamicuseradvancement');
        $main = new \block_dynamicuseradvancement\output\main($course, (int)$USER->id, $this->config);
        $this->content->text = $renderer->render($main);

        return $this->content;
    }

    /**
     * Tipi di pagina in cui e' inseribile.
     *
     * @return array<string, bool>
     */
    public function applicable_formats(): array {
        return [
            'course-view' => true,
            'site-index'  => true,
            'my'          => true,
        ];
    }

    /**
     * Nessuna impostazione globale.
     *
     * @return bool
     */
    public function has_config(): bool {
        return false;
    }
}
