<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
require_once "../../functions.php";
$stmt = $connect->prepare("INSERT INTO `users`(
    `login`,
    `password`,
    `lastname`,
    `firstname`,
    `middlename`,
    `role_id`
)
VALUES(
    :login,
    :password,
    :lastname,
    :firstname,
    :middlename,
    '4'
)");
$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", generateRandomPassword(), PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->execute();
header("Location: front_table_methodologists.php");