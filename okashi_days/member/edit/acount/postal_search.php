<?php
// 郵便番号をGETして、それに該当する住所をDBから取得、JSONに変換
require_once('../../../../Config.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Base.php');
require_once(Config::APP_ROOT_DIR.'classes/model/Address.php');


// サニタイズ
$postal_code = htmlspecialchars($_POST['postal_code']);

// 半角数字がどうか、7桁かどうかチェック
if((preg_match("/^[0-9]+$/", $postal_code) === 0) || (strlen($postal_code) !== 7))
{
    print '';
}
else
{
    $db = new Address();
    $address = $db ->getAddress($postal_code);

    if($address['address2'] === '以下に掲載がない場合')
    {
        $address['address2'] = '';
    }

    // switch ($address['prefecture']) {
    //     case '北海道':
    //         $address['prefecture_id'] = '1';
    //         break;
    //     case '青森県':
    //         $address['prefecture_id'] = '2';
    //         break;
    //     case '岩手県':
    //         $address['prefecture_id'] = '3';
    //         break;
    //     case '宮城県':
    //         $address['prefecture_id'] = '4';
    //         break;
    //     case '秋田県':
    //         $address['prefecture_id'] += '5';
    //         break;
    //     case '山形県':
    //         $address['prefecture_id'] += '6';
    //         break;
    //     case '福島県':
    //         $address['prefecture_id'] += '7';
    //         break;
    //     case '茨城県':
    //         $address['prefecture_id'] += '8';
    //         break;
    //     case '栃木県':
    //         $address['prefecture_id'] += '9';
    //         break;
    //     case '群馬県':
    //         $address['prefecture_id'] += '10';
    //         break;
    //     case '埼玉県':
    //         $address['prefecture_id'] += '11';
    //         break;
    //     case '千葉県':
    //         $address['prefecture_id'] += '12';
    //         break;
    //     case '東京都':
    //         $address['prefecture_id'] += '13';
    //         break;
    //     case '神奈川県':
    //         $address['prefecture_id'] += '14';
    //         break;
    //     case '新潟県':
    //         $address['prefecture_id'] += '15';
    //         break;
    //     case '富山県':
    //         $address['prefecture_id'] += '16';
    //         break;
    //     case '石川県':
    //         $address['prefecture_id'] += '17';
    //         break;
    //     case '福井県':
    //         $address['prefecture_id'] += '18';
    //         break;
    //     case '山梨県':
    //         $address['prefecture_id'] += '19';
    //         break;
    //     case '長野県':
    //         $address['prefecture_id'] += '20';
    //         break;
    //     case '岐阜県':
    //         $address['prefecture_id'] += '21';
    //         break;
    //     case '静岡県':
    //         $address['prefecture_id'] += '22';
    //         break;
    //     case '愛知県':
    //         $address['prefecture_id'] += '23';
    //         break;
    //     case '三重県':
    //         $address['prefecture_id'] += '24';
    //         break;
    //     case '滋賀県':
    //         $address['prefecture_id'] += '25';
    //         break;
    //     case '京都府':
    //         $address['prefecture_id'] += '26';
    //         break;
    //     case '大阪府':
    //         $address['prefecture_id'] += '27';
    //         break;
    //     case '兵庫県':
    //         $address['prefecture_id'] += '28';
    //         break;
    //     case '奈良県':
    //         $address['prefecture_id'] += '29';
    //         break;
    //     case '和歌山県':
    //         $address['prefecture_id'] += '30';
    //         break;
    //     case '鳥取県':
    //         $address['prefecture_id'] += '31';
    //         break;
    //     case '島根県':
    //         $address['prefecture_id'] += '32';
    //         break;
    //     case '岡山県':
    //         $address['prefecture_id'] += '33';
    //         break;
    //     case '広島県':
    //         $address['prefecture_id'] += '34';
    //         break;
    //     case '山口県':
    //         $address['prefecture_id'] += '35';
    //         break;
    //     case '徳島県':
    //         $address['prefecture_id'] += '36';
    //         break;
    //     case '香川県':
    //         $address['prefecture_id'] += '37';
    //         break;
    //     case '愛媛県':
    //         $address['prefecture_id'] += '38';
    //         break;
    //     case '高知県':
    //         $address['prefecture_id'] += '39';
    //         break;
    //     case '福岡県':
    //         $address['prefecture_id'] += '40';
    //         break;
    //     case '佐賀県':
    //         $address['prefecture_id'] += '41';
    //         break;
    //     case '長崎県':
    //         $address['prefecture_id'] += '42';
    //         break;
    //     case '熊本県':
    //         $address['prefecture_id'] += '43';
    //         break;
    //     case '大分県':
    //         $address['prefecture_id'] += '44';
    //         break;
    //     case '宮崎県':
    //         $address['prefecture_id'] += '45';
    //         break;
    //     case '鹿児島県':
    //         $address['prefecture_id'] += '46';
    //         break;
    //     case '沖縄県':
    //         $address['prefecture_id'] += '47';
    //         break;
    //     default:
    //         $address['prefecture_id'] += '0';
    //         break;
    //     }

    //jsonに変換,
    //日本語をそのままの形式で扱い：JSON_UNESCAPED_UNICODE
    $return_address = json_encode($address, JSON_UNESCAPED_UNICODE);

    header('content-type: application/json; charset=utf-8');
    print $return_address;
}
?>