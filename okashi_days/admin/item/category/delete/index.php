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
    header('Location: ../../../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}


//ワンタイムトークンの取得
$token = Safety::getToken();

//ログインしているユーザーの情報を変数に格納
$user = $_SESSION['user'];

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいカテゴリのIDをセッションに保存
if(isset($post['item_category_id']))
{
    $_SESSION['id']['delete_category'] = $post['item_category_id'];
}

//商品管理のインスタンス生成
$db = new ItemManage();

// 登録されている商品詳細のカテゴリIDに$post['item_category_id']が1つでもあれば、エラー画面
$category_count = $db ->countCategory($_SESSION['id']['delete_category']);

if($category_count['COUNT(*)'] >= 1)
{
    header('Location: ./error.php');
    exit;
}

//POSTされてきた商品カテゴリIDに該当する情報をDBから取得
$category = $db ->getCategory($_SESSION['id']['delete_category']);
$_SESSION['delete_category'] = $category;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ削除</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ削除</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の商品カテゴリを削除します。</p>

        <form action="process.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php print $category['item_category_name'];?>
                    </td>
                </tr>
            
                <tr>
                    <th>カテゴリ画像</th>
                    <td class="align-left">
                    <img src="../img/<?php print $category['item_category_image'];?>" width="25%" height="auto">
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?php print $token;?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>