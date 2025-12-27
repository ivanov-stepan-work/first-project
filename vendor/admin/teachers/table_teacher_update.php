<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$role = 0;
$sql_delete_role = "DELETE FROM `roles_users` WHERE `role_id` = :role AND `user_id` = :user_id";
$sql_add_role = "INSERT IGNORE INTO `roles_users` (`role_id`, `user_id`) VALUES (:role, :user_id)";
if(isset($_POST['head_of_department_check'])){
    if($_POST['head_of_department_check'] == 'on'){
    $role = 2;
    $stmt = $connect->prepare($sql_add_role);
    $stmt->bindValue(":role", 2, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $_POST['id_teacher'], PDO::PARAM_STR);
}
}
else {
    $stmt = $connect->prepare($sql_delete_role);
    $stmt->bindValue(":role", 2, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $_POST['id_teacher'], PDO::PARAM_STR);
}
$stmt->execute();
if(isset($_POST['methodologist'])){
    $role = 4;
    if($_POST['methodologist'] == 'on'){
    $role = 4;
    $stmt = $connect->prepare($sql_add_role);
    $stmt->bindValue(":role", 4, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $_POST['id_teacher'], PDO::PARAM_STR);
    }
}
else{
    $stmt = $connect->prepare($sql_delete_role);
    $stmt->bindValue(":role", 4, PDO::PARAM_STR);
    $stmt->bindValue(":user_id", $_POST['id_teacher'], PDO::PARAM_STR);
}
$stmt->execute();
$sql = "UPDATE
`users`
SET
`login` = :login,
`password` = :password,
`lastname` = :lastname,
`firstname` = :firstname,
`middlename` = :middlename
WHERE
`users`.`id_user` = :id_user";

$stmt = $connect->prepare($sql);
$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", $_POST['password'], PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->bindValue(":id_user", $_POST['id_teacher'], PDO::PARAM_INT);
$stmt->execute();
header("Location: front_table_teachers.php");