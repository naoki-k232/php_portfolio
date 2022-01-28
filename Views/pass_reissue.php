<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();
if (!isset($_GET['key'])) {
    header('Location: index.php');
    exit();
}
// keyからユーザー情報取得
$key = $_GET['key'];
$params = $User->userFindByKey($key);

if (!$params) {
    header('Location: ./index.php');
    exit();
}
// formボタンクリック後
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = [];
    $error = [];
    $post = filter_input_array(INPUT_POST, $_POST);
    $post['key'] = $key;

    // CSRF対策
    $csrf_token = setToken();
    $post['token'] = $csrf_token;

    $reset_date = date('Y-m-d H:i:s');
    $post['reset_date'] = $reset_date;

    list($post, $error) = pass_validate($post);
    if (count($error) === 0) {
        $passUpdate = $User->passUpdate($post);

        if (!$passUpdate) {
            $_SESSION['msg'] = 'パスワード変更できませんでした。';
            header('Location: ./sign_up.php');
            exit();
        } else {
            $_SESSION['form'] = $post;
            header('Location: pass_reissue_complete.php');
            exit();
        }
    }
}
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
    <title>パスワード再登録画面</title>
</head>
<body>
    <?php
    // header部分
    include 'templates/header.php'; ?>
    </div>
    <div class="form-wrapper">
        <h1>パスワード再発行入力フォーム</h1>
        <p>新規パスワードを発行します。<br>再度パスワードを入力してください。</p>
        <form action="" method = 'POST'>
        <div class="form-item">
            <label for="password">・新しいパスワード</label>
            <?php if (isset($error['password'])):?>
                        <p class="error"><?php echo h($error['password']); ?></p>
                    <?php endif; ?>
            <input type="password" name="password" required="required" placeholder="パスワード"></input>
        </div>
        <div class="form-item">
            <label for="password_conf">・パスワード確認</label>
            <?php if (isset($error['password_conf'])):?>
                        <p class="error"><?php echo h($error['password_conf']); ?></p>
                    <?php endif; ?>
            <input type="password" name="password_conf" required="required" placeholder="パスワード確認"></input>
        </div>
        <div class="button-panel">
            <input type="submit" class="button" title="reissue" value="再登録"></input>
        </div>
        </form>
        <div class="form-footer">
            <p><a href="login.php">ログイン画面へ戻る</a></p>
        </div>
    </div>
</body>
</html>