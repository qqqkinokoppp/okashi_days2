<?php
// 設定クラスの読み込み
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
Session::sessionStart();

$add_member = $_SESSION['post']['add_member'];
$add_member['password'] = password_hash($add_member['password'], PASSWORD_DEFAULT);

$db = new Member();
try
{
    $admin = $db ->addMember($add_member);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    var_dump($e);
    //header('Location:../../error/');
}

?>