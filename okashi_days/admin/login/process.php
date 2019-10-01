<?php
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) {
// ワンタイムトークンが一致しないときは、エラーページにリダイレクト
header('Location: ../error/');
exit;
}

//サニタイズ
$post = Common::sanitize($_POST);
$user_name = $post['user_name'];
$password = $post['password'];

try
{
    $db = new Admin();
    $user = $db ->loginAdmin($user_name, $password);
    if(empty($user))
    {
        $_SESSION['error']['adminlogin'] = "ユーザー名またはパスワードが違います。";
        header('Location: ./');
    }
    else
    {
        // ユーザーの情報が取得できたとき
        // ユーザーの情報をセッション変数に保存
        $_SESSION['user'] = $user;
        // セッション変数に保存されているエラーメッセージをクリア
        $_SESSION['error']['adminlogin'] = "";
        unset($_SESSION['error']['adminlogin']);
        header('Location: ../');
    }
}   
catch(Exception $e)
{
    //header('Location: ../error/');
    print '<pre>';
    var_dump($e);
    print '</pre>';
}

?>