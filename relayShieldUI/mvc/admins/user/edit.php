<?php include '../../view/header.php'; ?>
<main>
    <section>
        
<table border='0' style='width:60%' align="center">
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">Control Center</h1>
      </td>
    </tr>
    <tr>
      <td>

 <form id="edit_user" name="edit_user" action="index.php" method="post">
          <input type="hidden" name="action" value="update_user">
	  <input type="hidden" name="old_usr_less_grps" value='<?php echo base64_encode(serialize($user)); ?>'>
	  <input type="hidden" name="old_user_groups" value='<?php echo base64_encode(serialize($user_groups)) ?>'>
          <fieldset>
            <legend>Edit User</legend>

            <pre><?php echo $edit_user_message; ?></pre>
            <p>
              <label for="edit_user_firstname"><span>First Name:</span></label>
              <input type="text" id="edit_user_firstname" name="edit_user_firstname" value='<?php echo $user['fname'];?>' disabled >
            </p>
            <p>
              <label for="edit_user_lastname"><span>Last Name:</span></label>
              <input type="text" id="edit_user_lastname" name="edit_user_lastname" value='<?php echo $user['lname'];?>' disabled >
            </p>
            <p>
              <label for="edit_user_email"><span>Email:</span></label>
              <input type="email" id="edit_user_email" name="edit_user_email" value='<?php echo $user['email'];?>' disabled >
            </p>
            <p>
              <label for="edit_user_username"><span>username:</span></label>
              <input type="text" id="edit_user_username" name="edit_user_username" value='<?php echo $user['_user'];?>' disabled >
            </p>
	    <p>
		<label for="user_status"><span>Active</span></label>
		<input type="checkbox" id="edit_user_status" name="edit_user_status" <?php echo ($user['status'] ? "checked" : ""); ?> />
	    </p>
	    <p>
		<label for="user_type"><span>User Type:</span></label>
		<select name="edit_user_type">
		    <?php for($j = 1; $j <= 4; $j++) : ?>
			<option value="<?php echo $j; ?>" <?php echo ($user['utypeid'] == $j) ? 'selected' : '' ; ?> ><?php echo $j; ?></option>
		    <?php endfor; ?>
		</select>
	    </p>
	    <p>
		<label for="groups"><span>Group(s):</span></label>
		<select multiple name="edit_user_groups[]">
		    <?php foreach($groups as $group) : ?>
			<option value="<?php  echo $group['id']; ?>" <?php echo in_array($group['id'], $user_groups) ? 'selected' : '' ;?> >
				<?php  echo $group['groupname']; ?>
			</option>
		    <?php endforeach; ?>
		</select>
	    </p>
            <p>
	     <button type="submit">Update</button>
             <button type="reset">Reset</button>
             <a href="index.php">Cancel</a>
            </p>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

