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


//サニタイズ
$post = Common::sanitize($_POST);


//修正するカテゴリのIDを変数に格納
// $id = $_SESSION['delete_category']['id'];

//商品管理インスタンス生成、カテゴリ修正メソッドの呼び出し
$db = new ItemManage();
try
{
    $detail = $db ->deleteItemDetail($_SESSION['delete_detail_id']);
    if(isset($post['item_image']))
    {
        unlink('../img/'.$post['item_image']);
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