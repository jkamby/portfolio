<?php include '../../view/header.php'; ?>
<main>
    <section>
        
<table border='0' style='width:95%' align="center">
  <thead></thead>
  <tbody>
    <tr>
      <td>
        <h1 align="center">Control Center</h1>
      </td>
    </tr>
    <tr>
      <td>

        <form id="group_factory" name="group_factory" action="index.php" method="post">
          <input type="hidden" name="action" value="new_group">
          <fieldset>
            <legend>Group Factory</legend>
            <select name="filter" onchange="this.form.action.value='group_list'; this.form.submit()">
              <option value="none" selected>filter by:</option>
              <option value="all">all</option>
              <option value="active">active</option>
            </select>
            <table border=1>
              <tr>
                <th width="70%">Group</th>
                <th>Users</th>
                <th>Facilities</th>
                <th>Description</th>
		<th style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Action</th>
              </tr>
              <?php foreach ($all_grps as $group) : ?>
              <tr>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
		<a href='index.php?action=edit_group&group=<?php echo base64_encode(serialize($group)); ?>'>
		 <font color='<?php echo $group['status'] ? '' : 'grey' ; ?>' >
                  <?php echo $group['_group']; ?></font></a> </td>
                <td>
                  <?php echo $group['users']; ?> </td>

                <td>
                  <?php echo $group['facilities']; ?>
                </td>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
                  <?php echo $group['description']; ?>
		</td>
		<td style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">
		    <button name="delete_group" value='<?php echo base64_encode(serialize($group)); ?>' onclick="confirm('Are you sure you want to delete this group?') ? this.form.action.value='delete_group' : this.form.action.value='group_list'; this.form.submit()" >delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit" style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Add Group</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

