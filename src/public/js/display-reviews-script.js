$(document).ready(function() {
    // タブがクリックされた時の処理
    $('.tab-title').click(function() {
        // すべてのタブを非アクティブにする
        $('.tab-title').removeClass('active');
        $('.tab-content').removeClass('active');

        // クリックされたタブをアクティブにする
        $(this).addClass('active');

        // 対応するタブのコンテンツを表示
        var tabId = $(this).data('tab');
        $('#' + tabId).addClass('active');
    });
});
