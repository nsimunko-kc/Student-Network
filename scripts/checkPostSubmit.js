
function ValidatePost() {

    var success = true;

    var postContent = $(".new-post-div textarea").val();

    if(postContent.length == 0 ||
        postContent.length > 149) {
        success = false;
        alert('Post mora sadržavati između 0 i 150 znakova!');
    }

    return success;
}
