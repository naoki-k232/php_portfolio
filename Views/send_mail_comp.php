<?php

session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once '../functions.php';
require_once ROOT_PATH.'Controllers/UserController.php';
$User = new UserController();

if ($_SESSION['csrf_token'] == $_SESSION['form']['token']) {
    $post = $_SESSION['form'];
} else {
    header('Location: index.php');
    exit();
}
$secret_key = sha1(uniqid(rand(), true));
$post['secret_key'] = $secret_key;
$reset_date = date('Y-m-d H:i:s');
$post['reset_date'] = $reset_date;

// トークンとリセット時間を更新
$result = $User->user_reset_Update($post);

//受信者の登録情報を取得
$params = $User->getUser($post['email']);
if ($result == true) {
    $params = $User->getUser($post['email']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/sanitize.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>メール送信完了 | 神社仏閣レビュー</title>
</head>
<body>
    <?php
    // header部分
    include 'templates/header.php'; ?>
    <div class="form-wrapper">
        <h2>メール送信が完了しました。</h2>
        <p>パスワード再設定用のURLをご登録頂いている<br>メールアドレス宛に送信しました。</p>
        <p>URLよりパスワード再設定画面へ進んでください。</p>
        <div class="form-footer">
            <p><a href="login.php">ログイン画面へ戻る</a></p>
        </div>
    </div>
</body>
</html>

<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// 設置した場所のパスを指定する
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/SMTP.php';
// 文字エンコードを指定
mb_language('uni');
mb_internal_encoding('UTF-8');

// インスタンスを生成（true指定で例外を有効化）
$mail = new PHPMailer(true);

// 文字エンコードを指定
$mail->CharSet = 'utf-8';
try {
    // デバッグ設定
    // $mail->SMTPDebug = 2; // デバッグ出力を有効化（レベルを指定）
    // $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str<br>";};

    // SMTPサーバの設定
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //デバグの出力を有効に（テスト環境での検証用）
    $mail->isSMTP();                          // SMTPの使用宣言
    $mail->Host = 'smtp.gmail.com';   // SMTPサーバーを指定
    $mail->SMTPAuth = true;                 // SMTP authenticationを有効化
    $mail->Username = 'test@gmail.com';   // SMTPサーバーのユーザ名
    $mail->Password = 'lnc9D3wSgxR#';           // SMTPサーバーのパスワード
    // $mail->SMTPSecure = false; // ★★★ 暗号化（TLS)を無効
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ★★★ 暗号化（TLS)を有効に
    $mail->Port = 587; // TCPポートを指定（tlsの場合は465や587）

    // 送受信先設定（第二引数は省略可）
    $mail->setFrom('test@gmail.com', '鈴木一郎[テスト管理人]'); // 送信者
    $mail->addAddress($params['email'], $params['name'].'様');   // 宛先
    //$mail->addAddress($_POST['mail'], $params['name'].'様');   // 宛先
    //$mail->addReplyTo('replay@example.com', 'お問い合わせ'); // 返信先
    //$mail->addCC('cc@example.com', '受信者名'); // CC宛先
    $mail->Sender = 'test@gmail.com'; // Return-path

    // 送信内容設定
    $mail->Subject = '【神社仏閣レビュー】パスワード再設定用URLの送付';
    $mail->Body =
    '
    ※このメールはシステムからの自動返信です。
    ご登録ユーザー名
    ＜'.$params['name'].'＞様
    
    お世話になっております。
    パスワード再設定の申請を受け付けました。
    以下URLよりパスワード再設定ページにアクセスの上、パスワードの再設定を行ってください。
    30分間のみ有効です。

    http://localhost/pass_reissue.php?key='.$params['secret_key'];

    // 送信
    $mail->send();
} catch (Exception $e) {
    // エラーの場合
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    return;
}
?>
