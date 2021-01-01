<?php

 require('../../model/rsusers.php');
 require('../../model/rsgroups.php');
// require('../../model/rsdevices.php');
 require('../../model/rsdatabase.php');
// require('../../model/rsfacilities.php');
 require('../../model/rshousekeepinglog.php');
 require('../../model/rsdeletedstuff.php');
 require('../../model/rsgroupusermemberships.php');
// require('../../model/rsdevicefacilitymatches.php');
// require('../../model/rsfacilitygroupmemberships.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'user_list';
    }
}

if ($action == 'user_list') {
    $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);
    if($filter == NULL) {
	$filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_STRING);
	if($filter == NULL) {
	    $filter = 'all';
	}
    }
    try {
	if($filter == "active")
	   $all_usrs = get_active_users_list($db);
	else
	   $all_usrs = get_users_list($db);
    } catch (PDOException $e) {
      $error_message = $e->getMessage(); 
      include('../../errors/database_error.php');
      exit();
    }
    include('list.php');
} elseif ($action == 'new_user') {
    include('registration.php');
} elseif ($action == 'edit_user') {
    // beware the input char '#', it messes up the serialization.
    $user = unserialize(base64_decode(filter_input(INPUT_GET, 'user')));
    try {
	$user_id = (int)get_user_id($db, $user['_user']);
	echo('Got userid: ' . $user_id);
	$user_groups = get_groups_by_user($db, $user_id);
	echo('Got ' . $user_groups . ' groups.');
        $groups = get_all_groups($db);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    include('edit.php');
} elseif ($action == 'add_user') {
$firstname = filter_input(INPUT_POST, 'firstname');
if ($firstname == NULL) {
    $firstname = filter_input(INPUT_GET, 'firstname');
    if ($firstname == NULL) {
        echo('$firstname is blank!');
    }
}

$lastname = filter_input(INPUT_POST, 'lastname');
if ($lastname == NULL) {
    $lastname = filter_input(INPUT_GET, 'lastname');
    if ($lastname == NULL) {
        echo('$lastname is blank!');
    }
}
$email = filter_input(INPUT_POST, 'email');
if ($email == NULL) {
    $email = filter_input(INPUT_GET, 'email');
    if ($email == NULL) {
        echo('$email is blank!');
    }
}

$username = filter_input(INPUT_POST, 'username');
if ($username == NULL) {
    $username = filter_input(INPUT_GET, 'username');
    if ($username == NULL) {
        echo('$username is blank!');
    }
}
// TODO: use password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
$password = filter_input(INPUT_POST, 'password');
if ($password == NULL) {
    $password = filter_input(INPUT_GET, 'password');
    if ($password == NULL) {
        echo('$password is blank!');
    }
}

$encryptedpassword = $password ? password_hash($password, PASSWORD_BCRYPT) : '';

$confirm_password = filter_input(INPUT_POST, 'confirm_password');
if ($confirm_password == NULL) {
    $confirm_password = filter_input(INPUT_GET, 'confirm_password');
    if ($confirm_password == NULL) {
        echo('$confirm_password is blank!');
    }
}
    try {
        $successful_registration = add_user($db, $firstname, $lastname, $email, $username, $encryptedpassword, (int)1, (int)0);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    if($successful_registration){
        $login_message = 'User registration successful...';
        header('Location: .');
    } else {
        $registration_message = 'User registration NOT successful...';
        include('registration.php');
    }
} elseif ($action == 'update_user') {
$old_user = unserialize(base64_decode(filter_input(INPUT_POST, 'old_usr_less_grps')));
if ($old_user == NULL) {
    $old_user = unserialize(base64_decode(filter_input(INPUT_GET, 'old_usr_less_grps')));
    if ($old_user == NULL) {
        echo("Nothing came through for old_user");
    }
}

$old_user_groups = unserialize(base64_decode(filter_input(INPUT_POST, 'old_user_groups')));
if ($old_user_groups == NULL) {
    $old_user_groups = unserialize(base64_decode(filter_input(INPUT_GET, 'old_user_groups')));
    if ($old_user_groups == NULL) {
        echo("Nothing came through for old_user_groups");
    }
}

$edit_user_status = filter_input(INPUT_POST, 'edit_user_status', FILTER_VALIDATE_BOOLEAN);
if ($edit_user_status == NULL) {
    $edit_user_status = filter_input(INPUT_GET, 'edit_user_status', FILTER_VALIDATE_BOOLEAN);
    if ($edit_user_status == NULL) {
        echo("Nothing came through for edit_user_status");
	$edit_user_status = 0;
    }
}

$edit_user_type = filter_input(INPUT_POST, 'edit_user_type');
if ($edit_user_type == NULL) {
    $edit_user_type = filter_input(INPUT_GET, 'edit_user_type');
    if ($edit_user_type == NULL) {
        echo("Nothing came through for edit_user_type");
    }
}

$edit_user_group_ids = filter_input(INPUT_POST, 'edit_user_groups', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
if ($edit_user_group_ids == NULL) {
    $edit_user_group_ids = filter_input(INPUT_GET, 'edit_user_groups', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    if ($edit_user_group_ids == NULL) {
        echo("Nothing came through for edit_user_groups");
    }
}

    try {
	if($old_user['status'] != $edit_user_status || $old_user['utypeid'] != $edit_user_type) {
            update_user_props($db, $edit_user_status, $edit_user_type, get_user_by_name($db, $old_user['_user']));
	}

	$usr_id_to_edit = (int)get_user_id($db, ($edit_user_name ? $edit_user_name : $old_user['_user']));

	if ($edit_user_group_ids && $old_user_groups) {
	    $groups_to_del = array_diff($old_user_groups, $edit_user_group_ids);
	    $groups_to_add = array_diff($edit_user_group_ids, $old_user_groups);
	} elseif ($old_user_groups && !$edit_user_group_ids) {
	    $groups_to_del = $old_user_groups;
	    $groups_to_add = [];
	} elseif ($edit_user_group_ids && !$old_user_groups) {
	    $groups_to_del = [];
	    $groups_to_add = $edit_user_group_ids;
	} else {
	    $groups_to_del = [];
	    $groups_to_add = [];
	}
	foreach ($groups_to_del as $grp_to_del) {
	   delete_group_user($db, $grp_to_del, $usr_id_to_edit);
	}
	foreach ($groups_to_add as $grp_to_add) {
	    add_group_user($db, $grp_to_add, $usr_id_to_edit);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_user') {
$delete_user = unserialize(base64_decode(filter_input(INPUT_POST, 'delete_user')));
if ($delete_user == NULL) {
    $delete_user = unserialize(base64_decode(filter_input(INPUT_GET, 'delete_user')));
    if ($delete_user == NULL) {
        echo("Nothing came through for delete_user");
    }
}

    try {
	if($delete_user) {
	    $usr_id_to_del = get_user_id($db, $delete_user['_user']);
	    delete_user_groups($db, $usr_id_to_del);
	    delete_user($db, $delete_user['_user']);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} else { echo "Something's wrong!"; }

?>
