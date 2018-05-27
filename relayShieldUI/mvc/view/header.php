<?php   $app_path = 'http://34.238.162.30/doser/mvc/'; ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
  <title>Mr. Doser</title>
  <link rel="stylesheet" type="text/css" href="<?php echo $app_path . 'main.css' ?>">

</head>
<!-- the body section -->

<body>
  <aside>
    <br><img src="<?php echo $app_path; ?>images/mustachetc.png" alt="Mr. Doser">
  </aside>

  <header>
    <h1>Mr. Doser<br></h1>
    <div align="right">
	<?php 
	    if($_SESSION['firstname']) {
		echo('<a href="' . $app_path . '?action=edit_profile">' . $_SESSION['firstname'] . '</a>' . ' | <a href="' . $app_path . '?action=logout">logout</a>');
	    } else { echo(''); }
	?>
   </div>
  </header>
  <aside>
    <br>
    <div id="operator" class="operator">
      <a href="<?php echo $app_path; ?>">Home</a>
    </div>
    <br>
    <div id="operator" class="operator" style="display:<?php echo(($_SESSION['firstname'] && $_SESSION['usertypeid'] != 3) ? ' block' : ' none'); ?>">
      <label for="operator"><span>Operate:</span></label>
      <?php $user_facilities = get_user_facilities($db, $_SESSION['user']['id']); ?>
        <select onchange="location.assign(this.options[this.selectedIndex].value);">
        <option value=0>[choose]</option>
        <?php foreach($user_facilities as $user_facility) : ?>
        <option value='<?php echo $app_path ?>operator/index.php?action=load_facility&user_facility=<?php echo base64_encode(serialize($user_facility)); ?>'>
        <?php echo $user_facility['facility']; ?>
        </option>
        <?php endforeach; ?>
        </select>
    </div>
    <br>
    <div id="admin" class="admin" style="display:<?php echo(($_SESSION['firstname'] && $_SESSION['usertypeid'] > 2) ? ' block' : ' none'); ?>">
      <label for="operator"><span>Configure:</span></label>
      <select name="entities" onchange="location.assign(this.options[this.selectedIndex].value);">
        <option value=0>[choose]</option>
        <option value="<?php echo $app_path; ?>admins/facility">Facilities</option>
        <option value="<?php echo $app_path; ?>admins/device">Devices</option>
        <option value="<?php echo $app_path; ?>admins/group">Groups</option>
        <option value="<?php echo $app_path; ?>admins/user">Users</option>
      </select>
        </div>
    </aside>

