<?php include '../../view/header.php'; ?>
<?php /*session_start();*/ ?>
<?php /*if(!isset($_SESSION['firstname'])) :
        include($app_path);
        exit();
      endif;*/
?>

<main>
    <section>
        
<table border='0' style='width:95%' align='center'>
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">Control Center</h1>
      </td>
    </tr>
    <tr>
      <td>

        <form id="user_deployment" name="user_deployment" action="index.php" method="post">
          <input type="hidden" name="action" value="new_user">
          <fieldset>
            <legend>User Deployment</legend>
            <select name="filter" onchange="this.form.action.value='user_list'; this.form.submit()">
              <option value="none" selected>filter by:</option>
              <option value="all">all</option>
              <option value="active">active</option>
            </select>
            <table border=1>
              <tr>
                <th width="70%">User</th>
                <th>Type</th>
                <th>Groups</th>
		<th style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Action</th>
              </tr>
              <?php foreach ($all_usrs as $user) : ?>
              <tr>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
		<a href='index.php?action=edit_user&user=<?php echo base64_encode(serialize($user)); ?>'>
		<font color='<?php echo $user['status'] ? '' : 'grey' ; ?>' >
                <?php echo $user['_user']; ?>
		</font>
		</a>
		</td>
                <td>
                  <?php echo $user['type']; ?> </td>

                <td>
                  <?php echo $user['groups']; ?>
		</td>
		<td style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">
		  <button name="delete_user" value='<?php echo base64_encode(serialize($user)); ?>' onclick="confirm('Are you sure you want to delete this user?') ? this.form.action.value='delete_user' : this.form.action.value='user_list'; this.form.submit()" >delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit" style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Add User</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

