
function ValidateRegisteredUser() {
    var success = true;

    var username         = $("#username").val();
    var email            = $("#email").val();
    var password         = $("#password").val();
    var confirm_password = $("#confirm-password").val();


    // Validiraj korisnicko ime
    if(username.length < 5) {
        success = false;
        $(".msg-username").text("Korisnièko ime mora sadržavati minimalno 5 znakova!");
    }
    else if(!/^[a-zA-Z0-9_-]+$/.test(username)) {
        success = false;
        $(".msg-username").text("Korisnièko ime može sadržavati slova, brojeve i znakove '_' i '-'");
    }
    else {
        $(".msg-username").text("");
    }

    // Validiraj email adresu
    if(!/^[\w]+([._-][\w]+)*@[\w]+(.[a-z]{2,})+$/.test(email)) {
        success = false;
        $(".msg-email").text("Neispravna email adresa!");
    }
    else {
        $(".msg-email").text("");
    }

    // Validiraj lozinku
    if(password.length < 6) {
        success = false;
        $(".msg-password").text("Lozinka mora sadržavati minimalno 6 znakova!");
    }
    else if(!/^[A-Za-z0-9!@#$%^&*()_-]{6,}$/.test(password)) {
        success = false;
        $(".msg-password").text("Lozinka može sadržavati slova, brojeve i posebne znakove ( !@#$%^&*()_- ).");
    }
    else {
        $(".msg-password").text("");
    }

    // Provjeri potvrdu lozinke
    if(!(password === confirm_password)) {
        success = false;
        $(".msg-password-confirm").text("Potvrdite lozinku!");
    }
    else {
        $(".msg-password-confirm").text("");
    }

    return success;
}