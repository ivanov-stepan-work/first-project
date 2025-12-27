<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_teacher = $_POST['id_teacher'];
$sql = "DELETE
FROM
    `users`
WHERE
    `id_user` = '$id_teacher'";
$connect->exec($sql);
header("Location:front_table_teachers.php");