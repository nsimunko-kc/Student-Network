<?php
session_start();

require_once('../includes/DatabaseAjax.php');

header('Content-Type: application/json');

$db = new DatabaseAjax();

if(!isset($_SESSION['user_id']) || !isset($_POST['friendID'])) {
    echo json_encode(array('response' => 'invalid api call'));
}
else {
    $friendID = $db->cleanInput($_POST['friendID']);

    if($db->query('INSERT INTO followers (follower, following) VALUES ('.$_SESSION['user_id'].','.$friendID.')') === true) {
        echo json_encode(array('response' => 'user following'));
    }
    else {
        echo json_encode(array('response' => 'following failed'));
    }
}

$db->closeConnection();