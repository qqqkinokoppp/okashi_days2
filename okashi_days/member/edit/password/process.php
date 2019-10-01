<?php
// 設定クラスの読み込み
require_once("../../../../Config.php");

// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');
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

//サニタイズ
$post = Common::sanitize($_POST);
$_SESSION['post']['edit_password'] = $post;
// var_dump($post);
// exit;

// var_dump($post['password_old']);
// var_dump(password_hash($post['password_old'], PASSWORD_DEFAULT));
// exit;

//修正するユーザーのIDを変数に格納
$id = $_SESSION['id']['edit_password'];

$_SESSION['error']['edit_password'] = '';

//現在のパスワードが入力されていなかったら
if($post['password_old'] === '')
{
    $_SESSION['error']['edit_password'] = '現在のパスワードを入力してください。';
    header('Location:./index.php');
    exit;
}

//新しいパスワードが入力されていなかったら
if(empty($post['password']))
{
    $_SESSION['error']['edit_password'] = '新しいパスワードを入力してください。';
    header('Location:./index.php');
    exit;
}

//確認用パスワードが入力されていなかったら
if(empty($post['password2']))
{
    $_SESSION['error']['edit_password'] = '確認用パスワードを入力してください。';
    header('Location:./index.php');
    exit;
}

// 現在登録されているパスワードと入力されたパスワードの照合
$db = new Member();
$password_db = $db ->getMember($id);

if(password_verify($post['password_old'], $password_db['password']) === false)
{
    $_SESSION['error']['edit_password'] = '現在のパスワードが一致しません。';
    header('Location:./index.php');
    exit;
}

// 新しいパスワードと確認用パスワードの照合
if($post['password'] !== $post['password2'])
{
    $_SESSION['error']['edit_password'] = '確認用パスワードが一致しません。';
    header('Location:./index.php');
    exit;
}

// バリデーションにすべて通ったら、新しいパスワードをハッシュ化
$post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);


// パスワード変更処理
try
{
    $member = $db ->editPassword($post, $id);
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