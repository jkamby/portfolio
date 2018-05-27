<?php // the try/catch for these actions is in the caller, index.php

// include('rshousekeepinglog.php');

function add_deleted_stuff($db, $from_table, $deleted_record) {
    $query = 'INSERT INTO RSDeletedStuff (fromtable, recordsummary) VALUES (:from_table, :deleted_record)';
    $statement = $db->prepare($query);
    $statement->bindValue(':from_table', $from_table);
    $statement->bindValue(':deleted_record', $deleted_record);
    $remarks = $from_table . ' deletion archive ' . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

// getters & setters: TODO.

?>

