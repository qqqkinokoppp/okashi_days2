<?php
// 設定クラスの読み込み
require_once("../../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');

// セッションスタート
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

// var_dump($_SESSION['post']);
// exit;

// $edit_category = $_SESSION['edit_category_after'];

// var_dump($_SESSION['edit_category_after']);
// exit;

//サニタイズ
$post = Common::sanitize($_POST);


//修正するカテゴリのIDを変数に格納
$id = $_SESSION['id']['edit_category'];

//商品管理インスタンス生成、カテゴリ修正メソッドの呼び出し
$db = new ItemManage();
try
{
    // 新しい画像が選択されていなかったら、カテゴリ名だけ更新
    if($_SESSION['post']['edit_category']['item_category_image'] === '')
    {
        $category = $db ->editCategoryNoImage($edit_category, $id);
    }
    // 新しい画像が選択されていれば、カテゴリ名とカテゴリ画像を更新
    else
    {
        $category = $db ->editCategory($edit_category, $id);
        //DBに前の画像が登録されていればそれを削除
        if(isset($post['old_category_img_name']))
        {
        unlink('../img/'.$post['old_category_img_name']);
        }
    }
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    header('Location:../../error/');
    exit;
}

?>