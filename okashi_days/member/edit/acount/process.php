<?php

// 設定クラスの読み込み
require_once("../../../../Config.php");

// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');

// セッションスタート
Session::sessionStart();
$edit_member = $_SESSION['post']['edit_member'];

//修正するユーザーのIDを変数に格納
$id = $_SESSION['id']['edit_member'];
var_dump($edit_member);
var_dump($id);
// exit;

$db = new Member();
try
{
    $member = $db ->editMember($edit_member, $id);
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