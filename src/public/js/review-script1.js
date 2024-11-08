$(document).ready(function() {
    const fileInput = $('#file-input');
    const preview = $('#preview');

    // アップロードボックスがクリックされたときにfileInputをクリック
    // $('#upload-box').on('click', function() {
    //     fileInput.trigger('click'); // 手動でfile-inputをクリック
    // });
    $("button").on("click", function() {
        $("input").trigger("click");
    });

    // ファイルが選択されたときの処理
    fileInput.on('change', function() {
        if (fileInput[0].files.length > 0) {
            handleFile(fileInput[0].files[0]);
        }
    });

    // ドラッグアンドドロップのイベント設定
    $('#upload-box').on('dragover', function(e) {
        e.preventDefault();
        $(this).css('background-color', '#e0e0e0'); // ドラッグ時の背景変更
    }).on('dragleave', function() {
        $(this).css('background-color', ''); // 元の色に戻す
    }).on('drop', function(e) {
        e.preventDefault();
        $(this).css('background-color', '');
        const files = e.originalEvent.dataTransfer.files;
        if (files.length) {
            fileInput[0].files = files; // ドロップされたファイルをfileInputに設定
            handleFile(files[0]); // プレビューを表示
        }
    });

    // プレビュー表示用関数
    function handleFile(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.html(`<img src="${e.target.result}" alt="プレビュー画像" style="max-width: 100%; height: auto;">`);
            };
            reader.readAsDataURL(file); // 画像ファイルをデータURLとして読み込む
        }
    }
});
