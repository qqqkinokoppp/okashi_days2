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

//アレルギー品目をJSON形式に変換し、セッションのアレルギー項目へ上書き
$allergy = json_encode($_SESSION['post']['add_detail']['allergy_item']);
$_SESSION['post']['add_detail']['allergy_item'] = $allergy;

//DB登録用の変数に保存
$detail = $_SESSION['post']['add_detail'];

// print '<pre>';
// var_dump($_SESSION['add_detail']);
// print '</pre>';
// exit;

//DB接続、詳細登録
$db = new ItemManage();
try
{
    $category = $db ->addItemDetail($detail);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    //header('Location:../../error/');
}

?>