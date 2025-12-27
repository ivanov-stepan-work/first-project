<?php
require_once "../connect.php";
session_start();
if (!in_array('3', $_SESSION['user']['role']))
    header("Location: ../../index.php");
$login = $_SESSION['user']['login'];
$id_user = $_SESSION['user']['id'];

$students = $connect->query("SELECT
`users`.`id_user`,
CONCAT(
    `users`.`lastname`,
    ' ',
    `users`.`firstname`,
    ' ',
    `users`.`middlename`
) AS full_name,
`roles`.*
FROM users
INNER JOIN roles_users ON users.id_user = roles_users.user_id
INNER JOIN roles ON roles_users.role_id = roles.id_role
WHERE `roles`.`id_role` = '5'");
$students = $students->fetchAll();

$objects = $connect->query("SELECT `objects`.* FROM `objects`
INNER JOIN `teachers_objects` ON `objects`.`id_object` = `teachers_objects`.`object_id`
INNER JOIN `users` ON `teachers_objects`.`teacher_id` = `users`.`id_user`
WHERE `users`.`id_user` = '$id_user'");
$objects = $objects->fetchAll();
$projects = $connect->query("SELECT `projects`.`id_project`, `projects`.`student_id`, `projects`.`object_id`, `projects`.`topic`, `projects`.`grade` FROM `projects` WHERE `projects`.`teacher_id` = '$id_user' ORDER BY `id_project` ASC;");
$projects = $projects->fetchAll(PDO::FETCH_ASSOC);
$left_projects = $connect->query("SELECT (SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user') - (SELECT COUNT(*) FROM `projects` WHERE `projects`.`teacher_id` = '$id_user')");
$left_projects = $left_projects->fetchColumn();

$numbers_of = $connect->query("SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user'");
$numbers_of = $numbers_of->fetchColumn();

if (!isset($_SESSION['limit_of_students']))
    $_SESSION['limit_of_students'] = null;

if (!isset($_SESSION['err_student_alredy_exist']))
    $_SESSION['err_student_alredy_exist'] = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Распределение проектов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        border: 1px solid #ccc;
    }

    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    table tr:nth-child(even) {
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

    #td_select_student select {
        width: auto;
    }

    #err_message {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    #success_message {
        color: green;
        font-weight: bold;
        margin-top: 10px;
    }

    #back_button {
        margin: 20px;
    }

    /* Добавленные стили */
    td:nth-child(4) input[type="number"] {
        width: 60px;
        text-align: center;
    }

    td:nth-child(5) input[type="submit"],
    td input[type="submit"] {
        width: 100%;
        text-align: center;
        margin: 0;
    }

    input,
    textarea,
    select {
        outline: none;
    }

    .error {
        color: red;
    }

    #alert-error-empty-topic {
        position: fixed;
        top: -100px;
        /* Устанавливаем начальную позицию за пределами видимой области сверху */
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        padding: 10px;
        text-align: center;
        transition: top 0.5s;
        /* Добавляем плавную анимацию */
    }

    /* Анимация при появлении */
    #alert-error-empty-topic.show {
        top: 0;
    }

    /* Анимация при исчезновении */
    #alert-error-empty-topic.hide {
        top: -100px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="scripts/scriptTeacher.js"></script>
</head>

<body>
    <input type="submit" value="Назад" id="back">

    <table>
        <tr>
            <td colspan="5"></td>
            <td>
                <?php
                if(is_null($left_projects)) {
                    echo "<p class=\"error\">Вам ещё не определили число проектов.</p>";
                    die;
                }
                else if ($left_projects == 0) echo "Все проекты назначены";
                else if ($left_projects > 0) echo "Осталось проектов: " . $left_projects;
                else echo "<p class=\"error\">Вы назначили " . abs($left_projects) . " лишних проекта, удалите лишние.</p>";
                

                ?>
            </td>
        </tr>
        <?php if ($left_projects != $numbers_of) : ?>
        <tr>
            <th>Студент</th>
            <th>Дисциплина</th>
            <th>Тема</th>
            <th>Оценка</th>
            <th>Сохранить</th>
            <th>Удалить</th>
        </tr>
        <?php
            foreach ($projects as $project) :
            ?>

        <form action="distribution_of_projects_back.php" method="post">
            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
            <input type="hidden" name="old_student" value="<?= $project['student_id'] ?>">
            <tr>
                <td id="td_select_student">
                    <select name="select_student">
                        <?php foreach ($students as $student) : ?>
                        <option value="<?= $student['id_user'] ?>"
                            <?= ($student['id_user'] == $project['student_id']) ? 'selected' : '' ?>>
                            <?= $student['full_name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="select_object">
                        <?php foreach ($objects as $object) : ?>
                        <option value="<?= $object['id_object'] ?>"
                            <?= ($object['id_object'] == $project['object_id']) ? 'selected' : '' ?>>
                            <?= $object['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <textarea name="topic" cols="30" rows="5"><?= $project['topic'] ?></textarea>
                </td>
                <td>
                    <?php
                            if ($project['grade'] == 0) :
                            ?>
                    <input type="number" name="grade" value="" min="1" max="5">
                    <?php
                            else :
                            ?>
                    <input type="number" name="grade" value="<?= $project['grade'] ?>" min="1" max="5">
                    <?php
                            endif;
                            ?>
                </td>
                <td>
                    <input type="submit" value="Сохранить">
                </td>

        </form>
        <form action="distribution_of_projects_delete.php" method="post">
            <input type="hidden" name="id_project" value="<?= $project['id_project'] ?>">
            <td>
                <input type="submit" value="Удалить">
            </td>
        </form>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <?php
    $check_limit = $connect->query("SELECT (SELECT COUNT(*) FROM `projects` WHERE `projects`.`teacher_id` = '$id_user') >= (SELECT `number_of_students`.`numbers_of` FROM `number_of_students` WHERE `number_of_students`.`teacher_id` = '$id_user')");
    $check_limit = $check_limit->fetchColumn();
    if (!$check_limit) : ?>
    <form action="distribution_of_projects_create_new.php" class="formAdd" method="post">
        <table>
            <tr>
                <th colspan="3">Добавить проект</th>
            </tr>
            <tr>
                <th>Студент</th>
                <th>Дисциплина</th>
                <th>Тема</th>
            </tr>
            <tr>
                <td>
                    <select name="select_student">
                        <?php foreach ($students as $student) : ?>
                        <option value="<?= $student['id_user'] ?>"><?= $student['full_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="select_object">
                        <?php foreach ($objects as $object) : ?>
                        <option value="<?= $object['id_object'] ?>"><?= $object['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <textarea name="topic" cols="30" rows="5" class="topic"></textarea>
                </td>
            </tr>
            <tr>
                <th class="text-center" colspan="3">
                    <input type="submit" id="addButton" value="Добавить"
                        <?php if ($left_projects == 0) echo 'disabled'; ?>>
                </th>
            </tr>
        </table>
    </form>
    <?php endif; ?>

    <?php if ($_SESSION['err_student_alredy_exist']) : ?>
    <div id="err_message">
        <?= $_SESSION['err_student_alredy_exist'] ?>
        <?php
            $_SESSION['err_student_alredy_exist'] = null;
            ?>
    </div>
    <?php endif; ?>

    <?php if ($_SESSION['limit_of_students']) : ?>
    <div id="err_message">
        <?= $_SESSION['limit_of_students'] ?>
    </div>
    <?php endif; ?>


    <div id="alert-error-empty-topic" class="alert alert-danger hide" role="alert"></div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>


</html>