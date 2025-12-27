<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$id_teacher = $_POST['id_teacher'];
$id_object = $_POST['select_object_delete'];
$sql = "DELETE
FROM
    `teachers_objects`
WHERE
    `teacher_id` = '$id_teacher' AND `object_id` = '$id_object'";
$connect->exec($sql);
header("Location:front_table_T_O.php");