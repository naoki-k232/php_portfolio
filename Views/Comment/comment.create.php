<?php

session_start();
require_once '../functions.php';
require_once ROOT_PATH.'Controllers/ShrineController.php';
require_once ROOT_PATH.'Controllers/UserController.php';
require_once ROOT_PATH.'Controllers/CommentController.php';

$User = new UserController();
$Shrine = new ShrineController();
$Comment = new CommentController();

ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE);

if (!isset($_POST)) {
    header('Location: ../index.php');

    exit();
}

$newTweet = filter_input_array(INPUT_POST, $_POST, FILTER_SANITIZE_SPECIAL_CHARS);
// 投稿バリデーション
list($newTweet, $error) = tweet_validate($newTweet);
// exit();
if (count($error) === 0) {
    $result = $Comment->createTweet($newTweet);
    unset($_SESSION['msg']);
    header('Location: ../Posts/post.show.php?id='.$newTweet['review_id']);
} else {
    $_SESSION['msg'] = $error;
    header('Location: ../Posts/post.show.php?id='.$newTweet['review_id']);
    exit();
}

if ($result == true) {
    header('Location: ../Posts/post.show.php?id='.$newTweet['review_id']);
    exit();
} else {
    $_SESSION['msg']['title'] = 'コメント投稿に失敗しました。';
    header('Location: ../Posts/post.show.php?id='.$newTweet['review_id']);
    exit();
}
