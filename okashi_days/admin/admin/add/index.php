<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_user']))
{
    if(isset($_SESSION['post']['add_user']['user_name']))
    {
        $user_name = $_SESSION['post']['add_user']['user_name'];
    }
    if(isset($_SESSION['post']['add_user']['name']))
    {
        $name = $_SESSION['post']['add_user']['name'];
    }
    if(isset($_SESSION['add_user']['email']))
    {
        $email = $_SESSION['post']['add_user']['email'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者登録</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者登録</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['add_admin'])):?>
        <p class="error">
            <?= $_SESSION['error']['add_admin'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($user_name)):?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $user_name?>">
                        <?php else:?>
                        <input type="text" name="user_name" id="user_name" class="user_name
                        " value="">
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password" id="password" class="password" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="password" name="password2" id="password2" class="password2" value="">
                    </td>
                </tr>
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                    <?php if(isset($name)):?>
                    <input type="text" name="name" id="name" class="name" value="<?= $name?>">
                    <?php else:?>
                    <input type="text" name="name" id="name" class="name" value="">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php if(isset($email)):?>
                    <input type="text" name="email" id="email" class="email" value="<?= $email?>">
                    <?php else:?>
                    <input type="text" name="email" id="email" class="email" value="">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>