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

        <form id="edit_device" name="edit_device" action="index.php" method="post">
          <input type="hidden" name="action" value="update_device">
          <input type="hidden" name="old_dev" value='<?php echo base64_encode(serialize($device)); ?>'>
          <fieldset>
            <legend>Edit Device</legend>

            <p>
              <label for="device"><span>Device Token:</span></label><br>
              <input type="text" id="edit_device_name" size="35" name="edit_device_name" value="<?php echo $device['device']; ?>"/>
            </p>
            <p>
              <label for="token"><span>Access Token:</span></label>
              <input type="text" id="edit_device_token" size="35" name="edit_device_token" value="<?php echo $device['token']; ?>"/>
            </p>
            <p>
              <label for="device_facility_id"><span>Facility:</span></label>
              <select name="edit_device_facility_id">
		  <option value='<?php echo $device_facility_id ; ?>' >
			<?php echo $device['facility']; ?>
		  </option>
		  <option value='' style="<?php echo(($device['facility'] != '[none]' && $_SESSION['user']['usertypeid'] == 4) ? 'block' : 'none'); ?>" >[none]</option>
                  <?php foreach($available_facilities as $facility) : ?>
                  <option value="<?php  echo $facility['id']; ?>">
                        <?php  echo $facility['facilityname']; ?>
                  </option>
                  <?php endforeach; ?>
              </select>
            </p>
            <p>
              <label for="status"><span>Active</span></label>
              <input type="checkbox" id="edit_device_status" name="edit_device_status" <?php echo ($device['status'] ? "checked" : ""); ?>/>
            </p>
            <p>
              <label for="description"><span>Device description:</span></label>
              <input type="textbox" id="edit_device_description" name="edit_device_description" value="<?php  echo $device['description']; ?>" />
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

