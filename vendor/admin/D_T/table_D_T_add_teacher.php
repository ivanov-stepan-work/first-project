<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
    try {

if (isset($_POST['id_department'], $_POST['select_teacher_add'])){
$stmt = $connect->prepare("INSERT INTO `department_teachers`(`department_id`, `teacher_id`)
VALUES(:department_id, :teacher_id)");
$stmt->bindValue(":department_id", $_POST['id_department'], pdo::PARAM_INT);
$stmt->bindValue(":teacher_id", $_POST['select_teacher_add'], pdo::PARAM_INT);
$stmt->execute();}
} catch (PDOException $e) {
    // Обработка исключения PDO
    echo "Ошибка базы данных: " . $e->getMessage();
}

echo 'Успешно...';