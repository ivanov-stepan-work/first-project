<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");

$stmt = $connect->prepare("INSERT INTO `roles`(
    `name`
)
VALUES(
    :role_name
)");
$stmt->bindValue(":role_name", $_POST['role_name'], PDO::PARAM_STR);
$stmt->execute();
header("Location: front_table_roles.php");