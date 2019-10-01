<?php
require_once("../../../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Member.php');


// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    // var_dump($user);
    // exit;
}
else
{
    header('Location: ../../member/login/');
    exit;
}

$_SESSION['url'] = '../../order/cart/';
// if(!isset($_SESSION['user']))
// {
//     header('Location: ../../../login/');
// }
// else
// {
//     $user = $_SESSION['user'];
// }

// if(isset($_SESSION['cart']))
// {
// 	$cart_items = $_SESSION['cart'];
// }
// var_dump($cart_items);

//会員データの取得
$db = new Member();
$member = $db ->getMember($user['id']);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>購入ページ1 | okashi days.</title>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="../../"><img src="../../images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['last_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="../../">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="./index.php">カート</a></li>
				<!-- <li><a href="access.html">アクセス</a></li> -->
				<li><a href="../../item/list.php">商品一覧</a></li>
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
        <h2>購入ステップ2　注文者・配送先確認</h2>
        
        <h3>注文者</h3>

<!-- 
		<?php
		if(empty($_SESSION['cart']) === true)
		{
			print 'カート内に商品がありません';
		}
		?> -->
		<!-- <form action="./delete.php" method="post"> -->
		<!-- <form action="./delete.php" method="post">
			<input type="submit" value="カート内全削除">
		</form> -->
        <!-- </form> -->
        
		<!-- <div class="menu-block">
			<?php foreach($details as $detail):?>
			<div class="menu-item">
				<div class="menu-photo">
					<img src="../../admin/item/detail/img/<?= $detail['item_image'];?>" alt="" width="50%" height="auto">
				</div>
				<div class="menu-text">
					<a href="detail.php?id=<?= $detail['id'];?>"><h3><?= $detail['item_name']; ?></h3></a>
					<p><?= $detail['item_description']; ?></p>
                    <p>&yen;<?= $detail['unit_price']; ?></p>
                    <p><?= $cart_items[$detail['id']];?>個</p>
					<form action="./change.php?id=<?= $detail['id'];?>" method="post">
						<input type="text" name="change" value=<?= $cart_items[$detail['id']];?>>個
						<input type="submit" value="数量変更">
					</form>
				</div>
			</div>
			<?php endforeach; ?>		
        </div> -->
        <form action="./customer_confirm.php" method="post">
        <input type="submit" value="購入者確認ページへ" onclick="./customer_confirm.php">
        <input type="button" value="戻る" onclick="history.back()">
        </form>
    </main>

	<!-- メイン ここまで -->
	<!-- フッター -->
	<footer class="footer">
		<p>&copy;Copyright KUJIRA Cafe. All rights reserved.</p>
	</footer>
	<!-- フッター ここまで -->
</div>
</body>
</html>