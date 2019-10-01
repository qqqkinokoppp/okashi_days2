<?php 
require_once('../../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Safety.php');
//セッション開始
Session::sessionStart();
$user = $_SESSION['user'];
// var_dump($_SESSION['edituser']['id']);
// exit;

// ワンタイムトークンの確認
if (!Safety::checkToken($_POST['token'])) 
{
    // ワンタイムトークンが一致しないときは、エラーページにリダイレクト
    header('Location: ../error/error.php');
    exit;
}

//サニタイズ
$post = Common::sanitize($_POST);

//セッションにフォームから送られてきたデータを格納
$_SESSION['post']['add_category'] = $post;

if(isset($_FILES['category_img']))
{
    $category_img = $_FILES['category_img'];
}

$_SESSION['error']['add_category'] = '';

// var_dump($post);
// exit();
// var_dump($post['user_name']);
// exit;

//カテゴリ名が入力されていなかったら
if(empty($post['category_name']))
{
    $_SESSION['error']['add_category'] = 'カテゴリ名を入力してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//カテゴリ画像が選択されていなかったら
if(empty($category_img))
{
    $_SESSION['error']['add_category'] = 'カテゴリ画像を選択してください。';
    // print '通った';
    // exit;
    header('Location:./index.php');
    exit;
}

//画像サイズが大きすぎたら
if($category_img['size']>0)
{
    if($category_img['size']>1000000)
    {
        $_SESSION['error']['add_category'] = 'カテゴリ画像が大きすぎます。';
        header('Location:./index.php');
        exit;
    }
    else
    {
        //ファイルサイズがOKなら、画像ファイルを移動させる
        move_uploaded_file($category_img['tmp_name'], '../img/'.$category_img['name']);
        //セッション配列に画像ファイル名を追加
        $_SESSION['post']['add_category']['category_img'] = $category_img['name'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>カテゴリ登録確認</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>カテゴリ登録確認</h1>
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
    <p>以下の内容で登録します。</p>
        <form action="./process.php" method="post">
            <table class="list" height="200">
                <tr>
                    <th>カテゴリ名</th>
                    <td class="align-left">
                        <?php print $post['category_name'];?>
                    </td>
                </tr>
                <tr>
                    <th>カテゴリ画像</th>
                    <td class="align-left">
                        <img src="../img/<?php print $category_img['name'];?>" width="25%" height="auto">
                    </td>
                </tr>

            </table>
            <input type="hidden" name="category_name" value="<?php print $post['category_name'];?>">
            <input type="hidden" name="category_img" value="<?php print $category_img['name'];?>">
            <input type="submit" value="登録">
            <input type="button" value="キャンセル" onclick="location.href='./';">
        </form>
    </main>

    <footer>

    </footer>
</div>
</body>
</html>