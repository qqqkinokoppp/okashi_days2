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

//ログインしているユーザーの情報を変数に格納
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/login.php');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

//サニタイズ
$post = Common::sanitize($_POST);


//修正したい商品のIDをセッションに保存
if(isset($post['item_detail_id']))
{
    $_SESSION['delete_detail_id'] = $post['item_detail_id'];
}

//商品管理のインスタンス生成
$db = new ItemManage();

//商品IDに該当する情報をDBから取得
$detail = $db ->getDetail($_SESSION['delete_detail_id']);

//DBに登録されているアレルギー品目の項目のJSONファイルを配列に変換
$detail_allergies_id = json_decode($detail['allergy_item'], true);
$detail_allergies = array();//foreachのための配列変数準備
foreach($detail_allergies_id as $value)
{
    $detail_allergies += array($value => $db ->getAllergy($value));
}

//カテゴリ
$category = $db ->getCategory($detail['item_category_id']);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細削除</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細削除</h1>
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
    <p>以下の商品を削除します。</p>
        <form action="process.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php print $detail['item_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                    <?php print $detail['item_model_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>商品カテゴリ</th>
                    <td class="align-left">
                    <?php print $category['item_category_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php print $detail['item_description'];?>
                    </td>
                </tr>

                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                    <?php print $detail['item_detail'];?>
                    </td>
                </tr>

                <tr>
                    <th>アレルギー品目</th>
                    <td class="align-left">
                        <?php 
                        foreach($detail_allergies as $detail_allergy)
                        {
                            print $detail_allergy['allergy_item'].' ';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>単価</th>
                    <td class="align-left">
                        <?php print $detail['unit_price'];?>
                    </td>
                </tr>

                <tr>
                    <th>商品画像</th>
                    <td class="align-left">
                    <img src="../img/<?php print $detail['item_image'];?>">
                    </td>
                </tr>

                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                    <?php if($detail['is_recommend'] === "1"):?>
                    〇
                    <?php else:?>
                    ×
                    <?php endif;?>
                    </td>
                </tr>

            </table>
            <br>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken();?>">

            <input type="hidden" name="item_image" value="<?php print $detail['item_image'];?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>