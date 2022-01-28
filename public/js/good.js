$(document).on("click", ".good_btn", function (e) {
    e.stopPropagation();
    let user_id = $(e.currentTarget).data("user_id");
    let review_id = $(e.currentTarget).data("review_id");
    // console.log(user_id);
    // console.log(review_id);

    $.ajax({
        type: "POST",
        url: "./ajax/good.php",
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
// console.log("postTweet");
// $(function () {
//     const MAX_TWEET_LENGTH = 140;

//     $("#send").click(function () {
//         // データ取得確認OK
//         let text = $(".textarea-form").val();
//         let review = $("#review_id").val();
//         let user = $("#user_id").val();
//         //140文字以内でのみ投稿処理
//         if (text.length > MAX_TWEET_LENGTH || text.length == 0) {
//             console.log("投稿内容を確認してください");
//         } else {
//             console.log("ajax前");
//             $.ajax({
//                 url: "/ajax/ajax_post.php",
//                 type: "POST",
//                 dataType: "json",
//                 data: {
//                     user_id: user,
//                     review_id: review,
//                     text: text,
//                 },
//             })
//                 .done(function (data) {
//                     console.log("ajax success");
//                     console.log("data:\n", data);
//                     //$('.debugArea').prepend(data);

//                     //投稿後の処理
//                     $(".tweetInput").val("");
//                     $(data).prependTo(".tweetList").hide().fadeIn(1000);
//                 })
//                 .fail(function (msg) {
//                     console.log("Ajax Error:", msg);
//                 });
//             // .done(function (data) {
//             //     location.reload();
//             // })
//             // .fail(function () {
//             //     location.reload();
//             // });
//         }
//     });
// });
