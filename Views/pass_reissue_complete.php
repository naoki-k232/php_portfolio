<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();

if (!isset($_SESSION['form'])) {
    header('Location: index.php');
    exit();
}
if ($_SESSION['csrf_token'] == $_SESSION['form']['token']) {
} else {
    header('Location: index.php');
    exit();
}
$_SESSION = [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>パスワード再登録完了画面</title>
</head>
<body>
    <?php
    // header部分
    include 'templates/header.php'; ?>
    </div>
    <div class="form-wrapper">
    <h1>パスワード再登録完了</h1>
        <div class="form-footer">
            <p><a href="login.php">ログイン画面へ</a></p>
            <p><a href="index.php">トップページへ戻る</a></p>
        </div>
    </div>
</body>
</html>