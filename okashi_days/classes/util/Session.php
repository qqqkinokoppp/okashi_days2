<?php
/**
 * セッション関係クラス
 */
class Session
{
    /**
     * セッションスタート
     *
     * @return void
     */
    public static function sessionStart()
    {
        session_start();
        session_regenerate_id(true);
    }
    
    /**
     * セッション破棄メソッド
     * 
     */
    public static function sessionDestroy()
    {
        self::sessionStart();
        $_SESSION = array();
        if(isset($_COOKIE[session_name()]) === true)
        {
            setcookie(session_name(), '', time()-4200, '/');
        }
        session_destroy();
    }
}
?>