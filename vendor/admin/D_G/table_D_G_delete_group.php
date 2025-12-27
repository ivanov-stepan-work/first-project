<?php

require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role'])) {
    header("Location:../../../index.php");
}
$id_group = $_POST['select_group_delete'];
$sql = "UPDATE `groups` SET `dep_id`= NULL WHERE `id_group` = '$id_group'";
$connect->exec($sql);
header("Location:front_table_D_T.php");
