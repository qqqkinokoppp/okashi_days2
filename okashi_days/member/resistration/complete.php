<?php 
require_once('../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');

// セッションの開始
Session::sessionStart();

$add_member = $_SESSION['post']['add_member'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員登録完了</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員登録完了</h1>
        </div>
    </header>

    <main>
    <p>以下の内容で登録しました。</p>
    <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?= $add_member['user_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名(フリガナ)</th>
                    <td class="align-left">
                        <?= $add_member['last_name_kana'].' '.$add_member['first_name_kana'];?>
                    </td>
                </tr>

                <tr>
                    <th>氏名</th>
                    <td class="align-left">
                        <?= $add_member['last_name'].' '.$add_member['first_name'];?>
                    </td>
                </tr>

                <tr>
                    <th>生年月日</th>
                    <td class="align-left">
                        <?= $add_member['birthday'];?>
                    </td>
                </tr>

                <tr>
                    <th>性別</th>
                    <td class="align-left">
                        <?php 
                        if($add_member['gender'] === '0')
                        {
                            print '男';
                        }
                        if($add_member['gender'] === '1')
                        {
                            print '女';
                        }
                        if($add_member['gender'] === '2')
                        {
                            print '回答しない';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?= $add_member['postal_code1'].'-'.$add_member['postal_code2'];?>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <?= $add_member['prefecture'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?= $add_member['address1'];?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?= $add_member['address2'];?>
                    </td>
                </tr>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?= $add_member['phone_number'];?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?= $add_member['email'];?>
                    </td>
                </tr>
            <input type="button" value="ログイン画面へ" onclick="location.href='../login/'">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>