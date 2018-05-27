<?php

// include('rshousekeepinglog.php');
// include('rsdeletedstuff.php');

function add_group_user($db, $groupid, $userid) {

    $query = 'INSERT INTO RSGroupUserMemberships (groupid, userid) VALUES (:groupid, :userid)';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupid', $groupid);
    $statement->bindValue(':userid', $userid);
    $remarks = 'Adding groupid-userid pair' . ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
}

/*
function add_group_users($db, $groupid, $userids) {
        foreach($userids as $userid) {
                $query = 'INSERT INTO RSGroupUserMemberships VALUES (:groupid, :userid)';
                $statement = $db->prepare($query);
                $statement->bindValue(':groupid',$groupid);
                $statement->bindValue(':userids',$userids);
                $statement->bindValue(':userid',$userid);
                $remarks = 'Adding groupid-userid pair' . ($statement->execute() ? ' successful.' : ' failed.');
                $statement->closeCursor();
//              add_log($db, $remarks);
        }
}
*/

function get_groups_by_user($db, $userid) {
        $query = 'SELECT * FROM RSGroupUserMemberships WHERE userid = :userid';
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        $user_groups = [];
        foreach($results as $result) {
                $user_groups[] = $result['groupid'];
        }
        return $user_groups;
}


function get_users_by_group($db, $groupid) {
        $query = 'SELECT * FROM RSGroupUserMemberships WHERE groupid = :groupid';
        $statement = $db->prepare($query);
        $statement->bindValue(':groupid', $groupid);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        $group_users = [];
        foreach($results as $result) {
                $group_users[] = $result['userid'];
        }
        return $group_users;
}

function get_all_group_users($db) {
        $query = 'SELECT * FROM RSGroupUserMemberships';
        $statement = $db->prepare($query);
        $statement->execute();
        $group_users = $statement->fetchAll();
        $statement->closeCursor();
        return $group_users;
}

/*
function delete_group_user($db, $groupid, $userid) {
    $to_be_deleted = json_encode(get_group_user($db, $groupid, $userid));
    $query = 'DELETE FROM RSGroupUserMemberships WHERE groupid = :groupid AND userid = :userid';
    $statement = $db->prepare($query);
    $statement->bindValue(':groupid',$groupid);
    $statement->bindValue(':userid',$userid);
    $remarks = 'groupid-userid pair' . ($statement->execute() ? ' deleted.' : 'not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSGroupUserMemberships', $to_be_deleted);
}
*/

function delete_group_users($db, $groupid) {
                $to_be_deleted = json_encode(array($groupid => get_users_by_group($db, $groupid)), JSON_FORCE_OBJECT);
                echo('to be deleted: ' . $to_be_deleted);
                $query = 'DELETE FROM RSGroupUserMemberships WHERE groupid = :groupid';
                $statement = $db->prepare($query);
                $statement->bindValue(':groupid', $groupid);
                $remarks = 'groupid-userid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
                $statement->closeCursor();
                add_log($db, $remarks);
                if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSGroupUserMemberships', $to_be_deleted);
}

function delete_user_groups($db, $userid) {
                $to_be_deleted = json_encode(array($userid => get_groups_by_user($db, $userid)), JSON_FORCE_OBJECT);
                $query = 'DELETE FROM RSGroupUserMemberships WHERE userid = :userid';
                $statement = $db->prepare($query);
                $statement->bindValue(':userid',$userid);
                $remarks = 'groupid-userid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
                $statement->closeCursor();
                add_log($db, $remarks);
                if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSGroupUserMemberships', $to_be_deleted);
}


function delete_all_group_users($db) {
    $to_be_deleted = json_encode(get_all_group_users($db));
    $query = 'DELETE FROM RSGroupUserMemberships';
    $statement = $db->prepare($query);
    $remarks = 'All groupid-userid pairs' . ($statement->execute() ? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSGroupUserMemberships', $to_be_deleted);
}

?>

