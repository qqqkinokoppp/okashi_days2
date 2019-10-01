<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/okashi_days/classes/model/Base.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/okashi_days/classes/model/Member.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/okashi_days/classes/util/Common.php');

$post = Common::sanitize($_POST);
$user_name = $post['user_name'];
$password = $post['password'];

try
{
    $db = new Member();
    $db ->loginMember($user_name, $password);
}
catch(Exception $e)
{
    var_dump($e);
}

?>