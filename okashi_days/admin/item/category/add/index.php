<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
Session::sessionStart();
$user = $_SESSION['user'];

$token = Safety::getToken();
//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_category']))
{
    if(isset($_SESSION['post']['add_category']['category_name']))
    {
        $category_name = $_SESSION['post']['add_category']['category_name'];
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ登録</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ登録</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php'">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['addCategory'])):?>
        <p class="error">
            <?php print $_SESSION['error']['addCategory'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>カテゴリ名</th>
                    <td class="align-left">
                        <?php if(isset($category_name)):?>
                        <input type="text" name="category_name" id="category_name" class="category_name" value="<?php print $category_name?>">
                        <?php else:?>
                        <input type="text" name="category_name" id="category_name" class="category_name" value="">
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>商品カテゴリ画像</th>
                    <td class="align-left">
                    <input type="file" name="category_img" id="category_img" class="category_img" value="">
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../../'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>