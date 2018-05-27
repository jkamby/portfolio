<?php

 require('../../model/rsusers.php');
 require('../../model/rsgroups.php');
 require('../../model/rsdevices.php');
 require('../../model/rsdatabase.php');
 require('../../model/rsfacilities.php');
 require('../../model/rshousekeepinglog.php');
 require('../../model/rsdeletedstuff.php');
// require('../../model/rsgroupusermemberships.php');
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
    $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    if($filter == NULL) {
	$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
	if($filter == NULL) {
	    $filter = 'all';
	}
    }
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
    // beware the input char '#', it messes up the serialization.
    $facility = unserialize(base64_decode(filter_input(INPUT_GET, 'facility')));
    try {
	$facility_id = (int)get_facility_id($db, $facility['facility']);
	$facility_device_id = (int)get_device_id($db, $facility['device']);
	$facility_groups = get_groups_by_facility($db, $facility_id);
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

$new_facility_device_id = filter_input(INPUT_POST, 'new_facility_device_id');
if ($new_facility_device_id == NULL) {
    $new_facility_device_id = filter_input(INPUT_GET, 'new_facility_device_id');
    if ($new_facility_device_id == NULL) {
        echo("Nothing came through for new_facility_device_id");
    }
}

$new_facility_group_ids = filter_input(INPUT_POST, 'new_facility_group_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($new_facility_group_ids == NULL) {
    $new_facility_group_ids = filter_input(INPUT_GET, 'new_facility_group_ids', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($new_facility_group_ids == NULL) {
        echo("Nothing came through for new_facility_group_ids");
    }
}

    try {
        add_facility($db, $new_facility_name, (int)$new_facility_relay, (int)$new_facility_status);
	if ($new_facility_device_id) add_device_facility($db, (int)$new_facility_device_id, get_facility_id($db, $new_facility_name));
	$new_facility_id = (int)get_facility_id($db, $new_facility_name);
	foreach ($new_facility_group_ids as $new_facility_group_id) {
            add_facility_group($db, $new_facility_id, (int)$new_facility_group_id);
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'update_facility') {
$old_facility = unserialize(base64_decode(filter_input(INPUT_POST, 'old_fac_less_grps')));
if ($old_facility == NULL) {
    $old_facility = unserialize(base64_decode(filter_input(INPUT_GET, 'old_fac_less_grps')));
    if ($old_facility == NULL) {
        echo("Nothing came through for old_facility");
    }
}

$old_facility_groups = unserialize(base64_decode(filter_input(INPUT_POST, 'old_facility_groups')));
if ($old_facility_groups == NULL) {
    $old_facility_groups = unserialize(base64_decode(filter_input(INPUT_GET, 'old_facility_groups')));
    if ($old_facility_groups == NULL) {
        echo("Nothing came through for old_facility_groups");
    }
}

$edit_facility_name = filter_input(INPUT_POST, 'edit_facility_name');
if ($edit_facility_name == NULL) {
    $edit_facility_name = filter_input(INPUT_GET, 'edit_facility_name');
    if ($edit_facility_name == NULL) {
        echo("Nothing came through for edit_facility_name");
    }
}

$edit_facility_relays = filter_input(INPUT_POST, 'edit_facility_relays');
if ($edit_facility_relays == NULL) {
    $edit_facility_relays = filter_input(INPUT_GET, 'edit_facility_relays');
    if ($edit_facility_relays == NULL) {
        echo("Nothing came through for edit_facility_relays");
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

$edit_facility_group_ids = filter_input(INPUT_POST, 'edit_facility_groups', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($edit_facility_group_ids == NULL) {
    $edit_facility_group_ids = filter_input(INPUT_GET, 'edit_facility_groups', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($edit_facility_group_ids == NULL) {
        echo("Nothing came through for edit_facility_groups");
    }
}

    try {
	if($old_facility['facility'] != $edit_facility_name || $old_facility['relays'] != $edit_facility_relays || $old_facility['status'] != $edit_facility_status) {
            update_facility($db, $edit_facility_name, $edit_facility_relays, $edit_facility_status, get_facility_by_name($db, $old_facility['facility']));
	}

	$old_device_id = (int)get_device_id($db, $old_facility['device']);

	if ($old_device_id) {
	    if($edit_device_id) {
		if ($old_device_id != $edit_device_id) update_device_facility($db, (int)$edit_device_id, (int)get_facility_id($db, $edit_facility_name));
	    } else {
		delete_dev_fac_by_device($db, $old_device_id);
	    }
	} else {
	    if($edit_device_id) add_device_facility($db, (int)$edit_device_id, (int)get_facility_id($db, $old_facility['facility']));
	}	


	$fac_id_to_edit = (int)get_facility_id($db, ($edit_facility_name ? $edit_facility_name : $old_facility['facility']));
	if ($edit_facility_group_ids && $old_facility_groups) {
	    $groups_to_del = array_diff($old_facility_groups, $edit_facility_group_ids);
	    $groups_to_add = array_diff($edit_facility_group_ids, $old_facility_groups);
	} elseif ($old_facility_groups && !$edit_facility_group_ids) {
	    $groups_to_del = $old_facility_groups;
	    $groups_to_add = [];
	} elseif ($edit_facility_group_ids && !$old_facility_groups) {
	    $groups_to_del = [];
	    $groups_to_add = $edit_facility_group_ids;
	} else {
	    $groups_to_del = [];
	    $groups_to_add = [];
	}
	foreach ($groups_to_del as $grp_to_del) {
	   delete_facility_group($db, $fac_id_to_edit, $grp_to_del);
	}
	foreach ($groups_to_add as $grp_to_add) {
	    add_facility_group($db, $fac_id_to_edit, $grp_to_add);
	    echo('Added group ' . $grp_to_add);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_facility') {
$delete_facility = unserialize(base64_decode(filter_input(INPUT_POST, 'delete_facility')));
if ($delete_facility == NULL) {
    $delete_facility = unserialize(base64_decode(filter_input(INPUT_GET, 'delete_facility')));
    if ($delete_facility == NULL) {
        echo("Nothing came through for delete_facility");
    }
}

    try {
	if($delete_facility) {
	    $fac_id_to_del = get_facility_id($db, $delete_facility['facility']);
	    delete_facility_groups($db, $fac_id_to_del);
	    delete_dev_fac_by_facility($db, $fac_id_to_del);
	    delete_facility($db, $delete_facility['facility']);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} else { echo "Something's wrong!"; }

?>
