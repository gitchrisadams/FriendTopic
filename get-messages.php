<?php
// Database connection variables:
require_once('dbconnect.php');

$db = db_connect();

if ($db->connect_error) {
    die("Sorry, there was a problem connecting to our database.");
}

$username = stripslashes(htmlspecialchars($_GET['username']));
$topicID = stripslashes(htmlspecialchars($_GET['topic_id']));

$result = $db->query
    ("SELECT messages.id, messages.username, messages.message, messages.topic_id
    FROM messages 
    WHERE topic_id =" . $topicID);


while ($r = $result->fetch_row()) {
    echo $r[1];
    echo "\\";
    echo $r[2];
    echo "\n";
}


?>
