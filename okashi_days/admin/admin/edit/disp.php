<?php
require_once("../../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Admin.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
// セッションスタート
Session::sessionStart();
$user = $_SESSION['user'];

$db = new Admin();
//管理者データの取得
$edit_users = $db ->getAdminAll();
//foreach用カウンターの初期化
$i = 0;

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>管理者情報修正</title>
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/main.css">
</head>
<body>
<div class="container">
    <header>
        <div class="title">
            <h1>管理者情報修正</h1>
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
                <th colspan="2">管理者名</th>
            </tr>
            <?php foreach($edit_users as $edit_user):?>
            <?php if($i%2 === 0):?>
            <tr class="even">
            <?php else:?>
            <tr class="odd">
            <?php endif;?>

                <td class="align-left">
                    <?php
                    print $edit_user['name'];
                    ?>
                </td>
                <td>
                    <form action="index.php" method="post">
                    <!--選択したユーザーのIDを渡す-->
                        <input type="hidden" name="user_id" value="<?php print $edit_user['id'];?>">
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