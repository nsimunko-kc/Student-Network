<div class="container">
    <a href="index.php">Naslovnica</a>
    <?php
    if(isset($_SESSION['user_id']) || isset($_SESSION['userprofile'])) {
        echo "<a href='logout.php'>Odjava</a>";
        echo "<a href='profile.php?pid={$_SESSION['user_id']}'>Profil</a>";
    }
    else {
        ?>
        <a href="register.php">Registracija</a>
        <a href="javascript:void(0)" id="btn-sign-in">Prijava</a>
    <?php
    }
    ?>
</div>