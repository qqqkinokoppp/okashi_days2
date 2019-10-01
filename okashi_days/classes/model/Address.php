<?php
    require_once('Base.php');
    class Address extends Base
    {
        /**
         * 親コンストラクタの呼び出し
         */
        public function __construct()
        {
        parent::__construct();
        }
    
        /**
         * 住所取得メソッド
         * @var int $id
         * @return array $rec 
         */
        public function getAddress($postal_code)
        {
            $sql = '';
            $sql .='SELECT prefecture,address1,address2,prefecture_id FROM postal_code ';//SQL文の結合をするとき、文末にスペースを入れる！！！
            $sql .='WHERE postal_code=:postal_code';
            $stmt = $this ->dbh ->prepare($sql);
            $stmt ->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
            $stmt ->execute();
            $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
            return $rec;
            
        }

        /**
         * 都道府県全取得メソッド
         * @return array $rec 
         */
        public function getPrefAll()
        {
            $sql = '';
            $sql .= 'SELECT id,prefecture FROM prefectures;';//SQL文の結合をするとき、文末にスペースを入れる！！！
            $stmt = $this ->dbh ->prepare($sql);
            $stmt ->execute();
            $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
            return $rec;
        }

    }
?>