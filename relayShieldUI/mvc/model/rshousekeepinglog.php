<?php // the try/catch for these actions is in the caller, index.php 

session_start();

function add_log($db, $remarks) {
    $query = 'INSERT INTO RSHouseKeepingLog (remarks, userid)';
    $query .= ' VALUES (:remarks, ' . (isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 99999) . ')';
    $statement = $db->prepare($query);
    $statement->bindValue(':remarks', $remarks);
    $statement->execute();
    $statement->closeCursor();
}

function update_log($db, $log_id, $remarks) {
    $query = 'UPDATE RSHouseKeepingLog SET remarks = :remarks';
    $query .= ', userid = ' . $_SESSION['user']['id'] . ' WHERE id = :log_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':remarks', $remarks);
    $statement->bindValue(':log_id', $log_id);
    $statement->execute();
    $statement->closeCursor();
}

?>
