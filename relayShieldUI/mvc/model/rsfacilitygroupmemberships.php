<?php

// include('rshousekeepinglog.php');
// include('rsdeletedstuff.php');

function add_facility_group($db, $facilityid, $groupid ) {

    $query = 'INSERT INTO RSFacilityGroupMemberships (facilityid, groupid) VALUES (:facilityid, :groupid)';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityid', $facilityid);
    $statement->bindValue(':groupid', $groupid);
    $remarks = 'Adding facilityid-groupid pair' . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

function add_facility_groups($db, $facilityid, $groupids) {
        foreach($groupids as $groupid) {
                $query = 'INSERT INTO RSFacilityGroupMemberships (facilityid, groupid) VALUES (:facilityid, :groupid)';
                $statement = $db->prepare($query);
                $statement->bindValue(':facilityid',$facilityid);
                $statement->bindValue(':groupid',$groupid);
                $remarks = 'Adding facilityid-groupid pair' . ($statement->execute() ? ' successful.' : ' failed.');
                $statement->closeCursor();
                add_log($db, $remarks);
        }
}

function add_group_facilities($db, $groupid, $facilityids) {
        foreach($facilityids as $facilityid) {
                $query = 'INSERT INTO RSFacilityGroupMemberships VALUES ($facilityid, :groupid)';
                $statement = $db->prepare($query);
                $statement->bindValue(':facilityids',$facilityids);
                $statement->bindValue(':facilityid',$facilityid);
                $statement->bindValue(':groupid',$groupid);
                $remarks = 'Adding facilityid-groupid pair' . ($statement->execute() ? ' successful.' : ' failed.');
                $statement->closeCursor();
                add_log($db, $remarks);
        }
}

function get_facilities_by_group($db, $groupid) {
        $query = 'SELECT * FROM RSFacilityGroupMemberships WHERE groupid = :groupid';
        $statement = $db->prepare($query);
        $statement->bindValue(':groupid',$groupid);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        $group_facilities = [];
        foreach($results as $result) {
                $group_facilities[] = $result['facilityid'];
        }
        return $group_facilities;
}

function get_groups_by_facility($db, $facilityid) {
        $query = 'SELECT * FROM RSFacilityGroupMemberships WHERE facilityid = :facilityid';
        $statement = $db->prepare($query);
        $statement->bindValue(':facilityid',$facilityid);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        $facility_groups = [];
        foreach($results as $result) {
                $facility_groups[] = $result['groupid'];
        }
        return $facility_groups;
}

function get_all_facility_groups($db) {
        $query = 'SELECT * FROM RSFacilityGroupMemberships';
        $statement = $db->prepare($query);
        $statement->execute();
        $facility_groups = $statement->fetchAll();
        $statement->closeCursor();
        return $facility_groups;
}

function delete_facility_group($db, $facilityid, $groupid) {
    $to_be_deleted = json_encode(get_facility_group($db, $facilityid, $groupid));
    $query = 'DELETE FROM RSFacilityGroupMemberships WHERE facilityid = :facilityid AND groupid = :groupid';
    $statement = $db->prepare($query);
    $statement->bindValue(':facilityid',$facilityid);
    $statement->bindValue(':groupid',$groupid);
    $remarks = 'facilityid-groupid pair' . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSFacilityGroupMemberships', $to_be_deleted);
}

function delete_facility_groups($db, $facilityid) {
        $to_be_deleted = json_encode(array($facilityid => get_groups_by_facility($db, $facilityid)), JSON_FORCE_OBJECT);
        $query = 'DELETE FROM RSFacilityGroupMemberships WHERE facilityid = :facilityid';
        $statement = $db->prepare($query);
        $statement->bindValue(':facilityid', $facilityid);
        $remarks = 'facilityid-groupid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
        $statement->closeCursor();
        add_log($db, $remarks);
        if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSFacilityGroupMemberships', $to_be_deleted);
}

function delete_group_facilities($db, $groupid) {
        $to_be_deleted = json_encode(array($groupid => get_facilities_by_group($db, $groupid)), JSON_FORCE_OBJECT);
        $query = 'DELETE FROM RSFacilityGroupMemberships WHERE groupid = :groupid';
        $statement = $db->prepare($query);
        $statement->bindValue(':groupid',$groupid);
        $remarks = 'facility-groupid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
        $statement->closeCursor();
        add_log($db, $remarks);
        if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSFacilityGroupMemberships', $to_be_deleted);
}

function delete_all_facility_groups($db) {
    $to_be_deleted = json_encode(get_all_facility_groups($db));
    $query = 'DELETE FROM RSFacilityGroupMemberships';
    $statement = $db->prepare($query);
    $remarks = 'All facilityid-groupid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSFacilityGroupMemberships', $to_be_deleted);
}

?>

