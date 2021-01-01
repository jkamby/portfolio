<?php include '../../view/header.php'; ?>
<?php /*session_start();*/ ?>
<?php /*if(!isset($_SESSION['firstname'])) :
        include($app_path);
        exit();
      endif;*/
?>

<main>
    <section>
        
<table border='0' style='width:95%' align='center'>
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
                <th width="70%">Facility</th>
                <th>Relays</th>
                <th>Device</th>
                <th>Groups</th>
		<th style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Action</th>
              </tr>
              <?php foreach ($all_facs as $facility) : ?>
              <tr>
                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
		<a href='index.php?action=edit_facility&facility=<?php echo base64_encode(serialize($facility)); ?>'>
		<font color='<?php echo $facility['status'] ? '' : 'grey' ; ?>' >
                <?php echo $facility['facility']; ?>
		</font>
		</a>
		</td>
                <td>
                  <?php echo $facility['relays']; ?> </td>

                <td style='white-space: nowrap; overflow: hidden; max-width: 10px; text-overflow: ellipsis;'>
                  <?php echo $facility['device']; ?>
                </td>
                <td>
                  <?php echo $facility['groups']; ?>
		</td>
		<td style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">
		  <button name="delete_facility" value='<?php echo base64_encode(serialize($facility)); ?>' onclick="confirm('Are you sure you want to delete this facility?') ? this.form.action.value='delete_facility' : this.form.action.value='facility_list'; this.form.submit()" >delete</button>
		</td>
              </tr>
              <?php endforeach; ?>
            </table>
            <button type="submit" style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">Add Facility</button>
          </fieldset>
        </form>

      </td>
    </tr>
  </tbody>
</table>
        
    </section>
</main>
<?php include '../../view/footer.php'; ?>

