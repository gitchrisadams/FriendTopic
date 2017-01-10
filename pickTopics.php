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
if (!isset($_SESSION['user_id'])) 
{
  echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
  exit();
}

// Show the navigation menu
require_once('navmenu.php');

// Connect to the database 
$dbc = db_connect();

$queryTopics = "SELECT * FROM mismatch_topic"; 

$queryUsersTopics = "SELECT * FROM mismatch_user_topic";

$queryUsers = "SELECT birthdate, city, first_name, gender, join_date, last_name, picture, state, username, user_id FROM mismatch_user";

// Store data from our database:
$dataTopicsLoop = mysqli_query($dbc, $queryTopics);
$dataTopics = mysqli_query($dbc, $queryTopics);
$dataUsersTopics = mysqli_query($dbc, $queryUsersTopics);
$dataUsersTopics2 = mysqli_query($dbc, $queryUsersTopics);
$dataUsers = mysqli_query($dbc, $queryUsers);


// Store all the data we need from our database in arrays:
$topicsArray_topic_id = array();
$topicsArray_name = array();

$removeFromDatabase = false;  // Remove from database if true.
$insertIntoDatabase = true;

// Store all data needed from topics in the database:
while($row1 = mysqli_fetch_array($dataTopics)){
  array_push($topicsArray_topic_id, $row1['topic_id']);
  array_push($topicsArray_name, $row1['name']);
}

$usersTopicsArray_user_id = array();
$usersTopicsArray_topic_id = array();
// Store all data needed from user/topics in the database:
while($row2 = mysqli_fetch_array($dataUsersTopics)){
  array_push($usersTopicsArray_user_id, $row2['user_id']);
  array_push($usersTopicsArray_topic_id, $row2['topic_id']);
}

$usersArray_user_id = array();
$usersArray_username = array();

// Store all data needed from users in the database:
while($row3 = mysqli_fetch_array($dataUsers)){
  array_push($usersArray_user_id, $row3['user_id']);
  array_push($usersArray_username, $row3['username']);
}

if (isset($_POST['submit'])){

  // Remove submit button value from Post Data:
  unset($_POST['submit']);

  $error = false;

  if(!$error){
    // Delete everything from logged in user to start:
    $queryEmpty = "DELETE FROM mismatch_user_topic WHERE user_id=" . $_SESSION['user_id'];
    mysqli_query($dbc, $queryEmpty);

    // Confirm success with the user
    echo '<div class="TenPxPaddingDiv">';
    echo '<h2>Your Topics have been selected.</h2>';
    echo '<br><br> Visit <a href="pickTopics.php">pick topics</a> to select more topics.';
    echo '<br><br>or<br><br>';
    echo '<a href="createTopic.php">Create more topics</a>';
    echo '<br><br>or<br><br>';
    echo '<a href="index.php">Home</a><br>';
    echo '</div>';

    // Loop through all the POST data:  
    foreach ($_POST as $key => $value) {
      // Loop through and get topic ID from topic name:
      for ($i = 0, $c = count($topicsArray_topic_id); $i < $c; $i++){
        if($topicsArray_name[$i] == $value){
          $currentTopicID = $topicsArray_topic_id[$i];
          $currentTopicIDInt = intval($currentTopicID);
          $userIDAsInt = intval($_SESSION['user_id']);

          $querySelectTopics = "INSERT INTO mismatch_user_topic (user_topic_num, user_id, topic_id) VALUES (NULL," .  $userIDAsInt . "," .  $currentTopicIDInt . ")";

          // Send query to database:
          mysqli_query($dbc, $querySelectTopics);
        }
      }
    }
  }
  exit();
}
  
?>
<div class="TenPxPaddingDiv">
<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <fieldset>
    <legend>Pick Topics</legend>

<?php
  // Loop Topics and display them with checkboxes:
  while ($row = mysqli_fetch_array($dataTopicsLoop)){   
?>
      <input type="checkbox" 
             name="<?php if (!empty($row['name'])) echo $row['name']; ?>"
             id="<?php if (!empty($row['name'])) echo $row['name']; ?>"
             value="<?php if (!empty($row['name'])) echo $row['name']; ?>" 
             <?php //if($row['name'] == 
              // Loop the userTopics array:
              for ($i = 0, $c = count($usersTopicsArray_user_id); $i < $c; $i++) {

                // If the user in data base matches the user logged in and
                // the topics in database match the ones in the array, then
                // checked="checked" checks the proper checkboxes.
                if($usersTopicsArray_topic_id[$i] == $row['topic_id'] && 
                  $_SESSION['user_id'] == $usersTopicsArray_user_id[$i]){
                  echo 'checked="checked"';
                  //echo "checked" . "<br>";
                }
              }
             ?>
             />

             <label for="<?php if (!empty($row['name'])) echo $row['name']; ?>"><?php if (!empty($row['name'])) echo $row['name']; ?></label>
      <br />
<?php
  }

  mysqli_close($dbc);
?>
  <input class="btn" type="submit" name="submit" value="Pick Topics"  />
    </fieldset>
  </form>
</div>
<?php 
  require_once('footer.php');
?>
