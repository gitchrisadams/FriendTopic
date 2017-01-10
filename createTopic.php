<!-- External stylesheet -->
<link rel="stylesheet" type="text/css" href="style.css">

<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'FriendTopic';
  require_once('header.php');

  // Constants:
  require_once('appvars.php');

  // Database connection variables:
  require_once('dbconnect.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Show the navigation menu
  require_once('navmenu.php');

    // Connect to the database 
    $dbc = db_connect();


  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $topicName = mysqli_real_escape_string($dbc, trim($_POST['topicName']));
    $error = false;
  
    // Update the topic database w/ new topic:
    if(!$error){
      if(!empty($topicName)){
        $query = "INSERT INTO mismatch_topic(`topic_id`, `name`) VALUES (NULL, '$topicName')";
        
        // Insert data into the database:
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<h2>Your Topic ' . $topicName . ' has been added.</h2>';
        echo '<br><br> Visit <a href="pickTopics.php">pick topics</a> to select your topics.';
        echo '<br><br>or<br><br>';
        echo '<a href="createTopic.php">Create more topics</a>';
        echo '<br><br>or<br><br>';
        echo '<a href="index.php">Home</a>';
        mysqli_close($dbc);
        exit();
        }else {
          echo '<p class="error">You must enter a topic.</p>';
      }


    }
  } // End of check for form submission

  
?>
<div class="TenPxPaddingDiv">
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Create Topics</legend>
      <label for="topicName">Topic Name:</label>
      <input type="text" id="topicName" name="topicName" value="<?php if (!empty($topicName)) echo $topicName; ?>" /><br />
      
    </fieldset>
    <input type="submit" value="Submit Topic" name="submit" />
  </form>
</div>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
