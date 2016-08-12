<?php

if(isset($_REQUEST['login'])) {

    if(isset($_POST['username']) && isset($_POST['password'])
        && $_POST['username'] != '' && $_POST['password'] != '') {

        $username = $db->cleanInput($_POST['username']);
        $password = $db->cleanInput($_POST['password']);

        $user = $db->checkUserLogin($username, $password);

        if($user != false) {
            $_SESSION['user_id'] = $user;
        }
        else {
        }

        header('Location: index.php');
    }

}

if(isset($_SESSION['userprofile'])) {

    if(array_key_exists("email", $_SESSION['userprofile'])) {
        // Facebook and Google return user email address
        $email = $_SESSION['userprofile']['email'];

        // check if user already exists
        $sql = "SELECT id from users WHERE email = '" . $email . "' LIMIT 1";
        $result = $db->query($sql);

        if(mysqli_num_rows($result) > 0) {
            // user exists
            $_SESSION['user_id'] = mysqli_fetch_assoc($result)['id'];
            unset($_SESSION['userprofile']);
            header('Location: index.php');
        }
        else {
            // user does not exist. insert into database
            $user_name = substr($email, 0, strpos($email, '@'));
            $salt = sha1($user_name);
            $password = sha1($user_name . $salt);

            $insertId = $db->insertNewUser($user_name, $email, $password);

            $db->query("UPDATE users SET profile_img_path = 'default_profile.jpg' WHERE id = ". $insertId);

            $_SESSION['user_id'] = $insertId;
            unset($_SESSION['userprofile']);
            header('Location: index.php');
        }
    }
    else {
        // Twitter does not return email address
        $user_name = $_SESSION['userprofile']['screen_name'];
        $picture = $_SESSION['userprofile']['profile_image_url'];

        // check if user already exists
        $sql = "SELECT id from users WHERE username = '" . $user_name . "' LIMIT 1";
        $result = $db->query($sql);

        if(mysqli_num_rows($result) > 0) {
            // user exists
            $_SESSION['user_id'] = mysqli_fetch_assoc($result)['id'];
            unset($_SESSION['userprofile']);
            header('Location: index.php');
        }
        else {
            // user does not exist. insert into database
            $email = $user_name . "@sample.com";
            $salt = sha1($user_name);
            $password = sha1($user_name . $salt);

            $insertId = $db->insertNewUser($user_name, $email, $password);

            $db->query("UPDATE users SET profile_img_path = 'default_profile.jpg' WHERE id = ". $insertId);

            $_SESSION['user_id'] = $insertId;
            unset($_SESSION['userprofile']);
            header('Location: index.php');
        }
    }
}

?>