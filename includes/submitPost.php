<?php

if(isset($_REQUEST['submit-post'])) {

    $formSuccess = false;

    if(isset($_POST['post-content']) && $_POST['post-content'] != '') {

        $postContent = $db->cleanInput($_POST['post-content']);

        $formSuccess = true;
        $imageSet = false;
        $ext = null;

        // provjeri uploadanu sliku
        if(!empty($_FILES['post-image']['name'])) {

            if($_FILES['post-image']['size'] > 1000000) {
                $formSuccess = false;
                $error_msg = "Slika ne smije biti veća od 1MB!";
            }

            $check = getimagesize($_FILES['post-image']['tmp_name']);

            $allowedImgTypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');

            $ext = pathinfo($_FILES['post-image']['name'], PATHINFO_EXTENSION);

            if($check == false || !in_array($ext, $allowedImgTypes)) {
                $formSuccess = false;
                $error_msg = "Uploadani file nije slika!";
            }
            else {
                $imageSet = true;
            }
        }

        // sve sa formom je pro�lo u redu
        // zapo�ni ubacivanje posta u bazu
        if($formSuccess)
            $lastInsertId = $db->insertNewPost($_SESSION['user_id'], $postContent);

        if($imageSet) {

            $targetImageDir = "images/posted_images/";
            $targetImageName = $lastInsertId . '_img.' . $ext;

            if(!move_uploaded_file($_FILES['post-image']['tmp_name'], $targetImageDir . $targetImageName)) {
                die("error uploading your file!");
            }

            $db->query('UPDATE posts SET image_path = "'. $targetImageName .'" WHERE id = '. $lastInsertId);

        }
        if(!empty($_FILES['post-image']['name']) && !$imageSet) {
            die("Error uploading your file!");
        }

        unset($_REQUEST['submit-post']);

    }
    else {
        header('Location: exceptions/post_error.php');
    }
}

?>