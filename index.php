<?php
session_start();

require_once("includes/Database.php");
require_once("includes/Post.php");

$db = new Database();
$postHandler = new Post($db);

require_once("includes/loginCheck.php");
require_once("includes/submitPost.php");

?>

<!doctype html>
<html lang="hr">
<head>
    <meta charset="cp1250">
    <title>Studentska društvena mreža</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
</head>
<body>
    <?php require_once("fragments/login_modal_box.php"); ?>
    <header>
        <?php require_once("fragments/header.php"); ?>
    </header>
    <main>
        <?php
        if(isset($_SESSION['user_id'])) {
            require_once("fragments/home_logged_in.php");
        }
        else {
            require_once("fragments/home_logged_out.php");
        }
        ?>
    </main>
    <footer>

    </footer>
</body>
<script src="scripts/jQuery.js"></script>
<script src="scripts/main.js"></script>
<script src="scripts/checkPostSubmit.js"></script>
<script src="scripts/ajaxScripts.js"></script>
</html>
<?php $db->closeConnection(); ?>