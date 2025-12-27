<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "SELECT * FROM `departments`";
$departments = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department-Teacher Table</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table th,
    table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    table tr:last-child td {
        border-bottom: none;
    }

    select {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }

    input[type="submit"],
    button {
        background-color: #4CAF50;
        border: none;
        color: white;
        cursor: pointer;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        outline: none;
    }

    input[type="submit"]:hover,
    button {
        background-color: #45a049;
    }

    a.button {
        display: inline-block;
        padding: 8px 16px;
        text-decoration: none;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        font-weight: bold;
        margin: 20px;
    }

    a.button:hover {
        background-color: #0069d9;
    }

    input,
    select {
        outline: none;
    }

    #addButton {
        margin-top: 10px;
    }

    #deleteButton {
        margin: 0px;
        width: 90%;
    }

    .selectData {
        width: 30%;
    }
    </style>
</head>

<body>
    <a href="../../../index.php" class="button">Назад</a>
    <table>
        <tr>
            <th>Наименование кафедры</th>
            <th style="width: 200px;">Преподаватели</th>
            <th>Удалить</th>
            <th>Добавить</th>
        </tr>
        <?php foreach ($departments as $department): ?>
        <tr>
            <form action="table_D_T_delete_teacher.php" method="post">
                <input type="hidden" name="id_department" value="<?= $department['id_department'] ?>">
                <td><?= $department['name'] ?></td>
                <td class="selectData">
                    <select name="select_teacher_delete" class="selectTeacherDel" size="7">
                        <?php
                            $teachers = $connect->query("SELECT * FROM `groups` WHERE `dep_id` = " . $department['id_department'])->fetchAll();
                            foreach ($teachers as $teacher):
                                ?>
                        <option value="<?= $teacher['id_user'] ?>"><?= $teacher['full_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><button type="button" class="delButton ">Удалить</button></td>
            </form>
            <form action="table_D_T_add_teacher.php" id="addForm" method="post">
                <input type="hidden" name="id_department" value="<?= $department['id_department'] ?>">
                <td class="selectData">
                    <select name="select_teacher_add" class="selectTeacherAdd">
                        <?php
                            $teachers = $connect->query("SELECT
                            `users`.`id_user`,
                            CONCAT(
                                `users`.`lastname`,
                                ' ',
                                LEFT(`users`.`firstname`, 1),
                                '. ',
                                LEFT(`users`.`middlename`, 1),
                                '.'
                            ) AS full_name
                        FROM
                            `users`
                            INNER JOIN `roles_users` ON `roles_users`.`user_id` = `users`.`id_user`
                            INNER JOIN `roles` ON `roles_users`.`role_id` = `roles`.`id_role`
                        WHERE
                            `users`.`id_user` NOT IN (
                                SELECT `department_teachers`.`teacher_id`
                                FROM `department_teachers`
                            ) AND `roles`.`id_role` = '3'")->fetchAll();
                            foreach ($teachers as $teacher):
                                ?>
                        <option value="<?= $teacher['id_user'] ?>"><?= $teacher['full_name'] ?></option>
                        <?php endforeach; ?>
                    </select><br>
                    <button type="button" class="addButton">Добавить</button>
                </td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="scripts/script.js">
    </script>
</body>

</html>