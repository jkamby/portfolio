<?php

    $dsn = 'mysql:host=localhost;dbname=RelayShieldDB';
    $username = 'root';		// TODO: should pick up logged in username
    $password = 'Root@123';


try {
    // specify that DB errors cause exceptions, so we can see
    // more about them
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('../errors/database_error.php');
    exit();
}

?>
