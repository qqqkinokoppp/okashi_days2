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

//サニタイズ
$post = Common::sanitize($_POST);
// var_dump($post);
// exit;

//修正したい商品のIDをセッションに保存
if(isset($post['item_detail_id']))
{
    $_SESSION['id']['edit_detail'] = $post['item_detail_id'];
}

//商品管理のインスタンス生成
$db = new ItemManage();

//商品IDに該当する情報をDBから取得
$detail = $db ->getDetail($_SESSION['id']['edit_detail']);

//DBに登録されているアレルギー品目のJSONファイルを配列に変換、登録されているアレルギー品目を取得する
$detail_allergies_id = json_decode($detail['allergy_item'], true);

$detail_allergies = array();//foreachのための配列変数準備
foreach($detail_allergies_id as $value)
{
    $detail_allergies += array($value => $db ->getAllergy($value));
}

//セッションにDB登録データを格納
$_SESSION['before']['edit_detail'] = $detail;
// var_dump($detail);
$_SESSION['before']['edit_detail']['allergy_item'] = $detail_allergies_id;

//フォーム初期化のための変数に値を格納
$edit_detail = $_SESSION['before']['edit_detail'];

//カテゴリ、アレルギー品目取得
$categories = $db ->getCategoryAll();
$allergies = $db ->getAllergyAll();

// var_dump($categories);
// DOCTYPEの前には空行入れない！
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細修正</h1>
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
    <?php if(!empty($_SESSION['error']['edit_detail'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_detail'];?>
        </p>
    <?php endif;?>


        <form action="confirm.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_detail']['item_name'])):?>
                        <input type="text" name="item_name" value="<?= $_SESSION['post']['edit_detail']['item_name']?>" >
                        <?php else:?><!--入力された値がなければDBに登録されている内容を入力$_SESSION['edit_detail_before']に保持-->
                        <input type="text" name="item_name" value="<?= $_SESSION['before']['edit_detail']['item_name'];?>">
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_detail']['item_model_number'])):?>
                        <input type="text" name="item_model_number" value="<?= $_SESSION['post']['edit_detail']['item_model_number'];?>">
                        <?php else:?>
                        <input type="text" name="item_model_number" value="<?= $_SESSION['before']['edit_detail']['item_model_number'];?>">
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品カテゴリ</th>
                    <td class="align-left">
                    <select name="item_category_id">
                        <!--DBに登録済みのカテゴリを選択状態にしておく-->
                        <?php foreach($categories as $category):?>
                        <?php if($detail['item_category_id'] === $category['id']):?>
                        <option value="<?= $category['id'];?>" selected><?= $category['item_category_name'];?></option>
                        <?php else:?>
                        <option value="<?=  $category['id'];?>"><?= $category['item_category_name'];?></option>
                        <?php endif;?>
                        <?php endforeach;?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_detail']['item_description'])):?>
                        <textarea name="item_description"><?= $_SESSION['post']['edit_detail']['item_description'];?></textarea>
                        <?php else:?>
                        <textarea name="item_description"><?= $_SESSION['before']['edit_detail']['item_description'];?></textarea>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['edit_detail_after']['item_detail'])):?>
                        <textarea name="item_detail"><?= $_SESSION['post']['edit_detail']['item_detail'];?></textarea>
                        <?php else:?>
                        <textarea name="item_detail"><?= $_SESSION['before']['edit_detail']['item_detail'];?> </textarea>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>アレルギー品目</th>
                    <td class="align-left">
                        <?php 
                        print '<b>現在登録されているアレルギー品目：';
                        foreach($detail_allergies as $detail_allergy)
                        {
                            print $detail_allergy['allergy_item'].' ';
                        }
                        print '</b></br>';
                        print '＊変更しない場合は「変更しない」にチェックを入れてください。';
                        print '</br>';
                        ?>
                        <input type="checkbox" name="not_verify" value="1">変更しない<br>
                        <?php foreach($allergies as $allergy):?>
                        <input type="checkbox" name="allergy_item[]" value="<?= $allergy['id'];?>"><?= $allergy['allergy_item'];?><br>
                        <?php endforeach;?>
                    </td>
                </tr>

                <tr>
                    <th>単価</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_detail']['unit_price'])):?>
                        <input type="text" name="unit_price" value="<?= $_SESSION['post']['edit_detail']['unit_price']?>">円
                        <?php else:?>
                        <input type="text" name="unit_price" value="<?= $_SESSION['before']['edit_detail']['unit_price'];?>">円
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品画像</th>
                    <td class="align-left">
                    <img src="../img/<?= $detail['item_image'];?>" width="25%" height="auto">
                    <input type="file" name="item_image" id="item_image" class="item_image" value="">
                    </td>
                </tr>

                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                    <?php if($detail['is_recommend'] === "1"):?>
                    <input type="radio" name="is_recommend" value="1" checked>おすすめ
                    <?php else:?>
                    <input type="radio" name="is_recommend" value="1">おすすめ
                    <?php endif;?>

                    <?php if($detail['is_recommend'] === "0"):?>
                    <input type="radio" name="is_recommend" value="0" checked>非おすすめ
                    <?php else:?>
                    <input type="radio" name="is_recommend" value="0">非おすすめ
                    <?php endif;?>
                    </td>
                </tr>

            </table>
            <br>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken();?>">

            <input type="hidden" name="old_category_img_name" value="<?= $_SESSION['before']['edit_detail']['item_image'];?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
            <input type="button" value="管理者トップページへ" onclick="location.href='../../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>