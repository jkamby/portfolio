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
                <th>Device</th>
                <th>Facility</th>
                <th>Description</th>
		<th>Action</th>
              </tr>
              <?php foreach ($all_devs as $device) : ?>
              <tr>
                <td><a href='index.php?action=edit_device&device=<?php echo serialize($device); ?>'>
                  <?php echo $device['device']; ?></a> </td>
                <td>
                  <?php echo $device['facility']; ?> </td>

                <td>
                  <?php echo $device['description']; ?>
                </td>
		<td>
		  <button name="delete_device_name" onclick="confirm('Are you sure you want to delete this device?') ? this.form.action.value='delete_device' : this.form.action.value='device_list'; this.form.submit()" value="<?php echo $device['device']; ?>">delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit">Add Device</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

