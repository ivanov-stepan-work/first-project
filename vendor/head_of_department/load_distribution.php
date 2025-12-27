<?php
require_once "../connect.php";
require_once "../functions.php";
session_start();
if (!in_array('2', $_SESSION['user']['role'])) {
    header("Location: ../../index.php");
}

$login = $_SESSION['user']['login'];
$result = $connect->query("SELECT
`users`.`id_user`,
CONCAT(
    `users`.`lastname`,
    ' ',
    `users`.`firstname`,
    ' ',
    `users`.`middlename`
) AS full_name,
`number_of_students`.`numbers_of`
FROM
`roles` 
INNER JOIN `roles_users` ON `roles`.`id_role` = `roles_users`.`role_id`
INNER JOIN `users` ON `roles_users`.`user_id` = `users`.`id_user`
INNER JOIN `department_teachers` ON `department_teachers`.`teacher_id` = `users`.`id_user`
LEFT JOIN `number_of_students` ON `number_of_students`.`teacher_id` = `department_teachers`.`teacher_id`
WHERE
`roles`.`id_role` = '3' AND `department_teachers`.`department_id` =(
SELECT
    `departments`.`id_department`
FROM
    `departments`
INNER JOIN `users` ON `departments`.`head_id` = `users`.`id_user`
WHERE
    `users`.`login` = '$login'
) ORDER BY full_name ASC");
$result = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Распределение нагрузки</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    @media screen and (max-width: 768px) {}

    body {
        font-family: Arial, sans-serif;
    }

    table {
        text-align: center;
        margin-top: 20px;
    }

    table th,
    table td {
        padding: 10px;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table td {
        border-bottom: 1px solid #ddd;
    }

    input[type="number"] {
        width: 80px;
        height: 30px;
        font-size: 14px;
    }

    input[type="submit"] {
        height: 30px;
        padding: 5px 10px;
        font-size: 14px;
        background-color: #4CAF50;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        outline: none;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    #exit {
        margin-top: 20px;
    }

    #exit input[type="submit"] {
        background-color: #ccc;
        color: #000;
    }

    #exit input[type="submit"]:hover {
        background-color: #aaa;
    }

    #alert-succes-insertion {
        position: fixed;
        top: -100px;
        /* Устанавливаем начальную позицию за пределами видимой области сверху */
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        padding: 10px;
        opacity: 0.745;
        text-align: center;
        transition: top 0.5s;
        z-index: 99;
        /* Добавляем плавную анимацию */

    }

    #alert-succes-insertion.hide {
        top: -100px;
    }

    #alert-succes-insertion.show {
        top: 0;
    }

    table {
        border-collapse: collapse;
    }

    td {
        vertical-align: middle;
    }
    </style>
</head>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/header.php';
?>

<body>
    <div class="mobile-content">
        <h1 class="text-center my-4">Распределение нагрузки</h1>

        <!-- <th>Количество студентов</th>
                    <th>Сохранить</th> -->
        <?php
        $countTeachers = 1;
foreach ($result as $element) :
    ?>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $countTeachers ?>" aria-expanded="true"
                        aria-controls="collapse<?= $countTeachers ?>">
                        <?= $element['full_name'] ?>
                    </button>
                </h2>
                <div id="collapse<?= $countTeachers ?>" class="accordion-collapse collapse"
                    aria-labelledby="heading<?= $countTeachers ?>" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="numbers_of_students_back.php"
                            class="formUpdate d-flex flex-column justify-content-center align-items-center"
                            method="post">
                            <input type="hidden" name="id" value="<?= $element['id_user'] ?>">

                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <button class="minus btn btn-outline-secondary" type="button">-</button>
                                </div>
                                <input style="box-shadow: none;" type="text" name="numbers"
                                    class="quantity form-control text-center numbers" value="<?php if (isset($element['numbers_of'])) {
                                        echo $element['numbers_of'];
                                    } ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary plus" type="button">+</button>
                                </div>
                            </div>


                            <button class="btn btn-primary" type="submit">
                                <span class="spinner-border spinner-border-sm spinnerBtn" role="status"
                                    aria-hidden="true"></span>
                                Сохранить
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $countTeachers++;
endforeach;
?>
        </tbody>

    </div>
    <div class="container desktop-content">

        <h1 class="text-center mt-4">Распределение нагрузки</h1>

        <table class="table table-bordered table-striped">

            <thead class="thead-light">
                <tr>
                    <th>ФИО преподавателя</th>
                    <th>Количество студентов</th>
                    <th>Сохранить</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $element) : ?>
                <form action="numbers_of_students_back.php" class="formUpdate" method="post">
                    <tr>
                        <input type="hidden" name="id" value="<?= $element['id_user'] ?>">
                        <td><?= $element['full_name'] ?></td>
                        <td class="justify-content-center">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="minus btn btn-outline-secondary" type="button">-</button>
                                </div>
                                <input style="box-shadow: none;" type="text" name="numbers"
                                    class="quantity form-control text-center numbers" value="<?php if (isset($element['numbers_of'])) {
                                        echo $element['numbers_of'];
                                    } ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary plus" type="button">+</button>
                                </div>
                            </div>

                        </td>
                        <td>
                            <button class="btn btn-primary" type="submit">
                                <span class="spinner-border spinner-border-sm spinnerBtn" role="status"
                                    aria-hidden="true"></span>
                                Сохранить
                            </button>
                        </td>
                    </tr>
                </form>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Недоступное количество проектов.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    Назначаемое значение недопустимо. Количество назначенных проектов превосходит устанавливаемое.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div> <!-- Закончите контейнер .container -->
    <!-- Остальной код как у вас -->
    <?php
    include_once '../notifications.php';
?>
</body>


<script src="../notifications.js"></script>
<script src="scripts/script.js">
</script>

</html>