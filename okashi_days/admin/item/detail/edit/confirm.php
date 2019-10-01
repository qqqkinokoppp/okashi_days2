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
    header('Location: ../../../login/');
}
else
{
    $user = $_SESSION['user'];
}


// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

$post = Common::MySanitize($_POST);

//セッションにフォームから送られてきたデータを格納
$_SESSION['post']['edit_detail'] = $post;


//画像が選択されていれば、セッションと変数に保存、選択されていなければ、DB登録されている画像を表示
if(isset($_FILES['item_image']))
{
    $item_image = $_FILES['item_image'];
    $_SESSION['post']['edit_detail']['item_image'] = $_FILES['item_image'];
}

//アレルギー品目が選択されていれば、$_SESSION['post']['edit_detail']に格納、「変更しない」場合は$_SESSION['before']['edit_detail']['allergy_item']を格納
if(isset($post['allergy_item']))
{
    $_SESSION['post']['edit_detail']['allergy_item'] = $post['allergy_item'];
}
else
{
    $_SESSION['post']['edit_detail']['allergy_item'] =  $_SESSION['before']['edit_detail']['allergy_item'];
}

// var_dump($_SESSION['edit_detail_after']);
// exit;

$_SESSION['error']['edit_detail'] = '';

//以下、バリデーション
//商品名が入力されていなかったら
if(empty($post['item_name']))
{
    $_SESSION['error']['edit_detail'] = '商品名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品名が100文字超えていれば
if(strlen($post['item_name'])>100)
{
    $_SESSION['error']['edit_detail'] = '商品名は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品型番が入力されていなかったら
if(empty($post['item_model_number']))
{
    $_SESSION['error']['edit_detail'] = '商品型番を選択してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品型番が20桁超えていれば
if(strlen($post['item_model_number'])>20)
{
    $_SESSION['error']['edit_detail'] = '商品型番は20桁以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品型番が半角英数でなければ
if(preg_match("/^[a-zA-Z0-9]+$/", $post['item_model_number']) === 0)
{
    $_SESSION['error']['edit_detail'] = '商品型番は半角英数で入力してください';
    header('Location:./index.php');
    exit;  
}

//商品カテゴリが選択されていなかったら
if(empty($post['item_category_id']))
{
    $_SESSION['error']['edit_detail'] = '商品カテゴリを選択してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品説明が入力されていなかったら
if(empty($post['item_description']))
{
    $_SESSION['error']['edit_detail'] = '商品説明を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品説明が100文字超えていれば
if(strlen($post['item_description'])>100)
{
    $_SESSION['error']['edit_detail'] = '商品説明は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//商品詳細が入力されていなかったら
if(empty($post['item_detail']))
{
    $_SESSION['error']['edit_detail'] = '商品詳細を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//商品詳細が500文字超えていれば
if(strlen($post['item_detail'])>500)
{
    $_SESSION['error']['edit_detail'] = '商品説明は100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//アレルギー品目が選択されていなかったら
if(empty($post['allergy_item']) && empty($post['not_verify']))
{
    $_SESSION['error']['edit_detail'] = 'アレルギーを入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//単価が入力されていなかったら
if(empty($post['unit_price']))
{
    $_SESSION['error']['edit_detail'] = '商品単価を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//単価が数字でなければ
if(preg_match("/[0-9]+$/", $post['unit_price']) === 0)
{
    $_SESSION['error']['edit_detail'] = '単価は数字で入力してください';
    header('Location:./index.php');
    exit;
}

//画像サイズが大きすぎたら
if($_SESSION['post']['edit_detail']['item_image']['size']>0)
{
    if($_SESSION['post']['edit_detail']['item_image']['size']>1000000)
    {
        $_SESSION['error']['edit_detail'] = '画像サイズが大きすぎます。';
        header('Location:./index.php');
        exit;
    }
    else
    {
        //ファイルサイズがOKなら、画像ファイルを移動させる
        move_uploaded_file($_SESSION['post']['edit_detail']['item_image']['tmp_name'], '../img/'.$_SESSION['post']['edit_detail']['item_image']['name']);
    }
}

//カテゴリ、アレルギー表示のためのDB接続
$db = new ItemManage();

//カテゴリ取得
$category = $db ->getCategory($post['item_category_id']);

//アレルギー取得
// var_dump($post['allergy']);
// exit;
$allergies = array();//foreachのための配列変数準備

//アレルギー品目が新しく選択されていたら
if(isset($post['allergy_item']))
{
    $_SESSION['post']['edit_detail']['allergy_item'] = json_encode($post['allergy_item']);
    foreach($post['allergy_item'] as $value)
    {
    $allergies += array($value => $db ->getAllergy($value));
    }
}
else
{
    $_SESSION['post']['edit_detail']['allergy_item'] = json_encode($_SESSION['before']['edit_detail']['allergy_item']);
    foreach($_SESSION['before']['edit_detail']['allergy_item'] as $value)
    {
    $allergies += array($value => $db ->getAllergy($value));
    }
   
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品詳細修正確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品詳細修正確認</h1>
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
    <p>以下の内容で修正します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>商品名</th>
                    <td class="align-left">
                        <?php print $post['item_name'];?>
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
                        <?php print $post['item_model_number'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品説明</th>
                    <td class="align-left">
                        <?php print $post['item_description'];?>
                    </td>
                </tr>
                <tr>
                    <th>商品詳細</th>
                    <td class="align-left">
                        <?php print $post['item_detail'];?>
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
                        <?php print $post['unit_price'];?>円
                    </td>
                </tr>
                <tr>
                    <th>商品画像画像</th><!--画像が選択されていれば新しい画像、されていなければDBに登録されている画像-->
                    <td class="align-left">
                        <?php if($_SESSION['post']['edit_detail']['item_image']['name'] !== ''):?>
                        <img src="../img/<?= $_SESSION['post']['edit_detail']['item_image']['name'];?>" width="25%" height="25%">
                        <?php else:?>
                        <img src="../img/<?= $_SESSION['before']['edit_detail']['item_image'];?>" width="400" height="260">
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>おすすめ</th>
                    <td class="align-left">
                        <?php if($post['is_recommend'] === "1")
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
            <?php 
            // var_dump($_SESSION['edit_detail_after']);
            // exit;
            ?>
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
            <input type="button" value="管理者トップページへ" onclick="location.href='../../../';">
        </form>
        <?php
        // var_dump($_SESSION['edit_detail_after']);
        // exit;
        ?>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>