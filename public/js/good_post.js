$(document).on("click", ".good_post_btn", function (e) {
    e.stopPropagation();
    let user_id = $(e.currentTarget).data("user_id");
    let review_id = $(e.currentTarget).data("review_id");

    $.ajax({
        type: "POST",
        url: "../ajax/good.php",
        dataType: "json",
        data: { user_id: user_id, review_id: review_id },
    })
        .done(function (data) {
            location.reload();
        })
        .fail(function () {
            location.reload();
        });
});
// コメント投稿
$(document).on("click", ".sendPostTweet", function (e) {
    e.stopPropagation();

    let text = $(".textarea-form").val();
    let review_id = $("#review_id").val();
    let user_id = $("#user_id").val();
    $.ajax({
        type: "POST",
        url: "../Comment/comment.create.php",
        dataType: "json",
        data: { user_id: user_id, review_id: review_id, text: text },
    })
        .done(function (data) {
            location.reload();
        })
        .fail(function () {
            location.reload();
        });
});
