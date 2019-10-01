<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッション開始
Session::sessionStart();
$user = $_SESSION['user'];

$post = Common::sanitize($_POST);

//カテゴリ、アレルギー表示のためのDB接続
$db = new ItemManage();

//カテゴリ取得
$category = $db ->getCategory($_SESSION['post']['add_detail']['item_category_id']);

//アレルギー品目取得
$allergies = array();
foreach(json_decode($_SESSION['post']['add_detail']['allergy_item'], true) as $value)
    {
    $allergies += array($value => $db ->getAllergy($value));
    }

?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細登録完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細登録完了</h1>
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
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_detail']['item_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php print $category['item_category_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_detail']['item_model_number'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_detail']['item_description'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_detail']['item_detail'];?>
                    </td>
                </tr>
                <tr>
                    <th>アレルギー品目</th>
                    <td class="align-left">
                        <?php 
                        foreach($allergies as $allergy)
                        {
                            print $allergy['allergy_item'].' ';
                        }
                        ?>
                    </td>
                </tr>
            
                <tr>
                    <th>単価</th>
                    <td class="align-left">
                        <?php print $_SESSION['post']['add_detail']['unit_price'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品画像画像</th>
                    <td class="align-left">
                        <img src="../img/<?php print $_SESSION['post']['add_detail']['item_image']['name'];?>" width="25%" height="auto">
                    </td>
                </tr>
                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                        <?php if($_SESSION['post']['add_detail']['is_recommend'] === "1")
                        {
                            print '〇';
                        }
                        else
                        {
                            print '×';
                        }?>
                    </td>
                </tr>

            </table>
            <input type="button" value="完了" onclick="location.href='../../../';">
            <input type="button" value="管理者トップページへ" onclick="location.href='../../../';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>