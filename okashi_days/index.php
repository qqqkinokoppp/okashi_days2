<?php
require_once("../Config.php");
// 必要なクラスのファイルを読み込む
require_once(Config::APP_ROOT_DIR.'/classes/util/Session.php');
require_once(Config::APP_ROOT_DIR.'/classes/util/Common.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'/classes/model/ItemManage.php');

// セッションスタート
Session::sessionStart();
if(isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}

$_SESSION['url'] = '';
//おすすめ商品データの取得
$db = new ItemManage();
$recommends = $db ->getRecommendDetail();

// おすすめ商品の数（for文用）
$recommends_count = $db ->countRecommend();
// var_dump($recommends);
// print $recommends_count['COUNT(*)'];
//foreach用カウンターの初期化
$i = 0;

$images = scandir('./admin/item/detail/img/');//指定ディレクトリ内にあるファイルとディレクトリの取得　ファイル名、ディレクトリ名が配列が返ってきてる
$img = array();//画像を入れる配列を初期化
//var_dump($images);
foreach($images as $i)
{
    if(is_file("./admin/item/detail/img/$i"))//$images内の要素のうち、ファイルであるもののみ、$imgに入れていく！！覚書　ダブルクォーテーション内の変数は展開される
    {
        $img[] = $i;
    }
}
//var_dump($img);

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.3/js/swiper.min.js"></script><!--swiperのライブラリ、スタイルシート読み込み-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.css">
<title>okashi days.</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper">
	<!-- ヘッダー -->
	<header class="header">
		<h1 class="logo"><a href="./index.php"><img src="./images/okashi_days_logo.png" alt="okashi days."></a></h1>
		<?php if(isset($user) === true):?>
		<p>ようこそ、<?= $user['last_name'].' '.$user['last_name'].'さん';?></p>
		<?php endif;?>
		<nav class="nav">
			<ul>
				<li><a href="index.html">ホーム</a></li>
				<!-- <li><a href="about.html">店舗案内</a></li> -->
				<li><a href="./order/cart/">カート</a></li>
				<!-- <li><a href="./item/category/">商品カテゴリ一覧</a></li> -->
				<li><a href="./item/list.php">商品一覧</a></li>
				<!-- <li><a href="contact.html">お問い合わせ</a></li> -->
				<?php if(!isset($user)):?>
				<li><a href="contact.html">新規会員登録</a></li>
				<li><a href="./member/login/">ログイン</a></li>
				<?php else:?>
				<li><a href="./member/">会員ページ</a></li>
				<li><a href="./member/login/logout.php">ログアウト</a></li>
				<?php endif;?>
			</ul>
		</nav>
	</header>
	<!-- ヘッダー ここまで -->
	<!-- メイン -->
	<div class="bg-test">
    <div class="swiper-container" style="background-image:url(../okashi_back.png)">
        <div class="swiper-wrapper">
			<?php foreach($img as $a):?><!--スライドさせる画像をforeachで回す-->
			<?php foreach($recommends as $key => $recommend):?>
			<!-- おすすめ商品の画像をスライド表示させる -->
			<?php if($a === $recommend['item_image']):?>
			<div class="swiper-slide" align="center">
			<a href="./item/detail.php?id=<?= $recommend['id'];?>">
			<img src="<?php print './admin/item/detail/img/'.$a?>">
			</a>
			</div>
			<?php endif;?>
			<?php endforeach;?>
			<?php endforeach;?>
        </div>
        <div class="swiper-pagination"></div><!--ページネーション-->
            <div class="swiper-button-prev"></div><!--右へ左へボタン-->
            <div class="swiper-button-next"></div>
    </div>
</div>
<script>
var mySwiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 3000,
    autoplay: {
    delay: 3000,
    disableOnInteraction: false
    },
    pagination: {
		el: '.swiper-pagination',
		type: 'bullets',
		clickable: true
	},
    navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev'
	}

});
</script>
	<!-- <div class="keyvisual">
		<img src="images/keyvisual.jpg" alt="">
	</div> -->
	<main>
		<h2 id="news">News</h2>
		<p class="news-item">4月29日（土）は、九寺楽町の春祭りに出店するため、お店は休業させていたただきます。春祭りでタルトやキッシュ、コーヒーも販売するので、ぜひお越しください。</p>
		<p class="news-item">3月20日（月・祝）は、18時からアコースティックギターデュオ「<a href="http://www.sbcr.jp" target="_blank">PICNIC</a>」のライブを開催します。投げ銭方式です。お楽しみに！</p>
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