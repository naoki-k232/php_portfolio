<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';

$User = new UserController();

if ($_SESSION['login_user']['id'] != $_GET['id']) {
    header('Location: index.php');

    return;
} else {
    $user = $_SESSION['login_user'];
    // ユーザー情報取得
    $params = $User->findById($user['id']);
}

//送信ボタンクリック後
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = [];
    $post = filter_input_array(INPUT_POST, $_POST);
    list($post, $error) = user_update_validate($post);
    // var_dump($post);
    // exit();
    if (count($error) === 0) {
        // ユーザー情報更新
        $result = $User->userUpdate($post);
        if (!$result) {
            $_SESSION['msg'] = '更新できませんでした。';
        } else {
            header('Location: ./mypage.php?id='.$post['id']);
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
    <title>神社仏閣レビューMyページ編集</title>
</head>

<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div class="form-wrapper">
        <h1>アカウント編集フォーム</h1>
        <form action="" method="POST">
            <div class="form-item">
                <?php if (empty($_SESSION['msg'])):?>
                    <p class="error"><?php echo $_SESSION['msg']; ?></p>
                <?php endif; ?>
                <input type="hidden" name="id" value="<?php echo h($params['id']); ?>">
                <label for="name">・ユーザー名</label>
                <?php if (isset($error['name'])):?>
                    <p class="error"><?php echo h($error['name']); ?></p>
                <?php endif; ?>
                <input type="name" name="name" required="required" placeholder="ユーザー名" value="<?php echo h($params['name']); ?>">
            </div>
            <div class="form-item">
                <label for="email">・メールアドレス</label>
                <?php if (isset($error['email'])):?>
                            <p class="error"><?php echo h($error['email']); ?></p>
                        <?php endif; ?>
                <input type="email" name="email" required="required" placeholder="メールアドレス" value="<?php echo h($params['email']); ?>">
            </div>
            <div class="button-panel">
                <input type="submit" class="button" title="Sign Up" value="アカウント更新">
            </div>
        </form>
        <div class="form-footer">
            <p><a href="./pass_reset.php?id=<?php echo h($params['id']); ?>">パスワード変更画面</a></p>
            <p><a href="./mypage.php?id=<?php echo h($params['id']); ?>">Myページへ戻る</a></p>
        </div>
    </div>
</body>
</html>