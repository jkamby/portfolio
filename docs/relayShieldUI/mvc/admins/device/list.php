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

        <form id="device_factory" name="device_factory" action="index.php" method="post">
          <input type="hidden" name="action" value="new_device">
          <fieldset>
            <legend>Device Factory</legend>
            <select name="filter" onchange="this.form.action.value='device_list'; this.form.submit()">
              <option value="none" selected>filter by:</option>
              <option value="all">all</option>
              <option value="active">active</option>
              <option value="inactive">inactive</option>
            </select>
            <table border=1>
              <tr>
                <th width="70%">Device</th>
                <th>Facility</th>
                <th>Description</th>
		<th style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Action</th>
              </tr>
              <?php foreach ($all_devs as $device) : ?>
              <tr>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
		<a href='index.php?action=edit_device&device=<?php echo base64_encode(serialize($device)); ?>'>
		 <font color='<?php echo $device['status'] ? '' : 'grey' ; ?>' >
                  <?php echo $device['device']; ?></font></a> </td>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
                  <?php echo $device['facility']; ?> </td>

                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
                  <?php echo $device['description']; ?>
                </td>
		<td style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">
		    <button name="delete_device" value='<?php echo base64_encode(serialize($device)); ?>' onclick="confirm('Are you sure you want to delete this device?') ? this.form.action.value='delete_device' : this.form.action.value='device_list'; this.form.submit()" >delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit" style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Add Device</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

