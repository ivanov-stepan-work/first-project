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
    `roles`.`id_role` = '5'
) = COUNT(`student_groups`.`student_id`) AS check_add
FROM
`student_groups`";
$check_add = $connect->query($sql_check_add)->fetchAll()[0][0];
echo $check_add;