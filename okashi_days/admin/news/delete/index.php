<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/NewsManage.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

Session::sessionStart();
if(!isset($_SESSION['user']))
{
    header('Location: ../login/');
    exit;
}
else
{
    $user = $_SESSION['user'];
}

//サニタイズ
$post = Common::sanitize($_POST);

//修正したいお知らせのIDをセッションに保存
if(isset($post['news_id']))
{
    $_SESSION['id']['delete_news'] = $post['news_id'];
}

$db = new NewsManage();

//ワンタイムトークンの取得
$token = Safety::getToken();

//POSTされてきたユーザーIDに該当するお知らせ情報を取得してくる
$delete_news = $db ->getNews($_SESSION['id']['delete_news']);

$news_index = $delete_news['news_index'];
$news_content = $delete_news['news_content'];
$expiration_date = $delete_news['expiration_date'];

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ削除</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせ削除</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['delete_news'])):?>
        <p class="error">
            <?= $_SESSION['error']['delete_news'];?>
        </p>
        <?php endif;?>

        <form action="process.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?= $token;?>">
            <table class="list">
                <tr>
                    <th>お知らせ見出し</th>
                    <td class="align-left">
                        <?= $news_index?>
                    </td>
                </tr>
                <tr>
                    <th>お知らせ内容</th>
                    <td class="align-left">
                    <?= $news_content?>
                    </td>
                </tr>
                <tr>
                    <th>掲載期限日</th>
                    <td class="align-left">
                    <?= $expiration_date?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="削除">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>