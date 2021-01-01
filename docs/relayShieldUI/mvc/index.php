<?php

 session_start();
 
 require('model/rsusers.php');
 require('model/rsdatabase.php');
 require('model/rshousekeepinglog.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'login';
    }
}

if ($action == 'login') {
    include('login.php');
} elseif ($action == 'sign_in') {
$username = filter_input(INPUT_POST, 'login_username');
if ($username == NULL) {
    $username = filter_input(INPUT_GET, 'login_username');
    if ($username == NULL) {
        echo('$username is blank!');
    }
}
// TODO: use password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
$password = filter_input(INPUT_POST, 'login_password');
if ($password == NULL) {
    $password = filter_input(INPUT_GET, 'login_password');
    if ($password == NULL) {
        echo('$password is blank!');
    }
}

// $encryptedpassword = $password ? password_hash($password, PASSWORD_BCRYPT) : '';

    try {
        $successful_login = user_login($db, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('errors/database_error.php');
        exit();
    }
    if($successful_login) {
        //test to see if user an admin/not
	$user = get_user_by_name($db, $username);
	$_SESSION['user'] = $user;
	$_SESSION['firstname'] = $user['firstname'];
	$_SESSION['usertypeid'] = $user['usertypeid'];
	$_SESSION['username'] = $user['username'];
        include('login.php'); // include('admins/facility/index.php'); // include('users');
    } else {
        echo('Login not successful...' . $encryptedpassword);
        $login_message = 'Login not successful...';
        include('login.php');
    }
} elseif ($action == 'logout') {
    unset($_SESSION['firstname']);
    unset($_SESSION['usertypeid']);
    unset($_SESSION['username']);
    include('login.php');
} elseif ($action == 'registration') {
    include('registration.php');
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
        include('login.php');
    } else {
        $registration_message = 'User registration NOT successful...';
        include('registration.php');
    }
} elseif ($action == 'recovery') {
    include('passwdrecovery.php');
} elseif ($action == 'recover_password') {
$recovery_email = filter_input(INPUT_POST, 'recovery_email');
if ($recovery_email == NULL) {
    $recovery_email = filter_input(INPUT_GET, 'recovery_email');
    if ($recovery_email == NULL) {
        echo('$recovery_email is blank!');
    }
}

    try {
        $recovery_successful = recover_password($db, $recovery_email);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    if($recovery_successful) {
        $recovery_message='Password Recovery successful... please check your email...';
        include('login.php');
    } else {
        $recovery_message='Password Recovery unsuccessful... please try again.';
        include('passwdrecovery.php');
    }
} elseif ($action == 'edit_profile') {
$recovery_email = filter_input(INPUT_POST, 'recovery_email');

    try {
	$user = get_user_by_name($db, $_SESSION['username']); 
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    include('profile.php');
} elseif ($action == 'update_profile') {
$old_profile = unserialize(filter_input(INPUT_POST, 'old_profile'));
if ($old_profile == NULL) {
    $old_profile = unserialize(filter_input(INPUT_GET, 'old_profile'));
    if ($old_profile == NULL) {
        echo("Nothing came through for old_profile");
    }
}

$profile_firstname = filter_input(INPUT_POST, 'profile_firstname');
if ($profile_firstname == NULL) {
    $profile_firstname = filter_input(INPUT_GET, 'profile_firstname');
    if ($profile_firstname == NULL) {
        echo('$profile_firstname is blank!');
    }
}

$profile_lastname = filter_input(INPUT_POST, 'profile_lastname');
if ($profile_lastname == NULL) {
    $profile_lastname = filter_input(INPUT_GET, 'profile_lastname');
    if ($profile_lastname == NULL) {
        echo('$profile_lastname is blank!');
    }
}
$profile_email = filter_input(INPUT_POST, 'profile_email');
if ($profile_email == NULL) {
    $profile_email = filter_input(INPUT_GET, 'profile_email');
    if ($profile_email == NULL) {
        echo('$profile_email is blank!');
    }
}

$profile_username = filter_input(INPUT_POST, 'profile_username');
if ($profile_username == NULL) {
    $profile_username = filter_input(INPUT_GET, 'profile_username');
    if ($profile_username == NULL) {
        echo('$profile_username is blank!');
    }
}
// TODO: use password_hash($profile_password, PASSWORD_BCRYPT, ['cost' => 10]);
$profile_password = filter_input(INPUT_POST, 'profile_password');
if ($profile_password == NULL) {
    $profile_password = filter_input(INPUT_GET, 'profile_password');
    if ($profile_password == NULL) {
        echo('$profile_password is blank!');
    }
}

$profile_encryptedpassword = $profile_password ? password_hash($profile_password, PASSWORD_BCRYPT) : '';

$profile_confirm_password = filter_input(INPUT_POST, 'profile_confirm_password');
if ($profile_confirm_password == NULL) {
    $profile_confirm_password = filter_input(INPUT_GET, 'profile_confirm_password');
    if ($profile_confirm_password == NULL) {
        echo('$profile_confirm_password is blank!');
    }
}

    try {
	if($profile_firstname || $profile_lastname || $profile_email || $profile_password) {
	    update_user($db, $profile_firstname, $profile_lastname, $profile_email, $profile_password, $old_profile);
	}
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    header('Location: .');
} elseif ($action == 'delete_profile') {
//    include
} elseif ($action == 'profile_delete') {
$recovery_email = filter_input(INPUT_POST, 'recovery_email');
if ($recovery_email == NULL) {
    $recovery_email = filter_input(INPUT_GET, 'recovery_email');
    if ($recovery_email == NULL) {
        echo('$recovery_email is blank!');
    }
}

    try {
        $recovery_successful = recover_password($db, $recovery_email);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
    }
    if($recovery_successful) {
        $recovery_message='Password Recovery successful... please check your email...';
        include('login.php');
    } else {
        $recovery_message='Password Recovery unsuccessful... please try again.';
        include('passwdrecovery.php');
    }
} else { echo "Something's wrong!"; }

?>

