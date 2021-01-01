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

        <form id="edit_group" name="edit_group" action="index.php" method="post">
          <input type="hidden" name="action" value="update_group">
          <input type="hidden" name="old_grp_less_usrs_facs" value='<?php echo base64_encode(serialize($group)); ?>'>
          <input type="hidden" name="old_group_users" value='<?php echo base64_encode(serialize($group_users)); ?>'>
          <input type="hidden" name="old_group_facilities" value='<?php echo base64_encode(serialize($group_facilities)); ?>'>
          <fieldset>
            <legend>Edit Group</legend>

            <p>
              <label for="group"><span>Group:</span></label>
              <input type="text" id="edit_group_name" name="edit_group_name" value="<?php echo htmlspecialchars($group['_group']); ?>">
            </p>
            <p>
              <label for="description"><span>Description:</span></label>
              <input type="text" id="edit_group_description" name="edit_group_description" value="<?php echo htmlspecialchars($group['description']); ?>">
            </p>
            <p>
              <label for="status"><span>Active</span></label>
              <input type="checkbox" id="edit_group_status" name="edit_group_status" <?php echo ($group['status'] ? "checked" : ""); ?> >
            </p>
            <p>
              <label for="users"><span>Users:</span></label>
              <select multiple name="edit_group_users[]">
                  <option value=0>[select]</option>
                <?php foreach($users as $user) : ?>
                  <option value="<?php echo $user['id'] ?>" <?php echo in_array($user['id'], $group_users) ? ' selected ' : '' ;?> ><?php echo $user['username'] ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p>
              <label for="facilities"><span>Facilities:</span></label>
              <select multiple name="edit_group_facilities[]">
                  <option value=0>[select]</option>
                <?php foreach($facilities as $facility) : ?>
                  <option value="<?php echo $facility['id'] ?>" <?php echo in_array($facility['id'], $group_facilities) ? ' selected ' : '' ;?> ><?php echo $facility['facilityname'] ?></option>
                <?php endforeach; ?>
              </select>
            </p>
            <p>
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

