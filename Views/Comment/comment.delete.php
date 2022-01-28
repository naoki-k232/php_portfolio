<?php

// コメント削除画面 コメント情報を削除
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/CommentController.php';

$delete_c = filter_input_array(INPUT_POST, $_POST, FILTER_SANITIZE_SPECIAL_CHARS);
$shrines_id = $delete_c['shrines_id'];
$Comment = new CommentController();
$comment_d = $Comment->comment_delete();

header('Location: ../Posts/post.show.php?id='.$shrines_id);
