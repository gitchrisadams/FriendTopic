<?php

// Database connection variables:
require_once('dbconnect.php');

$db = db_connect();

$username = stripslashes(htmlspecialchars($_GET['username']));
$message = stripslashes(htmlspecialchars($_GET['message']));
$topicID = stripslashes(htmlspecialchars($_GET['topic_id']));

if ($message == "" || $username == "") {
    die();
}

$result = $db->prepare("INSERT INTO messages VALUES('',?,?,?)");
$result->bind_param("ssd", $username, $message, $topicID);
$result->execute();



?>