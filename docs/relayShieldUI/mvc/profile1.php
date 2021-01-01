<?php include 'view/header.php'; ?>
<?php /*session_start();*/ ?>
<?php /*if(!$_SESSION['firstname']) :
        include '../index.php';
        exit();
      endif;*/
?>
<main>
    <section>
        
<table border='0' style='width:60%' align="center">
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">User Profile</h1>
      </td>
    </tr>
    <tr>
      <td>

 <form id="profile" name="profile" action="index.php" method="post">
          <input type="hidden" name="action" value="profile">
          <fieldset>
            <legend>User Profile</legend>

            <pre><?php echo $registration_message; ?></pre>
            <p>
              <label for="firstname"><span>First Name:</span></label>
              <input type="text" id="profile_firstname" name="profile_firstname" value='<?php echo $user['firstname'];?>' >
            </p>
            <p>
              <label for="lastname"><span>Last Name:</span></label>
              <input type="text" id="profile_lastname" name="profile_lastname" value='<?php echo $user['lastname'];?>' >
            </p>
            <p>
              <label for="email"><span>Email:</span></label>
              <input type="email" id="profile_email" name="profile_email" value='<?php echo $user['email'];?>' >
            </p>
            <p>
              <label for="username"><span>username:</span></label>
              <input type="text" id="profile_username" name="profile_username" value='<?php echo $user['username'];?>' disabled >
            </p>
            <p>
              <label for="password"><span>password:</span></label>
              <input type="password" id="profile_password" name="profile_password" >
            </p>
            <p>
              <label for="confirm_password"><span>confirm password:</span></label>
              <input type="password" id="profile_confirm_password" name="profile_confirm_password" >
            </p>
              <button type="submit">Update</button>
              <button onclick="this.form.action.value='delete_profile'; this.form.submit()">Delete Profile</button>
            </p>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include 'view/footer.php'; ?>

