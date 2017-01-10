<?php
  // Generate the navigation menu if user is logged in:
  echo '<hr />';
?>
<!-- External stylesheet -->
<link rel="stylesheet" type="text/css" href="style.css">

  <?php if (isset($_SESSION['username'])): ?>
    <div class="TenPxPaddingDiv">
    <!-- &#x7c is the hex code for a vertical bar | -->
    <a href="index.php">Home</a> &#x7c; 
    <a href="createTopic.php">Create Topic</a> &#x7c; 
    <a href="pickTopics.php">Pick Topics</a> &#x7c; 
    <a href="editprofile.php">Edit Profile</a> &#x7c; 
    <a href="logout.php" 
      onclick="return confirm('All chat data/history will be deleted, Are you sure?');">Log Out 
      (<?php echo $_SESSION['username'] ?>)</a> &#x7c; 
    <a href="about.php">About/FAQ</a>
    </div>



  <?php else: ?> 
    <div class="TenPxPaddingDiv">
    <!-- &#x7c is the hex code for a vertical bar | -->
    <a href="index.php">Home</a> &#x7c; 
    <a href="login.php">Log In</a> &#x7c; 
    <a href="signup.php">Sign Up</a> &#x7c; 
    <a href="about.php">About/FAQ</a> 
    </div>

<?php endif; ?>

<?php
  echo '<hr />';
?>
