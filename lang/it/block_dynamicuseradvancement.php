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
 * Italian strings for block_dynamicuseradvancement.
 *
 * @package    block_dynamicuseradvancement
 * @copyright  2026 Daniele Calisti <daniele.calisti@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Dynamic User Advancement';
$string['dynamicuseradvancement:addinstance'] = 'Aggiungi un nuovo blocco Dynamic User Advancement';
$string['dynamicuseradvancement:myaddinstance'] = 'Aggiungi un nuovo blocco Dynamic User Advancement alla Dashboard';
$string['privacy:metadata'] = 'Il blocco Dynamic User Advancement non memorizza alcun dato personale.';

// Generale.
$string['notinacourse'] = 'Aggiungi questo blocco dentro un corso per vedere l\'avanzamento.';
$string['notconfigured'] = 'Nessun traguardo configurato. Modifica il blocco per impostarli.';
$string['statuspending'] = 'In attesa';
$string['statusnotset'] = 'Non impostato';
$string['statusnotavailable'] = 'Non disponibile';
$string['gradedetail'] = 'Voto: {$a->grade} / {$a->max}';

// Badge.
$string['badgedone'] = 'Completato';
$string['badgecurrent'] = 'In corso';
$string['badgetodo'] = 'Da fare';

// Messaggio di stato.
$string['statusstart'] = 'Ciao {$a}';
$string['statusprogress'] = 'Ciao {$a}';
$string['statusalmost'] = 'Ciao {$a}';
$string['statuscomplete'] = 'Sei in regola';
$string['statuscompletesub'] = 'Tutta la formazione richiesta completata';
$string['progresssummary'] = '{$a->done} di {$a->total} traguardi · {$a->percent}%';
$string['gonow'] = 'Vai';
$string['certobtained'] = 'Attestato conseguito';

// Banner scadenza.
$string['updatedue'] = 'Aggiornamento tra {$a} giorni';
$string['updatevaliduntil'] = 'Valido fino al {$a}';

// Checkpoint di default.
$string['cpaccess'] = 'Accesso al corso';
$string['cpexam'] = 'Verifica';
$string['cpcertificate'] = 'Attestato';

// Form.
$string['cfggeneral'] = 'Generale';
$string['cfgtitle'] = 'Titolo del blocco';
$string['cfgtitle_help'] = 'Lascia vuoto per usare il nome del corso.';
$string['cfgshow'] = 'Mostra questo traguardo';
$string['cfglabel'] = 'Etichetta';
$string['cfgnone'] = 'Nessuno';
$string['cfgaccess'] = 'Traguardo: accesso al corso';
$string['cfggrade'] = 'Traguardo: verifica';
$string['cfggradeactivity'] = 'Attivita\' valutata';
$string['cfgthreshold'] = 'Voto minimo';
$string['cfgthreshold_help'] = 'Il voto di sufficienza nella scala dell\'attivita\' scelta.';
$string['cfgcert'] = 'Traguardo: attestato';
$string['cfgcertinstance'] = 'Attivita\' attestato';
$string['cfgexpiry'] = 'Scadenza aggiornamento';
$string['cfgrenewyears'] = 'Periodo di aggiornamento (anni)';
$string['cfgrenewyears_help'] = 'Anni sommati alla data di emissione dell\'attestato per calcolare la scadenza.';

// Origine dati attestato (simplecertificate moddata).
$string['cfgcerttable'] = 'Tabella emissioni';
$string['cfgcerttable_help'] = 'Tabella del database che registra le emissioni degli attestati. Predefinita: simplecertificate_issues. Modificala solo se la vostra simplecertificate e\' stata moddata.';
$string['cfgcertcol'] = 'Colonna certificato';
$string['cfgcertcol_help'] = 'Colonna che collega l\'emissione all\'istanza del certificato. Predefinita: certificateid.';
$string['cfgcertusercol'] = 'Colonna utente';
$string['cfgcertusercol_help'] = 'Colonna che contiene l\'id utente. Predefinita: userid.';
$string['cfgcertdatecol'] = 'Colonna data emissione';
$string['cfgcertdatecol_help'] = 'Colonna che contiene la data di emissione. Predefinita: timecreated.';
