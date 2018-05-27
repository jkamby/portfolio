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

        <form id="edit_facility" name="edit_facility" action="index.php" method="post">
          <input type="hidden" name="action" value="update_facility">
          <input type="hidden" name="old_facility_name" value="<?php echo $facility['facility']; ?>">
          <input type="hidden" name="old_device_name" value="<?php echo $facility['device']; ?>">
          <fieldset>
            <legend>Edit Facility</legend>

            <p>
              <label for="facility"><span>Facility:</span></label>
              <input type="text" id="edit_facility_name" name="edit_facility_name" value="<?php echo $facility['facility']; ?>"/>
            </p>
            <p>
              <label for="relay_nos"><span># of Relays:</span></label>
              <select name="edit_facility_relays">
		  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
              </select>
            </p>
            <p>
              <label for="edit_facility_device_id"><span>Device ID:</span></label>
              <select name="edit_facility_device_id">
		  <option value="99999">
			<?php echo $facility['device']; ?>
		  </option>
		  <?php foreach($available_devices as $device) : ?>
                  <option value="<?php  echo $device['id']; ?>">
			<?php  echo $device['deviceid']; ?>
		  </option>
		  <?php endforeach; ?>
              </select>
            </p>
	    <p>
	      <label for="facility_status"><span>Active</span></label>
	      <input type="checkbox" id="edit_facility_status" name="edit_facility_status" <?php echo ($facility['status'] ? "checked" : ""); ?> />
	    </p>
            <p>
              <label for="groups"><span>Group(s):</span></label>
              <select multiple name="edit_facility_groups[]">
		  <?php foreach($groups as $group) : ?>
                  <option value="<?php  echo $group['id']; ?>">
			<?php  echo $group['groupname']; ?>
		  </option>
		  <?php endforeach; ?>
              </select>
            </p>
              <button type="submit">Update</button>
              <button type="reset">Cancel</button>
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

