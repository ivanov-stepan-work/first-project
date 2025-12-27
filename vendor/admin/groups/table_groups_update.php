<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "UPDATE
`groups`
SET
`name` = :group_name
WHERE
`id_group` = :id_group";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":group_name", $_POST['group_name'], PDO::PARAM_STR);
$stmt->bindValue(":id_group", $_POST['id_group'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_groups.php");