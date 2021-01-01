<?php

// include('rshousekeepinglog.php');
// include('rsdeletedstuff.php');

function add_device_facility($db, $deviceid, $facilityid) {	// NB: this is not the deviceid string but the int PK!
	
    $query = 'INSERT INTO RSDeviceFacilityMatches (deviceid, facilityid) VALUES (:deviceid, :facilityid)';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $statement->bindValue(':facilityid',$facilityid);
    $remarks = 'Adding deviceid-facilityid pair' . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function update_device_facility($db, $new_deviceid, $facilityid) {	// NB: this is not the new_deviceid string but the int PK!
	
	$query = 'UPDATE RSDeviceFacilityMatches ';
	$query .= 'SET deviceid = :new_deviceid ';
	$query .= 'WHERE facilityid = :facilityid';
	$statement = $db->prepare($query);
	$statement->bindValue(':new_deviceid',$new_deviceid);
	$statement->bindValue(':facilityid',$facilityid);
	$remarks = 'Updating deviceid-facilityid pair' . ($statement->execute() ? ' successful.' : ' failed.');
	$statement->closeCursor();
	add_log($db, $remarks);
}

function update_facility_device($db, $deviceid, $new_facilityid) {	// NB: this is not the new_deviceid string but the int PK!
	
	$query = 'UPDATE RSDeviceFacilityMatches ';
	$query .= 'SET facilityid = :new_facilityid ';
	$query .= 'WHERE deviceid = :deviceid';
	$statement = $db->prepare($query);
	$statement->bindValue(':deviceid',$deviceid);
	$statement->bindValue(':new_facilityid',$new_facilityid);
	$remarks = 'Updating deviceid-facilityid pair' . ($statement->execute() ? ' successful.' : ' failed.');
	$statement->closeCursor();
	add_log($db, $remarks);
}

function get_device_by_facility($db, $facilityid) {
	$query = 'SELECT * FROM RSDeviceFacilityMatches WHERE facilityid = :facilityid';
	$statement = $db->prepare($query);
	$statement->bindValue(':facilityid',$facilityid);
	$statement->execute();
	$device_id = $statement->fetch()['deviceid'];
	$statement->closeCursor();
	return $device_id;
}

function get_facility_by_device($db, $deviceid) { // NB: this is not the deviceid string but the int PK!
	$query = 'SELECT * FROM RSDeviceFacilityMatches WHERE deviceid = :deviceid';
	$statement = $db->prepare($query);
	$statement->bindValue(':deviceid',$deviceid);
	$statement->execute();
	$facility_id = $statement->fetch()['facilityid'];
	$statement->closeCursor();
	return $facility_id;
}

function get_dev_fac_by_facility($db, $facilityid) {
	$query = 'SELECT * FROM RSDeviceFacilityMatches WHERE facilityid = :facilityid';
	$statement = $db->prepare($query);
	$statement->bindValue(':facilityid',$facilityid);
	$statement->execute();
	$dev_fac = $statement->fetch();
	$statement->closeCursor();
	return $dev_fac;
}

function get_dev_fac_by_device($db, $deviceid) { // NB: this is not the deviceid string but the int PK!
	$query = 'SELECT * FROM RSDeviceFacilityMatches WHERE deviceid = :deviceid';
	$statement = $db->prepare($query);
	$statement->bindValue(':deviceid',$deviceid);
	$statement->execute();
	$dev_fac = $statement->fetch();
	$statement->closeCursor();
	return $dev_fac;
}

function get_all_device_facilities($db) {
	$query = 'SELECT * FROM RSDeviceFacilityMatches';
	$statement = $db->prepare($query);
	$statement->execute();
	$device_facilities = $statement->fetchAll();
	$statement->closeCursor();
	return $device_facilities;
}

function delete_device_facility($db, $deviceid, $facilityid) { // NB: this is not the deviceid string but the int PK!
    $to_be_deleted = json_encode(get_device_facility($db, $deviceid, $facilityid));
    $query = 'DELETE FROM RSDeviceFacilityMatches WHERE deviceid = :deviceid AND facilityid = :facilityid';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid', $deviceid);
    $statement->bindValue(':facilityid', $facilityid);
    $remarks = 'deviceid-facilityid pair' . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSDeviceFacilityMatches', $to_be_deleted);
}

function delete_dev_fac_by_facility($db, $facilityid) {
	$to_be_deleted = json_encode(get_dev_fac_by_facility($db, $facilityid));
	$query = 'DELETE FROM RSDeviceFacilityMatches WHERE facilityid = :facilityid';
	$statement = $db->prepare($query);
	$statement->bindValue(':facilityid', $facilityid);
	$remarks = 'deviceid-facilityid pair' . ($statement->execute() ? ' deleted.' : ' not deleted.');
	$statement->closeCursor();
	add_log($db, $remarks);
	if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSDeviceFacilityMatches', $to_be_deleted);
}

function delete_dev_fac_by_device($db, $deviceid) { // NB: this is not the deviceid string but the int PK!
	$to_be_deleted = json_encode(get_dev_fac_by_device($db, $deviceid));
	$query = 'DELETE FROM RSDeviceFacilityMatches WHERE deviceid = :deviceid';
	$statement = $db->prepare($query);
	$statement->bindValue(':deviceid', $deviceid);
	$remarks = 'deviceid-facilityid pair' . ($statement->execute() ? ' deleted.' : ' not deleted.');
	$statement->closeCursor();
	add_log($db, $remarks);
	if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSDeviceFacilityMatches', $to_be_deleted);
}

function delete_all_device_facilities($db) {
    $to_be_deleted = json_encode(get_all_device_facilities($db));
    $query = 'DELETE FROM RSDeviceFacilityMatches';
    $statement = $db->prepare($query);
    $remarks = 'All deviceid-facilityid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSDeviceFacilityMatches', $to_be_deleted);
}

?>
