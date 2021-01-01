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
          <input type="hidden" name="old_fac_less_grps" value='<?php echo base64_encode(serialize($facility)); ?>'>
          <input type="hidden" name="old_facility_name" value="<?php echo $facility['facility']; ?>">
          <input type="hidden" name="old_device_name" value="<?php echo $facility['device']; ?>">
          <input type="hidden" name="old_facility_groups" value='<?php echo base64_encode(serialize($facility_groups)) ?>'>
          <fieldset>
            <legend>Edit Facility</legend>

            <p>
              <label for="facility"><span>Facility:</span></label>
              <input type="text" id="edit_facility_name" name="edit_facility_name" value="<?php echo $facility['facility']; ?>"/>
            </p>
            <p>
              <label for="relay_nos"><span># of Relays:</span></label>
              <select name="edit_facility_relays">
		<?php for($j = 1; $j <= 4; $j++) : ?>
                  <option value="<?php echo $j; ?>" <?php echo ($facility['relays'] == $j) ? 'selected' : '' ; ?> ><?php echo $j; ?></option>
                <?php endfor; ?>
              </select>
            </p>
            <p>
              <label for="facility_device_id"><span>Device ID:</span></label>
              <select name="edit_facility_device_id">
		  <option value='<?php  echo $facility_device_id ; ?>' > <?php  echo $facility['device']; ?>
		  </option>
		  <?php foreach($available_devices as $device) : ?>
                  <option value="<?php  echo $device['id']; ?>" >
			<?php  echo $device['deviceid']; ?>
		  </option>
		  <?php endforeach; ?>
		  <option v<option value='' style='<?php echo($facility['device'] != '[none]' && $_SESSION['user']['usertype'] == 4 ? 'block' : 'none'); ?>' >[none]</option>
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
                  <option value="<?php  echo $group['id']; ?>" <?php echo in_array($group['id'], $facility_groups) ? 'selected' : '' ;?> >
			<?php  echo $group['groupname']; ?>
		  </option>
		  <?php endforeach; ?>
              </select>
            </p>
              <button type="submit">Update</button>
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

