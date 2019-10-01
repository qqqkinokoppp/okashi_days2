<?php
// 設定クラスの読み込み
require_once("../../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
Session::sessionStart();
//サニタイズ
$post = Common::sanitize($_POST);
$_SESSION['category_name'] = $post['category_name'];
$_SESSION['category_img'] = $post['category_img'];

$db = new ItemManage();
try
{
    $category = $db ->addCategory($post);
    header('Location:./complete.php');
}
catch(Exception $e)
{
    var_dump($e);
    //header('Location:../../error/');
}

?>