<?php
  // Insert the page header
  $page_title = 'FriendTopic';
  require_once('header.php');
  // Show the navigation menu
  require_once('navmenu.php');

  // Database connection variables:
  require_once('dbconnect.php');
  session_start();

  // Connect to the database 
  $dbc = db_connect();

  // Store the username in variable for database operations:
  $user_username = $_SESSION['username'];


  // If the user is logged in, delete the session vars to log them out
  if (isset($_SESSION['user_id'])) {


    // Delete the session vars by clearing the $_SESSION array
    $_SESSION = array();

    // Delete the session cookie by setting its expiration to an hour ago (3600)
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Destroy the session
    session_destroy();
  }

  // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
  setcookie('user_id', '', time() - 3600);
  setcookie('username', '', time() - 3600);

  // The user is logged out so set chat status to offline:
  // Set the chat status of the user to 0 since they are now online:
$querySetChatStatus = 
  "UPDATE christad_friendtopic.mismatch_user 
  SET chat_status=0 WHERE mismatch_user.username=" . "'" . $user_username . "'";

  
  // User has logged off so delete all their chat messages from database:
  $queryDeleteAllMessages = "DELETE FROM messages 
    WHERE username=" . "'" . $user_username . "'";

  // Set chat status to offline:
  mysqli_query($dbc, $querySetChatStatus);

  mysqli_query($dbc, $queryDeleteAllMessages);



  mysqli_close($dbc);

  // Redirect to the home page
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 'index.php';
  header('Location: ' . $home_url);
?>
