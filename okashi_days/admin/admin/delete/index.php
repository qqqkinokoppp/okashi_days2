<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
//ログインしているユーザーの情報を変数に格納
$user = $_SESSION['user'];


$post = Common::sanitize($_POST);
//修正したいユーザーのIDをセッションに保存
if(isset($post['user_id']))
{
$_SESSION['deleteuser']['id'] = $post['user_id'];
}

// $user_name = $_SESSION['edit_user']['user_name'];
// $emai = $_SESSION['edit_user']['email'];

$db = new Admin();

//ワンタイムトークンの取得
$token = Safety::getToken();
//POSTされてきたユーザーIDに該当するユーザー情報を取得してくる
$delete_user = $db ->getAdmin($_SESSION['deleteuser']['id']);
$user_name = $delete_user['user_name'];
$name = $delete_user['name'];
$email = $delete_user['email'];

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者削除確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者削除確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下のユーザーを削除します。</p>

        <form action="process.php" method="post">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php print $user_name;?>
                    </td>
                </tr>

                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                        <?php print $name;?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php print $email?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>