<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once '../functions.php';

require_once ROOT_PATH.'Controllers/ShrineController.php';
require_once ROOT_PATH.'Controllers/UserController.php';
require_once ROOT_PATH.'Controllers/GoodController.php';

$User = new UserController();
$Good = new GoodController();
$Shrine = new ShrineController();

$user = $_SESSION['login_user'];

// ログインチェック
$result = $User->checkLogin($user);
$id = $_GET['id'];
if (!$result) {
    header('Location: ../login.php');

    return;
} else {
    // ユーザー情報取得
    $params = $User->findById($id);
}

// ユーザーの投稿を取得
$myReviews = $Shrine->reviewsById($id);

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
    <link rel="stylesheet" href="../css/sanitize.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>神社仏閣レビュー</title>
</head>

<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div>
        <h2 class="my_review">レビュー一覧</h2>
    </div>
    <main class="top_box">
        <?php foreach ($myReviews as $myReview): ?>
        <div class=tweetBox>
            <div class="tweetUser">
                <a class="userName" href="../User/mypage.php?id=<?php echo h($myReview['user_id']); ?>"><?php echo h($myReview['user_name']); ?></a>
            </div>
            <div class=tweetFlex>
                <div class="tweetImage">
                    <img src="<?php echo '/'."{$myReview['image']}"; ?>" alt="...">
                </div>
                <div class="tweetText">
                    <p class="tweetTitle" ><a href="../Posts/post.show.php?id=<?php echo h($myReview['id']); ?>"><?php echo h($myReview['title']); ?></a></p>
                    <p class="tweetLevel">おすすめ度</p>
                        <div class="raty" name="<?php echo h($myReview['recommends']); ?>"></div>
                    <!-- Ajax いいね機能部分 -->
                    <form class="good_count" action="" method="POST">
                        <button type="button" name="good" class="good_btn" data-review_id="<?php echo h($review['id']); ?>" data-user_id="<?php echo h($_SESSION['login_user']['id']); ?>">
                            <div class="hand">
                                <?php if (isset($_SESSION['login_user'])): ?>
                                    <?php if ($Good->check_good_duplicate($_SESSION['login_user']['id'], $myReview['id'])):?>
                                        <i class="fas fa-heart" style="color:fuchsia;">いいね解除</i>
                                    <?php else: ?>
                                        <i class="far fa-heart">いいね</i>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
        <?php endforeach; ?>
    </main>
    <script type="text/javascript" src="/js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery.raty.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/good_post.js"></script>
    <script src="../js/good.js"></script>
    <script src="../js/delete.js"></script>
    <script type="text/javascript">
        $('.raty').each(function(){
            $(this).raty({
                readOnly: true,
                number: 5,
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