<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$sql = "SELECT * FROM `roles`";
$roles = $connect->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 200px;
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
            font-size: 15pt;
            box-sizing: border-box;
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
    </style>
</head>
<body>
    <a href="../../../index.php" class="button">Назад</a>
    <table>
        <tr>
            <th>Наименование роли</th>
            <th>Сохранить</th>
            <th>Удалить</th>
        </tr>
        <?php foreach ($roles as $role): ?>
            <form action="table_roles_update.php" method="post">
                <input type="hidden" name="id_role" value="<?= $role['id_role'] ?>">
                <tr>
                    <td>   <input type="text" name="role_name" value="<?= $role['name'] ?>">   </td>
                    <td>   <input type="submit" value="Сохранить">    </td>
            </form>
            <form action="table_roles_delete.php" method="post">
                <input type="hidden" name="id_role" value="<?= $role['id_role'] ?>">
                <td>    <input type="submit" value="Удалить">    </td>
            </form>
                </tr>
        <?php endforeach; ?>
    </table>
    <table>
        <tr>
            <th>Наименование роли</th>
            <th>Добавить</th>
        </tr>
        <form action="table_roles_add.php" method="post">
            <tr>
                <td>   <input type="text" name="role_name" value="">   </td>
                <td>   <input type="submit" value="Добавить">    </td>
                <td>    <input type="submit" value="Удалить" style="visibility: hidden;">    </td>
            </tr>
        </form>
    </table>
</body>
</html>
