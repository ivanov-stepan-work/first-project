<?php
require_once "../connect.php";
require_once "../functions.php";
session_start();
if(!in_array('2', $_SESSION['user']['role']))
header("Location: ../../index.php");


$sql = "INSERT INTO `number_of_students` (`teacher_id`, `numbers_of`)
VALUES (:id, :numbers)
ON DUPLICATE KEY UPDATE `numbers_of` = :numbers";
$stmt = $connect->prepare($sql);
$stmt->bindValue(":id", $_POST['id'],pdo::PARAM_INT);
$stmt->bindValue(":numbers", $_POST['numbers'],pdo::PARAM_INT);
$stmt->execute();
