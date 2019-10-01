<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

Session::sessionStart();
$user = $_SESSION['user'];

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員パスワード修正完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員パスワード修正完了</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['user_name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>パスワードを修正しました。</p>
            <input type="button" value="戻る" onclick="location.href='../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>