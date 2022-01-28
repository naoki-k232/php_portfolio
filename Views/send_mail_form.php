<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();
$error = $_SESSION;
//送信ボタンクリック後
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = [];
    $error = [];
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $error['email'] = 'メールアドレスを入力してください';
    }
    $result = $User->findUserEmail($email);
    if (!$result) {
        $error['false'] = '*ご入力頂いたメールアドレスでのご登録はありません。';
    }
    // var_dump($result);
    // exit();
    // CSRF対策
    $csrf_token = setToken($token);
    $_POST['token'] = $csrf_token;
    if (count($error) === 0) {
        $_SESSION['form'] = $_POST;
        header('Location: send_mail_comp.php');

        exit();
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
    <title>パスワード再発行メール送信フォーム</title>
</head>
<body>
    <?php
    // header部分
    include 'templates/header.php'; ?>
    <div class="form-wrapper">
        <h2>パスワード再設定URLを送信します。</h2>
        <?php if (isset($error['false'])):?>
                        <p class="error"><?php echo h($error['false']); ?></p>
                    <?php endif; ?>
        <p>ご登録頂いているメールアドレスを入力してください。</p>
        <form action="" method="POST">
        <div class="form-item">
            <label for="email"></label>
            <?php if (isset($error['email'])):?>
                        <p class="error"><?php echo h($error['email']); ?></p>
                    <?php endif; ?>
            <input type="email" name="email" required="required" placeholder="メールアドレス"></input>
        </div>
        <div class="button-panel">
            <input type="submit" class="button" title="reissue" value="再発行"></input>
        </div>
        </form>
        <div class="form-footer">
            <p><a href="login.php">ログイン画面へ戻る</a></p>
        </div>
    </div>
</body>
</html>