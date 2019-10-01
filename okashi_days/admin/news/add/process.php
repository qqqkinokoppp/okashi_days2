<?php
// 設定クラスの読み込み
require_once("../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/NewsManage.php');
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

$add_news = $_SESSION['post']['add_news'];

//DB接続

$db = new NewsManage();
try
{
    $news = $db ->addNews($add_news);
    header('Location:./complete.php');
    exit;
}
catch(Exception $e)
{
    var_dump($e);
    //header('Location:../../error/');
}

?>