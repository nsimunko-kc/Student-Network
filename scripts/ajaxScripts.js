
function ajaxDelete(postID) {
    var c = confirm("Jeste li sigurni da želite obrisati ovaj post?");

    if(c == true) {
        $.ajax({
            url: "api/deletePost.php",
            method: "POST",
            data: {postID: postID},
            success: function(response) {
                $("hr[data-id="+ postID +"]").remove();
                $("article[data-id="+ postID +"]").remove();
            }
        });
    }
}

function ajaxLike(postID) {
    $.ajax({
        url: "api/likePost.php",
        method: "POST",
        data: {postID: postID},
        success: function(response) {
            if(response.response != "invalid api call") {
                $("article[data-id='"+postID+"'] a.like-btn")
					.text("Sviđa mi se ("+ response.response +")");
            }
        }
    });
}

function ajaxFollowFriend(friendID, friendName) {
    var c = confirm("Želite li pratiti obavijesti korisnika '" + friendName + "'?");

    if(c == true) {
        $.ajax({
            url: "api/followFriend.php",
            method: "POST",
            data: {friendID: friendID},
            success: function(response) {
                $("div.friend-suggestion[data-id="+friendID+"]").remove();
            }
        });
    }
}