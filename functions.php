<?php

/**
 * XSS対策：エスケープ処理.
 *
 * @param string $str 対象の文字列
 *
 * @return string 処理された文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * CSRF対策.
 *
 * @param void
 *
 * @return string
 */
function setToken()
{
    // トークンを生成
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;

    return $token;
}

/**
 * 新規登録のバリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */
function sign_up_validate($post)
{
    $error = [];
    if ($post['name'] === '') {
        $error['name'] = 'ユーザー名を入力してください';
    }
    if ($post['email'] === '' || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '正しいメールアドレスを入力してください';
    }
    // パスワード正規表現
    // 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上の正規表現
    $password = filter_input(INPUT_POST, 'password');
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    if (!$uppercase) {
        $error['password'] = 'パスワードに半角英大文字が足りません';
    } elseif (!$lowercase) {
        $error['password'] = 'パスワードに半角英小文字が足りません';
    } elseif (!$number) {
        $error['password'] = 'パスワードに半角数字が足りません';
    } elseif (strlen($password) < 8) {
        $error['password'] = 'パスワードは8文字以上必要です';
    }
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    if ($password !== $password_conf) {
        $error['password_conf'] = 'パスワードと違います';
    }

    return [$post, $error];
}
/**
 * ログインバリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */
function login_validate($post)
{
    $error = [];
    if ($post['email'] === '' || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '正しいメールアドレスを入力してください';
    }
    $password = $post['password'];
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    if (!$uppercase) {
        $error['password'] = 'パスワードに半角英大文字が足りません';
    } elseif (!$lowercase) {
        $error['password'] = 'パスワードに半角英小文字が足りません';
    } elseif (!$number) {
        $error['password'] = 'パスワードに半角数字が足りません';
    } elseif (strlen($password) < 8) {
        $error['password'] = 'パスワードは8文字以上必要です';
    }

    return [$post, $error];
}

/**
 * passリセットバリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */
function pass_validate($post)
{
    $error = [];
    // パスワード正規表現
    // 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上の正規表現
    $password = filter_input(INPUT_POST, 'password');
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    if (!$uppercase) {
        $error['password'] = 'パスワードに半角英大文字が足りません';
    } elseif (!$lowercase) {
        $error['password'] = 'パスワードに半角英小文字が足りません';
    } elseif (!$number) {
        $error['password'] = 'パスワードに半角数字が足りません';
    } elseif (strlen($password) < 8) {
        $error['password'] = 'パスワードは8文字以上必要です';
    }
    $password_conf = filter_input(INPUT_POST, 'password_conf');
    if ($password !== $password_conf) {
        $error['password_conf'] = 'パスワードと違います';
    }

    return [$post, $error];
}

/**
 * ユーザー情報更新バリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */
function user_update_validate($post)
{
    $error = [];
    if ($post['name'] === '') {
        $error['name'] = 'ユーザー名を入力してください';
    }
    if ($post['email'] === '' || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
        $error['email'] = '正しいメールアドレスを入力してください';
    }

    return [$post, $error];
}

/**
 * pass更新バリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */
function pass_up_validate($post)
{
    $old_pass = $post['old_pass'];
    $new_pass = $post['new_pass'];
    $new_pass_conf = $post['new_pass_conf'];
    $error = [];
    // パスワード正規表現
    // 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上の正規表現
    $uppercase = preg_match('@[A-Z]@', $old_pass);
    $lowercase = preg_match('@[a-z]@', $old_pass);
    $number = preg_match('@[0-9]@', $old_pass);
    if (!$uppercase) {
        $error['old_pass'] = 'パスワードに半角英大文字が足りません';
    } elseif (!$lowercase) {
        $error['old_pass'] = 'パスワードに半角英小文字が足りません';
    } elseif (!$number) {
        $error['old_pass'] = 'パスワードに半角数字が足りません';
    } elseif (strlen($old_pass) < 8) {
        $error['old_pass'] = 'パスワードは8文字以上必要です';
    }

    $uppercase = preg_match('@[A-Z]@', $new_pass);
    $lowercase = preg_match('@[a-z]@', $new_pass);
    $number = preg_match('@[0-9]@', $new_pass);
    if (!$uppercase) {
        $error['new_pass'] = 'パスワードに半角英大文字が足りません';
    } elseif (!$lowercase) {
        $error['new_pass'] = 'パスワードに半角英小文字が足りません';
    } elseif (!$number) {
        $error['new_pass'] = 'パスワードに半角数字が足りません';
    } elseif (strlen($new_pass) < 8) {
        $error['new_pass'] = 'パスワードは8文字以上必要です';
    }
    if ($new_pass == $old_pass) {
        $error['new_pass'] = '古いパスワードと同じです。';
        $error['old_pass'] = '新しいパスワードと同じです。';
    }
    if ($new_pass !== $new_pass_conf) {
        $error['new_pass_conf'] = 'パスワードと違います';
    }

    return [$post, $error];
}

/*
 * 投稿時のバリデーション.
 *
 * @param array $post
 *
 * @return array $post $error
 */

function review_validate($review)
{
    if (empty($review['title']) || mb_strlen($review['title']) > 30) {
        $error['title'] = 'タイトルは必須です。また、30文字以内で入力してください。';
    }
    if (empty($review['description']) || mb_strlen($review['description']) > 1000) {
        $error['description'] = '説明、感想は必須です。また、1000文字以内で入力してください。';
    }
    if ($review['score'] == 0) {
        $error['star'] = 'おすすめ度は必須です。';
    }

    return [$review, $error];
}

/*
 * コメントのバリデーション.
 *
 * @param array $newTweet
 *
 * @return array $newTweet $error
 */

function tweet_validate($newTweet)
{
    $error = [];
    if (empty($newTweet['text']) || mb_strlen($newTweet['text']) > 140) {
        $error['text'] = 'コメントは必須です。また、140文字以内で入力してください。';
    }

    return [$newTweet, $error];
}
