<?php
require_once("../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Cart.php');


// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}

$_SESSION['url'] = '';
// if(!isset($_SESSION['user']))
// {
//     header('Location: ../../../login/');
// }
// else
// {
//     $user = $_SESSION['user'];
// }

$item_id = $_GET['id'];

// サニタイズ
$post = Common::sanitize($_POST);
// var_dump($_POST);
// var_dump($post);

//商品詳細データの取得
$db = new ItemManage();
$detail = $db ->getDetail($item_id);

// カテゴリー取得
$category = $db ->getCategory($detail['item_category_id']);
// var_dump($category);

//DBに登録されているアレルギー品目のJSONファイルを配列に変換、登録されているアレルギー品目を取得する
$detail_allergies_id = json_decode($detail['allergy_item'], true);

$detail_allergies = array();//foreachのための配列変数準備
foreach($detail_allergies_id as $value)
{
    $detail_allergies += array($value => $db ->getAllergy($value));
}

//foreach用カウンターの初期化
$i = 0;

// var_dump($_SESSION['cart']);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $detail['item_name']; ?> | okashi days</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="index.html"><img src="../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['last_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="../order/cart/">カート</a></li>
				<!-- <li><a href="menu.html">商品カテゴリ一覧</a></li> -->
				<li><a href="../item/list.php">商品一覧</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="contact.html">新規会員登録</a></li>
				<li><a href="../member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="../member/">会員ページ</a></li>
				<li><a href="../member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<main>
		<h2>カートに追加しました</h2>
		<?= $detail['item_name']; ?>を<?=$_SESSION['quantity']['cartin']; ?>個カートに追加しました。
		<div class="menu-block">
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../admin/item/detail/img/<?= $detail['item_image'];?>" alt="" width="50%" height="auto">
				</div>
				<div class="menu-text">
                    <h3><?= $detail['item_name']; ?></h3>
                    <p>&yen;<?= $detail['unit_price']; ?></p>
                    <p>商品カテゴリ:<?= $category['item_category_name']; ?></p>
                    <p>商品型番:<?= $detail['item_model_number']; ?></p>
                    <p>商品の説明</p>
                    <p><?= $detail['item_description']; ?></p>
				</div>
			</div>
			
		</div>
	</main>
	<input type="button" value="戻る" onclick="history.back()">

	
	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
		<p>&copy;Copyright KUJIRA Cafe. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>