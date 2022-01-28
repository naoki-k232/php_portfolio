<?php

// 投稿削除画面 投稿とコメントといいね情報を削除
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/ShrineController.php';
require_once ROOT_PATH.'Controllers/UserController.php';
require_once ROOT_PATH.'Controllers/CommentController.php';

$User = new UserController();
$Shrine = new ShrineController();
$Comment = new CommentController();

// var_dump($_GET);
// exit();

// $userにログイン情報を格納
$user = $_SESSION['login_user'];
// ログインチェック
$result = $User->checkLogin($user);
if ($result == false) {
    header('Location: ../login.php');

    return;
}
// レビュー情報を削除
$result_d = $Shrine->shrine_delete();
header('Location: ../index.php');
