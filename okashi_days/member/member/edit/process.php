<?php
// 設定クラスの読み込み
require_once("../../../../Config.php");

// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');

// セッションスタート
Session::sessionStart();
$edituser = $_SESSION['post']['edit_user'];

//修正するユーザーのIDを変数に格納
$id = $_SESSION['id']['edit_user'];

$edituser['password'] = password_hash($edituser['password'], PASSWORD_DEFAULT);

$db = new Admin();
try
{
    $admin = $db ->editAdmin($edituser, $id);
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