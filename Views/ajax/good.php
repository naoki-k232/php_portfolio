<?php

session_start();
require_once '../functions.php';

require_once ROOT_PATH.'Controllers/GoodController.php';

$Good = new GoodController();

error_reporting(E_ALL & ~E_NOTICE);
if (empty($_POST)) {
    header('Location: ../index.php');
    exit();
}
if (isset($_POST)) {
    $user_id = $_SESSION['login_user']['id'];
    $review_id = $_POST['review_id'];

    // いいね登録確認処理
    $result = $Good->check_good_duplicate($user_id, $review_id);
    if ($result == false) {
        // いいね登録処理
        $result_g = $Good->good_entry($user_id, $review_id);
    } else {
        // いいね解除処理
        $result_d = $Good->good_exit($user_id, $review_id);
    }
}

// header('Content-Type: application/json; charset=UTF-8'); //ヘッダー情報の明記。必須。
// session_start();
// require_once '../functions.php';
// require_once '../Debug.php';
// dlog('ajax postTweet  $_POST:', $_POST);

// require_once ROOT_PATH.'Controllers/ShrineController.php';
// require_once ROOT_PATH.'Controllers/UserController.php';
// require_once ROOT_PATH.'Controllers/CommentController.php';
// $User = new UserController();
// $Shrine = new ShrineController();
// $Comment = new CommentController();

// $idNewComment = $Comment->create($_POST);
