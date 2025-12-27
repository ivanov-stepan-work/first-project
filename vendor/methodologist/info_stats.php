<?php

session_start();
require_once "../connect.php";
if (!(in_array('4', $_SESSION['user']['role']) || in_array('1', $_SESSION['user']['role']))) {
    header("Location: ../../index.php");
}


$student_without_proj = "SELECT groups.name AS group_name, CONCAT(users.lastname, ' ', users.firstname, ' ', users.middlename) AS full_name
FROM users
JOIN student_groups ON users.id_user = student_groups.student_id
JOIN groups ON student_groups.group_id = groups.id_group
LEFT JOIN projects ON users.id_user = projects.student_id
WHERE projects.id_project IS NULL
ORDER BY groups.name, users.lastname, users.firstname, users.middlename";

// Подготовка запроса
$stmt_student_without_proj = $connect->prepare($student_without_proj);
// Выполнение запроса
$stmt_student_without_proj->execute();

// Создание массива для хранения данных
$data = array();
// Получение результатов
while($row = $stmt_student_without_proj->fetch(PDO::FETCH_ASSOC)) {
    $group_name = $row["group_name"];
    $full_name = $row["full_name"];

    // Добавление студента в группу в массив
    $data[$group_name][] = $full_name;
}


$sql = "SELECT
(
SELECT
COUNT(*)
FROM
`projects`
) AS projects,
(
SELECT
COUNT(*)
FROM `groups`
INNER JOIN `student_groups` ON `student_groups`.`group_id` = `groups`.`id_group`
INNER JOIN `users` ON 	`users`.`id_user` = `student_groups`.`student_id`
INNER JOIN `roles_users` ON `roles_users`.`user_id` = `users`.`id_user`
INNER JOIN `roles` ON `roles_users`.`role_id` = `roles`.`id_role`
WHERE `roles`.`id_role` = '5'
) AS students";
$result = $connect->query($sql);
$result = $result->fetchAll(PDO::FETCH_ASSOC)[0];

$hodStats = $connect->query("SELECT 
U.id_user, 
CONCAT(U.lastname, ' ', U.firstname, ' ', U.middlename) AS full_name, 
COUNT(DISTINCT N.teacher_id) AS total_teachers_with_students,
COUNT(DISTINCT DT.teacher_id) AS total_teachers 
FROM users U 
INNER JOIN roles_users RU ON RU.user_id = U.id_user 
INNER JOIN roles R ON RU.role_id = R.id_role 
LEFT JOIN departments D ON D.head_id = U.id_user 
LEFT JOIN department_teachers DT ON DT.department_id = D.id_department 
LEFT JOIN number_of_students N ON N.teacher_id = DT.teacher_id AND N.numbers_of IS NOT NULL AND N.numbers_of <> 0
WHERE R.id_role = 2 
GROUP BY U.id_user;
ORDER BY full_name ASC
");
$hodStats = $hodStats->fetchAll(PDO::FETCH_ASSOC);
$teacherStats = $connect->query("SELECT
U.`id_user`,
CONCAT(
    U.`lastname`,
    ' ',
    U.`firstname`,
    ' ',
    U.`middlename`
) AS full_name,
COUNT(DISTINCT P.`id_project`) AS distributed_projects_count,
N.`numbers_of` AS total_students, D.`name` as department
FROM `departments` AS D
INNER JOIN `department_teachers` AS DT ON DT.`department_id` = D.`id_department` 
INNER JOIN `users` AS U ON DT.`teacher_id` = U.`id_user`
INNER JOIN `roles_users` AS RU ON RU.`user_id` = U.`id_user`
INNER JOIN `roles` AS R ON RU.`role_id` = R.`id_role`
LEFT JOIN `projects` AS P ON P.`teacher_id` = U.`id_user`
LEFT JOIN `number_of_students` AS N ON N.`teacher_id` = U.`id_user`
WHERE R.`id_role` = '3'
AND N.`numbers_of` IS NOT NULL
AND N.`numbers_of` <> 0
GROUP BY U.`id_user`, N.`numbers_of`
ORDER BY full_name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Общий отчёт</title>
    <style>
    * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    }

    .bg-danger-custom {
        background-color: rgba(255, 0, 0, 0.1) !important;
    }

    .bg-success-custom {
        background-color: rgba(0, 255, 0, 0.1) !important;
    }

    .accordion-button:not(.collapsed) {
        color: #000 !important;
    }
    </style>
</head>

<body style="background-color: #f2f2f2;">
    <?php
    include '../header.php';
?>
    <div class="desktop-content">
        <p class="text-center text-success">Количество назначенных проектов: <?= $result['projects']?></p>
        <p class="text-center text-danger mb-4">Количество оставшихся
            проектов: <?= $result['students'] - $result['projects']?>
        </p>
        <div class="accordion d-flex flex-column align-items-center">
            <p class="d-flex flex-column w-25 align-items-center justify-content-center">
                <button class="btn btn-primary mx-4 mb-4 w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#teacherStats" aria-expanded="false" aria-controls="teacherStats">
                    Отчет по преподавателям
                </button>
                <button class="btn btn-primary mx-4 mb-4 w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#SWPStats" aria-expanded="false" aria-controls="teacherStats">
                    Отчет по студентам
                </button>
                <button class="reportCurator btn btn-primary mx-4 mb-4 w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="" aria-expanded="false" aria-controls="teacherStats">
                    Отчет для кураторов
                </button>
            </p>
            <div class="collapse w-50 text-center" id="SWPStats" data-bs-parent=".accordion">
                <h2 class="text-center">Студенты без проектов</h2>
                <div class="card card-body">
                    <?php
                    $count = 0;
foreach($data as $group_name => $students):
    ?>
                    <div class="accordion" id="accordionHODStats">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingHODStats">
                                <button class="accordion-button collapsed text-danger" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseHODStats<?= $count?>"
                                    aria-expanded="false" aria-controls="collapseHODStats">
                                    <?= $group_name?>
                                </button>
                            </h2>
                            <div id="collapseHODStats<?= $count?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ФИО Студента</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
foreach($students as $student):
    ?>
                                            <tr>
                                                <td><?= $student?></td>
                                            </tr>
                                            <?php
endforeach;
    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $count++;
endforeach;
?>
                </div>
            </div>
            <div class="collapse w-100" id="teacherStats" data-bs-parent=".accordion">
                <h2 class="text-center">Отчет по преподавателям</h2>
                <div class="card card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">ФИО преподавателя</th>
                                <th class="text-center" scope="col">Распределенные проекты/Общее количество проектов
                                </th>
                                <th class="text-center" scope="col">Кафедра</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
   foreach ($teacherStats as $teacherStat):
       ?>
                            <tr class="<?php if($teacherStat['distributed_projects_count'] == $teacherStat['total_students'] && $teacherStat['distributed_projects_count'] != 0) {
                                echo 'bg-success-custom text-success';
                            } else {
                                echo 'bg-danger-custom text-danger';
                            }?>">
                                <td class="text-center"><?= $teacherStat['full_name']?></td>
                                <td class="text-center">
                                    <?= $teacherStat['distributed_projects_count'] . '/' . $teacherStat['total_students']?>
                                </td>
                                <td class="text-center">
                                    <?= $teacherStat['department']?>
                                </td>
                            </tr>
                            <?php
   endforeach;
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="mobile-content">
        <p class="text-center text-success">Количество назначенных проектов: <?= $result['projects']?></p>
        <p class="text-center text-danger mb-4">Количество оставшихся
            проектов: <?= $result['students'] - $result['projects']?>
        </p>
        <div class="accordion d-flex flex-column align-items-center">
            <p class="d-flex flex-column w-50 align-items-center justify-content-center">
                <button class="btn btn-primary mx-4 mb-4 w-100 d-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#HODStats" aria-expanded="false" aria-controls="HODStats">
                    Статистика по заведующим кафедрой
                </button>
                <button class="btn btn-primary mx-4 mb-4 w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#teacherStats" aria-expanded="false" aria-controls="teacherStats">
                    Отчет по преподавателям
                </button>
                <button class="reportCurator btn btn-primary mx-4 mb-4 w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="" aria-expanded="false" aria-controls="teacherStats">
                    Отчет для кураторов
                </button>
            </p>


            <div class="collapse w-100" id="HODStats" data-bs-parent=".accordion">
                <div class="card card-body">
                    <?php
                    $count = 0;
