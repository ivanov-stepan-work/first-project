<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "UPDATE
`roles`
SET
`name` = :role_name
WHERE
`id_role` = :id_role";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":role_name", $_POST['role_name'], PDO::PARAM_STR);
$stmt->bindValue(":id_role", $_POST['id_role'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_roles.php");