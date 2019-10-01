<?php
// 設定クラスの読み込み
require_once("../../../../Config.php");

// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/NewsManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');

// セッションスタート
Session::sessionStart();
$edit_news = $_SESSION['post']['edit_news'];

//修正するお知らせのIDを変数に格納
$id = $_SESSION['id']['edit_news'];

$db = new NewsManage();
try
{
    $news = $db ->editNews($edit_news, $id);
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