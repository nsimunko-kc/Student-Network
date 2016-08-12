var insideLoginDiv = false;

$(document).ready(function() {

});

$(".login-select").mouseenter(function() {
    insideLoginDiv = true;
});

$(".login-select").mouseleave(function() {
    insideLoginDiv = false;
});

$("#btn-sign-in").click(function() {
    $(".overlay").fadeIn();
});

$(".overlay").click(function() {
    if(!insideLoginDiv) {
        $(".overlay").fadeOut();
    }
});

/* textarea-auto-resize by Louis Lazaris */
var txt = $('#post-area'),
    hiddenDiv = $(document.createElement('div')),
    content = null;

txt.addClass('txtstuff');
hiddenDiv.addClass('hiddendiv common');

$('body').append(hiddenDiv);

txt.on('keyup', function () {

    content = $(this).val();

    content = content.replace(/\n/g, '<br>');
    hiddenDiv.html(content + '<br class="lbr">');

    $(this).css('height', hiddenDiv.height());

});
/**/