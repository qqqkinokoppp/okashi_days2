<?php
require_once('Base.php');

class NewsManage extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * お知らせ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addNews($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO news ( ';
        $sql .= 'news_index, ';
        $sql .= 'news_content, ';
        $sql .= 'expiration_date';
        $sql .= ') VALUES (' ;
        $sql .= ':news_index, ';
        $sql .= ':news_content, ';
        $sql .= ':expiration_date ';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':news_index', $data['news_index'], PDO::PARAM_STR);
        $stmt ->bindValue(':news_content', $data['news_content'], PDO::PARAM_STR);
        $stmt ->bindValue(':expiration_date', $data['expiration_date'], PDO::PARAM_STR);
        $rec = $stmt ->execute();
        return $rec;
    }


    /**
     * お知らせ修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editNews($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE news SET ';
        $sql .= 'news_index= :news_index, ';
        $sql .= 'news_content = :news_content, ';
        $sql .= 'expiration_date = :expiration_date ';
        $sql .= 'WHERE id = :id ;';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':news_index', $data['news_index'], PDO::PARAM_STR);
        $stmt ->bindValue(':news_content', $data['news_content'], PDO::PARAM_STR);
        $stmt ->bindValue(':expiration_date', $data['expiration_date'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お知らせ削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteNews($id)
    {
        $sql ='';
        $sql .='UPDATE news SET ';
        $sql .='is_deleted = 1 ';
        $sql .='WHERE id =:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * お知らせ取得メソッド
     * @var int $id
     * @return array $rec 
     */
    public function getNews($id)
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='news_index, ';
        $sql .='news_content, ';
        $sql .='expiration_date, ';
        $sql .='is_deleted ';
        $sql .='FROM news ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * お知らせ全取得メソッド
     * @return array $rec 
     */
    public function getNewsAll()
    {
        $sql = '';
        $sql .='SELECT id,';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='news_index, ';
        $sql .='news_content, ';
        $sql .='is_deleted,';
        $sql .='expiration_date ';
        $sql .='FROM news ';
        $sql .='WHERE is_deleted=0';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }
}
