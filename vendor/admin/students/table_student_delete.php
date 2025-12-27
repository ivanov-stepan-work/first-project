<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_student = $_POST['id_student'];
$sql = "DELETE
FROM
    `users`
WHERE
    `id_user` = '$id_student'";
$connect->exec($sql);
header("Location:front_table_students.php");