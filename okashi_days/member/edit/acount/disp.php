<?php
require_once("../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
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

$db = new Member();

//管理者データの取得
$edit_members = $db ->getMemberAll();
//foreach用カウンターの初期化
$i = 0;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員情報修正</title>
<link rel="stylesheet" href="../../../css/normalize.css">
<link rel="stylesheet" href="../../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>会員情報修正</h1>
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

        <table class="admin" width="300">
            <tr>
                <th colspan="6">会員一覧</th>
            </tr>
            <th>ユーザー名</th><th>会員氏名</th><th>会員氏名（カナ）</th><th>都道府県</th><th>電話番号</th><th>修正</th>
            <?php foreach($edit_members as $edit_member):?>
            <?php if($i%2 === 0):?>
            <tr class="even">
            <?php else:?>
            <tr class="odd">
            <?php endif;?>
                <td class="align-left">
                    <?php
                    print $edit_member['user_name'];
                    ?>
                </td>

                <td class="align-left">
                    <?php
                    print $edit_member['last_name'].' '.$edit_member['first_name'];
                    ?>
                </td>

                <td class="align-left">
                    <?php
                    print $edit_member['last_name_kana'].' '.$edit_member['first_name_kana'];
                    ?>
                </td>

                <td class="align-left">
                    <?php
                    print $edit_member['prefecture'];
                    ?>

                </td><td class="align-left">
                    <?php
                    print $edit_member['phone_number'];
                    ?>
                </td>

                <td>
                    <form action="index.php" method="post">
                    <!--選択したユーザーのIDを渡す-->
                        <input type="hidden" name="user_id" value="<?php print $edit_member['id'];?>">
                        <input type="submit" value="修正">
                    </form>
                </td>
                <?php ?>
            </tr>
            <?php $i++;?>
            <?php endforeach;?>
        </table>

    </main>

    <footer>

    </footer>
</div>
</body>
</html>