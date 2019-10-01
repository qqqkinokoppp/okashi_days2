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
    header('Location: ../../../login/');
}
else
{
    $user = $_SESSION['user'];
}
$edit_category = $_SESSION['edit_detail_after'];
// var_dump($_SESSION['edit_detail_after']);
// exit;

//サニタイズ
$post = Common::sanitize($_POST);

//修正するカテゴリのIDを変数に格納
$id = $_SESSION['id']['edit_detail'];

$data = $_SESSION['post']['edit_detail'];

// var_dump($_SESSION['edit_detail_after']);
// exit;

//商品管理インスタンス生成、カテゴリ修正メソッドの呼び出し
$db = new ItemManage();
try
{
    if($_SESSION['post']['edit_detail']['item_image']['name'] === '')
    {
        $detail = $db ->editItemDetail($data, $id);
        //print '通った1';
    }
    else
    {
        $detail = $db ->editItemDetail($data, $id, $data['item_image']['name']);
        //print '通った2';
    }
    header('Location: complete.php');
    exit;
}
catch(Exception $e)
{
    var_dump($e);
    exit;
}
?>