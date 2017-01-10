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

  // Show the navigation menu
  require_once('navmenu.php');

?>
<div id="about">
<h1>About FriendTopic</h1>
<h2>What is FriendTopic?</h2>
<p>Friend topic allows you to chat on different topics. When you log off or if you are inactive for longer than 1 hour, all chat data is deleted. You can pick topics that you find interesting as well as create new topics that are not currently on FriendTopic. Once a topic is created it will show up in list for an available topic to pick. You can then chat about these topics.</p>

<h2>Where did my chat data go?</h2>
<p>When you log off the chat data is deleted. Also, there is
auto-logoff that will log off a user that is inactive for over 1 hour. </p>

<h2>What is the pick topics thing?</h2>
<p>When you pick topics you are picking topics you are interested in. When another person logs in, they will see users that are online and the topics they like to talk about. This enables people to talk to each other about topics they find interesting.  </p>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>