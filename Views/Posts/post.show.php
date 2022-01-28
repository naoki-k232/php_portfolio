<?php
session_start();
require_once '../functions.php';
require_once ROOT_PATH.'Controllers/ShrineController.php';
require_once ROOT_PATH.'Controllers/UserController.php';
require_once ROOT_PATH.'Controllers/CommentController.php';
require_once ROOT_PATH.'Controllers/GoodController.php';
$User = new UserController();
$Shrine = new ShrineController();
$Comment = new CommentController();
$Good = new GoodController();

ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE);

$id = $_GET['id'];
if (!isset($id)) {
    header('Location: ../index.php');

    return;
}
// $userにログイン情報を格納
$user = $_SESSION['login_user'];
// ログインチェック
$result = $User->checkLogin($user);
if ($result == true) {
    // ユーザー情報取得
    $params = $User->findById($user['id']);
} else {
    header('Location: ../login.php');

    return;
}
// レビュー情報を取得--OK
$review = $Shrine->edit($id);
// このレビューに対するすべてのコメントを取得--OK
$comments = $Comment->commentAll($id);

$user_id = $user['id'];
$review_id = $review['id'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- リセット CSS -->
    <link rel="stylesheet" href="../css/sanitize.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>神社仏閣レビュー詳細画面</title>
</head>

<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div>
        <h2 class="">レビュー詳細</h2>
        <div class="top-edit">
            <?php if ($user['id'] == $review['user_id']): ?>
                <a class="btn btn-success btn-lg" href="./post.edit.php?id=<?php echo h($review['id']); ?>" role="button">編集</a>
            <?php endif; ?>
            <?php if ($user['id'] == $review['user_id'] || $user['role'] == 1):?>
                <a class="btn btn-danger btn-lg" href="./post.delete.php?id=<?php echo h($review['id']); ?>" role="button">削除</a>
            <?php endif; ?>
        </div>
    </div>
        <div class="oya">
            <div class="flex">
                <div class="box1">
                    <div id="photo_view" class="thumbnail-image">
                        <img class="img-box" src="<?php echo '/'."{$review['image']}"; ?>" alt="...">
                    </div>
                </div>
                <div class="box2">
                    <div class="title-form">
                        <label for="title">・投稿ユーザー</label>
                        <p class="title"><?php echo h($review['user_name']); ?></p>
                    </div>
                    <div class="title-form">
                        <label for="title">・タイトル</label>
                        <p class="title"><?php echo h($review['title']); ?></p>
                    </div>
                    <div class="recommend-form">
                        <label class="recommend-label"for="recommend">・おすすめ度</label>
                        <div class="raty" name="<?php echo h($review['recommends']); ?>"></div>
                    </div>
                    <!-- Ajax いいね機能部分 -->
                    <form class="good_edit" action="" method="POST">
                        <button type="button" name="good" class="good_post_btn" data-review_id="<?php echo h($review['id']); ?>" data-user_id="<?php echo h($user['id']); ?>">
                            <div class="heart_edit">
                                <?php if ($Good->check_good_duplicate($user['id'], $review['id'])):?>
                                    <i class="fas fa-heart" style="color:fuchsia;">いいね解除</i>
                                <?php else: ?>
                                    <i class="far fa-heart">いいね</i>
                                <?php endif; ?>
                            </div>
                        </button>
                    </form>
                    <!-- <p>高評価・低評価</p>
                    <i class="far fa-thumbs-up fa-4x"></i>
                    <i class="far fa-thumbs-down fa-4x"></i> -->
                </div>
            </div>
            <div class="box3">
                <div class="description-form">
                    <label for="description">・説明、感想</label>
                    <p class="textarea"><?php echo nl2br(h($review['description'])); ?></p>
                </div>
            </div>
        </div>

        <!-- コメント投稿部分 -->
        <!-- <form class="comment.post" action="../Comment/comment.create.php" method="POST"> -->
        <form class="comment.post" action="" method="POST">
            <div class="commentBox">
                    <div class="commentFlex">
                        <p class="form-title">・コメント投稿</p>
                        <?php if (isset($_SESSION['msg']['text'])):?>
                            <p class="error"><?php echo h($_SESSION['msg']['text']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['msg']['title'])):?>
                            <p class="error"><?php echo h($_SESSION['msg']['title']); ?></p>
                        <?php endif; ?>
                        <button id="send" class="btn btn-primary comment-form-btn sendPostTweet" type="submit">投稿</button>
                    </div>
                    <input type="hidden" name="review_id" id="review_id" value="<?php echo h($review['id']); ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo h($user['id']); ?>">
                    <textarea class="textarea-form" name="text" id="text" data-value="inputText" placeholder="コメント入力。140文字以内にしてください。"></textarea>
            </div>
        </form>
        

        <!-- 投稿したコメントを取得し表示 -->
        <?php foreach ((array) $comments as $tweet): ?>
            <div class="commentsBox">
                <div class="commentsFlex">
                    <a class="commentUserName" href="../User/mypage.php?id=<?php echo h($tweet['user_id']); ?>"><?php echo h($tweet['user_name']); ?></a>
                    <p class="dateTime"><?php echo h(date('Y年m月j日H時i分', strtotime($tweet['created_at']))); ?></p>
                    <?php if ($tweet['user_id'] == $user_id || $user['role'] == 1): ?>
                        <form action="../Comment/comment.delete.php?id=<?php echo h($tweet['id']); ?>" method="POST">
                            <input type="hidden" name="shrines_id" value="<?php echo h($tweet['shrines_id']); ?>">
                            <button class="btn btn-danger delete" type="submit">削除</button>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="description-form">
                    <p class="commentArea"><?php echo nl2br(h($tweet['text'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <?php
        // header部分
        include ROOT_PATH.'Views/templates/footer.php'; ?>
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery.raty.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/good_post.js"></script>
    <script src="../js/delete.js"></script>
    <script type="text/javascript">
        $('.raty').each(function(){
            $(this).raty({
                readOnly: true,
                number: 5,
                size:50,
                //スコアは対象になっているclass「raty」の「name」
                score: $(this).attr('name'),
                path:  '/img/' //サーバ上のRaty画像のパス
                });
            });
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>