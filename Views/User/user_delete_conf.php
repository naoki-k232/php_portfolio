<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();

// 直接リンク禁止
if ($_SESSION['login_user']['id'] != $_GET['id']) {
    header('Location: index.php');

    return;
} else {
    $user = $_SESSION['login_user'];
    // ユーザー情報取得
    $params = $User->findById($user['id']);
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>神社仏閣レビューアカウント削除画面</title>
</head>

<body>
<?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div class="form-wrapper">
        <h1>アカウント削除</h1>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo h($params['id']); ?>">
            <div class="form-item">
                <p>アカウント削除を行うユーザー情報を失います。</p>
                <p>よろしいですか？</p>
            </div>
            <div class="button-panel">
            <a class="btn btn-danger deleteBtn" href="user_delete_comp.php?id=<?php echo h($params['id']); ?>" role="button">アカウント削除</a>
            </div>
            <div class="form-footer">
                <p><a href="./mypage.php?id=<?php echo h($params['id']); ?>">Myページへ戻る</a></p>
            </div>
        </form>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>