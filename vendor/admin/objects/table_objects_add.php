<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$stmt = $connect->prepare("INSERT INTO `objects`(
    `name`
)
VALUES(
    :object_name
)");
$stmt->bindValue(":object_name", $_POST['object_name'], PDO::PARAM_STR);
$stmt->execute();
header("Location: front_table_objects.php");