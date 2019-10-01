<?php 

class Base//DB接続の基底クラス
{   /** @var string ユーザー名*/
    protected const USER = 'root';
    
    /** @var string データベース名、ホスト名、文字コード
     */
    protected const DSN = 'mysql:dbname=okashi_days;host=localhost;charset=utf8';
    
    /**　@var string パスワード 設定なし*/
    protected const PASSWORD = '';
    
    /** @var object データベースハンドル　PDOインスタンス */
    protected $dbh;
    
    /**　コンストラクタ */
    public function __construct()
    {   
        $this ->dbh = new PDO(self::DSN, self::USER, self::PASSWORD);
        $this ->dbh ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//DB接続において例外発生時、PDOExceptionが投げられる
        //print '接続成功';
    }
    
    /** 
     * 以下、トランザクション関係
     * トランザクション開始メソッド */
    public function begin()
    {
        $this ->dbh ->beginTransaction();
    }
    /**ロールバックメソッド */
    public function rollBack()
    {
        $this ->dbh ->rollBack();
    }
    
    /**コミットメソッド */
    public function commit()
    {
        $this ->bdh ->commit();
    }
}
?>