<?php
require_once("../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');


// セッションスタート
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/');
}
else
{
    $user = $_SESSION['user'];
}

//おすすめ商品データの取得
$db = new ItemManage();
$recommend = $db ->getRecommendDetail();

//foreach用カウンターの初期化
$i = 0;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お菓子な日々トップページ</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>おすすめ商品</h1>
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
    
    <?php foreach($details as $detail):?>
    <table class="item" width="300">
        <tr>
            <th>商品名</th>
            <th>商品説明</th>
            <td rowspan="2">
                <form action="index.php" method="post">
                <!--選択した商品のIDを渡す-->
                    <input type="hidden" name="item_detail_id" value="<?php print $detail['id'];?>">
                    <input type="submit" value="削除">
                </form>
            </td>
        </tr>
        <tr>
            <td><?php print $detail['item_name'];?></td>
            <td rowspan="2"><?php print $detail['item_description'];?></td>
        </tr>
        <tr>
        <td>
        <img src="../img/<?php print $detail['item_image'];?>">
        </td>
        </tr>
    </table>
    <?php endforeach;?>
    <input type="button" value="戻る" onclick="location.href='../../../';">
    </main>
    <footer>
    </footer>
</div>
</body>
</html>