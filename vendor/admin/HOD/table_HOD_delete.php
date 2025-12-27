<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_HOD = $_POST['id_HOD'];
$sql = "DELETE
FROM
    `users`
WHERE
    `id_user` = '$id_HOD'";
$connect->exec($sql);
header("Location:front_table_HOD.php");