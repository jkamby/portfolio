<?php
require('../../model/rsgroups.php');
require('../../model/rsdevices.php');
require('../../model/rsdatabase.php');
require('../../model/rsfacilities.php');
require('../../model/rsdevicefacilitymatches.php');
require('../../model/rsfacilitygroupmemberships.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'facility_list';
    }
}

if ($action == 'facility_list') {
    if($filter == NULL)
	$filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    try {
	if($filter == "active")
	   $all_facs = get_active_facilities_list($db);
	else
	   $all_facs = get_facilities_list($db);
    } catch (PDOException $e) {
      $error_message = $e->getMessage(); 
      include('../../errors/database_error.php');
      exit();
    }
    include('list.php');
} elseif ($action == 'new_facility') {
    try {
        $available_devices = get_all_available_devices($db);
        $groups = get_all_groups($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');    
        exit();
    }
    include('new.php');
} elseif ($action == 'edit_facility') {
    $facility = unserialize(filter_input(INPUT_GET, 'facility'));
    try {
        $available_devices = get_all_available_devices($db);
        $groups = get_all_groups($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    include('edit.php');
} elseif ($action == 'add_facility') {
$new_facility_name = filter_input(INPUT_POST, 'new_facility_name');
if ($new_facility_name == NULL) {
    $new_facility_name = filter_input(INPUT_GET, 'new_facility_name');
    if ($new_facility_name == NULL) {
        echo("Nothing came through for new_facility_name");
    }
}

$new_facility_relay = filter_input(INPUT_POST, 'new_facility_relays');
if ($new_facility_relay == NULL) {
    $new_facility_relay = filter_input(INPUT_GET, 'new_facility_relays');
    if ($new_facility_relay == NULL) {
        echo("Nothing came through for new_facility_relay");
    }
}

$new_facility_status = filter_input(INPUT_POST, 'new_facility_status', FILTER_VALIDATE_BOOLEAN);
if ($new_facility_status == NULL) {
    $new_facility_status = filter_input(INPUT_GET, 'new_facility_status', FILTER_VALIDATE_BOOLEAN);
    if ($new_facility_status == NULL) {
        echo("Nothing came through for new_facility_status");
	$new_facility_status = 0;
    }
}

$new_device_id = filter_input(INPUT_POST, 'new_facility_device_id');
if ($new_device_id == NULL) {
    $new_device_id = filter_input(INPUT_GET, 'new_facility_device_id');
    if ($new_device_id == NULL) {
        echo("Nothing came through for new_device_id");
    }
}

    try {
        add_facility($db, $new_facility_name, (int)$new_facility_relay, (int)$new_facility_status);
	add_device_facility($db, (int)$new_device_id, get_facility_id($db, $new_facility_name));
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'update_facility') {
$old_facility_name = filter_input(INPUT_POST, 'old_facility_name');
if ($old_facility_name == NULL) {
    $old_facility_name = filter_input(INPUT_GET, 'old_facility_name');
    if ($old_facility_name == NULL) {
        echo("Nothing came through for old_facility_name");
    }
}

$old_device_name = filter_input(INPUT_POST, 'old_device_name');
if ($old_device_name == NULL) {
    $old_device_name = filter_input(INPUT_GET, 'old_device_name');
    if ($old_device_name == NULL) {
        echo("Nothing came through for old_device_name");
    }
}

$edit_facility_name = filter_input(INPUT_POST, 'edit_facility_name');
if ($edit_facility_name == NULL) {
    $edit_facility_name = filter_input(INPUT_GET, 'edit_facility_name');
    if ($edit_facility_name == NULL) {
        echo("Nothing came through for edit_facility_name");
    }
}

$edit_facility_relay = filter_input(INPUT_POST, 'edit_facility_relays');
if ($edit_facility_relay == NULL) {
    $edit_facility_relay = filter_input(INPUT_GET, 'edit_facility_relays');
    if ($edit_facility_relay == NULL) {
        echo("Nothing came through for edit_facility_relay");
    }
}

$edit_facility_status = filter_input(INPUT_POST, 'edit_facility_status', FILTER_VALIDATE_BOOLEAN);
if ($edit_facility_status == NULL) {
    $edit_facility_status = filter_input(INPUT_GET, 'edit_facility_status', FILTER_VALIDATE_BOOLEAN);
    if ($edit_facility_status == NULL) {
        echo("Nothing came through for edit_facility_status");
	$edit_facility_status = 0;
    }
}

$edit_device_id = filter_input(INPUT_POST, 'edit_facility_device_id');
if ($edit_device_id == NULL) {
    $edit_device_id = filter_input(INPUT_GET, 'edit_facility_device_id');
    if ($edit_device_id == NULL) {
        echo("Nothing came through for edit_device_id");
    }
}

    try {
        update_facility($db, $edit_facility_name, (int)$edit_facility_relay, (int)$edit_facility_status, get_facility_by_name($db, $old_facility_name));
	if ($edit_device_id != 99999) {
	    update_device_facility($db, (int)$edit_device_id, (int)get_facility_id($db, $edit_facility_name));
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_facility') {
$delete_facility_name = filter_input(INPUT_POST, 'delete_facility_name');
if ($delete_facility_name == NULL) {
    $delete_facility_name = filter_input(INPUT_GET, 'delete_facility_name');
    if ($delete_facility_name == NULL) {
        echo("Nothing came through for delete_facility_name");
    }
}

$delete_confirmation = filter_input(INPUT_POST, 'delete_confirmation', FILTER_VALIDATE_BOOLEAN);
if ($delete_confirmation == NULL) {
    $delete_confirmation = filter_input(INPUT_GET, 'delete_confirmation', FILTER_VALIDATE_BOOLEAN);
    if ($delete_confirmation == NULL) {
        echo("Nothing came through for delete_confirmation");
    }
}

if($delete_confirmation == true) {
	echo('proceed with deleting ' . $delete_facility_name . ' now.');
	die();
	} else {
	echo('deleting ' . $delete_facility_name . ' halted.');
	die();
	}
    header('Location: .');
} else { echo "Something's wrong!"; }

?>
