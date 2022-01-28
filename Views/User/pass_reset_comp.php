<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();

// 直接リンク禁止
if (!isset($_SESSION['form']) && $_SESSION['csrf_token'] == $_SESSION['form']['token']) {
    header('Location: index.php');
    exit();
} else {
    $post = $_SESSION['form'];
}

// パスワード更新
$result = $User->passUp($post);
if (!$result) {
    header('Location: pass_reset.php');
    exit();
} else {
    unset($_SESSION['form']);
    unset($_SESSION['csrf_token']);
}
$user = $_SESSION['login_user'];
$params = $User->findById($user['id']);
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>神社仏閣レビューパスワード更新完了画面</title>
</head>

<body>
<?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div class="form-wrapper">
        <h1>パスワード変更</h1>
            <div class="form-item">
                <p>パスワード更新完了しました。</p>
                <p>次回のログインから使用してください。</p>
            </div>
        <div class="form-footer">
            <p><a href="./mypage.php?id=<?php echo h($params['id']); ?>">Myページへ戻る</a></p>
        </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>