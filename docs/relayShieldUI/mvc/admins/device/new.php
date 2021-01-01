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

        <form id="new_device" name="new_device" action="index.php" method="post">
	  <input type="hidden" name="action" value="add_device">
          <fieldset>
            <legend>New Device</legend>

            <p>
              <label for="device"><span>Device Token:</span></label><br>
              <input type="text" size="35" id="new_device_name" name="new_device_name" />
            </p>
            <p>
              <label for="token"><span>Access Token:</span></label>
              <input type="text" size="35" id="new_device_token" name="new_device_token" />
            </p>
            <p>
              <label for="facility_id"><span>Facility:</span></label>
              <select name="new_device_facility_id">
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
              <input type="checkbox" id="new_device_status" name="new_device_status" />
            </p>
            <p>
              <label for="description"><span>Device description:</span></label>
              <input type="textbox" id="new_device_description" name="new_device_description" />
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

