<?php
require('../../model/rsusers.php');
// require('../../model/rsgroups.php');
require('../../model/rsdevices.php');
require('../../model/rsdatabase.php');
require('../../model/rsfacilities.php');
require('../../model/rshousekeepinglog.php');
require('../../model/rsdeletedstuff.php');
require('../../model/rsdevicefacilitymatches.php');
// require('../../model/rsfacilitygroupmemberships.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'device_list';
    }
}

if ($action == 'device_list') {
    if($filter == NULL)
	$filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    try {
	if($filter == "active")
	   $all_devs = get_active_devices_list($db);
	elseif($filter == "inactive")
	   $all_devs = get_inactive_devices_list($db);
	else
	   $all_devs = get_devices_list($db);
    } catch (PDOException $e) {
      $error_message = $e->getMessage(); 
      include('../../errors/database_error.php');
      exit();
    }
    include('list.php');
} elseif ($action == 'new_device') {
    try {
        $available_facilities = get_all_available_facilities($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');    
        exit();
    }
    include('new.php');
} elseif ($action == 'edit_device') {
    // beware the input char '#', it messes up the serialization.
    $device = unserialize(base64_decode(filter_input(INPUT_GET, 'device')));
    try {
	$device_facility_id = (int)get_facility_id($db, $device['facility']);
        $available_facilities = get_all_available_facilities($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    include('edit.php');
} elseif ($action == 'add_device') {
$new_device_name = filter_input(INPUT_POST, 'new_device_name');
if ($new_device_name == NULL) {
    $new_device_name = filter_input(INPUT_GET, 'new_device_name');
    if ($new_device_name == NULL) {
        echo("Nothing came through for new_device_name");
    }
}

$new_device_token = filter_input(INPUT_POST, 'new_device_token');
if ($new_device_token == NULL) {
    $new_device_token = filter_input(INPUT_GET, 'new_device_token');
    if ($new_device_token == NULL) {
        echo("Nothing came through for new_device_token");
    }
}

$new_facility_id = filter_input(INPUT_POST, 'new_device_facility_id');
if ($new_facility_id == NULL) {
    $new_facility_id = filter_input(INPUT_GET, 'new_device_facility_id');
    if ($new_facility_id == NULL) {
        echo("Nothing came through for new_facility_id");
    }
}

$new_device_status = filter_input(INPUT_POST, 'new_device_status', FILTER_VALIDATE_BOOLEAN);
if ($new_device_status == NULL) {
    $new_device_status = filter_input(INPUT_GET, 'new_device_status', FILTER_VALIDATE_BOOLEAN);
    if ($new_device_status == NULL) {
        echo("Nothing came through for new_device_status");
	$new_facility_status = 0;
    }
}

$new_device_description = filter_input(INPUT_POST, 'new_device_description');
if ($new_device_description == NULL) {
    $new_device_description = filter_input(INPUT_GET, 'new_device_description');
    if ($new_device_description == NULL) {
        echo("Nothing came through for new_device_description");
    }
}

    try {
        add_device($db, $new_device_name, $new_device_token, $new_device_description, $new_device_status);
	if($new_facility_id) add_device_facility($db, (int)get_device_id($db, $new_device_name), $new_facility_id);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'update_device') {
$old_device = unserialize(base64_decode(filter_input(INPUT_POST, 'old_dev')));
if ($old_device == NULL) {
    $old_device = unserialize(base64_decode(filter_input(INPUT_GET, 'old_dev')));
    if ($old_device == NULL) {
        echo("Nothing came through for old_device");
    }
}

$edit_device_name = filter_input(INPUT_POST, 'edit_device_name');
if ($edit_device_name == NULL) {
    $edit_device_name = filter_input(INPUT_GET, 'edit_device_name');
    if ($edit_device_name == NULL) {
        echo("Nothing came through for edit_device_name");
    }
}

$edit_device_token = filter_input(INPUT_POST, 'edit_device_token');
if ($edit_device_token == NULL) {
    $edit_device_token = filter_input(INPUT_GET, 'edit_device_token');
    if ($edit_device_token == NULL) {
        echo("Nothing came through for edit_facility_relay");
    }
}

$edit_facility_id = filter_input(INPUT_POST, 'edit_device_facility_id');
if ($edit_facility_id == NULL) {
    $edit_facility_id = filter_input(INPUT_GET, 'edit_device_facility_id');
    if ($edit_facility_id == NULL) {
        echo("Nothing came through for edit_facility_id");
    }
}

$edit_device_status = filter_input(INPUT_POST, 'edit_device_status', FILTER_VALIDATE_BOOLEAN);
if ($edit_device_status == NULL) {
    $edit_device_status = filter_input(INPUT_GET, 'edit_device_status', FILTER_VALIDATE_BOOLEAN);
    if ($edit_device_status == NULL) {
        echo("Nothing came through for edit_device_status");
	$edit_device_status = 0;
    }
}

$edit_device_description = filter_input(INPUT_POST, 'edit_device_description');
if ($edit_device_description == NULL) {
    $edit_device_description = filter_input(INPUT_GET, 'edit_device_description');
    if ($edit_device_description == NULL) {
        echo("Nothing came through for edit_device_description");
    }
}

    try {
	if($old_device['deviceid'] != $edit_device_name || $old_device['token'] != $edit_device_token || $old_device['status'] != $edit_device_status || $old_device['description'] != $edit_device_description) {
            update_device($db, $edit_device_name, $edit_device_token, $edit_device_description, $edit_device_status, get_device_by_name($db, $old_device['device']));
	}

	$old_facility_id = get_facility_id($db, $old_device['facility']);

	if($old_facility_id) {
	    if($edit_facility_id) {
		if ($old_facility_id != $edit_facility_id) update_facility_device($db, get_device_id($db, $old_device['device']), $edit_facility_id);
	    } else {
		delete_dev_fac_by_facility($db, $old_facility_id);
	    }
	} else {
	    if($edit_facility_id) add_device_facility($db, get_device_id($db, $old_device['device']), $edit_facility_id);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_device') {
$delete_device = unserialize(base64_decode(filter_input(INPUT_POST, 'delete_device')));
if ($delete_device == NULL) {
    $delete_device = unserialize(base64_decode(filter_input(INPUT_GET, 'delete_device')));
    if ($delete_device == NULL) {
        echo("Nothing came through for delete_device");
    }
}

    try {
        if($delete_device) {
            $dev_id_to_del = get_device_id($db, $delete_device['device']);
            delete_dev_fac_by_device($db, $dev_id_to_del);
            delete_device($db, $delete_device['device']);
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} else { echo "Something's wrong!"; }

?>
