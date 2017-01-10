<?php
  // Insert the page header
  $page_title = 'FriendTopic';
  require_once('header.php');
  // Show the navigation menu
  require_once('navmenu.php');

  // Database connection variables:
  require_once('dbconnect.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // Query for setting user's chat status:
  // $querySetChatStatus = 
  //   "UPDATE christad_friendtopic.mismatch_user 
  //   SET chat_status=1 WHERE mismatch_user.user_id=" . $user_username;

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database 
      $dbc = db_connect();

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));




      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username FROM mismatch_user WHERE username = '$user_username' AND password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];

          // Cookie expires in 30 days:
          //setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));   
          //setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30)); 
           

          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'index.php';
          header('Location: ' . $home_url);

          // Set the chat status of the user to 1 since they are now online:
          $querySetChatStatus = 
            "UPDATE christad_friendtopic.mismatch_user 
            SET chat_status=1 WHERE mismatch_user.username=" . "'" . $user_username . "'";

            mysqli_query($dbc, $querySetChatStatus);

        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }

  // Insert the page header
  $page_title = 'Log In';
  require_once('header.php');

  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
    echo '<p class="error">' . $error_msg . '</p>';
?>
<div class="TenPxPaddingDiv">
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" />
    </fieldset>


    <button class="btn btn-primary" type="submit" value="Log In" name="submit"><i class="fa fa-sign-in" aria-hidden="true"> Log In</i></button>
  </form>

<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');

    

  }
?>
</div>
<?php
  mysqli_close($dbc);
  // Insert the page footer
  require_once('footer.php');
?>
