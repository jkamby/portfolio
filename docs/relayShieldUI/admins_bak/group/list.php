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

        <form id="facility_factory" name="facility_factory" action="index.php" method="post">
          <input type="hidden" name="action" value="new_facility">
          <fieldset>
            <legend>Facility Factory</legend>
            <select name="filter" onchange="this.form.action.value='facility_list'; this.form.submit()">
              <option value="none" selected>filter by:</option>
              <option value="all">all</option>
              <option value="active">active</option>
            </select>
            <table border=1>
              <tr>
                <th>Facility</th>
                <th>Relays</th>
                <th>Device</th>
                <th>Status</th>
		<th>Action</th>
              </tr>
              <?php foreach ($all_facs as $facility) : ?>
              <tr>
                <td><a href='index.php?action=edit_facility&facility=<?php echo serialize($facility); ?>'>
                  <?php echo $facility['facility']; ?></a> </td>
                <td>
                  <?php echo $facility['relays']; ?> </td>

                <td>
                  <?php echo $facility['device']; ?>
                </td>
                <td>
                  <?php echo $facility['status'] ? 'ACTIVE' : 'INACTIVE'; ?>
		</td>
		<td>
		  <button name="delete_facility_name" onclick="confirm('Are you sure you want to delete this facility?') ? this.form.action.value='delete_facility' : this.form.action.value='facility_list'; this.form.submit()" value="<?php echo $facility['facility']; ?>">delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit">Add Facility</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

