<?php

session_start();
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();
// $userにログイン情報を格納
$user = $_SESSION['login_user'];
// ログインチェック
$result = $User->checkLogin($user);

if (!$result) {
    header('Location: login.php');
    exit();
} else {
    // ログアウト処理
    $logout = $User->logout();
    header('Location: index.php');
    exit();
}
