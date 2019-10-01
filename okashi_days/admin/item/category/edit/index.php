<?php 
//設定ファイルの読み込み
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッションの開始
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

//ワンタイムトークンの取得
$token = Safety::getToken();


//サニタイズ
$post = Common::sanitize($_POST);

//修正したいカテゴリのIDをセッションに保存
if(isset($post['item_category_id']))
{
    $_SESSION['id']['edit_category'] = $post['item_category_id'];
}

//商品管理のインスタンス生成
$db = new ItemManage();

//POSTされてきた商品カテゴリIDに該当する情報をDBから取得
$category = $db ->getCategory($_SESSION['id']['edit_category']);
$_SESSION['before']['edit_category'] = $category;

//フォーム初期化のための変数に値を格納
// $edit_category = $_SESSION['edit_category_before'];

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ修正</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <!--エラーメッセージがセットされていたら-->
        <?php if(!empty($_SESSION['error']['edit_category'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_category'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_category']['edit_category_name'])):?>
                        <input type="text" name="edit_category_name" id="edit_category_name" class="edit_category_name" value="<?= $_SESSION['post']['edit_category']['item_category_name'];?>">
                        <?php else:?>
                        <input type="text" name="edit_category_name" id="edit_category_name" class="edit_category_name" value="<?= $_SESSION['before']['edit_category']['item_category_name'];?>">
                        <?php endif;?>
                    </td>
                </tr>
            
                <tr>
                    <th>カテゴリ画像</th>
                    <td class="align-left">
                    <img src="../img/<?= $_SESSION['before']['edit_category']['item_category_image'];?>" width="25%" height="auto">
                    <input type="file" name="edit_category_img" id="edit_category_img" class="edit_category_img" value="<?= $_SESSION['before']['edit_category']['item_category_image'];?>">
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <!---->
            <input type="hidden" name="old_category_img_name" value="<?= $_SESSION['before']['edit_category']['item_category_image'];?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>