<?php
require('../../model/rsusers.php');
require('../../model/rsgroups.php');
require('../../model/rsdevices.php');
require('../../model/rsdatabase.php');
require('../../model/rsfacilities.php');
require('../../model/rshousekeepinglog.php');
require('../../model/rsdeletedstuff.php');
require('../../model/rsgroupusermemberships.php');
require('../../model/rsdevicefacilitymatches.php');
require('../../model/rsfacilitygroupmemberships.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'group_list';
    }
}

if ($action == 'group_list') {
    if($filter == NULL)
	$filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    try {
	if($filter == "active")
	   $all_grps = get_active_groups_list($db);
	else
	   $all_grps = get_groups_list($db);
    } catch (PDOException $e) {
      $error_message = $e->getMessage(); 
      include('../../errors/database_error.php');
      exit();
    }
    include('list.php');
} elseif ($action == 'new_group') {
    try {
	$users = get_all_users($db);
        $facilities = get_all_facilities($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');    
        exit();
    }
    include('new.php');
} elseif ($action == 'edit_group') {
    // beware the input char '#', it messes up the serialization.
    $group = unserialize(base64_decode(filter_input(INPUT_GET, 'group')));
    try {
	$group_id = (int)get_group_id($db, $group['_group']);
        $users = get_all_users($db);
        $facilities = get_all_facilities($db);
	$group_users = get_users_by_group($db, $group_id);
	$group_facilities = get_facilities_by_group($db, $group_id);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    include('edit.php');
} elseif ($action == 'add_group') {
$new_group_name = filter_input(INPUT_POST, 'new_group_name');
if ($new_group_name == NULL) {
    $new_group_name = filter_input(INPUT_GET, 'new_group_name');
    if ($new_group_name == NULL) {
        echo("Nothing came through for new_group_name");
    }
}

$new_group_description = filter_input(INPUT_POST, 'new_group_description');
if ($new_group_description == NULL) {
    $new_group_description = filter_input(INPUT_GET, 'new_group_description');
    if ($new_group_description == NULL) {
        echo("Nothing came through for new_group_description");
    }
}

$new_group_status = filter_input(INPUT_POST, 'new_group_status', FILTER_VALIDATE_BOOLEAN);
if ($new_group_status == NULL) {
    $new_group_status = filter_input(INPUT_GET, 'new_group_status', FILTER_VALIDATE_BOOLEAN);
    if ($new_group_status == NULL) {
        echo("Nothing came through for new_group_status");
	$new_group_status = 0;
    }
}

$new_group_users = filter_input(INPUT_POST, 'new_group_users', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($new_group_users == NULL) {
    $new_group_users = filter_input(INPUT_GET, 'new_group_users', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($new_group_users == NULL) {
        echo("Nothing came through for new_group_users");
    }
}

$new_group_facilities = filter_input(INPUT_POST, 'new_group_facilities', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($new_group_facilities == NULL) {
    $new_group_facilities = filter_input(INPUT_GET, 'new_group_facilities', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($new_group_facilities == NULL) {
        echo("Nothing came through for new_group_facilities");
    }
}
    try {
        add_group($db, htmlspecialchars($new_group_name), htmlspecialchars($new_group_description), (int)$new_group_status);
	$new_group_id = (int)get_group_id($db, $new_group_name);
	foreach ($new_group_users as $new_group_user_id) {
		add_group_user($db, $new_group_id, (int)$new_group_user_id);
	}
	foreach ($new_group_facilities as $new_group_facility_id) {
            add_facility_group($db, (int)$new_group_facility_id, $new_group_id);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'update_group') {
$old_group = unserialize(base64_decode(filter_input(INPUT_POST, 'old_grp_less_usrs_facs')));
if ($old_group == NULL) {
    $old_group = unserialize(base64_decode(filter_input(INPUT_GET, 'old_grp_less_usrs_facs')));
    if ($old_group == NULL) {
        echo("Nothing came through for old_group");
    }
}

$old_group_users = unserialize(base64_decode(filter_input(INPUT_POST, 'old_group_users')));
if ($old_group_users == NULL) {
    $old_group_users = unserialize(base64_decode(filter_input(INPUT_GET, 'old_users')));
    if ($old_group_users == NULL) {
        echo("Nothing came through for old_group_users");
    }
}

$old_group_facilities = unserialize(base64_decode(filter_input(INPUT_POST, 'old_group_facilities')));
if ($old_group_facilities == NULL) {
    $old_group_facilities = unserialize(base64_decode(filter_input(INPUT_GET, 'old_group_facilities')));
    if ($old_group_facilities == NULL) {
        echo("Nothing came through for old_group_facilities");
    }
}

$edit_group_name = filter_input(INPUT_POST, 'edit_group_name');
if ($edit_group_name == NULL) {
    $edit_group_name = filter_input(INPUT_GET, 'edit_group_name');
    if ($edit_group_name == NULL) {
        echo("Nothing came through for edit_group_name");
    }
}

$edit_group_description = filter_input(INPUT_POST, 'edit_group_description');
if ($edit_group_description == NULL) {
    $edit_group_description = filter_input(INPUT_GET, 'edit_group_description');
    if ($edit_group_description == NULL) {
        echo("Nothing came through for edit_group_description");
    }
}

$edit_group_status = filter_input(INPUT_POST, 'edit_group_status', FILTER_VALIDATE_BOOLEAN);
if ($edit_group_status == NULL) {
    $edit_group_status = filter_input(INPUT_GET, 'edit_group_status', FILTER_VALIDATE_BOOLEAN);
    if ($edit_group_status == NULL) {
        echo("Nothing came through for edit_group_status");
	$edit_group_status = 0;
    }
}

$edit_group_users = filter_input(INPUT_POST, 'edit_group_users', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($edit_group_users == NULL) {
    $edit_group_users = filter_input(INPUT_GET, 'edit_group_users', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($edit_group_users == NULL) {
        echo("Nothing came through for edit_group_users");
    }
}

$edit_group_facilities = filter_input(INPUT_POST, 'edit_group_facilities', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($edit_group_facilities == NULL) {
    $edit_group_facilities = filter_input(INPUT_GET, 'edit_group_facilities', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($edit_group_facilities == NULL) {
        echo("Nothing came through for edit_group_facilities");
    }
}

    try {
	if($old_group['_group'] != $edit_group_name || $old_group['description'] != $edit_group_description || $old_group['status'] != $edit_group_status) {
            update_group($db, $edit_group_name, $edit_group_description, $edit_group_status, get_group_by_name($db, $old_group['_group']));
	}
	
	$grp_id_to_edit = (int)get_group_id($db, ($edit_group_name ? $edit_group_name : $old_group['_group']));

	if ($edit_group_users && $old_group_users) {
	    $users_to_del = array_diff($old_group_users, $edit_group_users);
	    $users_to_add = array_diff($edit_group_users, $old_group_users);
	} elseif (!$edit_group_users && $old_group_users) {
	    $users_to_del = $old_group_users;
	    $users_to_add = [];
	} elseif ($edit_group_users && !$old_group_users) {
	    $users_to_del = [];
	    $users_to_add = $edit_group_users;
	} else {
	    $users_to_del = [];
	    $users_to_add = [];
	}
	foreach ($users_to_del as $usr_to_del) {
	    delete_group_user($db, $grp_id_to_edit, $usr_to_del);
	}
	foreach ($users_to_add as $usr_to_add) {
	    add_group_user($db, $grp_id_to_edit, $usr_to_add);
	}

	if ($edit_group_facilities && $old_group_facilities) {
	    $facilities_to_del = array_diff($old_group_facilities, $edit_group_facilities);
	    $facilities_to_add = array_diff($edit_group_facilities, $old_group_facilities);
	} elseif (!$edit_group_facilities && $old_group_facilities) {
	    $facilities_to_del = $old_group_facilities;
	    $facilities_to_add = [];
	} elseif ($edit_group_facilities && !$old_group_facilities) {
	    $facilities_to_del = [];
	    $facilities_to_add = $edit_group_facilities;
	} else {
	    $facilities_to_del = [];
	    $facilities_to_add = [];
	}
	foreach ($facilities_to_del as $fac_to_del) {
	    delete_facility_group($db, $fac_to_del, $grp_id_to_edit);
	}
	foreach ($facilities_to_add as $fac_to_add) {
	    add_facility_group($db, $fac_to_add, $grp_id_to_edit);
	}

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_group') {
$delete_group = unserialize(base64_decode(filter_input(INPUT_POST, 'delete_group')));
if ($delete_group == NULL) {
    $delete_group = unserialize(base64_decode(filter_input(INPUT_GET, 'delete_group')));
    if ($delete_group == NULL) {
        echo("Nothing came through for delete_group");
    }
}

    try {
        if($delete_group) {
            $grp_id_to_del = get_group_id($db, $delete_group['_group']);
            if ($delete_group['users'] > 0) delete_group_users($db, $grp_id_to_del);
	    if ($delete_group['facilities'] > 0) delete_group_facilities($db, $grp_id_to_del);
	    delete_group($db, $delete_group['_group']);
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} else { echo "Something's wrong!"; }

?>
