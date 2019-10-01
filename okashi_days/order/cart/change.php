<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Cart.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}

// サニタイズ
$item_id = $_GET['id'];
$post = Common::sanitize($_POST);

// var_dump($post['change']);

// var_dump($item_id);
// exit;
Cart::changeCart($item_id, $post['change']);
header('Location: ./');
exit;

?>