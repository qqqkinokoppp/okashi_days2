<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

//セッションの開始
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

//前回入力データがあればフォーム初期値用の変数に格納
if(isset($_SESSION['post']['add_news']))
{
    if(isset($_SESSION['post']['add_news']['news_index']))
    {
        $news_index = $_SESSION['post']['add_news']['news_index'];
    }
    if(isset($_SESSION['post']['add_news']['news_content']))
    {
        $news_content = $_SESSION['post']['add_news']['news_content'];
    }
    if(isset($_SESSION['post']['add_news']['expiration_date']))
    {
        $expiration_date = $_SESSION['post']['add_news']['expiration_date'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>お知らせ登録</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>お知らせ登録</h1>
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
        <?php if(!empty($_SESSION['error']['add_news'])):?>
        <p class="error">
            <?= $_SESSION['error']['add_news'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
            <table class="list">
                <tr>
                    <th>お知らせ見出し</th>
                    <td class="align-left">
                        <?php if(isset($news_index)):?>
                        <textarea name="news_index" id="news_index" class="news_index" ><?= $news_index?></textarea>
                        <?php else:?>
                        <textarea name="news_index" id="news_index" class="news_index"></textarea>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>お知らせ内容</th>
                    <td class="align-left">
                    <?php if(isset($news_index)):?>
                        <textarea name="news_content" id="news_content" class="news_content" ><?= $news_content?></textarea>
                        <?php else:?>
                        <textarea name="news_content" id="news_content" class="news_content"></textarea>
                        <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>掲載期限日</th>
                    <td class="align-left">
                    *掲載日を選択しない場合は自動的に一か月後の設定になります。
                    <?php if(isset($expiration_date)):?>
                    <input type="date" name="expiration_date" id="expiration_date" class="expiration_date" value="<?= $expiration_date?>">
                    <?php else:?>
                    <input type="date" name="expiration_date" id="expiration_date" class="expiration_date" value="">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?=Safety::getToken()?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>