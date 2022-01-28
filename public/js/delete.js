$(function () {
    // 削除用ポップアップ
    $(".delete").on("click", function () {
        if (!confirm("削除してもよろしいですか？")) {
            return false;
        } else {
            return true;
        }
    });
});
