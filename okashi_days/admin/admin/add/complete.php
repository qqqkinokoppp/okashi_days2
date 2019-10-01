<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

// セッションの開始
Session::sessionStart();

if(!isset($_SESSION['user']))
{
    header('Location: ../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

$adduser = $_SESSION['post']['add_admin'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者登録完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>管理者登録完了</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で登録しました。</p>
            <table class="list" height="200">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php print $adduser['user_name'];?>
                    </td>
                </tr>
             
                <!--tr>
                    <th>パスワード</th>
                    <td class="align-left">
                    <input type="text" name="item_name" id="item_name" class="item_name" value="">
                    </td>
                </tr>
                <tr>
                    <th>確認用パスワード</th>
                    <td class="align-left">
                    <input type="text" name="item_name" id="item_name" class="item_name" value="">
                    </td>
                </tr>-->
                <tr>
                    <th>管理者氏名</th>
                    <td class="align-left">
                        <?php print $adduser['name'];?>
                    <!--<input type="text" name="item_name" id="item_name" class="item_name" value="">-->
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php print $adduser['email'];?>
                    <!--<input type="text" name="item_name" id="item_name" class="item_name" value="">-->
                    </td>
                </tr>

            </table>
            <input type="button" value="戻る" onclick="location.href='../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>