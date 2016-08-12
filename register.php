<?php
session_start();

require_once("includes/Database.php");

$db = new Database();

$formSuccess = false;
$error_msg = null;

require_once("includes/loginCheck.php");

if(isset($_REQUEST['register'])) {

    if(isset($_POST['username']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['confirm-password']) &&
        $_POST['username'] != '' &&
        $_POST['email'] != '' &&
        $_POST['password'] != '' &&
        $_POST['confirm-password'] != '' &&
        $_POST['password'] == $_POST['confirm-password']) {

        // form values are ok
        $username = $db->cleanInput($_POST['username']);
        $email = $db->cleanInput($_POST['email']);
        $password = $db->cleanInput($_POST['password']);
        $confirm_password = $db->cleanInput($_POST['confirm-password']);

        $description = '';

        if(isset($_POST['description'])) {
            $description = $db->cleanInput($_POST['description']);
        }

        $formSuccess = true;

        $imageSet = false;
        $ext = null;

        // provjeri uploadanu sliku
        if(!empty($_FILES['profile-image']['name'])) {

            if($_FILES['profile-image']['size'] > 1000000) {
                $formSuccess = false;
                $error_msg = "Profilna slika ne smije biti veÊa od 1MB!";
            }

            $check = getimagesize($_FILES['profile-image']['tmp_name']);

            $allowedImgTypes = array('jpg', 'jpeg', 'png', 'gif', 'bmp');

            $ext = pathinfo($_FILES['profile-image']['name'], PATHINFO_EXTENSION);

            if($check == false || !in_array($ext, $allowedImgTypes)) {
                $formSuccess = false;
                $error_msg = "Uploadani file nije slika!";
            }
            else {
                $imageSet = true;
            }
        }

        // sve sa formom je proölo u redu
        // zapoËni ubacivanje korisnika u bazu
        $lastInsertId = $db->insertNewUser($username, $email, $password, $description);

        if($imageSet) {

            $targetImageDir = "images/profile_images/";
            $targetImageName = $lastInsertId . '_profile_img.' . $ext;

            if(!move_uploaded_file($_FILES['profile-image']['tmp_name'], $targetImageDir . $targetImageName)) {
                die("error uploading your file!");
            }

            $db->query('UPDATE users SET profile_img_path = "'. $targetImageName .'" WHERE id = '. $lastInsertId);

        }
        else {
        }

        unset($_REQUEST['register']);

        header('Location: index.php');
    }

    $error_msg = "Provjeri sva polja forme!";

}

?>

<!doctype html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Studentska dru≈°tvena mre≈æa</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <link rel="stylesheet" type="text/css" href="styles/register.css">
</head>
<body>
<?php require_once("fragments/login_modal_box.php"); ?>
<header>
    <?php require_once("fragments/header.php"); ?>
</header>
<main>
    <div class="container">
        <section>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                  enctype="multipart/form-data"
                  onsubmit="return ValidateRegisteredUser()">
                <?php if(!$formSuccess) {
                    echo "<p style='color: red;'>{$error_msg}</p>";
                } ?>
                <table id="register-form">
                    <colgroup>
                        <col width="40%">
                        <col width="60%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="2">Ispunite obrazac za registraciju</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <label for="username">Korisniƒçko ime: </label>
                        </td>
                        <td>
                            <input type="text" name="username" id="username">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p class="msg-username"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email adresa: </label>
                        </td>
                        <td>
                            <input type="email" name="email" id="email">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p class="msg-email"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Lozinka: </label>
                        </td>
                        <td>
                            <input type="password" name="password" id="password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p class="msg-password"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="confirm-password">Potvrdi lozinku: </label>
                        </td>
                        <td>
                            <input type="password" name="confirm-password" id="confirm-password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p class="msg-password-confirm"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Profilna slika: </label>
                        </td>
                        <td>
                            <input type="file" name="profile-image">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p class="msg-photo"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="description">Kratki opis: </label>
                        </td>
                        <td>
                            <textarea rows="5" name="description" id="description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <p></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            <input type="submit" value="Registriraj me" name="register">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </section>
    </div>
</main>

</body>
<script src="scripts/jQuery.js"></script>
<script src="scripts/main.js"></script>
<script src="scripts/registerUser.js"></script>
</html>

<?php
$db->closeConnection();
?>