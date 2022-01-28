<?php
// session_start();

require_once '../functions.php';
?>
<header class="page_header motion">
    <h1><a class="wrapper" href="../index.php"><img  class="logo" src="/img/tatemono_jinja.png" alt="画像">神社仏閣レビュー</a></h1>
    <nav>
        <ul class="main_nav">
            <?php if ($_SESSION['login_user']['role'] == 1): ?>
                <li>管理人</li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['login_user'])):?>
                <li><a href="login.php">ログイン</a></li>
            <?php endif; ?>
            <li><a href="../User/mypage.php?id=<?php echo h($_SESSION['login_user']['id']); ?>">Myページ</a></li>
            <?php if (isset($_SESSION['login_user'])):?>
                <li><a href="../logout.php">ログアウト</a></li>
            <?php endif; ?>
            <?php if (!empty($_SESSION['login_user'])):?>
                <li><a href="/Posts/post.php">投稿</a></li>
            <?php endif; ?>

        </ul>
    </nav>
</header>