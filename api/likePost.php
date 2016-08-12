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
    $userID = $_SESSION['user_id'];

    $result = $db->query("SELECT * FROM likes WHERE post_id = ".$postID." AND user_id = ".$userID);


    if(mysqli_num_rows($result) > 0) {
        // post already liked
        $db->query("UPDATE posts SET num_of_likes = num_of_likes - 1 WHERE id = ". $postID);
        $db->query("DELETE FROM likes WHERE user_id = ". $userID);
    }
    else {
        // post not liked
        $db->query("UPDATE posts SET num_of_likes = num_of_likes + 1 WHERE id = ". $postID);
        $db->query("INSERT INTO likes (user_id, post_id) VALUES (".$userID.", ".$postID.")");
    }

    $result = $db->query("SELECT num_of_likes FROM posts WHERE id = ". $postID);

    $row = mysqli_fetch_assoc($result);

    echo json_encode(array('response' => $row['num_of_likes']));
}

$db->closeConnection();