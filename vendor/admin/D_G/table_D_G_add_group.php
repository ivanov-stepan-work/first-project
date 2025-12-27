<?php

require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role'])) {
    header("Location:../../../index.php");
}
try {

    if (isset($_POST['id_department'], $_POST['select_group_add'])) {
        $stmt = $connect->prepare("UPDATE `groups` SET `dep_id`= :department_id WHERE `id_group` = :group_id");
        $stmt->bindValue(":department_id", $_POST['id_department'], pdo::PARAM_INT);
        $stmt->bindValue(":group_id", $_POST['select_group_add'], pdo::PARAM_INT);
        $stmt->execute();
    }
} catch (PDOException $e) {
    // Обработка исключения PDO
    echo "Ошибка базы данных: " . $e->getMessage();
}

echo 'Успешно...';
