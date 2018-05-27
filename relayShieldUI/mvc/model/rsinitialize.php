<?php

function initial_db($db) {
    try {
	$query = 'DELETE FROM RSDeviceFacilityMatches;';
	$query .= 'DELETE FROM RSFacilityGroupMemberships;';
	$query .= 'DELETE FROM RSFacilities;';
	$query .= 'DELETE FROM RSDevices;';
	$query .= 'DELETE FROM RSGroupUserMemberships;';
	$query .= 'DELETE FROM RSGroups;';
	$query .= 'DELETE FROM RSUsers;';
	$query .= 'DELETE FROM RSUserTypes;';
	$query .= 'DELETE FROM RSHouseKeepingLog;';
        $query .= 'DELETE FROM RSDeletedStuff;';
        $query .= 'DELETE FROM RSActivityLog;';
	$query .= "INSERT INTO RSHouseKeepingLog VALUES (1, now(), 'Initialization of database!');";
        $query .= "INSERT INTO RSUserTypes VALUES (1, 'regular', '1-facility user'), (2, 'uber', 'multi-facility user'), (3, 'admin', 'user-group-facility assigner'), (4, 'super', 'group-facility creator');";
        $statement = $db->prepare($query);
        $statement->execute();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../errors/database_error.php');
        exit();
    }
    return $statement;
}
?>
