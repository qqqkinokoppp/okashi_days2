<?php 
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Member.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Address.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');

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

//修正したいユーザーのIDをセッションに保存
if(isset($post['user_id']))
{
    $_SESSION['id']['deactive_member'] = $post['user_id'];
}

//ワンタイムトークンの取得
$token = Safety::getToken();

//POSTされてきたユーザーIDに該当するユーザー情報を取得してくる
$db = new Member();
$deactive_member = $db ->getMember($_SESSION['id']['deactive_member']);
$user_name = $deactive_member['user_name'];
$last_name = $deactive_member['last_name'];
$first_name = $deactive_member['first_name'];
$last_name_kana = $deactive_member['last_name_kana'];
$first_name_kana = $deactive_member['first_name_kana'];
$birthday = $deactive_member['birthday'];
$gender = $deactive_member['gender'];

//DBから取得した郵便番号を上3桁、下4桁に分割、戻り値はarray
$postal_code1 = substr($deactive_member['postal_code'], 0, 3);
$postal_code2 = substr($deactive_member['postal_code'], 3, 4);

$prefecture = $deactive_member['prefecture'];
$prefecture_id = $deactive_member['prefecture_id'];
$address1 = $deactive_member['address1'];
$address2 = $deactive_member['address2'];
$phone_number = $deactive_member['phone_number'];
$email = $deactive_member['email'];

// <!-- 都道府県取得のためのDB接続 -->
$db = new Address();
$prefectures = $db ->getPrefAll();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員退会</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員退会</h1>
        </div>
        <div class="login_info">
            <ul>
                <li>ようこそ<?= $user['user_name'];?>さん</li>
                <li>
                    <form>
                        <input type="button" value="ログアウト" onclick="location.href='../../login/logout.php';">
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <main>
        <?php if(!empty($_SESSION['error']['deactive_member'])):?>
        <p class="error">
            <?= $_SESSION['error']['deactive_member'];?>
        </p>
        <?php endif;?>

        <form action="process.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?= $token;?>">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $user_name?>
                    </td>
                </tr>
                
                <tr>
                    <th>会員姓</th>
                    <td class="align-left">
                    <?= $last_name?>
                    </td>
                </tr>

                <tr>
                    <th>会員名</th>
                    <td class="align-left">
                    <?= $first_name?>
                    </td>
                </tr>

                <tr>
                    <th>会員姓（カナ）</th>
                    <td class="align-left">
                    <?= $last_name_kana?>
                    </td>
                </tr>

                <tr>
                    <th>会員名（カナ）</th>
                    <td class="align-left">
                    <?= $first_name_kana?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $postal_code1?>-<?= $postal_code2?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $prefecture ?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $address1?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $address2?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $phone_number?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $email?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="退会">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
            <input type="button" value="トップページへ" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>