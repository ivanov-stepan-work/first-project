<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");

$sql_check_add = "SELECT
(
SELECT
    COUNT(`users`.`id_user`)
FROM
    `users`
    INNER JOIN `roles_users` ON `roles_users`.`user_id` = `users`.`id_user`
    INNER JOIN `roles` ON `roles_users`.`role_id` = `roles`.`id_role`
WHERE
    `roles`.`id_role` = '3'
) = COUNT(`department_teachers`.`teacher_id`) AS check_add
FROM
`department_teachers`";
$check_add = $connect->query($sql_check_add)->fetchAll()[0][0];
echo $check_add;