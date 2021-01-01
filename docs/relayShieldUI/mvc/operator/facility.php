<?php include '../view/header.php'; ?>
<?php /*if(!$_SESSION['firstname']) :
 	include '../index.php');
	exit();
      endif;*/
?>
<main>
<section>

<table border='0' style='width:95%' align="center">
  <thead><?php $user_facility = unserialize(base64_decode(filter_input(INPUT_GET, 'user_facility'))); ?></thead>
  <tbody>
    <tr>
      <td><h1 align="center"><?php echo $user_facility['facility']; ?></h1></td>
    </tr>
    <tr>
      <td><?php $submitAll = '' ?>
      <?php for($i = 1; $i <= (int)$user_facility['relays']; $i++) : ?>
        <form id="<?php echo('tank' . $i); ?>" name="<?php echo('tank' . $i); ?>" class="form-inline">
          <fieldset>
          <input type="hidden" id="<?php echo('device' . $i); ?>" name="device" value="<?php echo($user_facility['device']); ?>">
          <input type="hidden" id="<?php echo('token' . $i); ?>" name="token" value="<?php echo($user_facility['token']); ?>">
            <legend><?php echo('Tank #' . $i); ?></legend>
            <pre id="<?php echo('log' . $i); ?>">Status: updating...</pre>
            <div id="<?php echo('radios' . $i); ?>" onclick="<?php echo('nextPage(' . $i . ')'); ?>">
              <input type="radio" id="doserType1" name="automan" value="auto">
              <label for="doserType1">Auto</label>
              <input type="radio" id="doserType2" name="automan" value="manual">
              <label for="doserType2">Manual</label>
            </div>
            <div id="<?php echo('details' . $i); ?>" style="display:none">
              <label for="duration">Duration:</label>
              <input type="number" id="duration" name="duration" min="1" max="99999" size="5" placeholder="...seconds" style="width:100px" required>
              <div class="not_auto" id="<?php echo('not_auto_' . $i); ?>">
                <label for="interval">Interval:</label>
                <input type="number" id="<?php echo('_interval' . $i); ?>" name="_interval" oninput="_interval.min = Math.ceil(duration.value/60);" max="99999" size="5" placeholder="...minutes" style="width:100px">
              </div>
              <button type="submit">Submit</button>
              <button type="reset" onclick="<?php echo('prevPage(' . $i . ')'); ?>">Reset</button>
            </div>
          </fieldset>
        </form>
	<?php  $submitAll .= 'javascript:document.getElementById(\'tank' . $i . '\').dispatchEvent(new Event(\'submit\')); ' ?>
        <?php endfor; ?>
      </td>
    </tr><tr><td style="text-align:center; vertical-align:middle;"><button onclick="<?php echo $submitAll ?>" > Submit All! </button> | <button onclick="cancelAll('<?php echo($user_facility['device']); ?>', '<?php echo($user_facility['token']); ?>', '<?php echo($user_facility['relays']); ?>');" > Cancel All! </button></td></tr>
  </tbody>
</table>
</section>
</main>
<?php include '../view/footer.php'; ?>
