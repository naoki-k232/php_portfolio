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

$id = $_GET['id'];
// ログインチェック
$result = $User->checkLogin($user);

if (!$result) {
    header('Location: ../login.php');

    return;
} else {
    // ユーザー情報取得
    $params = $User->findById($id);
}
// $id = $_SESSION['review_id'];
// ユーザーの投稿件数を取得
$count = $Shrine->findById($id);
$goods = $Good->findById($id);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>神社仏閣レビュー</title>
</head>

<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div class="mypage-wrapper">
        <h1>アカウント情報</h1>
        <div class="form-item MyPageName">
            <label class="myName"for="name">・ユーザー名</label>
            <p class="myPageP"><?php echo h($params['name']); ?></p>
        </div>
        <div class="form-item MyPageName">
            <?php if ($user['id'] == $params['id']): ?>
                <label class="myEmail" for="email">・メールアドレス</label>
                <p class="myPageP"><?php echo h($params['email']); ?></p>
            <?php endif; ?>
        </div>
        <div class="form-item MyPageName">
            <label>・投稿一覧</label>
            <a href="./myreview.php?id=<?php echo h($params['id']); ?>"><?php echo h($count); ?>件</a>
        </div>
        <div class="form-item MyPageName">
            <label>・いいね一覧</label>
            <a href="./myreview.good.php?id=<?php echo h($params['id']); ?>"><?php echo h($goods); ?>件</a>
        </div>
        <?php if ($user['id'] == $params['id']):?>
            <div class="btnFlex">
                <a class="btn btn-primary" href="user_edit.php?id=<?php echo h($params['id']); ?>" role="button">アカウント編集</a>
                <a class="btn btn-danger" href="user_delete_conf.php?id=<?php echo h($params['id']); ?>" role="button">アカウント削除</a>
            </div>
        <?php endif; ?>
    </div>
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>