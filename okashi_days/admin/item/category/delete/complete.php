<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

//セッション開始
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

// $category_name = $_SESSION['edit_category_after']['item_category_name'];
// if($_SESSION['edit_category_after']['item_category_image'] === '')
// {
//     $category_img = $_SESSION['edit_category_before']['item_category_image'];
// }
// else
// {
// $category_img = $_SESSION['edit_category_after']['item_category_image'];
// }

// //使い終わったセッションの破棄
// unset($_SESSION['item_category']);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ削除完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ削除完了</h1>
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
    <p>カテゴリを削除しました。</p>
            <!-- <table class="list" height="200">
                <tr>
                    <th>カテゴリー名</th>
                    <td class="align-left">
                        <?php print $category_name;?>
                    </td>
                </tr>
            
                <tr>
                    <th>カテゴリー画像</th>
                    <td class="align-left">
                    <img src="../img/<?php print $category_img;?>">
                    </td>
                </tr>
            </table> -->
            <input type="button" value="戻る" onclick="location.href='../../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>