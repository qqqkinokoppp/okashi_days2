<?php
class Cart
{
    /**
     * カートに追加するメソッド
     * すでにIDに該当する商品がカートに入っていたら、個数valueを加算
     * 該当する商品が入っていなかったら、連想配列を追加
     * @var int $id
     * @var int $quantity
     */
    public static function addCart($id, $quantity)
    {
        // カートにすでに同じ商品があれば、数量を追加
        if(empty($_SESSION['cart'][$id]) === false)
        {
            $_SESSION['cart'][$id] = $_SESSION['cart'][$id] + $quantity;
        }
        // 商品がなければ新たに追加
        else
        {
            if(is_array($_SESSION['cart']) === true)
            {
                $_SESSION['cart'] += array($id => $quantity);
            }
        }
        // return $_SESSION;
    }    

    /**
     * カートの数量変更メソッド
     * @var int $id
     * @var int $quantity
     */
    public static function changeCart($id, $quantity)
    {
        $_SESSION['cart'][$id] = $quantity;
    }

    /**
     * カート内削除メソッド
     */
    public static function deleteCart()
    {
        $_SESSION['cart'] = array();
    }
}
?>