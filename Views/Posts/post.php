<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

require_once '../functions.php';
require_once ROOT_PATH.'Controllers/ShrineController.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$Shrine = new ShrineController();
$User = new UserController();
$user = $_SESSION['login_user'];
ini_set('display_errors', 'On');

// ログインチェック
$result = $User->checkLogin($user);
if (!$result) {
    header('Location: ../login.php');

    return;
}
$user_id = $user['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($_POST);
    // var_dump($_FILES);
    $error = [];
    $review = filter_input_array(INPUT_POST, $_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    // 投稿バリデーション
    list($review, $error) = review_validate($review);
    // 画像
    $img = basename($_FILES['image']['name']);
    $img_err = $_FILES['image']['error'];
    $img_size = $_FILES['image']['size'];
    $tmp_path = $_FILES['image']['tmp_name'];
    $upload_dir = 'img/';
    $save_filename = date('Ymdhis').$img;
    $save_path = $upload_dir.$save_filename;

    // 画像ファイルのバリデーション
    // ①画像ファイルがあるか
    if (is_uploaded_file($tmp_path)) {
        // 画像データを移動
        move_uploaded_file($tmp_path, $save_path);
    } else {
        $error['image'] = '画像を保存できませんでした。';
        // unset($_FILES);
    }

    // ②拡張子は画像形式か
    $allow_ext = ['jpg', 'jpeg', 'png'];
    $file_ext = pathinfo($img, PATHINFO_EXTENSION);

    if (!in_array(strtolower($file_ext), $allow_ext)) {
        $error['image'] = '画像ファイルはjpg,jpeg,png形式にしてください。';
        // unset($_FILES);
    }

    // ③ファイルのサイズが1MB未満か
    if ($imgsize > 1048576 || $img_err == 2) {
        $error['image'] = 'ファイルのサイズは1MB未満にしてください。';
        // unset($_FILES);
    }

    // CSRF対策
    // $csrf = $_SESSION['csrf_token'];
    // $token = filter_input(INPUT_POST, 'csrf_token');
    // if (!isset($csrf) || $token !== $csrf) {
    //     exit('不正なリクエストです。');
    // }
    // unset($csrf);

    // エラーがなければ、DBにデータを保存し、トップ画面に遷移
    if (count($error) === 0) {
        $result = $Shrine->createReview($user_id, $review, $save_path);
        header('Location: ../index.php');
        exit;
    }
}
// unset($_FILES);
// $error = [''];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- リセット CSS -->
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>神社仏閣レビュー投稿画面</title>
</head>

<body>
    <?php
    // header部分
    include ROOT_PATH.'Views/templates/header.php'; ?>
    <h2 class="">レビュー投稿</h2>
        <form enctype = "multipart/form-data" action="" method="POST">
            <div class="oya">
                <div class="flex">
                    <div class="box1">
                        <div id="photo_view" class="thumbnail-image">
                            <p class="thumbnail-text">サムネイル画像</p>
                            <?php if (isset($error['image'])):?>
                                <p class="error"><?php echo h($error['image']); ?></p>
                            <?php endif; ?>
                            <!-- サムネイル表示領域 -->
                            <canvas id="canvas" width="0" height="0" class="canvas"></canvas>
                        </div>
                        <div class="input-group mb-3 file-up">
                            <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
                            <input type="file" name="image" accept="image/*" class="form-control" id="inputGroupFile02">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>
                    <div class="box2">
                        <div class="title-form">
                            <label for="title">・タイトル</label>
                            <?php if (isset($error['title'])):?>
                                <p class="error"><?php echo h($error['title']); ?></p>
                            <?php endif; ?>
                            <input class="input-title"name="title" type="text" required="required" placeholder="タイトル" value="<?php echo h($review['title']); ?>">
                        </div>
                        <div class="recommend-form">
                            <label class="recommend-label"for="recommend">・おすすめ度</label>
                                <?php if (isset($error['star'])):?>
                                    <p class="error"><?php echo h($error['star']); ?></p>
                                <?php endif; ?>
                            <!-- jQueryにて実装 -->
                            <div id="targetType"></div>
                            <input name="score" id="hint" type="hidden" />
                            
                            <!-- CSSにて星評価実装方法 -->
                            <!-- <div class="evaluation">
                                <input id="star1" type="radio" name="star" value="5" />
                                <label for="star1"><span class="text"></span>★</label>
                                <input id="star2" type="radio" name="star" value="4" />
                                <label for="star2"><span class="text"></span>★</label>
                                <input id="star3" type="radio" name="star" value="3" />
                                <label for="star3"><span class="text"></span>★</label>
                                <input id="star4" type="radio" name="star" value="2" />
                                <label for="star4"><span class="text"></span>★</label>
                                <input id="star5" type="radio" name="star" value="1" />
                                <label for="star5"><span class="text"></span>★</label>
                            </div> -->
                        
                        </div>
                    </div>
                </div>
                <div class="box3">
                    <div class="description-form">
                        <label for="description">・説明、感想</label>
                        <?php if (isset($error['description'])):?>
                                <p class="error"><?php echo h($error['description']); ?></p>
                        <?php endif; ?>
                        <textarea name="description" id="description"><?php echo nl2br(h($review['description'])); ?></textarea>
                    </div>
                </div>
                <div class="box4">
                    <div class="btn-post">
                        <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
                        <input type="submit" class="btn btn-primary btn post-btn" title="Post" value="投稿">
                    </div>
                    <div class="return-btn">
                        <button type="button" class="btn btn-secondary btn"><a href="../index.php">トップページへ戻る</a></button>
                    </div>
                </div>
            </div>
        </form>
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/jquery.raty.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="../js/ajaxPost.js"></script>
    <script>
        $('#targetType').raty({
            target:       '#hint',
            targetType:   'score',
            targetKeep:   true,
            path:  '/img/' //サーバ上のRaty画像のパス
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>