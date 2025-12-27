<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$stmt = $connect->prepare("INSERT INTO `groups`(
    `name`
)
VALUES(
    :group_name
)");
$stmt->bindValue(":group_name", $_POST['group_name'], PDO::PARAM_STR);
$stmt->execute();
header("Location: front_table_groups.php");