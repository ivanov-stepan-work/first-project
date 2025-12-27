<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_methodologist = $_POST['id_methodologist'];
$sql = "DELETE
FROM
    `users`
WHERE
    `id_user` = '$id_methodologist'";
$connect->exec($sql);
header("Location:front_table_methodologists.php");