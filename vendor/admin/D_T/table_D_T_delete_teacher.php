<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_department = $_POST['id_department'];
$id_teacher = $_POST['select_teacher_delete'];
$sql = "DELETE
FROM
    `department_teachers`
WHERE
    `department_id` = '$id_department' AND `teacher_id` = '$id_teacher'";
$connect->exec($sql);
header("Location:front_table_D_T.php");