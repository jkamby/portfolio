<?php

// include('rshousekeepinglog.php');
// include('rsdeletedstuff.php');

function add_group($db, $groupname, $groupdescription, $activestatus) {

    $query = 'INSERT INTO RSGroups (groupname, groupdescription, activestatus)';
    $query .= ' VALUES (:groupname, :groupdescription, :activestatus);';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname', $groupname);
    $statement->bindValue(':groupdescription', $groupdescription);
    $statement->bindValue(':activestatus', $activestatus);
    $remarks = 'Adding group: '. $groupname . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function update_group ($db, $groupname, $groupdescription, $activestatus, $old) {
        $remarks = 'Updating group: ' . $old['groupname'];
        $query = 'UPDATE RSGroups SET ';
        if($old['groupname'] != $groupname && get_group_id($db, $groupname) == NULL) {
                $query .= 'groupname = :groupname';
                $remarks .= ' name';
        }
        if($old['groupdescription'] != $groupdescription) {
                if(strpos($query, 'groupname')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
                $query .= 'groupdescription = :groupdescription';
                $remarks .= "description";
        }
        if($old['activestatus'] != $activestatus) {
                if(strpos($query, 'description') || strpos($query, 'groupname')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
                $query .= 'activestatus = :activestatus';
                $remarks .= 'status';
        }
	
	if(strlen($query) > 21) {
		$query .= ' WHERE id = ' . $old['id'];
		echo('update_query: ' . $query);
	        $statement = $db->prepare($query);

        	if(strpos($query, 'groupname')) $statement->bindValue(':groupname', $groupname);
		if(strpos($query, 'groupdescription')) $statement->bindValue(':groupdescription', $groupdescription);
		if(strpos($query, 'activestatus')) $statement->bindValue(':activestatus', $activestatus);
        	$remarks .= $statement->execute() ? ' successful.' : ' not successful.';
        	$statement->closeCursor();
        } else {
		$remarks .= 'not attempted.';// do nothing.
	}

        add_log($db, $remarks);
}

function get_group_id($db, $groupname) {
    $query = 'SELECT id FROM RSGroups WHERE groupname = :groupname';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname',$groupname);
    $statement->execute();
    $group_id = $statement->fetch()['id'];
    $statement->closeCursor();
    return $group_id;
}

function get_group_by_name($db, $groupname) {
    $query = 'SELECT * FROM RSGroups WHERE groupname = :groupname';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname',$groupname);
    $statement->execute();
    $group = $statement->fetch();
    $statement->closeCursor();
    return $group;
}

function get_group_by_id($db, $groupid) {
    $query = 'SELECT * FROM RSGroups WHERE id = :groupid';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupid',$groupid);
    $statement->execute();
    $group = $statement->fetch();
    $statement->closeCursor();
    return $group;
}

function get_all_groups($db) {
    $query = 'SELECT * FROM RSGroups';
    $statement = $db->prepare($query);
    $statement->execute();
    $groups = $statement->fetchAll();
    $statement->closeCursor();
    return $groups;
}

function get_groups_list($db) {
        $query = 'SELECT G2.groupname AS _group, G2.groupdescription AS description, IFNULL(U.GUMUsers, 0) AS users';
        $query .= ', IFNULL(F.FGMFacilities, 0) AS facilities, G2.activestatus AS status';
        $query .= ' FROM RSGroups G2';
        $query .= ' LEFT JOIN (SELECT G1.id AS GUMiD, COUNT(groupid) AS GUMUsers FROM RSGroupUserMemberships GUM, RSGroups G1 WHERE GUM.groupid = G1.id GROUP BY GUM.groupid) U ON G2.id = U.GUMiD';
	$query .= ' LEFT JOIN (SELECT G0.id AS FGMiD, COUNT(groupid) AS FGMFacilities FROM RSFacilityGroupMemberships FGM, RSGroups G0 WHERE FGM.groupid = G0.id GROUP BY FGM.groupid) F ON G2.id = F.FGMiD';
        $query .= ' ORDER BY G2.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $groups_list = $statement->fetchAll();
    $statement->closeCursor();
    return $groups_list;
}

function get_active_groups_list($db) {
        $query = 'SELECT DISTINCT G2.groupname AS _group, G2.groupdescription AS description, IFNULL(U.GUMUsers, 0) AS users';
        $query .= ', IFNULL(F.FGMFacilities, 0) AS facilities, G2.activestatus AS status';
        $query .= ' FROM RSGroups G2';
        $query .= ' LEFT JOIN (SELECT G1.id AS GUMiD, COUNT(groupid) AS GUMUsers FROM RSGroupUserMemberships GUM, RSGroups G1 WHERE GUM.groupid = G1.id GROUP BY GUM.groupid) U ON G2.id = U.GUMiD';
	$query .= ' LEFT JOIN (SELECT G0.id AS FGMiD, COUNT(groupid) AS FGMFacilities FROM RSFacilityGroupMemberships FGM, RSGroups G0 WHERE FGM.groupid = G0.id GROUP BY FGM.groupid) F ON G2.id = F.FGMiD';
	$query .= ' WHERE G2.activestatus = true';
        $query .= ' ORDER BY G2.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_groups_list = $statement->fetchAll();
    $statement->closeCursor();
    return $active_groups_list;
}

function get_all_available_groups($db) {
        $query = 'SELECT * FROM RSGroups WHERE id NOT IN
                        (SELECT groupid FROM RSGroupUserMemberships)';
    $statement = $db->prepare($query);
    $statement->execute();
    $all_available_groups = $statement->fetchAll();
    $statement->closeCursor();
    return $all_available_groups;
}

function get_active_groups($db) {
        $query = 'SELECT * FROM RSGroups WHERE activestatus = true';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_groups = $statement->fetchAll();
    $statement->closeCursor();
    return $active_groups;
}

function activate_group($db, $groupname) {
        $query = 'UPDATE RSGroups SET activestatus = true WHERE groupname = :groupname';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname',$groupname);
    $remarks = $groupname . ($statement->execute()? ' activated.' : ' not activated.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function deactivate_group($db, $groupname) {
        $query = 'UPDATE RSGroups SET activestatus = false WHERE groupname = :groupname';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname',$groupname);
    $remarks = $groupname . ($statement->execute()? ' de-activated.' : ' not de-activated.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function delete_group($db, $groupname) {
    $to_be_deleted = json_encode(get_group_by_name($db, $groupname));
    $query = 'DELETE FROM RSGroups WHERE groupname = :groupname';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupname',$groupname);
    $remarks = $groupname . ($statement->execute()? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSGroups', $to_be_deleted);
}

?>
		
