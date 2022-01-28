<?php

// ユーザー情報消去画面
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();
// 直リンク禁止
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}
// ユーザー情報削除
$result = $User->userDelete($_GET['id']);

if (!$result) {
    // falseだった場合
    $_SESSION['msg'] = 'アカウント削除に失敗しました。';
    header('Location: ./mypage.php');
} else {
    $_SESSION = [];
    session_destroy();
    header('Location: ../index.php');
}
exit();
