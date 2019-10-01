<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッション開始
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


// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) {
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);
$_SESSION['post']['edit_news'] = $post;

$_SESSION['error']['edit_news'] = '';

//お知らせ見出しが入力されていなかったら
if(empty($post['news_index']))
{
    $_SESSION['error']['edit_news'] = 'お知らせ見出しを入力してください。';
    header('Location:./index.php');
    exit;
}

//お知らせ見出しが100文字超えていれば
if(strlen($post['news_index'])>500)
{
    $_SESSION['error']['edit_news'] = 'お知らせ見出しは100文字以内です。。';
    header('Location:./index.php');
    exit;   
}

//お知らせ内容が入力されていなかったら
if(empty($post['news_content']))
{
    $_SESSION['error']['edit_news'] = 'お知らせ内容を入力してください。';
    header('Location:./index.php');
    exit;
}

//お知らせ内容が250文字超えていれば
if(strlen($post['news_index'])>250)
{
    $_SESSION['error']['edit_news'] = 'お知らせ内容は250文字以内です。。';
    header('Location:./index.php');
    exit;   
}


if($post['expiration_date'] !== '')
{
    if(strtotime($post['expiration_date']) === false)//掲載期限日が正しい日付じゃなかったら
    {
        $_SESSION['error']['edit_news'] = '掲載期限日を正しく入力してください。';
        header('Location:./index.php');
        exit;
    }
    if($post['expiration_date'] < date('Y-m-d'))//掲載期限日が今日より前に設定されていたら
    {
        $_SESSION['error']['edit_news'] = '掲載期限日は今日以降の日付にしてください。';
        header('Location:./index.php');
        exit;
    }
    $_SESSION['post']['edit_news']['expiration_date'] = $post['expiration_date'];

}
else
//掲載期限の選択がない場合は自動的に今日から一か月後に設定する
{
    $_SESSION['post']['edit_news']['expiration_date'] = date('Y-m-d', strtotime('+1 month'));
}



?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ修正確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせ修正確認</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?php print $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
    <p>以下の内容で修正します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>お知らせ見出し</th>
                    <td class="align-left">
                        <?php print $post['news_index'];?>
                    </td>
                </tr>

                <tr>
                    <th>お知らせ内容</th>
                    <td class="align-left">
                        <?php print $post['news_content'];?>
                    </td>
                </tr>

                <tr>
                    <th>掲載期限日</th>
                    <td class="align-left">
                    <?php print $post['expiration_date'];?>
                    </td>
                </tr>

            </table>
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>