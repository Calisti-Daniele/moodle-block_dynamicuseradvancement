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
 * English strings for block_dynamicuseradvancement.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Dynamic User Advancement';
$string['dynamicuseradvancement:addinstance'] = 'Add a new Dynamic User Advancement block';
$string['dynamicuseradvancement:myaddinstance'] = 'Add a new Dynamic User Advancement block to the Dashboard';
$string['privacy:metadata'] = 'The Dynamic User Advancement block does not store any personal data.';

// Generale.
$string['notinacourse'] = 'Add this block inside a course to see the advancement.';
$string['notconfigured'] = 'No milestone configured yet. Edit the block to set them up.';
$string['statuspending'] = 'Pending';
$string['statusnotset'] = 'Not set';
$string['statusnotavailable'] = 'Not available';
$string['gradedetail'] = 'Grade: {$a->grade} / {$a->max}';

// Badge.
$string['badgedone'] = 'Completed';
$string['badgecurrent'] = 'In progress';
$string['badgetodo'] = 'To do';

// Messaggio di stato.
$string['statusstart'] = 'Hi {$a}';
$string['statusprogress'] = 'Hi {$a}';
$string['statusalmost'] = 'Hi {$a}';
$string['statuscomplete'] = 'You\'re all set';
$string['statuscompletesub'] = 'All required training completed';
$string['progresssummary'] = '{$a->done} of {$a->total} milestones · {$a->percent}%';
$string['gonow'] = 'Go';
$string['certobtained'] = 'Certificate obtained';

// Banner scadenza.
$string['updatedue'] = 'Refresher due in {$a} days';
$string['updatevaliduntil'] = 'Valid until {$a}';

// Checkpoint di default.
$string['cpaccess'] = 'Course access';
$string['cpexam'] = 'Assessment';
$string['cpcertificate'] = 'Certificate';

// Form.
$string['cfggeneral'] = 'General';
$string['cfgtitle'] = 'Block title';
$string['cfgtitle_help'] = 'Leave empty to use the course name.';
$string['cfgshow'] = 'Show this milestone';
$string['cfglabel'] = 'Label';
$string['cfgnone'] = 'None';
$string['cfgaccess'] = 'Milestone: course access';
$string['cfggrade'] = 'Milestone: assessment';
$string['cfggradeactivity'] = 'Graded activity';
$string['cfgthreshold'] = 'Minimum grade';
$string['cfgthreshold_help'] = 'The pass mark on the chosen activity scale.';
$string['cfgcert'] = 'Milestone: certificate';
$string['cfgcertinstance'] = 'Certificate activity';
$string['cfgexpiry'] = 'Refresher expiry';
$string['cfgrenewyears'] = 'Renewal period (years)';
$string['cfgrenewyears_help'] = 'Years added to the certificate issue date to compute expiry.';

// Origine dati attestato (simplecertificate moddata).
$string['cfgcerttable'] = 'Issues table';
$string['cfgcerttable_help'] = 'Database table storing certificate issues. Default: simplecertificate_issues. Change only if your certificate plugin was modified.';
$string['cfgcertcol'] = 'Certificate column';
$string['cfgcertcol_help'] = 'Column linking an issue to the certificate instance. Default: certificateid.';
$string['cfgcertusercol'] = 'User column';
$string['cfgcertusercol_help'] = 'Column storing the user id. Default: userid.';
$string['cfgcertdatecol'] = 'Issue date column';
$string['cfgcertdatecol_help'] = 'Column storing the issue timestamp. Default: timecreated.';
