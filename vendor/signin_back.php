<?php
session_start();
if(isset($_SESSION['user']))
header("Location: ../index.php");
require_once "connect.php";


$login = $_POST['login'];
$password = $_POST['password'];


$prepare = $connect->prepare("SELECT EXISTS (SELECT * FROM `users` WHERE `login` = :login AND `password` = :password)");

$prepare->bindValue(':password', $password, pdo::PARAM_STR);
$prepare->bindValue(':login', $login, pdo::PARAM_STR);
$prepare->execute();
$result = $prepare->fetchColumn();
if(!$result){
die('100');
}
else{
    $prepare = $connect->query("SELECT `users`.`id_user`,
    `users`.`login`,
    CONCAT(`users`.`lastname`, ' ', `users`.`firstname`, ' ', `users`.`middlename`) AS full_name,
    GROUP_CONCAT(`roles`.`id_role` ORDER BY `roles`.`id_role` ASC SEPARATOR ',') AS roles
FROM `users`
INNER JOIN `roles_users` ON `roles_users`.`user_id` = `users`.`id_user`
INNER JOIN `roles` ON `roles_users`.`role_id` = `roles`.`id_role`
WHERE `login` = '$login' AND `password` = '$password'
GROUP BY `users`.`id_user`
");
    $result = $prepare->fetchAll()[0];
    $_SESSION['user'] = array("login" => $result['login'], "role" => explode(',', $result['roles']) , "id" => $result['id_user'], 'full_name' => $result['full_name']);
    header("Location: ../index.php");
}
?>