$(document).ready(function() {
    $('.tab-title').click(function() {
        $('.tab-title').removeClass('active');
        $('.tab-content').removeClass('active');

        $(this).addClass('active');

        var tabId = $(this).data('tab');
        $('#' + tabId).addClass('active');
    });
});
