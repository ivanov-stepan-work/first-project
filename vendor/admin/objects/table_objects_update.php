<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "UPDATE
`objects`
SET
`name` = :object_name
WHERE
`objects`.`id_object` = :id_object";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":object_name", $_POST['object_name'], PDO::PARAM_STR);
$stmt->bindValue(":id_object", $_POST['id_object'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_objects.php");