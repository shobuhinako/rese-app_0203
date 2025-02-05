$(document).ready(function() {
    $("#upload-button").on("click", function(event) {
        event.stopPropagation();
        $(".file__input").trigger("click");
    });

    $("#preview").on("click", function(event) {
        event.stopPropagation();
        $(".file__input").trigger("click");
    });

    $(".file__input").on("change", function() {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    $("#upload-button").on("dragover", function(event) {
        event.preventDefault();
        $(this).addClass("dragover");
    });

    $("#upload-button").on("dragleave", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
    });

    $("#upload-button").on("drop", function(event) {
        event.preventDefault();
        $(this).removeClass("dragover");
        const files = event.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $(".file__input")[0].files = files;
            handleFile(files[0]);
        }
    });

    function handleFile(file) {
        if (file && (file.type === "image/jpeg" || file.type === "image/png")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#preview").html(`<img class="uploaded__image" src="${e.target.result}" alt="プレビュー画像">`).show();
                $("#upload-button").addClass("image-uploaded");
            };
            reader.readAsDataURL(file);
        } else {
            alert("アップロードできる画像形式はJPEGまたはPNGのみです");
            $(".file__input").val('');
        }
    }
});