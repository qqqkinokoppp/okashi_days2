<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

//セッション開始
Session::sessionStart();
$user = $_SESSION['user'];

$post = Common::sanitize($_POST);

$categoryName = $_SESSION['post']['add_category']['category_name'];
$categoryImg = $_SESSION['post']['add_category']['category_img'];


// var_dump($_SESSION['post']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ登録完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ登録完了</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で登録しました。</p>
            <table class="list" height="200">
                <tr>
                    <th>カテゴリー名</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_category']['category_name'];?>
                    </td>
                </tr>
            
                <tr>
                    <th>カテゴリー画像</th>
                    <td class="align-left">
                    <img src="../img/<?php print $categoryImg;?>"  width="25%" height="auto">
                    </td>
                </tr>
            </table>
            <input type="button" value="戻る" onclick="location.href='../../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>