<?php
require_once('Base.php');

class ItemManage extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * カテゴリ登録メソッド
     * @var array $data
     * @return bool
     */
    public function addCategory($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO item_categories ( ';
        $sql .= 'item_category_name, ';
        $sql .= 'item_category_image ';
        $sql .= ') VALUES (' ;
        $sql .= ':item_category_name, ';
        $sql .= ':item_category_image ';
        $sql .= ')';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':item_category_name', $data['category_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_category_image', $data['category_img'], PDO::PARAM_STR);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * @todo カテゴリ修正メソッドはオプショナル引数を用いるメソッドに改造予定
     */
    
    /**
     * カテゴリ修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editCategory($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE item_categories SET ';
        $sql .= 'item_category_name = :item_category_name, ';
        $sql .= 'item_category_image = :item_category_image ';
        $sql .= 'WHERE id = :id ;';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':item_category_name', $data['item_category_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_category_image', $data['item_category_image'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * カテゴリ修正メソッド(画像変更なし)
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editCategoryNoImage($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE item_categories SET ';
        $sql .= 'item_category_name = :item_category_name ';
        $sql .= 'WHERE id = :id ;';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':item_category_name', $data['item_category_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }


    /**
     * カテゴリ削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteCategory($id)
    {
        $sql ='';
        $sql .='UPDATE item_categories SET ';
        $sql .='is_deleted = 1 ';
        $sql .='WHERE id =:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

     /**
     * カテゴリカウントメソッド
     * @var int $id
     * @return bool $rec
     */
    public function countCategory($id)
    {
        $sql = '';
        $sql .= 'SELECT COUNT(*) FROM items WHERE item_category_id = :id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 商品詳細登録メソッド
     * @var array $data
     * @return bool $rec
     */
    public function addItemDetail($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO items ( ';
        $sql .= 'item_category_id, ';
        $sql .= 'item_name, ';
        $sql .= 'item_model_number, ';
        $sql .= 'item_description, ';
        $sql .= 'allergy_item, ';
        $sql .= 'item_detail, ';
        $sql .= 'unit_price, ';
        $sql .= 'item_image, ';
        $sql .= 'is_recommend ';
        $sql .= ') VALUES ( ';
        $sql .= ':item_category_id, ';
        $sql .= ':item_name, ';
        $sql .= ':item_model_number, ';
        $sql .= ':item_description, ';
        $sql .= ':allergy_item, ';
        $sql .= ':item_detail, ';
        $sql .= ':unit_price, ';
        $sql .= ':item_image, ';
        $sql .= ':is_recommend ';
        $sql .= ');';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':item_category_id', $data['item_category_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_name', $data['item_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_model_number', $data['item_model_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_description', $data['item_description'], PDO::PARAM_STR);
        $stmt ->bindValue(':allergy_item', $data['allergy_item'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_detail', $data['item_detail'], PDO::PARAM_STR);
        $stmt ->bindValue(':unit_price', $data['unit_price'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_image', $data['item_image']['name'], PDO::PARAM_STR);
        $stmt ->bindValue(':is_recommend', $data['is_recommend'], PDO::PARAM_STR);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 商品詳細修正メソッド
     * @var array $data
     * @var int $id
     * 画像がなければ（第3引数省略）画像の更新はしない
     * @return bool $rec
     */
    public function editItemDetail($data, $id, $item_image = null)
    {
        $sql = '';
        $sql .= 'UPDATE items SET ';
        $sql .= 'item_category_id = :item_category_id, ';
        $sql .= 'item_name = :item_name, ';
        $sql .= 'item_model_number = :item_model_number, ';
        $sql .= 'item_description = :item_description, ';
        $sql .= 'allergy_item = :allergy_item, ';
        $sql .= 'item_detail = :item_detail, ';
        $sql .= 'unit_price = :unit_price, ';
        if($item_image !== null)
        {
            $sql .= 'item_image = :item_image ,';
        }
        $sql .= 'is_recommend = :is_recommend ';
        $sql .= 'WHERE id = :id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':item_category_id', $data['item_category_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':item_name', $data['item_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_model_number', $data['item_model_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_description', $data['item_description'], PDO::PARAM_STR);
        $stmt ->bindValue(':allergy_item', $data['allergy_item'], PDO::PARAM_STR);
        $stmt ->bindValue(':item_detail', $data['item_detail'], PDO::PARAM_STR);
        $stmt ->bindValue(':unit_price', $data['unit_price'], PDO::PARAM_STR);
        if($item_image !== null)
        {
            $stmt ->bindValue(':item_image', $data['item_image']['name'], PDO::PARAM_STR);
        }
        $stmt ->bindValue(':is_recommend', $data['is_recommend'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 商品詳細削除メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id
     * @return bool $rec 
     */
    public function deleteItemDetail($id)
    {
        $sql ='';
        $sql .='UPDATE items SET ';
        $sql .='is_deleted = 1 ';
        $sql .='WHERE id =:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 商品詳細全取得メソッド
     * @return array $rec 
     */
    public function getDetailAll()
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='item_category_id, ';
        $sql .='item_name, ';
        $sql .='item_model_number, ';
        $sql .='item_description, ';
        $sql .='allergy_item, ';
        $sql .='item_detail, ';
        $sql .='unit_price, ';
        $sql .='item_image, ';
        $sql .='is_recommend, ';
        $sql .='is_deleted ';
        $sql .='FROM items ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 商品詳細取得メソッド
     * @var int $id
     * @return array $rec 
     */
    public function getDetail($id)
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='item_category_id, ';
        $sql .='item_name, ';
        $sql .='item_model_number, ';
        $sql .='item_description, ';
        $sql .='allergy_item, ';
        $sql .='item_detail, ';
        $sql .='unit_price, ';
        $sql .='item_image, ';
        $sql .='is_recommend, ';
        $sql .='is_deleted ';
        $sql .='FROM items ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * おすすめ商品全取得メソッド
     * @return array $rec 
     */
    public function getRecommendDetail()
    {
        $sql = '';
        $sql .='SELECT id, ';
        $sql .='item_category_id, ';
        $sql .='item_name, ';
        $sql .='item_model_number, ';
        $sql .='item_description, ';
        $sql .='allergy_item, ';
        $sql .='item_detail, ';
        $sql .='unit_price, ';
        $sql .='item_image, ';
        $sql .='is_recommend, ';
        $sql .='is_deleted ';
        $sql .='FROM items ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND is_recommend=1';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * おすすめ商品数カウントメソッド
     *
     * @param [type] $id
     * @return int
     */
    public function countRecommend()
    {
        $sql = '';
        $sql .= 'SELECT COUNT(*) FROM items WHERE is_deleted = 0 AND is_recommend = 1 ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 商品カテゴリ全取得メソッド
     * @return array $rec 
     */
    public function getCategoryAll()
    {
        $sql = '';
        $sql .='SELECT id,item_category_name,item_category_image,is_deleted FROM item_categories ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * 商品カテゴリ取得メソッド
     * @var int $id
     * @return array $rec 
     */
    public function getCategory($id)
    {
        $sql = '';
        $sql .='SELECT id,item_category_name,item_category_image FROM item_categories ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE id=:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
        
    }

    /**
     * アレルギー全取得メソッド
     * @return array $rec 
     */
    public function getAllergyAll()
    {
        $sql = '';
        $sql .='SELECT id,allergy_item FROM allergy_items ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
    }

    /**
     * アレルギー取得メソッド
     * @return array $rec 
     */
    public function getAllergy($id)
    {
        $sql = '';
        $sql .='SELECT id,allergy_item FROM allergy_items ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE is_deleted=0 ';
        $sql .='AND id=:id ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
    }

}
