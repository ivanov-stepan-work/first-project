<?php
session_start();
require_once "../connect.php";
if (!in_array('3', $_SESSION['user']['role'])) {
    header("Location: ../../index.php");
}
$login = $_SESSION['user']['login'];
$id_user = $_SESSION['user']['id'];
include '../notifications.php';

$students = $connect->query("SELECT
u.id_user,
CONCAT(u.lastname, ' ', u.firstname, ' ', u.middlename) AS full_name,
r.*
FROM
groups g
INNER JOIN
student_groups sg ON sg.group_id = g.id_group
INNER JOIN
users u ON sg.student_id = u.id_user
INNER JOIN
roles_users ru ON u.id_user = ru.user_id
INNER JOIN
roles r ON ru.role_id = r.id_role
WHERE
r.id_role = '5'
ORDER BY
full_name ASC;
")->fetchAll(PDO::FETCH_ASSOC);
$students_name_id = $students;
function getFullNameById($id, $students)
{
    foreach ($students as $student) {
        if ($student['id_user'] == $id) {
            return $student['full_name'];
        }
    }
    return null;
}

$objects = $connect->query("SELECT `objects`.* FROM `objects`
INNER JOIN `teachers_objects` ON `objects`.`id_object` = `teachers_objects`.`object_id`
INNER JOIN `users` ON `teachers_objects`.`teacher_id` = `users`.`id_user`
WHERE `users`.`id_user` = '$id_user'");
$objects = $objects->fetchAll();
$groups = $connect->query("SELECT G.* FROM `groups` as G ORDER BY G.`name` ASC")->fetchAll(PDO::FETCH_ASSOC);
$projects = $connect->query("SELECT
p.id_project,
p.student_id,
g.name name_group,
p.object_id,
p.topic,
p.grade
FROM
projects p
INNER JOIN student_groups sg ON
sg.student_id = p.student_id
INNER JOIN groups g ON
g.id_group = sg.group_id
WHERE
p.teacher_id = '$id_user'
ORDER BY
g.name ASC;");
$projects = $projects->fetchAll(PDO::FETCH_ASSOC);
$left_projects = $connect->query("SELECT (SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user') - (SELECT COUNT(*) FROM `projects` WHERE `projects`.`teacher_id` = '$id_user')");
$left_projects = $left_projects->fetchColumn();

$numbers_of = $connect->query("SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user'");
$numbers_of = $numbers_of->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Распределение проектов</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .table {
        margin-bottom: 20px;
    }

    .input-group {
        margin: 5px 0;
    }

    .error {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    .success {
        color: green;
        font-weight: bold;
        margin-top: 10px;
    }

    /* Добавленные стили */
    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table th,
    .table td {
        padding: 10px;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    select,
    textarea,
    input[type="number"] {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #4CAF50;
        border: none;
        color: white;
        cursor: pointer;
        border-radius: 5px;
        outline: none;
        font-size: 14px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    table {
        text-align: center;
    }

    td {
        vertical-align: middle;
    }

    .btn-primary {
        background-color: #0d6efd !important;
    }

    hr::after {
        margin-bottom: 10vh;
        content: '';
    }

    .red-border {

        border: 1px solid red !important;

    }

    textarea {
        border-bottom-color: #ced4da !important;
    }

    textarea [name=topic] {
        width: auto !important;
    }

    optgroup {
        background-color: #e0e0e0;
        /* Цвет фона */
        font-weight: bold;
        /* Жирный шрифт */
        padding: 8px;
        /* Внутренний отступ */
    }
    </style>
</head>

<body>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/header.php';
?>
    <div class="text-center">
        <?php if ($left_projects == 0) : ?>
        <p class="text-success">Все проекты назначены</p>
        <?php elseif ($left_projects > 0) : ?>
        <p class="text-info">Осталось проектов: <?= $left_projects ?></p>
        <?php else : ?>
        <p class="text-danger">Вы назначили <?= abs($left_projects) ?> лишних проектов, удалите лишние.</p>
        <?php endif; ?>
    </div>
    <div class="mobile-content">
        <?php
    $countProjects = 1;
foreach ($projects as $project) :
    ?>
        <div class="accordion" id="accordionExample<?= $countProjects ?>">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $countProjects ?>">
                    <button class="accordion-button collapsed headAccordion " type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $countProjects ?>" aria-expanded="true"
                        aria-controls="collapse<?= $countProjects ?>">
                        <span class="text-primary col-3 text-end pe-4">[<?= $project['name_group']?>]</span>
                        <span class="col"><?= getFullNameById($project['student_id'], $students_name_id) ?></span>
                    </button>
                </h2>

                <div id="collapse<?= $countProjects ?>" class="accordion-collapse collapse"
                    aria-labelledby="heading<?= $countProjects ?>"
                    data-bs-parent="#accordionExample<?= $countProjects ?>">
                    <div class="accordion-body d-flex align-items-center flex-column">
                        <form class="formUpdate d-flex align-items-center flex-column"
                            action="distribution_of_projects_back.php" method="post">
                            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
                            <input type="hidden" name="old_student" value="<?= $project['student_id'] ?>">
                            <label for="select_object" class="form-label w-100 mt-4">Изменение дисциплины:</label>
                            <select name="select_object" class="form-select mb-4">
                                <?php foreach ($objects as $object) : ?>
                                <option value="<?= $object['id_object'] ?>"
                                    <?= ($object['id_object'] == $project['object_id']) ? 'selected' : '' ?>>
                                    <?= $object['name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="topic" class="form-label">Изменение темы:</label>
                            <textarea name="topic" id="topic" class="form-control w-100 mb-4"
                                rows="3"><?= $project['topic'] ?></textarea>
                            <label for="grade" class="form-label">Изменение оценки:</label>
                            <input type="number" id="grade" name="grade" class="form-control mb-4" min="1" max="5"
                                value="<?php if ($project['grade']) {
                                    echo $project['grade'];
                                } ?>">
                            <button class="btn btn-primary mb-5" type="submit">
                                <span class="spinner-border spinner-border-sm spinnerBtn" role="status"
                                    aria-hidden="true"></span>
                                Сохранить
                            </button>
                        </form>

                        <form action="distribution_of_projects_delete.php" class="formDel" method="post">
                            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
                            <button type="submit" class="btn btn-primary mt-5 delBtn">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $countProjects++;
endforeach;
?>
        <?php if ($left_projects != 0) : ?>
        <hr>
        <form action="distribution_of_projects_create_new.php" class="formAdd mt-4 " method="post">
            <h2 class="text-center mb-2">Добавить проект</h2>
            <div class="d-flex flex-column align-items-center">
                <select name="select_student" class="form-select mb-4 w-75">
                    <?php foreach ($groups as $group) :
                        $students = $connect->query("SELECT
                                    u.id_user,
                                    CONCAT(u.lastname, ' ', u.firstname, ' ', u.middlename) AS full_name,
                                    r.*
                                    FROM
                                    groups g
                                    INNER JOIN
                                    student_groups sg ON sg.group_id = g.id_group
                                    INNER JOIN
                                    users u ON sg.student_id = u.id_user
                                    INNER JOIN
                                    roles_users ru ON u.id_user = ru.user_id
                                    INNER JOIN
                                    roles r ON ru.role_id = r.id_role
                                    WHERE
                                    r.id_role = '5' AND g.id_group = '" . $group['id_group'] . "'
                                    AND u.id_user NOT IN (SELECT p.`student_id` FROM `projects` AS p)
                                    ORDER BY
                                    full_name ASC;
                                        ")->fetchAll(PDO::FETCH_ASSOC);?>
                    <optgroup label="<?= $group['name'] ?>"></optgroup>
                    <?php
                        foreach ($students as $student):
                            ?>

                    <option value="<?= $student['id_user'] ?>">
                        <?= $student['full_name']?>
                    </option>
                    <?php
                        endforeach;
                    endforeach; ?>
                </select>
                <select name="select_object" class="form-select mb-4 w-75">
                    <?php foreach ($objects as $object) : ?>
                    <option value="<?= $object['id_object'] ?>"><?= $object['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea id="addTxtArea" name="topic" class="form-control mb-4 w-75" rows="3"></textarea>
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary mb-4" <?php if ($left_projects == 0) {
                        echo 'disabled';
                    } ?>>Добавить</button>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>



    </div>
    <div class="desktop-content">
        <div class="container mt-4">
            <h1 class="text-center">Распределение проектов</h1>

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Студент</th>
                        <th>Группа</th>
                        <th>Дисциплина</th>
                        <th class="topic">Тема</th>
                        <th>Оценка</th>
                        <th>Сохранить</th>
                        <th>Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project) : ?>
                    <tr>
                        <form class="formUpdate" action="distribution_of_projects_back.php" method="post">
                            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
                            <input type="hidden" name="old_student" value="<?= $project['student_id'] ?>">
                            <td>
                                <?= getFullNameById($project['student_id'], $students_name_id)?>
                            </td>
                            <td>
                                <?= $project['name_group']?>
                            </td>
                            <td>
                                <select name="select_object" class="form-select">
                                    <?php foreach ($objects as $object) : ?>
                                    <option value="<?= $object['id_object'] ?>"
                                        <?= ($object['id_object'] == $project['object_id']) ? 'selected' : '' ?>>
                                        <?= $object['name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <textarea name="topic" style="width: auto;" class="form-control"
                                    rows="3"><?= $project['topic'] ?></textarea>
                            </td>
                            <td>
                                <input type="number" name="grade" class="form-control" min="1" max="5" value="<?php if ($project['grade']) {
                                    echo $project['grade'];
                                } ?>">
                            </td>
                            <td>
                                <button class="btn btn-primary" type="submit">
                                    <span class="spinner-border spinner-border-sm spinnerBtn" role="status"
                                        aria-hidden="true"></span>
                                    Сохранить
                                </button>
                            </td>
                        </form>
                        <form action="distribution_of_projects_delete.php" class="formDel" method="post">
                            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
                            <td>
                                <button type="submit" class="btn btn-primary delBtn">Удалить</button>
                            </td>
                        </form>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if ($left_projects != 0) : ?>
            <hr>
            <form action="distribution_of_projects_create_new.php" class="formAdd" method="post">
                <div class="table">
                    <h2 class="text-center">Добавить проект</h2>
                    <div class="row d-flex align-items-center">
                        <div class="col-4">
                            <select name="select_student" class="form-select">
                                <?php foreach ($groups as $group) :
                                    $students = $connect->query("SELECT
                                    u.id_user,
                                    CONCAT(u.lastname, ' ', u.firstname, ' ', u.middlename) AS full_name,
                                    r.*
                                    FROM
                                    groups g
                                    INNER JOIN
                                    student_groups sg ON sg.group_id = g.id_group
                                    INNER JOIN
                                    users u ON sg.student_id = u.id_user
                                    INNER JOIN
                                    roles_users ru ON u.id_user = ru.user_id
                                    INNER JOIN
                                    roles r ON ru.role_id = r.id_role
                                    WHERE
                                    r.id_role = '5' AND g.id_group = '" . $group['id_group'] . "'
                                    AND u.id_user NOT IN (SELECT p.`student_id` FROM `projects` AS p)
                                    ORDER BY
                                    full_name ASC;
                                        ")->fetchAll(PDO::FETCH_ASSOC);?>
                                <optgroup label="<?= $group['name'] ?>"></optgroup>
                                <?php
                                    foreach ($students as $student):
                                        ?>

                                <option value="<?= $student['id_user'] ?>">
                                    <?= $student['full_name']?>
                                </option>
                                <?php
                                    endforeach;
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="select_object" class="form-select">
                                <?php foreach ($objects as $object) : ?>
                                <option value="<?= $object['id_object'] ?>"><?= $object['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <textarea id="addTxtArea" name="topic" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" <?php if ($left_projects == 0) {
                                echo 'disabled';
                            } ?>>Добавить</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../notifications.js"></script>
    <script src="scripts/scriptTeacher.js"></script>
</body>

</html>