<?php 
//設定ファイルの読み込み
require_once('../../../../../Config.php');
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
// var_dump($_SESSION);

//エラーメッセージの初期化
$_SESSION['error']['edit_category'] = '';

//商品カテゴリ名が入力されていなかったら
if(empty($post['edit_category_name']))
{
    $_SESSION['error']['edit_category'] = '商品カテゴリ名を入力してください。';
    header('Location:./index.php');
    exit;
}


//商品カテゴリ画像が選択されていなくて、セッションにも画像がなければ
if(empty($_FILES['edit_category_img']) && empty($_SESSION['before']['edit_category']['item_category_image']))
{
    $_SESSION['error']['edit_category'] = '商品カテゴリ画像を選択してください。';
    header('Location:./index.php');
    exit;
}

//画像が選択されていればサイズをチェック
if(isset($_FILES['edit_category_img']))
    {
    if($_FILES['edit_category_img']['size']>1000000)
    {
        $_SESSION['error']['edit_category'] = '商品カテゴリ画像のサイズが大きすぎます。';
            header('Location:./index.php');
            exit;
    }
    else
    {
        //ファイルサイズがOKなら、画像ファイルを移動させる
        move_uploaded_file($_FILES['edit_category_img']['tmp_name'], '../img/'.$_FILES['edit_category_img']['name']);
    }
}

// var_dump($_SESSION['edit_category_before']['item_category_image']);
// exit;


?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>商品カテゴリ修正確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>商品カテゴリ修正確認</h1>
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
                    <th>商品カテゴリ名</th>
                    <td class="align-left">
                        <?php print $post['edit_category_name'];?>
                        <?php $_SESSION['post']['edit_category']['item_category_name'] = $post['edit_category_name'];?>
                        <input type="hidden" value="<?php print $_SESSION['id']['edit_category'];?>">
                    </td>
                </tr>

                <tr>
                    <th>商品カテゴリ画像</th>
                    <td class="align-left">
                    <!--新しい画像が選択されていれば-->
                    <?php if($_FILES['edit_category_img']['name'] !=='')
                    {
                    print '<img src="../img/'.$_FILES['edit_category_img']['name'].'" width="25%" height="auto">';
                    $_SESSION['psot']['edit_category']['item_category_image'] = $_FILES['edit_category_img']['name'];
                    }
                    else
                    {
                    //新しい画像が選択されていなければ-->
                    print '<img src="../img/'.$_SESSION['before']['edit_category']['item_category_image'].'"width="25%" height="auto">';
                    $_SESSION['post']['edit_category']['item_category_image'] = '';
                    }
                    ?>
                    </td>
                </tr>

            </table>
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
            <input type="hidden" name="old_category_img_name" value="<?php print $_SESSION['before']['edit_category']['item_category_image'];?>">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>