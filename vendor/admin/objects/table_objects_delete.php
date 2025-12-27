<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_object = $_POST['id_object'];
$sql = "DELETE
FROM
    `objects`
WHERE
    `id_object` = '$id_object'";
$connect->exec($sql);
header("Location:front_table_objects.php");