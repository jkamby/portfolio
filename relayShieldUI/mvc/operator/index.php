<?php
require('../model/rsusers.php');
require('../model/rsgroups.php');
require('../model/rsdevices.php');
require('../model/rsdatabase.php');
require('../model/rsfacilities.php');
require('../model/rshousekeepinglog.php');
require('../model/rsdevicefacilitymatches.php');
require('../model/rsfacilitygroupmemberships.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'load_facility';
    }
}

if ($action == 'load_facility') {
    $user_facility = unserialize(base64_decode(filter_input(INPUT_GET, 'user_facility')));
    include('facility.php');
} else { echo "Something's wrong!"; }

?>
