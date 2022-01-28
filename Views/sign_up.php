<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();

//送信ボタンクリック後
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = [];
    $error = [];
    unset($_SESSION['msg']);
    $post = filter_input_array(INPUT_POST, $_POST);
    // CSRF対策
    $csrf_token = setToken($token);
    $post['token'] = $csrf_token;
    list($post, $error) = sign_up_validate($post);
    $nameCheck = $User->checkName($post['name']);
    $emailCheck = $User->checkEmail($post['email']);

    if (count($error) === 0 && !isset($_SESSION['msg'])) {
        $_SESSION['form'] = $post;
        header('Location: sign_up_complete.php');
        exit();
    } else {
        if (isset($_SESSION['form'])) {
            $post = $_SESSION['form'];
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
    <title>新規登録画面</title>
</head>
<body>
    <?php
    // header部分
    include 'templates/header.php'; ?>
    <div class="form-wrapper">
        <h1>新規登録入力フォーム</h1>
        <form action="" method="POST">
                    <?php if (isset($_SESSION['msg'])):?>
                        <p class="error"><?php echo h($_SESSION['msg']); ?></p>
                    <?php endif; ?>
        <div class="form-item">
            <label for="name">・ユーザー名</label>
            <?php if (isset($error['name'])):?>
                        <p class="error"><?php echo h($error['name']); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg']['name'])):?>
                        <p class="error"><?php echo h($_SESSION['msg']['name']); ?></p>
                    <?php endif; ?>
            <input type="name" name="name" required="required" placeholder="ユーザー名" value="<?php echo h($post['name']); ?>">
        </div>
        <div class="form-item">
            <label for="email">・メールアドレス</label>
            <?php if (isset($error['email'])):?>
                        <p class="error"><?php echo h($error['email']); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg']['email'])):?>
                        <p class="error"><?php echo h($_SESSION['msg']['email']); ?></p>
                    <?php endif; ?>
            <input type="email" name="email" required="required" placeholder="メールアドレス" value="<?php echo h($post['email']); ?>">
        </div>
        <div class="form-item">
            <label for="password">・パスワード</label>
            <?php if (isset($error['password'])):?>
                        <p class="error"><?php echo h($error['password']); ?></p>
                    <?php endif; ?>
            <input type="password" name="password" required="required" placeholder="パスワード" value="<?php echo h($post['password']); ?>">
        </div>
        <div class="form-item">
            <label for="password_conf">・パスワード確認</label>
            <?php if (isset($error['password_conf'])):?>
                        <p class="error"><?php echo h($error['password_conf']); ?></p>
                    <?php endif; ?>
            <input type="password" name="password_conf" required="required" placeholder="パスワード確認" value="<?php echo h($post['password_conf']); ?>">
        </div>
        <div class="button-panel">
            <input type="submit" class="button" title="Sign Up" value="新規登録">
        </div>
        </form>
        <div class="form-footer">
            <p><a href="index.php">トップページへ戻る</a></p>
        </div>
    </div>
</body>
</html>