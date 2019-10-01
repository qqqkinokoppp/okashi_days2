<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/ItemManage.php');

//セッションの開始
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

//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_detail']))
{
    // print '通った';
    if(isset($_SESSION['post']['add_detail']['item_name']))//商品名
    {
        $item_name = $_SESSION['post']['add_detail']['item_name'];
        // print '通った1';
    }
    if(isset($_SESSION['post']['add_detail']['item_category_id']))//カテゴリID
    {
        $item_category_id = $_SESSION['post']['add_detail']['item_category_id'];
        // print '通った2';
    }
    if(isset($_SESSION['post']['add_detail']['item_model_number']))//商品型番
    {
        $item_model_number = $_SESSION['post']['add_detail']['item_model_number'];
        // print '通った3';
    }
    if(isset($_SESSION['post']['add_detail']['item_description']))//商品説明
    {
        $item_description = $_SESSION['post']['add_detail']['item_description'];
        // print '通った4';
    }
    // if(isset($_SESSION['post']['add_detail']['allergy_item']))//アレルギー品目、連想配列が入ってる
    // {
    //     $allergy = $_SESSION['post']['add_detail']['allergy_item'];
    //     print '通った5';
    // }
    if(isset($_SESSION['post']['add_detail']['item_detail']))//商品詳細
    {
        $item_detail = $_SESSION['post']['add_detail']['item_detail'];
        // print '通った6';
    }
    if(isset($_SESSION['post']['add_detail']['unit_price']))//単価
    {
        $unit_price = $_SESSION['post']['add_detail']['unit_price'];
        // print '通った7';
    }
    if(isset($_SESSION['post']['add_detail']['detail_img']['name']))//商品画像
    {
        $item_image = $_SESSION['post']['add_detail']['detail_img']['name'];
        // print '通った8';
    }
    if(isset($_SESSION['post']['add_detail']['is_recommend']))//おすすめフラグ
    {
        $is_recommend = $_SESSION['post']['add_detail']['is_recommend'];
        // print '通った9';
    }
}

//カテゴリ取得、アレルギー項目取得のためにDB接続
$db = new ItemManage();
$categories = $db ->getCategoryAll();
$allergies = $db ->getAllergyAll();

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細登録</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細登録</h1>
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
        <!--エラーメッセージ-->
        <?php if(!empty($_SESSION['error']['add_detail'])):?>
        <p class="error">
            <?php print $_SESSION['error']['add_detail'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post" enctype="multipart/form-data">
            <table class="list">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php if(isset($item_name)):?>
                        <input type="text" name="item_name" id="item_name" class="item_name" value="<?php print $item_name;?>">
                        <?php else:?>
                        <input type="text" name="item_name" id="item_name" class="item_name" value="">
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品型番</th>
                    <td class="align-left">
                        <?php if(isset($item_model_number)):?>
                        <input type="text" name="item_model_number" id="item_model_number" class="item_model_number" value="<?php print $item_model_number;?>">
                        <?php else:?>
                        <input type="text" name="item_model_number" id="item_model_number" class="item_model_number" value="">
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品カテゴリ</th>
                    <td class="align-left">
                    <select name="item_category_id">
                        <option value=""></option>
                        <?php foreach($categories as $category):?>
                        <option value="<?php print $category['id'];?>" 
                        <?php 
                        //リダイレクト時カテゴリ選択があれば、選択状態にする
                        if(isset($item_category_id))
                            {
                            if($category_id === $category['id'])
                                {
                            print 'selected';
                                }
                            }
                        ?>>
                        <?php print $category['item_category_name'];?></option>
                        <?php endforeach;?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php if(isset($item_description)):?>
                        <textarea name="item_description" id="item_description" class="item_description"><?php print $item_description;?></textarea>
                        <?php else:?>
                        <textarea name="item_description" id="item_description" class="item_description" value=""></textarea>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                        <?php if(isset($item_detail)):?>
                        <textarea name="item_detail" id="item_detail" class="item_detail"><?php print $item_detail;?></textarea>
                        <?php else:?>
                        <textarea name="item_detail" id="item_detail" class="item_detail" value=""></textarea>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>アレルギー品目</th>
                    <td class="align-left">
                        <?php foreach($allergies as $allergy):?>
                        <input type="checkbox" name="allergy_item[]" value="<?php print $allergy['id'];?>"><?php print $allergy['allergy_item'];?><br>
                        <?php endforeach;?>
                    </td>
                </tr>

                <tr>
                    <th>単価</th>
                    <td class="align-left">
                        <?php if(isset($item_description)):?>
                        <input type="text" name="unit_price" id="unit_price" class="unit_price" value="<?php print $unit_price;?>">
                        <?php else:?>
                        <input type="text" name="unit_price" id="unit_price" class="unit_price" value="">
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>商品画像</th>
                    <td class="align-left">
                    <input type="file" name="item_image" id="item_image" class="item_image" value="">
                    </td>
                </tr>

                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                    <input type="radio" name="is_recommend" value="1">おすすめ
                    <input type="radio" name="is_recommend" value="0" checked>非おすすめ
                    </td>
                </tr>

            </table>
            <br>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../../'">
        </form>
        <br>
        <br>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>