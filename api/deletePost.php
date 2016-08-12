<?php
session_start();

require_once('../includes/DatabaseAjax.php');

header('Content-Type: application/json');

$db = new DatabaseAjax();

if(!isset($_SESSION['user_id']) || !isset($_POST['postID'])) {
    echo json_encode(array('response' => 'invalid api call'));
}
else {
    $postID = $db->cleanInput($_POST['postID']);

    if($db->query('DELETE FROM posts WHERE id = '. $postID) === true) {
        echo json_encode(array('response' => 'post deleted'));
    }
    else {
        echo json_encode(array('response' => 'delete failed'));
    }
}

$db->closeConnection();