<?php

// include('rshousekeepinglog.php');
// include('rsdeletedstuff.php');

function add_device($db, $deviceid, $access_token, $devicedescription, $activestatus = false) {
	
    $query = 'INSERT INTO RSDevices (deviceid, encryptedaccesstoken, devicedescription, activestatus) VALUES (:deviceid, :encryptedaccesstoken, :devicedescription, :activestatus);';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $statement->bindValue(':encryptedaccesstoken',$access_token);
    $statement->bindValue(':devicedescription',$devicedescription);
    $statement->bindValue(':activestatus',$activestatus);
    $remarks = 'Device: ' . ($deviceid . $statement->execute() ? ' added.' : ' not added.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function update_device($db, $deviceid, $access_token, $devicedescription, $activestatus, $old) {
	
	$query = 'UPDATE RSDevices SET ';
	$remarks = 'Updating device: ' . $old['deviceid'];

	if($old['deviceid'] != $deviceid && get_device_id($db, $deviceid) == NULL) {
		$query .= 'deviceid = :deviceid';
		$remarks .= ' name';
	}
	if($old['encryptedaccesstoken'] != $access_token) {
		if(strpos($query, 'deviceid')) {
			$query .= ', ';
			$remarks .= ', ';
		}
		$query .= 'encryptedaccesstoken = :access_token';
		$remarks .= "access token";
	}
	if($old['devicedescription'] != $devicedescription) {
		if(strpos($query, 'token') || strpos($query, 'deviceid')) {
			$query .= ', ';
			$remarks .= ', ';
		}
		$query .= 'devicedescription = :devicedescription';
		$remarks .= "description";
	}
	if($old['activestatus'] != $activestatus) {
		if(strpos($query, 'description') || strpos($query, 'token') || strpos($query, 'deviceid')) {
			$query .= ', ';
			$remarks .= ', ';
		}
		$query .= 'activestatus = :activestatus';
		$remarks .= 'status';
	}

    if(strlen($query) > 21) {
	$query .= ' WHERE id = ' . $old['id'];
	$statement = $db->prepare($query);
	if(strpos($query, 'deviceid')) $statement->bindValue(':deviceid',$deviceid);
	if(strpos($query, 'access_token')) $statement->bindValue(':access_token',$access_token);
	if(strpos($query, 'devicedescription')) $statement->bindValue(':devicedescription',$devicedescription);
	if(strpos($query, 'activestatus')) $statement->bindValue(':activestatus',$activestatus);
	$remarks .= $statement->execute() ? ' successful.' : ' unsuccessful.';
	$statement->closeCursor();
    }
	$remarks .= 'not attempted.';
	
	add_log($db, $remarks);
}

function get_device_id($db, $deviceid) {
	$query = 'SELECT id FROM RSDevices WHERE deviceid = :deviceid';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $statement->execute();
    $device_id = $statement->fetch()['id'];
    $statement->closeCursor();
    return $device_id;
}

function get_device_by_id($db, $device_id) {
	$query = 'SELECT * FROM RSDevices WHERE id = :device_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':device_id', $device_id);
    $statement->execute();
    $device = $statement->fetch();
    $statement->closeCursor();
    return $device;
}

function get_device_by_name($db, $device_name) {
	$query = 'SELECT * FROM RSDevices WHERE deviceid = :device_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':device_name', $device_name);
    $statement->execute();
    $device = $statement->fetch();
    $statement->closeCursor();
    return $device;
}

function get_all_devices($db) {
	$query = 'SELECT * FROM RSDevices';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_devices = $statement->fetchAll();
    $statement->closeCursor();
    return $all_devices;
}

function get_devices_list($db) {
    $query = 'SELECT D.deviceid AS device, D.encryptedaccesstoken AS token';
    $query .= ', IFNULL(DF.facilityname, "[none]") AS facility, D.activestatus AS status';
    $query .= ', D.devicedescription AS description';
    $query .= ' FROM RSDevices D';
    $query .= ' LEFT JOIN (SELECT DFM.deviceid AS deviceid, DFM.facilityid AS facilityid, F.facilityname AS facilityname FROM RSDeviceFacilityMatches DFM, RSFacilities F WHERE DFM.facilityid = F.id) DF ON D.id = DF.deviceid';
    $query .= ' ORDER BY D.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $devices_list = $statement->fetchAll();
    $statement->closeCursor();
    return $devices_list;
}

function get_active_devices_list($db) {
    $query = 'SELECT D.deviceid AS device, D.encryptedaccesstoken AS token';
    $query .= ', IFNULL(DF.facilityname, "[none]") AS facility, D.activestatus AS status';
    $query .= ', D.devicedescription AS description';
    $query .= ' FROM RSDevices D';
    $query .= ' LEFT JOIN (SELECT DFM.deviceid AS deviceid, DFM.facilityid AS facilityid, F.facilityname AS facilityname FROM RSDeviceFacilityMatches DFM, RSFacilities F WHERE DFM.facilityid = F.id) DF ON D.id = DF.deviceid';
    $query .= ' WHERE D.activestatus = true';
    $query .= ' ORDER BY D.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_devices_list = $statement->fetchAll();
    $statement->closeCursor();
    return $active_devices_list;
}

function get_inactive_devices_list($db) {
    $query = 'SELECT D.deviceid AS device, D.encryptedaccesstoken AS token';
    $query .= ', IFNULL(DF.facilityname, "[none]") AS facility, D.activestatus AS status';
    $query .= ', D.devicedescription AS description';
    $query .= ' FROM RSDevices D';
    $query .= ' LEFT JOIN (SELECT DFM.deviceid AS deviceid, DFM.facilityid AS facilityid, F.facilityname AS facilityname FROM RSDeviceFacilityMatches DFM, RSFacilities F WHERE DFM.facilityid = F.id) DF ON D.id = DF.deviceid';
    $query .= ' WHERE D.activestatus = false';
    $query .= ' ORDER BY D.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $inactive_devices_list = $statement->fetchAll();
    $statement->closeCursor();
    return $inactive_devices_list;
}

function get_all_available_devices($db) {
	$query = 'SELECT * FROM RSDevices WHERE id NOT IN
			(SELECT deviceid FROM RSDeviceFacilityMatches)';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_available_devices = $statement->fetchAll();
    $statement->closeCursor();
    return $all_available_devices;
}

function get_active_devices($db) {
	$query = 'SELECT * FROM RSDevices WHERE activestatus = true';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_devices = $statement->fetchAll();
    $statement->closeCursor();
    return $active_devices;
}

function activate_device($db, $deviceid) {
	$query = 'UPDATE RSDevices SET activestatus = true WHERE deviceid = :deviceid';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $remarks = 'Device: ' . ($deviceid . $statement->execute() ? ' activated.' : ' not activated.');
    $statement->closeCursor();
	add_log($db, $remarks);
}

function deactivate_device($db, $deviceid) {
	$query = 'UPDATE RSDevices SET activestatus = false WHERE deviceid = :deviceid';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $remarks = 'Device: ' . ($deviceid . $statement->execute() ? ' de-activated.' : ' not de-activated.');
    $statement->closeCursor();
	add_log($db, $remarks);
}

function delete_device($db, $deviceid) {
    $to_be_deleted = json_encode(get_device_by_id($db, $deviceid));
    $query = 'DELETE FROM RSDevices WHERE deviceid = :deviceid';
    $statement = $db->prepare($query);
    $statement->bindValue(':deviceid',$deviceid);
    $remarks = 'Device ' . $deviceid . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSDevices', $to_be_deleted);
}

?>
