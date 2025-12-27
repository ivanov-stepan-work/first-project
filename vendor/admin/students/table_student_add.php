<?php

require_once "../../functions.php";
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");

try {

$stmt = $connect->prepare("INSERT INTO `users`(
    `login`,
    `password`,
    `lastname`,
    `firstname`,
    `middlename`
)
VALUES(
    :login,
    :password,
    :lastname,
    :firstname,
    :middlename
)");

$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", generateRandomPassword(), PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->execute();
$connect->exec("INSERT INTO `roles_users` (`role_id`, `user_id`) VALUES ('5', LAST_INSERT_ID())");

header("Location: front_table_students.php");
} 
catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        echo '101';
    } else {
        
        echo 'ОШИБКА: ' . $e->getMessage();
    }
    // header("Location: front_table_students.php");
}