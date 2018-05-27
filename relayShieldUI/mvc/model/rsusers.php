<?php

function add_user($db,  $firstname, $lastname, $email, $username, $encryptedpassword, $usertypeid = 1, $activestatus = false) {

    $query = 'INSERT INTO RSUsers (firstname, lastname, email, ';
    $query .= 'username, encryptedpassword, usertypeid, activestatus) ';
    $query .= 'VALUES (:firstname, :lastname, :email, ';
    $query .= ':username, :encryptedpassword, :usertypeid, :activestatus)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':encryptedpassword', $encryptedpassword);
    $statement->bindValue(':usertypeid', $usertypeid);
    $statement->bindValue(':activestatus', $activestatus);
    $remarks = 'Adding user: ' . $username .  ($statement->execute() ? ' successful.' : ' failed.');
    $statement->closeCursor();
    add_log($db, $remarks);
    return strpos($remarks, 'success');

}

function update_user($db, $firstname, $lastname, $email, $password, $old) {

        $query = 'UPDATE RSUsers SET ';
        $remarks = 'Updating user: ' . $old['firstname'];

        if($old['firstname'] != $firstname && get_user_id($db, $firstname) == NULL) {
                $query .= 'firstname = :firstname';
                $remarks .= ' first name';
        }
        if($old['lastname'] != $lastname) {
                if(strpos($query, 'first')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
				$query .= 'lastname = :lastname';
                $remarks .= ' last name';
        }
        if($old['email'] != $email) {
                if(strpos($query, 'last') || strpos($query, 'first')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
                $query .= 'email = :email';
                $remarks .= "email";
        }
        if(!password_verify($password, $old['encryptedpassword'])) {
                if(strpos($query, 'email') || strpos($query, 'last') || strpos($query, 'first')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
                $query .= 'encryptedpassword = \'' . password_hash($password, PASSWORD_BCRYPT) . '\'';
                $remarks .= "password";
        }
        
    if(strlen($query) > 21) {
        $query .= ' WHERE id = ' . $old['id'];
        $statement = $db->prepare($query);

        if(strpos($query, 'first')) $statement->bindValue(':firstname', $firstname);
        if(strpos($query, 'last')) $statement->bindValue(':lastname', $lastname);
        if(strpos($query, 'email')) $statement->bindValue(':email', $email);
//        if(strpos($query, 'password')) $statement->bindValue(':password', $password);
        $remarks .= $statement->execute() ? ' successful.' : ' unsuccessful.';
        $statement->closeCursor();
    } else {
        $remarks .= 'not attempted.';// do nothing.
    }

      add_log($db, $remarks);
}

function update_user_props($db, $activestatus, $usertypeid, $old) {

        $query = 'UPDATE RSUsers SET ';
        $remarks = 'Updating user: ' . $old['firstname'];

        if($old['activestatus'] != $activestatus) {
                $query .= 'activestatus = :activestatus';
                $remarks .= ' status';
        }
        if($old['usertypeid'] != $usertypeid) {
                if(strpos($query, 'status')) {
                        $query .= ', ';
                        $remarks .= ', ';
                }
		$query .= 'usertypeid = :usertypeid';
                $remarks .= ' user type';
        }
        
    if(strlen($query) > 21) {
        $query .= ' WHERE id = ' . $old['id'];
        $statement = $db->prepare($query);
        if(strpos($query, 'status')) $statement->bindValue(':activestatus', $activestatus);
        if(strpos($query, 'typeid')) $statement->bindValue(':usertypeid', $usertypeid);
        $remarks .= $statement->execute() ? ' successful.' : ' unsuccessful.';
        $statement->closeCursor();
    } else {
              $remarks .= 'not attempted.';// do nothing.
    }

      add_log($db, $remarks);
}

function user_login($db, $username, $password) {
    $query = 'SELECT encryptedpassword FROM RSUsers WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $encrypted_passwd = $statement->fetch()['encryptedpassword'];
    $statement->closeCursor();
    return password_verify($password, $encrypted_passwd); // passwd_encryption($password)
}

function get_user_id($db, $username) {
    $query = 'SELECT id FROM RSUsers WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user_id = $statement->fetch()['id'];
    $statement->closeCursor();
    return $user_id;
}

function get_user_by_name($db, $username) {
    $query = 'SELECT * FROM RSUsers WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function get_user_by_id($db, $userid) {
    $query = 'SELECT * FROM RSUsers WHERE id = :userid';
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $userid);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function get_users_list($db) {
        $query = 'SELECT U.username AS _user, UT.typename AS type, IFNULL(UG.GUMgroups, 0) AS groups';
        $query .= ', U.firstname AS fname, U.lastname AS lname, U.usertypeid AS utypeid, U.email AS email, U.activestatus AS status';
        $query .= ' FROM RSUserTypes UT, RSUsers U';
        $query .= ' LEFT JOIN (SELECT GUM.userid AS GUMuID, COUNT(GUM.groupid) AS GUMGroups FROM RSGroupUserMemberships GUM GROUP BY userid) UG ON U.id = UG.GUMuID';
	$query .= ' WHERE U.usertypeid = UT.id';
        $query .= ' ORDER BY U.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $users_list = $statement->fetchAll();
    $statement->closeCursor();
    return $users_list;
}

function get_active_users_list($db) {
        $query = 'SELECT U.username AS _user, UT.typename AS type, IFNULL(UG.GUMgroups, 0) AS groups';
        $query .= ', U.firstname AS fname, U.email AS email, U.activestatus AS status';
        $query .= ' FROM RSUserTypes UT, RSUsers U';
        $query .= ' LEFT JOIN (SELECT GUM.userid AS GUMuID, COUNT(GUM.groupid) AS GUMGroups FROM RSGroupUserMemberships GUM GROUP BY userid) UG ON U.id = UG.GUMuID';
	$query .= ' WHERE U.usertypeid = UT.id AND U.activestatus = true';
        $query .= ' ORDER BY U.id';
    $statement = $db->prepare($query);
    $statement->execute();
    $users_list = $statement->fetchAll();
    $statement->closeCursor();
    return $users_list;
}

function get_all_users($db) {
    $query = 'SELECT * FROM RSUsers';
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor();
    return $users;
}

function get_active_users($db) {
    $query = 'SELECT * FROM RSUsers WHERE activestatus = true';
    $statement = $db->prepare($query);
    $statement->execute();
    $active_users = $statement->fetchAll();
    $statement->closeCursor();
    return $active_users;
}

function get_user_facilities($db, $userid) {
	$query = 'SELECT F.facilityname AS facility, ';
    $query .= 'F.numberofrelays AS relays, F.activestatus AS fstatus, ';
    $query .= 'D.deviceid AS device, D.encryptedaccesstoken AS token, ';
    $query .= 'D.activestatus AS dstatus, FG.groupid AS fgroupid, ';
    $query .= 'U.firstname AS firstname, U.usertypeid AS utypeid, ';
    $query .= 'U.activestatus AS ustatus, UG.groupid AS ugroupid, ';
    $query .= 'G.activestatus AS gstatus ';
    $query .= 'FROM RSGroupUserMemberships UG, RSFacilities F, ';
    $query .= 'RSFacilityGroupMemberships FG, RSDevices D, ';
    $query .= 'RSDeviceFacilityMatches DFM, RSUsers U, RSGroups G ';
    $query .= 'WHERE F.id = FG.facilityid AND U.id = UG.userid ';
    $query .= 'AND  FG.groupid = UG.groupid AND G.id = UG.groupid ';
    $query .= 'AND D.id = DFM.deviceid AND G.id = FG.groupid AND ';
    $query .= 'F.id = DFM.facilityid AND U.id = :userid';
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $userid);
    $statement->execute();
    $user_facilities = $statement->fetchAll();
    $statement->closeCursor();
    return $user_facilities;
}

function delete_user($db, $username) {
    $to_be_deleted = json_encode(get_user_by_name($db, $username));
    $query = 'DELETE FROM RSUsers WHERE username = :username';
    $statement = $db->prepare($query);
    $statement->bindValue(':username',$username);
    $remarks = 'user: ' . $username . ($statement->execute()? ' deleted.' : ' not deleted.');
    $statement->closeCursor();
    add_log($db, $remarks);
    if(!strpos($remarks, 'not deleted')) add_deleted_stuff($db, 'RSUsers', $to_be_deleted);
}
?>

