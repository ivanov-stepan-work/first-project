<?php

require_once "../connect.php";
require "function_for_teachers.php";
if(!in_array('3', $_SESSION['user']['role'])) {
    header("Location: ../../index.php");
}
$login = $_SESSION['user']['login'];
if(trim($_POST['topic']) == '') {
    die("102");
}
$sql = "UPDATE
`projects`
SET
`object_id` = :object_id,
`topic` = :topic,
`grade` = :grade
WHERE
`projects`.`id_project` = :id_project";
$stmt = $connect->prepare($sql);
$stmt->bindValue(":object_id", $_POST['select_object'], pdo::PARAM_INT);
$stmt->bindValue(":topic", $_POST['topic'], pdo::PARAM_STR);
$stmt->bindValue(":grade", $_POST['grade'], pdo::PARAM_INT);
$stmt->bindValue(":id_project", $_POST['id_project'], pdo::PARAM_INT);
$stmt->execute();
