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

        <form id="new_facility" name="new_facility" action="index.php" method="post">
	  <input type="hidden" name="action" value="add_facility">
          <fieldset>
            <legend>New Facility</legend>

            <p>
              <label for="facility"><span>Facility:</span></label>
              <input type="text" id="new_facility_name" name="new_facility_name" />
            </p>
            <p>
              <label for="relay_nos"><span># of Relays:</span></label>
              <select name="new_facility_relays">
		  <option value="0"></option>
		  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
              </select>
            </p>
            <p>
              <label for="device_id"><span>Device ID:</span></label>
              <select name="new_facility_device_id">
		  <?php foreach($available_devices as $device) : ?>
                  <option value="<?php  echo $device['id']; ?>">
			<?php  echo $device['deviceid']; ?>
		  </option>
		  <?php endforeach; ?>
              </select>
            </p>
            <p>
              <label for="status"><span>Active</span></label>
              <input type="checkbox" id="new_facility_status" name="new_facility_status" />
            </p>
            <p>
              <label for="groups"><span>Group(s):</span></label>
              <select multiple name="new_facility_groups[]">
		  <?php foreach($groups as $group) : ?>
                  <option value="<?php  echo $group['id']; ?>">
			<?php  echo $group['groupname']; ?>
		  </option>
		  <?php endforeach; ?>
              </select>
            </p>
              <button type="submit">Create</button>
              <button type="reset">Reset</button>
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

