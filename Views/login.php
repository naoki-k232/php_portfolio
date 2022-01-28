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

    list($post, $error) = login_validate($post);
    $login = $User->userLogin($post);

    if (count($error) === 0 && !isset($_SESSION['msg'])) {
        unset($_SESSION['form']);
        header('Location: index.php');
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
    <title>ログイン画面</title>
</head>
<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    </div>
    <div class="form-wrapper">
        <h1>ログイン入力フォーム</h1>
        <form action="" method = "POST">
        <div class="form-item">
            <label for="email">・登録メールアドレス</label>
            <?php if (isset($error['email'])):?>
                        <p class="error"><?php echo h($error['email']); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg']['email'])):?>
                        <p class="error"><?php echo h($_SESSION['msg']['email']); ?></p>
                    <?php endif; ?>
            <input type="email" name="email" required="required" placeholder="メールアドレス" value="<?php echo h($post['email']); ?>">
        </div>
        <div class="form-item">
            <label for="password">・登録パスワード</label>
            <?php if (isset($error['password'])):?>
                        <p class="error"><?php echo h($error['password']); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['msg']['password'])):?>
                        <p class="error"><?php echo h($_SESSION['msg']['password']); ?></p>
                    <?php endif; ?>
            <input type="password" name="password" required="required" placeholder="パスワード" value="<?php echo h($post['password']); ?>">
        </div>
        <div class="button-panel">
            <input type="submit" class="button" title="Sign In" value="ログイン">
        </div>
        </form>
        <div class="form-footer">
            <p><a href="sign_up.php">新規作成はこちら</a></p>
            <p><a href="send_mail_form.php">パスワードを忘れた方はこちら</a></p>
        </div>
    </div>
</body>
</html>