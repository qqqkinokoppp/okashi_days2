<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッション開始
Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../../../login/login.php');
    exit;
}
else
{
    $user = $_SESSION['user'];
}


//登録内容表示、カテゴリ表示、アレルギー表示のためのDB接続
$db = new ItemManage();

$detail = $db ->getDetail($_SESSION['id']['edit_detail']);

//カテゴリ取得
$category = $db ->getCategory($detail['item_category_id']);

//アレルギー取得
$allergies = array();//foreachのための配列変数準備

// var_dump($detail);
// exit;

//アレルギー品目が新しく選択されていたら
if(isset($detail['allergy_item']))
{
    $detail['allergy_item'] = json_decode($detail['allergy_item'], true);
    foreach($detail['allergy_item'] as $value)
    {
        $allergies += array($value => $db ->getAllergy($value));
    }
}
else
{
    $_SESSION['post']['edit_detail']['allergy_item'] = json_encode($_SESSION['post']['edit_detail']['allergy_item']);
    foreach($_SESSION['post']['edit_detail']['allergy_item'] as $value)
    {
        $allergies += array($value => $db ->getAllergy($value));
    }
   
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細修正完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細修正完了</h1>
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
    <p>以下の内容で修正しました。</p>
            <table class="list" height="200">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php print $detail['item_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php print $category['item_category_name'];;?>
                    </td>
                </tr>
                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                        <?php print $detail['item_model_number'];?>
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
                        <?php print $detail['unit_price'];?>円
                    </td>
                </tr>
                <tr>
                    <th>商品画像画像</th><!--画像が選択されていれば新しい画像、されていなければDBに登録されている画像-->
                    <td class="align-left">
                        <img src="../img/<?= $detail['item_image'];?>" width="25%" height="auto">
                    </td>
                </tr>
                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                        <?php if($detail['is_recommend'] === "1")
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
            <input type="button" value="管理者トップページへ" onclick="location.href='../../../';">
    </main>

    <footer>

    </footer>
</div>
</body>
</html>