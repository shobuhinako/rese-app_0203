$(document).ready(function() {
    $("textarea[name='comment']").on("keyup", function() {
        var length = $(this).val().length;
        var maxLength = 400;
        $("#inputlength").text(length + "/" + maxLength + "（最高文字数）");
    });
});