foreach ($hodStats as $hodStat):
    ?>

                    <div class="accordion <?php if($hodStat['total_teachers_with_students'] == $hodStat['total_teachers']) {
                        echo 'text-success';
                    } else {
                        echo 'text-danger';
                    }?>" id="accordionHODStats">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingHODStats">
                                <button class="accordion-button collapsed <?php if($hodStat['total_teachers_with_students'] == $hodStat['total_teachers']) {
                                    echo 'text-success';
                                } else {
                                    echo 'text-danger';
                                }?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseHODStats<?= $count?>" aria-expanded="false"
                                    aria-controls="collapseHODStats">
                                    <?= $hodStat['full_name']?>
                                </button>
                            </h2>
                            <div id="collapseHODStats<?= $count?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Количество преподавателей с нагрузкой:
                                        <?= $hodStat['total_teachers_with_students']?></p>
                                    <p>Количество преподавателей без нагрузки: <?= $hodStat['total_teachers']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                                $count++;
endforeach;
?>
                </div>
            </div>
            <div class="collapse w-100" id="teacherStats" data-bs-parent=".accordion">
                <div class="card card-body">
                    <?php
                            $count = 0;
foreach ($teacherStats as $teacherStat):
    ?>
                    <div class="accordion mb-1" id="accordionHODStats">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingHODStats">
                                <button class="accordion-button collapsed <?php if($teacherStat['distributed_projects_count'] == $teacherStat['total_students']) {
                                    echo 'bg-success-custom';
                                } else {
                                    echo 'bg-danger-custom';
                                }?>" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseHODStats<?= $count?>" aria-expanded="false"
                                    aria-controls="collapseHODStats">
                                    <?= $teacherStat['full_name']?>
                                </button>
                            </h2>
                            <div id="collapseHODStats<?= $count?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Распределенные проекты:
                                        <span
                                            class="<?php if($teacherStat['distributed_projects_count'] == $teacherStat['total_students']) {
                                                echo 'text-success';
                                            } else {
                                                echo 'text-danger';
                                            }?>"><?= $teacherStat['distributed_projects_count'] . "/" . $teacherStat['total_students']?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                                                        $count++;
endforeach;
?>
                </div>
            </div>
        </div>
    </div>
    <?php
include_once '../notifications.php';
?>

</body>
<script src="scripts/script.js"></script>
<script src="../notifications.js"></script>

</html>