<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_group = $_POST['id_group'];
$sql = "DELETE
FROM
    `groups`
WHERE
    `id_group` = '$id_group'";
$connect->exec($sql);
header("Location:front_table_groups.php");