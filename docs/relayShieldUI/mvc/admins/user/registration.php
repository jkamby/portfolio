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

 <form id="new_user" name="new_user" action="index.php" method="post">
          <input type="hidden" name="action" value="add_user">
          <fieldset>
            <legend>User Registration</legend>

            <pre><?php echo $registration_message; ?></pre>
            <p>
              <label for="firstname"><span>First Name:</span></label>
              <input type="text" id="firstname" name="firstname" required/>
            </p>
            <p>
              <label for="lastname"><span>Last Name:</span></label>
              <input type="text" id="lastname" name="lastname" />
            </p>
            <p>
              <label for="email"><span>Email:</span></label>
              <input type="email" id="email" name="email" required/>
            </p>
            <p>
              <label for="username"><span>username:</span></label>
              <input type="text" id="username" name="username" required />
            </p>
            <p>
              <label for="password"><span>password:</span></label>
              <input type="password" id="password" name="password" oninput="(password.value == confirm_password.value) ? password.setCustomValidity('') : password.setCustomValidity('Passwords do not match.');" required/>
            </p>
            <p>
              <label for="confirm_password"><span>confirm password:</span></label>
              <input type="password" id="confirm_password" name="confirm_password" oninput="(confirm_password.value == password.value) ? confirm_password.setCustomValidity('') : confirm_password.setCustomValidity('Passwords do not match.');" required/>
            </p>
	       <button type="submit">Create</button>
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

