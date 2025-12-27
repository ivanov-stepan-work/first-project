<?php
require_once "../connect.php";
session_start();
if(!in_array('3', $_SESSION['user']['role']))
header("Location: ../../index.php");

$id_teacher = $_SESSION['user']['id'];
$result = $connect->query("SELECT IF(NOT EXISTS (SELECT 1 FROM 
`projects` WHERE LENGTH(`projects`.`topic`) = 0 AND `projects`.`teacher_id` = '$id_teacher'), 1, 0) AS result;")->fetchColumn();
echo $result;
?>
