<?php
// 設定クラスの読み込み
require_once("../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
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

$adduser = $_SESSION['post']['add_admin'];
$adduser['password'] = password_hash($adduser['password'], PASSWORD_DEFAULT);

$db = new Admin();
try
{
    $admin = $db ->addAdmin($adduser);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    var_dump($e);
    //header('Location:../../error/');
}

?>