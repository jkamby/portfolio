<?php include 'view/header.php'; ?>
<main>
    <section>
        
<table border='0' style='width:60%' align="center">
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">User Registration</h1>
      </td>
    </tr>
    <tr>
      <td>

 <form id="profile" name="profile" action="index.php" method="post">
          <input type="hidden" name="action" value="update_profile">
	  <input type="hidden" name="old_profile" value='<?php echo serialize($user); ?>'>
          <fieldset>
            <legend>User Profile</legend>

            <pre><?php echo $profile_message; ?></pre>
            <p>
              <label for="profile_firstname"><span>First Name:</span></label>
              <input type="text" id="profile_firstname" name="profile_firstname" value='<?php echo $user['firstname'];?>' >
            </p>
            <p>
              <label for="profile_lastname"><span>Last Name:</span></label>
              <input type="text" id="profile_lastname" name="profile_lastname" value='<?php echo $user['lastname'];?>' >
            </p>
            <p>
              <label for="profile_email"><span>Email:</span></label>
              <input type="email" id="profile_email" name="profile_email" value='<?php echo $user['email'];?>' >
            </p>
            <p>
              <label for="profile_username"><span>username:</span></label>
              <input type="text" id="profile_username" name="profile_username" value='<?php echo $user['username'];?>' disabled >
            </p>
            <p>
              <label for="profile_password"><span>password:</span></label>
              <input type="password" id="profile_password" name="profile_password" oninput="(password.value == confirm_password.value) ? password.setCustomValidity('') : password.setCustomValidity('Passwords do not match.');" >
            </p>
            <p>
              <label for="profile_confirm_password"><span>confirm password:</span></label>
              <input type="password" id="profile_confirm_password" name="profile_confirm_password" oninput="(profile_confirm_password.value == profile_password.value) ? profile_confirm_password.setCustomValidity('') : profile_confirm_password.setCustomValidity('Passwords do not match.');" >
            </p>
              <button type="submit">Update</button>
              <button onclick="this.form.action.value='login'; this.form.submit()">Cancel</button>
            </p>
	    <p><button onclick="this.form.action.value='delete_profile'; this.form.submit()">Delete Profile</button></p>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include 'view/footer.php'; ?>

