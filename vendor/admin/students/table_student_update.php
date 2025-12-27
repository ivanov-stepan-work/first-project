<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "UPDATE
`users`
SET
`login` = :login,
`password` = :password,
`lastname` = :lastname,
`firstname` = :firstname,
`middlename` = :middlename
WHERE
`users`.`id_user` = :id_user";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", $_POST['password'], PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->bindValue(":id_user", $_POST['id_student'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_students.php");