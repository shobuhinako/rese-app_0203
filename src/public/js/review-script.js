// $(document).ready(function() {
//     // クリックでファイル選択ダイアログを開く
//     $("#upload-button").on("click", function(event) {
//         event.stopPropagation();
//         $(".file__input").trigger("click");
//     });

//     // ファイルが選択された場合の処理（クリックとファイル選択両方で動作）
//     $(".file__input").on("change", function() {
//         if (this.files.length > 0) {
//             handleFile(this.files[0]);
//         }
//     });

//     // ドラッグオーバー時のスタイル変更
//     $("#upload-button").on("dragover", function(event) {
//         event.preventDefault();
//         $(this).addClass("dragover");
//     });

//     // ドラッグが離れたときにスタイルを元に戻す
//     $("#upload-button").on("dragleave", function(event) {
//         event.preventDefault();
//         $(this).removeClass("dragover");
//     });

//     // ドロップされたファイルを取得して処理
//     $("#upload-button").on("drop", function(event) {
//         event.preventDefault();
//         $(this).removeClass("dragover");
//         const files = event.originalEvent.dataTransfer.files;
//         if (files.length > 0) {
//             handleFile(files[0]);
//         }
//     });

//     ファイルのプレビューを表示する関数
//     function handleFile(file) {
//         // MIMEタイプを使用してJPEGまたはPNGかをバリデーション
//         if (file && (file.type === "image/jpeg" || file.type === "image/png")) {
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 $("#preview").html(`<img src="${e.target.result}" alt="プレビュー画像">`).show();
//                 $("#upload-button").addClass("image-uploaded"); // テキストを非表示にする
//             };
//             reader.readAsDataURL(file);
//         } else {
//             // 形式が異なる場合はアラートを表示し、ファイル選択をリセット
//             alert("アップロードできる画像形式はJPEGまたはPNGのみです");
//             $(".file__input").val(''); // 選択をクリア
//         }
//     }

// });


$(document).ready(function() {
    // クリックでファイル選択ダイアログを開く
    $("#upload-button").on("click", function(event) {
        event.stopPropagation();
        $(".file__input").trigger("click");
    });

    // ファイルが選択された場合の処理（クリックとファイル選択両方で動作）
    $(".file__input").on("change", function() {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    // ドラッグオーバー時のスタイル変更
    $("#upload-button").on("dragover", function(event) {
        event.preventDefault();
        $(this).addClass("dragover");
    });

    // ドラッグが離れたときにスタイルを元に戻す
    $("#upload-button").on("dragleave", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
    });

    // ドロップされたファイルを取得して処理
    $("#upload-button").on("drop", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
        const files = event.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            // ファイルを<input>に渡す
            $(".file__input")[0].files = files;
            handleFile(files[0]);
        }
    });

    // ファイルのプレビューを表示する関数
    function handleFile(file) {
        // MIMEタイプを使用してJPEGまたはPNGかをバリデーション
        if (file && (file.type === "image/jpeg" || file.type === "image/png")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#preview").html(`<img src="${e.target.result}" alt="プレビュー画像">`).show();
                $("#upload-button").addClass("image-uploaded"); // テキストを非表示にする
            };
            reader.readAsDataURL(file);
        } else {
            // 形式が異なる場合はアラートを表示し、ファイル選択をリセット
            alert("アップロードできる画像形式はJPEGまたはPNGのみです");
            $(".file__input").val(''); // 選択をクリア
        }
    }
});









