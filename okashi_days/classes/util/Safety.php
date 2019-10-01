<?php
/**
 * フォームの安全対策ユーティリティクラス
 */
class Safety
{   
    /**
     * 前ページから受け取ったワンタイムトークン（$_SESSION）とトークンが一致しているかどうかを確認する。
     * 
     * クロスサイトリクエストフォージェリ対策のワンタイムトークン生成。
     * @return string $token ワンタイムトークン
     */
    public static function getToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $_SESSION['token'] = $token;
        return $token;
    }
    /**
     * フォームで送信されてきたトークンが正しいかどうか確認
     *
     * @param string $token フォームで送信されてきたトークン
     * @return bool トークンが正しいとき：true、正しくないとき：false
     */
    public static function checkToken($token)
    {
        if (isset($_SESSION['token']) && $_SESSION['token'] == $token) {
            return true;
        }
        return false;
    }
}
?>