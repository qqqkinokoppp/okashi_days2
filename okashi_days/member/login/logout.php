<?php
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

Session::sessionDestroy();
if(isset($_SESSION['url']))
{
    header("Location:".$_SESSION['url']);
    exit;
}
else
{
    header("Location: ../../");
    exit;
}
?>