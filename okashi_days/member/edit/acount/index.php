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
if(isset($user['id']))
{
    $_SESSION['id']['edit_member'] = $user['id'];
}

//ワンタイムトークンの取得
$token = Safety::getToken();

//POSTされてきたユーザーIDに該当するユーザー情報を取得してくる
$db = new Member();
$edit_member = $db ->getMember($_SESSION['id']['edit_member']);
$user_name = $edit_member['user_name'];
$last_name = $edit_member['last_name'];
$first_name = $edit_member['first_name'];
$last_name_kana = $edit_member['last_name_kana'];
$first_name_kana = $edit_member['first_name_kana'];
$birthday = $edit_member['birthday'];
$gender = $edit_member['gender'];

//DBから取得した郵便番号を上3桁、下4桁に分割、戻り値はarray
$postal_code1 = substr($edit_member['postal_code'], 0, 3);
$postal_code2 = substr($edit_member['postal_code'], 3, 4);

$prefecture = $edit_member['prefecture'];
$prefecture_id = $edit_member['prefecture_id'];
$address1 = $edit_member['address1'];
$address2 = $edit_member['address2'];
$phone_number = $edit_member['phone_number'];
$email = $edit_member['email'];

// <!-- 都道府県取得のためのDB接続 -->
$db = new Address();
$prefectures = $db ->getPrefAll();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>会員情報修正</title>
<link rel="stylesheet" href="/okashi_days/admin/css/normalize.css">
<link rel="stylesheet" href="/okashi_days/admin/css/main.css">
</head>
<body>
<div class="container">
    <header>
         <div class="title">
            <h1>会員情報修正</h1>
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
        <?php if(!empty($_SESSION['error']['edit_member'])):?>
        <p class="error">
            <?= $_SESSION['error']['edit_member'];?>
        </p>
        <?php endif;?>

        <form action="confirm.php" method="post">
        <!--ワンタイムトークン-->
        <input type="hidden" name="token" value="<?= $token;?>">
            <table class="list">
                <tr>
                    <th>ログインユーザー名</th>
                    <td class="align-left">
                        <?php if(isset($_SESSION['post']['edit_member']['user_name'])):?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $_SESSION['post']['edit_member']['user_name']?>">
                        <?php else:?>
                        <input type="text" name="user_name" id="user_name" class="user_name" value="<?= $user_name?>">
                        <?php endif;?>
                    </td>
                </tr>
                
                <tr>
                    <th>会員姓</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['last_name'])):?>
                    <input type="text" name="last_name" id="last_name" class="last_name" value="<?= $_SESSION['post']['edit_member']['last_name']?>">
                    <?php else:?>
                    <input type="text" name="last_name" id="last_name" class="last_name" value="<?= $last_name?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>会員名</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['first_name'])):?>
                    <input type="text" name="first_name" id="first_name" class="first_name" value="<?= $_SESSION['post']['edit_member']['first_name']?>">
                    <?php else:?>
                    <input type="text" name="first_name" id="first_name" class="first_name" value="<?= $first_name?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>会員姓（カナ）</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['last_name_kana'])):?>
                    <input type="text" name="last_name_kana" id="last_name_kana" class="last_name_kana" value="<?= $_SESSION['post']['edit_member']['last_name_kana']?>">
                    <?php else:?>
                    <input type="text" name="last_name_kana" id="last_name_kana" class="last_name_kana" value="<?= $last_name_kana?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>会員名（カナ）</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['first_name_kana'])):?>
                    <input type="text" name="first_name_kana" id="first_name_kana" class="first_name_kana" value="<?= $_SESSION['post']['edit_member']['first_name_kana']?>">
                    <?php else:?>
                    <input type="text" name="first_name_kana" id="first_name_kana" class="first_name_kana" value="<?= $first_name_kana?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>郵便番号</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['postal_code1'])&&isset($_SESSION['post']['edit_member']['postal_code2'])):?>
                    <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="<?= $_SESSION['post']['edit_member']['postal_code1']?>" style="width:50px;">-
                    <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="<?= $_SESSION['post']['edit_member']['postal_code2']?>" style="width:50px;">
                    <?php else:?>
                    <input type="text" name="postal_code1" id="postal_code1" class="postal_code1" value="<?= $postal_code1?>" style="width:50px;">-
                    <input type="text" name="postal_code2" id="postal_code2" class="postal_code2" value="<?= $postal_code2?>" style="width:50px;">
                    <?php endif;?>
                    <input type="button" value="住所検索" id="search"><div id="error"></div>
                    </td>
                </tr>

                <tr>
                    <th>都道府県</th>
                    <td class="align-left">
                    <select name="prefecture_id" id="prefecture_id">
                    <option value=""></option>
                    <?php foreach($prefectures as $prefecture_select):?>
                    
                    <option value="<?= $prefecture_select['id']?>" 
                    <?php if(isset($prefecture_id)){if($prefecture_id === $prefecture_select['id']){ print 'selected';}}?>>
                    <?= $prefecture_select['prefecture']?>
                    </option>
                    
                    <?php endforeach;?>
                    </select>
                    </td>
                </tr>

                <tr>
                    <th>住所1（市区町村・町名）</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['address1'])):?>
                    <input type="text" name="address1" id="address1" class="address1" value="<?= $_SESSION['post']['edit_member']['address1']?>">
                    <?php else:?>
                    <input type="text" name="address1" id="address1" class="address1" value="<?= $address1?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>住所2（番地・建物名）</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['address2'])):?>
                    <input type="text" name="address2" id="address2" class="address2" value="<?= $_SESSION['post']['edit_member']['address2']?>">
                    <?php else:?>
                    <input type="text" name="address2" id="address2" class="address2" value="<?= $address2?>">
                    <?php endif;?>
                    </td>
                </tr>

                <!-- hiddenで都道府県名もpostする -->
                <input type="hidden" name="prefecture" id="prefecture" class="prefecture" value="<?= $prefecture?>">

                <!-- 住所検索 -->
                <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
                <script>
                $(function(){
                    $('#search').click(function(){
                        // console.log('a');//chromeディベロッパーツールのコンソールに出る
                        $.ajax('postal_search.php', 
                            {
                            type: 'post',
                            data: {
                                postal_code: $('#postal_code1').val() + $('#postal_code2').val(),
                            },
                            scriptCharset: 'utf-8',
                            dataType: 'json'//jsonで受け取り
                            }
                        )
                        .done(function(data){
                            // console.log('ok');
                            // console.log(data);
                            try
                            {
                                $("#error").text('');
                                // var array = JSON.parse(data);
                                // document.write(data.prefecture);
                                $("#prefecture_id").val(data.prefecture_id);
                                $("#prefecture").val(data.prefecture);
                                $("#address1").val(data.address1);
                                $("#address2").val(data.address2);
                            }
                            catch(e)
                            {
                                console.error(e);
                            }
                        })
                        //失敗時はエラーメッセージ表示とフォームの初期化
                        .fail(function(jqXHR, textStatus, errorThrown){
                            $("#XMLHttpRequest").html("XMLHttpRequest : " + jqXHR.status);
                            $("#textStatus").html("textStatus : " + textStatus);
                            $("#errorThrown").html("errorThrown : " + errorThrown);
                            $("#error").text('見つかりません。');
                            $("#pref").val('');
                            $("#address1").val('');
                            $("#address2").val('');
                        })
                    });
                });
                </script>

                <tr>
                    <th>電話番号</th>
                    <td class="align-left">
                    <?php if(isset($_SESSION['post']['edit_member']['phone_number'])):?>
                    <input type="text" name="phone_number" id="phone_number" class="phone_number" value="<?= $_SESSION['post']['edit_member']['phone_number']?>">
                    <?php else:?>
                    <input type="text" name="phone_number" id="phone_number" class="phone_number" value="<?= $phone_number?>">
                    <?php endif;?>
                    </td>
                </tr>

                <tr>
                    <th>メールアドレス</th>
                    <td class="align-left">
                    <?php if(isset($email)):?>
                    <input type="text" name="email" id="email" class="email" value="<?= $email?>">
                    <?php else:?>
                    <input type="text" name="email" id="email" class="email" value="">
                    <?php endif;?>
                    </td>
                </tr>
            </table>
            <!-- ワンタイムトークン -->
            <input type="hidden" name="token" value="<?= $token;?>">
            <input type="submit" value="確認画面へ">
            <input type="button" value="キャンセル" onclick="location.href='./disp.php';">
            <input type="button" value="トップページへ" onclick="location.href='../../';">
        </form>


    </main>

    <footer>

    </footer>
</div>
</body>
</html>