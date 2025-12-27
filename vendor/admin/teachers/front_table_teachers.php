<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "SELECT users.id_user,
users.login,
users.password,
users.lastname,
users.firstname,
users.middlename,
GROUP_CONCAT(roles.id_role SEPARATOR ', ') AS user_roles
FROM users
INNER JOIN roles_users ON users.id_user = roles_users.user_id
INNER JOIN roles ON roles_users.role_id = roles.id_role
WHERE `roles`.`id_role` = '3' OR `roles`.`id_role` = '2' OR `roles`.`id_role` = '4'
GROUP BY users.id_user
";
$students = $connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
if(!array_key_exists('error_login_exists', $_SESSION))
$_SESSION['error_login_exists'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Table</title>
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

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box; /* Учесть границы в общей ширине элемента */
        }

        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            outline: none;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
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
            cursor: pointer;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<a href="../../../index.php" class="button">Назад</a>
<a id="printTeachers" class="button">Печать</a>
    <table>
        <tr>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Зав. кафедрой</th>
            <th>Методист</th>
            <th>Сохранить</th>
            <th>Удалить</th>
        </tr>
        <?php foreach ($students as $student): 
            ?>
            <form class="formUpdate" action="table_teacher_update.php" method="post">
                <input type="hidden" name="id_teacher" value="<?= $student['id_user'] ?>">
                <tr>
                    <td><input type="text" name="login" value="<?= $student['login'] ?>"></td>
                    <td><input type="text" name="password" value="<?= $student['password'] ?>"></td>
                    <td><input type="text" name="lastname" value="<?= $student['lastname'] ?>"></td>
                    <td><input type="text" name="firstname" value="<?= $student['firstname'] ?>"></td>
                    <td><input type="text" name="middlename" value="<?= $student['middlename'] ?>"></td>
                    <td><input type="checkbox" id="head_of_department_check" name="head_of_department_check" <?php if(stristr($student['user_roles'], '2')) echo 'checked'; ?>></td>
                    <td><input type="checkbox" id="methodologist" name="methodologist" <?php if(stristr($student['user_roles'], '4')) echo 'checked'; ?>></td>
                    <td><input type="submit" value="Сохранить"></td>
                
            </form>
            <form action="table_teacher_delete.php" method="post">
            <input type="hidden" name="id_teacher" value="<?= $student['id_user']?>">
            <td>    <input type="submit" value="Удалить">    </td>
            </form>
            </tr>
        <?php endforeach; ?>
    </table>
    <table>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Добавить</th>
        </tr>
        <form class="formAdd" action="table_teacher_add.php" method="post">
            <tr>
            <td><input type="text" name="lastname" value=""></td>
                <td><input type="text" name="firstname" value=""></td>
                <td><input type="text" name="middlename" value=""></td>
                <td><input type="submit" value="Добавить"></td>
                <input type="hidden" name="login">
            </tr>
        </form>
    </table>
    <?php if($_SESSION['error_login_exists']):?>
    <div class="error">Пользователь с таким логином уже существует</div>
    <?php
    $_SESSION['error_login_exists'] = 0;
    endif;
    ?>
</body>
<?php
include_once '../../notifications.php';
?>
<script src="../../notifications.js"></script>
<script src="../script.js"></script>
</html>
