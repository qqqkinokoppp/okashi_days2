<?php
// 設定クラスの読み込み
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
Session::sessionStart();
// $deleteuser = $_SESSION['id']['deactive_member'];

//修正するユーザーのIDを変数に格納
$id = $_SESSION['id']['deactive_member'];

$db = new Member();
try
{
    $member = $db ->deleteMember($id);
    header('Location:./complete.php');
}
catch(Exception $e)
{
    print '<pre>';
    var_dump($e);
    print '</pre>';
    //header('Location:../../error/');
}

?>