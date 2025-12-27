<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_role = $_POST['id_role'];
$sql = "DELETE
FROM
    `roles`
WHERE
    `id_role` = '$id_role'";
$connect->exec($sql);
header("Location:front_table_roles.php");