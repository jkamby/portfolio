<?php include 'view/header.php'; ?>
<main>
  <section>
    <div style="display: <?php echo $_SESSION['username'] ? 'none' : 'block' ;?>">
      <table border='0' style='width: 95%' align="center">
        <thead></thead>
        <tbody>
          <tr>
            <td>
              <h1 align="center">User Login</h1>
            </td>
          </tr>
          <tr>
            <td>

              <form id="login" name="login" action="index.php" method="post">
                <input type="hidden" name="action" value="sign_in">
                <fieldset>
                  <legend>User Login</legend>

                  <pre><?php echo $login_message; ?></pre>
                  <p>
                    <label for="username"><span>username:</span></label>
                    <input type="text" id="login_username" name="login_username" requi red />
                  </p>
                  <p>
                    <label for="password"><span>password:</span></label>
                    <input type="password" id="login_password" name="login_password" r equired />
                  </p>
                  <button type="submit">Sign In</button>
                  </p>
                  <p><a href="?action=registration">Register</a> | <a href="?action=recovery">Forgot Password</a></p>
                </fieldset>
              </form>

            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 1) ? 'block' : 'none' ;?>">
      <table border='0' style='width: 95%' align="center">
        <thead></thead>
        <tbody>
          <tr>
            <td>
              <h1 align="center">Welcome...</h1>
            </td>
          </tr>
          <tr>
            <td>
              <p> Hi
                <?php echo $_SESSION['firstname'] ?>,<br> You have successfully logged into the Mr. Doser web application as an <i><b>operator</b></i>.
              </p>
              <p>You may use the drop down menu to your left to navigate to the facility you are authorized to operate.</p>
              <p>You can edit your personal profile by clicking your name (top right) or log out of the session by clicking the logout link next to your name.</p>
              <p>Clicking <u>Home</u> shall always bring you back to this page, if you are logged in or the login prompt.</p>
              <p>As an operator you only have access to the facility your supervisor/administrator registered you for. If you do not have access to any facility (blank drop down) or feel you were erroneously [not] assigned a facility contact your supervisor
                ASAP.</p>
              <p>A log is kept of all your actions whilst logged into this application.</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 2) ? 'block' : 'none' ;?>">
      <table border='0' style='width: 95%' align="center">
        <thead></thead>
        <tbody>
          <tr>
            <td>
              <h1 align="center">Welcome...</h1>
            </td>
          </tr>
          <tr>
            <td>
              <p> Hi
                <?php echo $_SESSION['firstname'] ?>,<br> You have successfully logged into the Mr. Doser web application as an <i><b>advanced operator</b></i>.
              </p>
              <p>You may use the drop down menu to your left to navigate to the facilities you are authorized to operate. You can ony operate one facility at a time.</p>
              <p>You can edit your personal profile by clicking your name (top right) or log out of the session by clicking the logout link next to your name.</p>
              <p>Clicking <u>Home</u> shall always bring you back to this page, if you are logged in or the login prompt.</p>
              <p>As an advanced operator you only have access to facilities your supervisor/administrator registers you for. If you feel you were erroneously [not] assigned a facility contact your supervisor ASAP.</p>
              <p>A log is kept of all your actions whilst logged into this application.</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 3) ? 'block' : 'none' ;?>">
      <table border='0' style='width: 95%' align="center">
        <thead></thead>
        <tbody>
          <tr>
            <td>
              <h1 align="center">Welcome...</h1>
            </td>
          </tr>
          <tr>
            <td>
              <p> Hi
                <?php echo $_SESSION['firstname'] ?>,<br> You have successfully logged into the Mr. Doser web application as an <i><b>administrator</b></i>.
              </p>
              <p>You may use the drop down menu to your left to navigate to the facility, device and group setup.</p>
              <p>You may <b>create</b>, <b>pair-up</b>, <b>modify</b> or <b>delete</b> a facility, device or group. You may also [re-]assign registered users to any group. Any changes you make to existing assignments shall take effect the next time the affected user logs in.</p>
            <p>You can edit your personal profile by clicking your name (top right) or log out of the session by clicking the logout link next to your name.</p>  
            <p>Clicking <u>Home</u> shall always bring you back to this page, if you are logged in or the login prompt.</p>
            <p>As an administrator you only have access to configuration menu of the facilities, devices and groups.</p>
            <p>A log is kept of all your actions whilst logged into this application.</p>
          </td>
        </tr>
      </tbody>
    </table>
</div>

<div style="display: <?php echo ($_SESSION['username'] && $_SESSION['usertypeid'] == 4) ? 'block' : 'none' ;?>">
    <table border='0' style='width: 95%' align="center">
      <thead></thead>
      <tbody>
        <tr>
          <td>
            <h1 align="center">Welcome...</h1>
          </td>
        </tr>
        <tr>
          <td>
          <p> Hi <?php echo $_SESSION['firstname'] ?>,<br>
              You have successfully logged into the Mr. Doser web application as an <i><b>super administrator</b></i>.
              </p>
              <p>You may use the drop down menus to your left to navigate to the operational facilities or to configure facilities, devices and groups.</p>
              <p>You may test any operational facility by navigating to the it through the operator menu.</p>
              <p>You may <b>create</b>, <b>pair-up</b>, <b>modify</b> or <b>delete</b> a facility, device or group (including un-attached entities, i.e stand-alone entities that are not paired up). You may also [re-]assign registered users to any group. Any changes you make to existing assignments shall take effect the next time the affected user logs in.</p>
            <p>You can edit your personal profile by clicking your name (top right) or log out of the session by clicking the logout link next to your name.</p>  
            <p>Clicking <u>Home</u> shall always bring you back to this page, if you are logged in or the login prompt.</p>
            <p>As a super administrator you have the most previleges in the system with configuration access to every choice the lesser user types have.</p>
            <p>A log is kept of all your actions whilst logged into this application.</p>
          </td>
        </tr>
      </tbody>
    </table>
</div>

  </section>
</main>
<?php include 'view/footer.php'; ?>
