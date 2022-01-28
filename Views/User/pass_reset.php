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
//更新ボタンクリック後
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = [];
    unset($_SESSION['msg']);
    $post = filter_input_array(INPUT_POST, $_POST);
    // CSRF対策
    $csrf_token = setToken();
    $post['token'] = $csrf_token;
    // バリデーション
    list($post, $error) = pass_up_validate($post);

    if (count($error) === 0 && !isset($_SESSION['msg'])) {
        $_SESSION['form'] = $post;
        header('Location: pass_reset_comp.php');
        exit();
    } else {
        if (isset($_SESSION['form'])) {
            $post = $_SESSION['form'];
            unset($_SESSION['form']);
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>神社仏閣レビューパスワード変更画面</title>
</head>

<body>
<?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <div class="form-wrapper">
        <h1>パスワード変更</h1>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo h($params['id']); ?>">
            <div class="form-item">
                <p>アカウント登録時のパスワードを変更します。</p>
                <?php if (isset($_SESSION['msg'])):?>
                    <p class="error"><?php echo h($_SESSION['msg']); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-item">
                <label for="old_pass">・古いパスワード</label>
                    <?php if (isset($error['old_pass'])):?>
                        <p class="error"><?php echo h($error['old_pass']); ?></p>
                    <?php endif; ?>
                        <?php if (isset($_SESSION['msg']['old_pass'])):?>
                            <p class="error"><?php echo h($_SESSION['msg']['old_pass']); ?></p>
                        <?php endif; ?>
                <input id="old_pass" type="password" name="old_pass" required="required" placeholder="古いパスワード" value="<?php echo h($post['old_pass']); ?>">
            </div>
            <div class="form-item">
                <label for="new_pass">・新しいパスワード</label>
                <?php if (isset($error['new_pass'])):?>
                            <p class="error"><?php echo h($error['new_pass']); ?></p>
                        <?php endif; ?>
                <input id="new_pass" type="password" name="new_pass" required="required" placeholder="新しいパスワード" value="<?php echo h($post['new_pass']); ?>">
            </div>
            <div class="form-item">
                <label for="new_pass_conf">・新しいパスワード確認</label>
                <?php if (isset($error['new_pass_conf'])):?>
                            <p class="error"><?php echo h($error['new_pass_conf']); ?></p>
                        <?php endif; ?>
                <input id="new_pass_conf" type="password" name="new_pass_conf" required="required" placeholder="新しいパスワード確認" value="<?php echo h($post['new_pass_conf']); ?>">
            </div>
            <div class="button-panel">
                <input type="submit" class="button" title="" value="パスワード更新">
            </div>
        </form>
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