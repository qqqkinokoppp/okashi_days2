<?php
require_once('Base.php');
class Member extends Base
{
    /**親コンストラクタ呼び出し */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 会員ログインメソッド
     * 入力されたパスワードが、ユーザー名に相当するパスワードと一致するか調べる
     * @var str $user_name
     * @var str $password
     * @return array  ログイン成功時以外は空配列を返す
     */
    public function loginMember($user_name, $password)
    {
        //パスワード、ユーザー名が入力されていなければ空配列を返す
        if(!isset($user_name)||!isset($password))
        {
            return array();
        }
        $sql = '';
        $sql .='SELECT id,user_name,last_name,first_name,password,is_deactive FROM members ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .='WHERE user_name=:user_name ';
        $sql .='AND is_deactive=0 ';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        
        //ユーザー名に相当するパスワードが登録されていなければ空配列を返す
        if(!isset($rec['password']))
        {
            // print '通った1';
            return array();
        }
        //DBに登録されているパスワードと入力されたパスワードが一致しなければ空配列を返す
        if(password_verify($password, $rec['password']))
        {
            // print '通った2';
            return $rec;
        }
        else
        {
            // print '通った3';
            return array();
        }
        
    }
    
    /**
     * 会員登録メソッド
     * @var array $data：管理者登録に必要な項目の連想配列
     * @return bool $rec
     */
    public function addMember($data)
    {
        $sql = '';
        $sql .= 'INSERT INTO members (';
        $sql .= 'user_name,';
        $sql .= 'password,';
        $sql .= 'last_name,';
        $sql .= 'first_name,';
        $sql .= 'last_name_kana,';
        $sql .= 'first_name_kana,';
        $sql .= 'birthday,';
        $sql .= 'gender,';
        $sql .= 'postal_code,';
        $sql .= 'prefecture,';
        $sql .= 'prefecture_id,';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'phone_number,';
        $sql .= 'email';
        $sql .= ') VALUES (';
        $sql .= ':user_name,';
        $sql .= ':password,';
        $sql .= ':last_name,';
        $sql .= ':first_name,';
        $sql .= ':last_name_kana,';
        $sql .= ':first_name_kana,';
        $sql .= ':birthday,';
        $sql .= ':gender,';
        $sql .= ':postal_code,';
        $sql .= ':prefecture,';
        $sql .= ':prefecture_id,';
        $sql .= ':address1,';
        $sql .= ':address2,';
        $sql .= ':phone_number,';
        $sql .= ':email)';
    
        $stmt = $this ->dbh -> prepare($sql);
        $stmt ->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt ->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':last_name_kana', $data['last_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':first_name_kana', $data['first_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':birthday', $data['birthday'], PDO::PARAM_STR);
        $stmt ->bindValue(':gender', $data['gender'], PDO::PARAM_INT);
        $stmt ->bindValue(':postal_code', $data['postal_code'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture', $data['prefecture'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture_id', $data['prefecture_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':address1', $data['address1'], PDO::PARAM_STR);
        $stmt ->bindValue(':address2', $data['address2'], PDO::PARAM_STR);
        $stmt ->bindValue(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);

        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 会員情報修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editMember($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE members SET ';
        $sql .= 'user_name = :user_name,';
        $sql .= 'last_name = :last_name,';
        $sql .= 'first_name = :first_name,';
        $sql .= 'last_name_kana = :last_name_kana,';
        $sql .= 'first_name_kana = :first_name_kana,';
        $sql .= 'postal_code = :postal_code,';
        $sql .= 'prefecture = :prefecture,';
        $sql .= 'prefecture_id = :prefecture_id,';
        $sql .= 'address1 = :address1,';
        $sql .= 'address2 = :address2,';
        $sql .= 'phone_number = :phone_number,';
        $sql .= 'email = :email ';
        $sql .= 'WHERE id = :id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':user_name', $data['user_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt ->bindValue(':last_name_kana', $data['last_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':first_name_kana', $data['first_name_kana'], PDO::PARAM_STR);
        $stmt ->bindValue(':postal_code', $data['postal_code'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture', $data['prefecture'], PDO::PARAM_STR);
        $stmt ->bindValue(':prefecture_id', $data['prefecture_id'], PDO::PARAM_INT);
        $stmt ->bindValue(':address1', $data['address1'], PDO::PARAM_STR);
        $stmt ->bindValue(':address2', $data['address2'], PDO::PARAM_STR);
        $stmt ->bindValue(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt ->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    
    }

    /**
     * 会員パスワード修正メソッド
     * @var array $data
     * @var int $id
     * @return bool $rec
     */
    public function editPassword($data, $id)
    {
        $sql = '';
        $sql .= 'UPDATE members SET ';
        $sql .= 'password = :password ';
        $sql .= 'WHERE id = :id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 退会（会員削除）メソッド
     * 削除フラグを0=>1に更新、表示対象から外す
     * @var int $id:管理者ID
     * @return bool $rec
     */
    public function deleteMember($id)
    {
        $sql ='';
        $sql .='UPDATE members SET ';
        $sql .='is_deactive = 1 ';
        $sql .='WHERE id =:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindValue(':id', $id, PDO::PARAM_INT);
        $rec = $stmt ->execute();
        return $rec;
    }

    /**
     * 会員情報全取得メソッド
     * @return array $rec 
     */
    public function getMemberAll()
    {
        $sql = '';
        $sql .= 'SELECT ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .= 'id,';
        $sql .= 'user_name,';
        $sql .= 'last_name,';
        $sql .= 'first_name,';
        $sql .= 'last_name_kana,';
        $sql .= 'first_name_kana,';
        $sql .= 'birthday,';
        $sql .= 'gender,';
        $sql .= 'postal_code,';
        $sql .= 'prefecture,';
        $sql .= 'prefecture_id,';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'phone_number,';
        $sql .= 'email ';
        $sql .= 'FROM members ';
        $sql .= 'WHERE is_deactive=0';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->execute();
        $rec = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        return $rec;
        
    }

    /**
     * 会員情報取得メソッド
     * @var int $id
     * @return array $rec 
     */
    public function getMember($id)
    {
        $sql = '';
        $sql .= 'SELECT ';//SQL文の結合をするとき、文末にスペースを入れる！！！
        $sql .= 'id,';
        $sql .= 'user_name,';
        $sql .= 'password,';
        $sql .= 'last_name,';
        $sql .= 'first_name,';
        $sql .= 'last_name_kana,';
        $sql .= 'first_name_kana,';
        $sql .= 'first_name,';
        $sql .= 'birthday,';
        $sql .= 'gender,';
        $sql .= 'postal_code,';
        $sql .= 'prefecture,';
        $sql .= 'prefecture_id,';
        $sql .= 'address1,';
        $sql .= 'address2,';
        $sql .= 'phone_number,';
        $sql .= 'email ';
        $sql .= 'FROM members ';
        $sql .= 'WHERE is_deactive=0 ';
        $sql .= 'AND id =:id';
        $stmt = $this ->dbh ->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt ->execute();
        $rec = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $rec;
        
    }

}
?>