<?php
require_once("../../Config.php");
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
// if(!isset($_SESSION['user']))
// {
//     header('Location: ../../../login/');
// }
// else
// {
//     $user = $_SESSION['user'];
// }
$get = Common::sanitize($_GET);
$item_id = $get['id'];

// サニタイズ
$post = Common::sanitize($_POST);
// var_dump($_POST);
// var_dump($post);

// カートへの追加
// if(empty($_SESSION['cart']) === false)
// {
//     $cart['cart'] = $_SESSION['cart'];
// }
// else
// {
//     $cart['cart'] = array();
// }

if(empty($_SESSION['cart']) === true)
{
    $_SESSION['cart'] = array();
}

Cart::addCart($item_id, $post['quantity']);
var_dump($_SESSION['cart']);
$_SESSION['quantity']['cartin'] = $post['quantity'];

header("Location: cartin.php?id=$item_id");
exit;

?>