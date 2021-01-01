<?php

// include 'rshousekeepinglog.php';
// include 'rsdeletedstuff.php';

function add_facility($db, $facilityname, $numberofrelays, $activestatus) {
    $query = 'INSERT INTO RSFacilities (facilityname, numberofrelays, activestatus) VALUES (:facilityname, :numberofrelays, :activestatus);';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityname',$facilityname);
    $statement->bindValue(':numberofrelays',$numberofrelays);
    $statement->bindValue(':activestatus',$activestatus);
    $remarks = 'Adding facility: '. $facilityname . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function update_facility ($db, $facilityname, $numberofrelays, $activestatus, $old) {
	$query = 'UPDATE RSFacilities SET ';
	$remarks = 'Updating facility: ' . $old['facilityname'];

	if($old['facilityname'] != $facilityname && get_facility_id($db, $facilityname) == NULL) {
		$query .= 'facilityname = :facilityname';
		$remarks .= ' name';
	}
	if($old['numberofrelays'] != $numberofrelays) {
		if(strpos($query, 'name') !== false) {
			$query .= ', ';
			$remarks .= ', ';
		}
		$query .= 'numberofrelays = :numberofrelays';
		$remarks .= 'relays';
	}
	if($old['activestatus'] != $activestatus) {
		if(strpos($query, 'relays') !== false || strpos($query, 'name') !== false) {
			$query .= ', ';
			$remarks .= ', ';
		}
		$query .= 'activestatus = :activestatus';
		$remarks .= 'status';
	}
	if(strlen($query) > 23) {
            $query .= ' WHERE id = '. $old['id'];
	    $statement = $db->prepare($query);
	    if(strpos($query, 'facilityname')) $statement->bindValue(':facilityname',$facilityname);
	    if(strpos($query, 'numberofrelays')) $statement->bindValue(':numberofrelays',$numberofrelays);
	    if(strpos($query, 'activestatus')) $statement->bindValue(':activestatus',$activestatus);
	    $remarks .= $statement->execute() ? ' successful.' : ' not successful.';
	    $statement->closeCursor();
	} else {
	    $remarks .= 'not attempted.';// do nothing.
	}
	add_log($db, $remarks);
}

function get_facility_id($db, $facilityname) {
	$query = 'SELECT id FROM RSFacilities WHERE facilityname = :facilityname';
	$statement = $db->prepare($query);
	$statement->bindValue(':facilityname',$facilityname);
	$statement->execute();
	$facility_id = $statement->fetch()['id'];
	$statement->closeCursor();
	return $facility_id;
}

function get_facility_by_name($db, $facilityname) {
	$query = 'SELECT * FROM RSFacilities WHERE facilityname = :facilityname';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityname',$facilityname);
    $statement->execute();
    $facility = $statement->fetch();
    $statement->closeCursor();
    return $facility;
}

function get_facility_by_id($db, $facilityid) {
	$query = 'SELECT * FROM RSFacilities WHERE id = :facilityid';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityid',$facilityid);
    $statement->execute();
    $facility = $statement->fetch();
    $statement->closeCursor();
    return $facility;
}

function get_all_facilities($db) {
	$query = 'SELECT * FROM RSFacilities';
    $statement = $db->prepare($query);
    $statement->execute();
    $facilities = $statement->fetchAll();
    $statement->closeCursor();
    return $facilities;
}

function get_facilities_list($db) {
        $query = 'SELECT F1.facilityname AS facility, F1.numberofrelays AS relays';
	$query .= ', IFNULL(G.FGMGroups, 0) AS groups, IFNULL(DFM1.deviceid, "[none]") AS device, F1.activestatus AS status';
        $query .= ' FROM RSFacilities F1';
	$query .= ' LEFT JOIN (SELECT DFM2.facilityid, D.deviceid FROM RSDeviceFacilityMatches DFM2, RSDevices D WHERE D.id = DFM2.deviceid) DFM1 ON DFM1.facilityid = F1.id';
	$query .= ' LEFT JOIN (SELECT F0.id AS FGMiD, COUNT(facilityid)AS FGMGroups FROM RSFacilityGroupMemberships FGM, RSFacilities F0 WHERE FGM.facilityid = F0.id GROUP BY FGM.facilityid) G ON F1.id = G.FGMiD';
	$query .= ' ORDER BY F1.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $facilities_list = $statement->fetchAll();
    $statement->closeCursor();
    return $facilities_list;
}

function get_active_facilities_list($db) {
        $query = 'SELECT DISTINCT F1.facilityname AS facility, F1.numberofrelays AS relays';
	$query .= ', IFNULL(G.FGMGroups, 0) AS groups, IFNULL(DFM1.deviceid, "[none]") AS device, F1.activestatus AS status';
        $query .= ' FROM RSFacilities F1';
	$query .= ' LEFT JOIN (SELECT DFM2.facilityid, D.deviceid FROM RSDeviceFacilityMatches DFM2, RSDevices D WHERE D.id = DFM2.deviceid) DFM1 ON DFM1.facilityid = F1.id';
	$query .= ' LEFT JOIN (SELECT F0.id AS FGMiD, COUNT(facilityid)AS FGMGroups FROM RSFacilityGroupMemberships FGM, RSFacilities F0 WHERE FGM.facilityid = F0.id GROUP BY FGM.facilityid) G ON F1.id = G.FGMiD';
	$query .= ' WHERE F1.activestatus = true';
	$query .= ' ORDER BY F1.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_facilities_list = $statement->fetchAll();
    $statement->closeCursor();
    return $active_facilities_list;
}

function get_all_available_facilities($db) {
        $query = 'SELECT * FROM RSFacilities WHERE id NOT IN
                        (SELECT facilityid FROM RSDeviceFacilityMatches)';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_available_facilities = $statement->fetchAll();
    $statement->closeCursor();
    return $all_available_facilities;
}

function get_active_facilities($db) {
	$query = 'SELECT * FROM RSFacilities WHERE activestatus = true';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_facilities = $statement->fetchAll();
    $statement->closeCursor();
    return $active_facilities;
}

function activate_facility($db, $facilityname) {
	$query = 'UPDATE RSFacilities SET activestatus = true WHERE facilityname = :facilityname';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityname',$facilityname);
    $remarks = $facilityname . ($statement->execute()? ' activated.' : ' not activated.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function deactivate_facility($db, $facilityname) {
	$query = 'UPDATE RSFacilities SET activestatus = false WHERE facilityname = :facilityname';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityname',$facilityname);
    $remarks = $facilityname . ($statement->execute()? ' de-activated.' : ' not de-activated.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function delete_facility($db, $facilityname) {
    $to_be_deleted = json_encode(get_facility_by_name($db, $facilityname));
    echo('to_be_deleted: ' . $to_be_deleted);
    $query = 'DELETE FROM RSFacilities WHERE facilityname = :facilityname';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityname',$facilityname);
    $remarks = $facilityname . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSFacilities', $to_be_deleted);
}

?>
