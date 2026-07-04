# Dynamic User advancement (block_dynamicuseradvancement)

Moodle block that shows a learner's training advancement as a set of
progress cards with status badges, designed to sit comfortably in a
narrow side column. Milestones are configurable per course (course
access, assessment grade, certificate issuance) and geared to mandatory
safety training (D.Lgs. 81/08 - Accordo Stato-Regioni 2025).

## Requirements

* Moodle 4.5 or later.
* PHP 8.3+.

## Installation

1. Copy the folder to `blocks/dynamicuseradvancement` in your Moodle install.
2. Visit *Site administration > Notifications* to complete the upgrade,
   or run `php admin/cli/upgrade.php`.
3. In a course, turn editing on and add the **Dynamic User advancement** block.

## Licence

GNU GPL v3 or later - see the LICENSE file.

Copyright (C) 2026 Daniele Calisti
