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

        <form id="new_group" name="new_group" action="index.php" method="post">
          <input type="hidden" name="action" value="add_group">
          <fieldset>
            <legend>New Group</legend>

            <p>
              <label for="group"><span>Group:</span></label><br>
              <input type="text" id="new_group_name" name="new_group_name">
            </p>
            <p>
              <label for="description"><span>Description:</span></label><br>
              <input type="text" id="new_group_description" name="new_group_description">
            </p>
            <p>
              <label for="status"><span>Active</span></label>
              <input type="checkbox" id="new_group_status" name="new_group_status">
            </p>
            <p>
              <label for="users"><span>Users:</span></label>
              <select multiple name="new_group_users[]">
                  <option value=0>[select]</option>
                <?php foreach($users as $user) : ?>
                  <option value="<?php echo $user['id'] ?>"><?php echo $user['username'] ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p>
              <label for="facilities"><span>Facilities:</span></label>
              <select multiple name="new_group_facilities[]">
                  <option value=0>[select]</option>
                <?php foreach($facilities as $facility) : ?>
                  <option value="<?php echo $facility['id'] ?>"><?php echo $facility['facilityname'] ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p>
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

