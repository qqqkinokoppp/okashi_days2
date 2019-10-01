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
    $_SESSION['id']['edit_news'] = $post['news_id'];
}

//リダイレクト時入力されたデータがあれば反映するため
if(isset($_SESSION['post']['edit_news']))
{
    if(isset($_SESSION['post']['edit_news']['news_index']))
    {
        $news_index = $_SESSION['post']['edit_news']['news_index'];
    }
    if(isset($_SESSION['post']['edit_news']['news_content']))
    {
        $news_content = $_SESSION['post']['edit_news']['news_content'];
    }
    if(isset($_SESSION['post']['edit_news']['expiration_date'])
    {
        $expiration_date = $_SESSION['post']['edit_news']['expiration_date'];
    }
}

$db = new NewsManage();

//ワンタイムトークンの取得
$token = Safety::getToken();

//POSTされてきたユーザーIDに該当するお知らせ情報を取得してくる
$edit_news = $db ->getNews($_SESSION['id']['edit_news']);

//セッション初期化のためセッションにDBからの情報を格納
$_SESSION['before']['edit_news'] = $edit_news;


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせ修正</h1>
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
        <?php if(!empty($_SESSION['error']['edit_news'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_news'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?= $token;?>">
            <table class="list">
                <tr>
                    <th>お知らせ見出し</th>
                    <td class="align-left">
                        <?php if(isset($news_index)):?>
                        <textarea name="news_index" id="news_index" class="news_index"><?= $news_index?></textarea>
                        <?php else:?>
                        <textarea name="news_index" id="news_index" class="news_index"><?= $_SESSION['before']['edit_news']['news_index']?></textarea>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>お知らせ内容</th>
                    <td class="align-left">
                    <?php if(isset($news_content)):?>
                        <textarea name="news_content" id="news_content" class="news_content"><?= $news_content?></textarea>
                        <?php else:?>
                        <textarea name="news_content" id="news_content" class="news_content"><?= $_SESSION['before']['edit_news']['news_content']?></textarea>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>掲載期限日</th>
                    <td class="align-left">
                    <?php if(isset($expiration_date)):?>
                    <input type="text" name="expiration_date" id="expiration_date" class="expiration_date" value="<?= $expiration_date?>">
                    <?php else:?>
                    <input type="text" name="expiration_date" id="expiration_date" class="expiration_date" value="<?= $_SESSION['before']['edit_news']['expiration_date']?>">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>