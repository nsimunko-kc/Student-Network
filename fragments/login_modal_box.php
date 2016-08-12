<div class="overlay">
    <div class="login-select">
        <div class="left">
            <table>
                <tr>
                    <td>
                        <button id="btn-login-facebook" onclick="window.location.assign('SocialLogin/login.php?app=facebook');">Facebook</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button id="btn-login-twitter" onclick="window.location.assign('SocialLogin/login.php?app=twitter');">Twitter</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button id="btn-login-google" onclick="window.location.assign('SocialLogin/login.php?app=google');">Google+</button>
                    </td>
                </tr>
            </table>
        </div>
        <div class="right">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <table>
                    <tr>
                        <td>
                            <input type="text" name="username" id="input-username" placeholder="Korisničko ime">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="password" id="input-password" placeholder="Lozinka">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="login" value="Prijavi se">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>