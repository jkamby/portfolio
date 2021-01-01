<?php include 'view/header.php'; ?>
<main>
    <section>
        
<table border='0' style='width:60%' align="center">
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">Password Recovery</h1>
      </td>
    </tr>
    <tr>
      <td>

        <form id="recovery" name="recovery" action="index.php" method="post">
	  <input type="hidden" name="action" value="recover_password">
          <fieldset>
            <legend>Password Recovery</legend>

            <pre><?php echo $recovery_message; ?></pre>
            <p>
              <label for="recovery_email"><span>Please enter the email address associated with your account:</span></label>
	    </p><p>
              <input type="email" id="recovery_email" name="recovery_email" required />
            </p>
            </p>
              <button type="submit">Submit</button>
              <button onclick="this.form.action.value='login'; this.form.submit(
)">Cancel</button>
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

