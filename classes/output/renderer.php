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

use plugin_renderer_base;

/**
 * Renderer for the Dynamic User advancement block.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti03@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends plugin_renderer_base {
    /**
     * Renderizza il componente principale.
     *
     * @param main $main Renderable con i dati.
     * @return string HTML.
     */
    public function render_main(main $main): string {
        $data = $main->export_for_template($this);
        return $this->render_from_template('block_dynamicuseradvancement/content', $data);
    }
}
