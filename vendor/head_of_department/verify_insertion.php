<?php
require_once "../connect.php";
require_once "../functions.php";
session_start();
if(!in_array('2', $_SESSION['user']['role']))
header("Location: ../../index.php");

$sql_check_number_of_projects = "SELECT COUNT(*) FROM `projects` WHERE `teacher_id` = '" . $_POST['id'] . "'";
$result_check = $connect->query($sql_check_number_of_projects)->fetchColumn();
if($result_check <= intval($_POST['numbers'])) echo 1;
else echo 0;
