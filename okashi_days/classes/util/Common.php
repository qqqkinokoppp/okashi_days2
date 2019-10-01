<?php
class Common
{
    /**
     * フォームからPOSTされたデータのサニタイズ
     * 配列がPOSTされてきたときの処理の追加
     * @var array $post
     * @return array $after
     */
    public function sanitize($before)
    {
        $after = array();
        foreach($before as $key => $value)
        {
            $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $after;
    }

    /**
     * 配列を含んだPOSTをサニタイズするメソッド
     * 連想配列のvalueに配列が入っている場合はもう一度foreachで値を取り出してサニタイズ
     * @var array $post
     * @return array $after
     */
    public function MySanitize($post)
    {
        foreach($post as $key => $value)
        {
            if(is_array($value))
            {
                foreach($value as $key2 => $value2)
                {
                $after[$key][$key2] = htmlspecialchars($value2, ENT_QUOTES, 'UTF-8');
                }
            }
            else
            {
                $after[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $after;
    }
}
?>