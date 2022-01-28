$(function () {
    var file = null; // 選択されるファイル
    var blob = null; // 画像(BLOBデータ)
    const THUMBNAIL_WIDTH = 450; // 画像リサイズ後の横の長さの最大値
    const THUMBNAIL_HEIGHT = 450; // 画像リサイズ後の縦の長さの最大値
    // アップロードするファイルを選択
    $("input[type=file]").change(function () {
        var file = $(this).prop("files")[0];

        // 画像以外は処理を停止
        if (!file.type.match("image.*")) {
            // $(this).val("");
            // $("#photo_view").html("");
            file = null;
            blob = null;
            return;
        }

        // 画像をリサイズする
        var image = new Image();
        var reader = new FileReader();
        reader.onload = function (e) {
            image.onload = function () {
                var width, height;
                if (image.width > image.height) {
                    // 横長の画像は横のサイズを指定値にあわせる
                    var ratio = image.height / image.width;
                    width = THUMBNAIL_WIDTH;
                    height = THUMBNAIL_WIDTH * ratio;
                } else {
                    // 縦長の画像は縦のサイズを指定値にあわせる
                    var ratio = image.width / image.height;
                    width = THUMBNAIL_HEIGHT * ratio;
                    height = THUMBNAIL_HEIGHT;
                }
                // サムネ描画用canvasのサイズを上で算出した値に変更
                var canvas = $("#canvas")
                    .attr("width", width)
                    .attr("height", height);
                var ctx = canvas[0].getContext("2d");
                // canvasに既に描画されている画像をクリア
                ctx.clearRect(0, 0, width, height);
                // canvasにサムネイルを描画
                ctx.drawImage(
                    image,
                    0,
                    0,
                    image.width,
                    image.height,
                    0,
                    0,
                    width,
                    height
                );

                // canvasからbase64画像データを取得
                var base64 = canvas.get(0).toDataURL("image/jpeg");
                // base64からBlobデータを作成
                var barr, bin, i, len;
                bin = atob(base64.split("base64,")[1]);
                len = bin.length;
                barr = new Uint8Array(len);
                i = 0;
                while (i < len) {
                    barr[i] = bin.charCodeAt(i);
                    i++;
                }
                blob = new Blob([barr], { type: "image/jpeg" });
                console.log(blob);
            };
            image.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
    $("input[type=file]").on("click", function () {
        $(".img-box").toggle(this.hidden);
    });
});
