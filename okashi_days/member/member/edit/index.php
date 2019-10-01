<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

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

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいユーザーのIDをセッションに保存
if(isset($user['user_id']))
{
    $_SESSION['id']['edit_member'] = $post['user_id'];
}

$db = new Member();

//ワンタイムトークンの取得
$token = Safety::getToken();

//POSTされてきたユーザーIDに該当するユーザー情報を取得してくる
$edit_user = $db ->getAdmin($_SESSION['id']['edit_user']);
$user_name = $edit_user['user_name'];
$name = $edit_user['name'];
$email = $edit_user['email'];

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員情報修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員情報修正</h1>
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
        <?php if(!empty($_SESSION['error']['edit_admin'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_admin'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?= $token;?>">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($user_name)):?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $user_name?>">
                        <?php else:?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="">
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
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>