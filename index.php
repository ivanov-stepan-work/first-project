<?php
// Начало сессии
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <title>ИРКПО - ИПС</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <style>
    body {
        font-family: Arial, sans-serif;
        
        background-color: #f2f2f;
        margin: 0;
        padding: 0;
    }

    form {
        margin-bottom: 20px;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #ffffff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .button-link {
        display: inline-block;
        margin-bottom: 10px;
    }

    .button-link a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #065fd4;
        color: #ffffff;
        text-decoration: none;
        border-radius: 3px;
    }

    table {
        width: 80%;
        border-collapse: collapse;
        /*margin-top: 20px;*/
    }

    th {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    } 
    td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    .no-project-message {
        color: red;
        margin-top: 10px;
    }

    .buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .buttons .btn {
        margin-bottom: 5px;
    }

    .empty {
        width: 50px;
        height: 50px;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }

    h1 {
        font-size: 250%;
    }

     strong, abbr{
        font-size: 12px;
        font-family: "Segoe UI";
    }
    
    h2 {
        font-size: 24px;
        font-family: "Segoe UI";
        font-weight: 300!important;
        margin-bottom: 6px;
    }
    
    .lead {
        font-size: 15px;
        font-family: "Segoe UI";
        font-weight: 300!important;
        margin-bottom: 12px;
    }
    
    .addres{
        line-height: 1em;
    }
    img {
        /*max-width: 40vh;*/
        max-height: 32vh;
    }

    #bg1 {
        max-width: 200%;
        max-height: 40vh;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 2;
        opacity: 0.3;
    }

    #bg2 {
        max-width: 200%;
        max-height: 40vh;
        position: fixed;
        left: 0;
        bottom: 0;
        z-index: 2;
        opacity: 0.3;
    }

    @media (max-width: 1024px) {
        .welcome::before {
            display: none;
        }

        .welcome::after {
            display: none;
        }
    }
    @media (max-width: 650px) {
        .welcome{
            
            background: #00A1DB !important;
        }
        img {
        max-width: 100%;
        max-height: 30vh;
    }
    .text{
        font-size: 120%;
    }
    }
    @media (min-width: 650px) and (max-width: 1024px) {
        .welcome {
            background: #00A1DB !important;
            
        }
        img {
        max-width: 100%;
        max-height: 30vh;
    }
    .text{
        font-size: 150%;
    }
        
    }
   

    .welcome::before {
        z-index: -1;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40vh;
        height: 40vh;
        background-image: url('img/bg2.png');
        content: '';
        background-size: 100% 100%;
        opacity: 0.5;
    }

    .welcome::after {
        z-index: -1;
        position: absolute;
        top: 0;
        right: 0;
        width: 40vh;
        height: 40vh;
        background-image: url('img/bg1.png');
        content: '';
        background-size: 100% 100%;
        opacity: 0.5;
    }

    .centerButtons {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        z-index: -1;
    }

    .btn-group-vertical .btn {
        padding: 20px 40px;
        /* Настройте размер кнопок по вашему усмотрению */
        font-size: 18px;
        /* Установите желаемый размер шрифта */
        margin-bottom: 10px;
        /* Добавьте отступ между кнопками */
    }

    .bi-arrow-right-circle-fill {
        color: #fff;
        font-size: 500%;
        
        /* opacity: 0.75; */
    }

    .bi-arrow-right-circle-fill::before {
        content: "\f133";
        
    }

    hr {
        color: #fff;
        display: inline-block;
        width: 50%;
        vertical-align: middle;
    }

    h3 {
        font-size: 100%;
    }

    .line {
    display: flex;
    align-items: center;
}

.line:before,
.line:after {
    content: " ";
    flex-grow: 2;
    color: #065fd4;
    height: 2px;
    width: 30px;
    background-color: #f8f9fa;
    margin: 0 10px;
    transform: translateY(-150%);
}
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <?php
if (!isset($_SESSION['user'])):

?>
    <div class="container-fluid" id="mobileContent">
        <div class="row flex-md-nowrap">
            <main class="col py-3">
                <div class="bg-light d-flex justify-content-center welcome bg-primary">
                    <div class="text-center d-flex flex-column lign-items-end my-auto">
                        <div class="img d-flex justify-content-center">
                            <img class="d-block my-auto" id="logo" src="img/logo_wordless_invert.png"  alt=""
                            srcset="">
                        </div>
                            
                                <h2 class="text-light ">Индивидуальные проекты студентов</h2>
                           
                            <div class="my-auto"></div>
                            <div class="my-auto">
                                <p class="addres text-light "><strong>Техническая поддержка</strong></br>
                                <abbr>Email: <a href="mailto:mtn@irkpo.ru" class= "text-light">mtn@irkpo.ru</a></abbr></br>
                                <abbr>Telegram: <a href="https://t.me/mayorovtn"  class= "text-light">mayorovtn</a></a></abbr></p>
                                
                                <p class="addres text-light "><strong>Разработка</strong></br>
                                <abbr>Telegram: <a href="https://t.me/stefanches"  class= "text-light">ivanovsa</a></a></abbr></p>
                            </div>

                            <div class="my-auto"></div>
                            <a href="vendor/signin_front.php" class="my-auto">
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </a>
                            
                    

                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="container-fluid" id="albumContent">
        <div class="row flex-md-nowrap">
        <main class="col py-3">
                <div class="bg-light d-flex justify-content-center welcome">
                    <div class="text-center d-flex flex-column my-auto">
                        <div class="img d-flex justify-content-center">
                            <img class="d-block my-auto" id="logo" src="img/logo_wordless_invert.png"  alt=""
                                srcset="">
                        </div>
                        <h2 class="text-light">Индивидуальные проекты студентов</h2>
                        <div class="my-auto"> 
                            <p class="addres text-light"><strong>Техническая поддержка</strong></br>
                                <abbr>Email: <a href="mailto:mtn@irkpo.ru" class= "text-light">mtn@irkpo.ru</a></abbr></br>
                                <abbr>Telegram: <a href="https://t.me/mayorovtn"  class= "text-light">mayorovtn</a></a></abbr>
                            </p>
                            
                            <p class="addres text-light "><strong>Разработка</strong></br>
                                <abbr>Telegram: <a href="https://t.me/stefanches"  class= "text-light">ivanovsa</a></a></abbr>
                            </p>
                        </div>
                        <a href="vendor/signin_front.php" class = "my-auto">
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </a>
                            
                    </div>
                </div>
            </main>
        </div>

    </div>
    <div class="container-fluid" id="desktopContent">
        <div class="row flex-md-nowrap">
            <main class="col py-3">
                <div class="bg-light d-flex justify-content-center align-items-center welcome">
                    <div class="text-center mx-4 mb-5">
                        <img id="logo" src="img/logo_IPSv4.png" class="mb-4" alt="" srcset="">
                        <!-- <h1>Индивидуальные проекты студентов</h1> -->
                        <h2>ГБПОУ ИО Иркутский региональный колледж педагогического образования </h2>
                        <p class="lead">Для начала работы выполните <a href="vendor/signin_front.php"
                                style="text-decoration: none;">вход</a> в систему.</p>
                        <p class="addres"><strong>Техническая поддержка</strong></br>
                        <abbr>Email: mtn@irkpo.ru</abbr></br>
                        <abbr>Telegram: <a href="https://t.me/mayorovtn" target="_blank" style="text-decoration: none;">@mayorovtn</a></a></abbr>
                        <p class="addres"><strong>Разработка</strong></br>
                        <abbr>Telegram: <a href="https://t.me/stefanches" target="_blank" style="text-decoration: none;">ivanovsa</a></a></abbr>
                        </p>
                       
                        
                </div>
            </main>
        </div>
    </div>

    <?php
else:
require_once "vendor/connect.php";
$id_user = $_SESSION['user']['id'];
include_once realpath(dirname(__FILE__)) . '/vendor/header.php';
?>


    </li>
    </ul>
    <div class="buttons centerButtons d-flex justify-content-center align-items-center">
        <div class="btn-group-vertical text-center" role="group">
            <?php if (in_array('3', $_SESSION['user']['role'])) : ?>
            <a href="vendor/teacher/distribution_of_projects.php" class="btn btn-primary">Распределение проектов</a>
            <?php endif; ?>
            <?php if (in_array('2', $_SESSION['user']['role'])) : ?>
            <a href="vendor/head_of_department/load_distribution.php" class="btn btn-primary">Распределение нагрузки</a>
            <a href="vendor/teacher/info_teachers.php" class="btn btn-primary">Отчет по кафедре</a>
            <?php endif; ?>
            <?php if (in_array('4', $_SESSION['user']['role'])) : ?>
            <a href="vendor/methodologist/info_stats.php" class="btn btn-primary">Сводные отчеты</a>
            <a href="vendor/methodologist/output.php" class="btn btn-primary" target="_blank">Сформировать приказ</a>
            <?php endif; ?>
        </div>

        <?php if (in_array('1', $_SESSION['user']['role'])) : ?>
        <div class="button-link">
            <a href="vendor/admin/students/front_table_students.php">Студенты</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/teachers/front_table_teachers.php">Преподаватели</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/departments/front_table_departments.php">Кафедры</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/groups/front_table_groups.php">Группы</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/objects/front_table_objects.php">Дисциплины</a>
        </div>

        <div class="empty"></div>

        <div class="button-link">
            <a href="vendor/admin/T_O/front_table_T_O.php">Преподаватели/дисциплины</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/S_G/front_table_S_G.php">Студенты/группы</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/D_T/front_table_D_T.php">Преподаватели/кафедры</a>
        </div>
        <div class="button-link">
            <a href="vendor/admin/D_G/front_table_D_G.php">Кафедры/группы</a>
        </div>
        <div class="empty"></div>
      <div class="button-link">
            <a href="vendor/methodologist/info_stats.php" class="btn btn-primary">Сводные отчёты</a>
        </div>
        <div class="button-link">
            
            <a target="_blank" href="vendor\methodologist\output.php">Сформировать приказ</a>
        </div>

    </div>
    <?php endif; ?>

    <?php
if (in_array('5', $_SESSION['user']['role'])) :
    $sql = "SELECT
    CONCAT(
        `users`.`lastname`,
        ' ',
        `users`.`firstname`,
        ' ',
        `users`.`middlename`
    ) as full_name_teacher,
    `objects`.`name` as name_object,
    `projects`.`topic` as topic,
    `projects`.`grade` as grade
    FROM
    `projects`
    INNER JOIN `users` ON `projects`.`teacher_id` = `users`.`id_user`
    INNER JOIN `objects` ON `projects`.`object_id` = `objects`.`id_object`
    WHERE
    `projects`.`student_id` = '$id_user'";
    $project = $connect->query($sql);
    $count_row = $project->rowCount();
    if ($count_row != 0) :
        $project = $connect->query($sql);
        $project = $project->fetchAll()[0];
?>
    <table>
        <tr>
            <td colspan="4" style="text-align: center;"><strong>Ваш проект:</strong></td>
        </tr>
        <tr>
            <th>Преподаватель</th>
            <th>Дисциплина</th>
            <th>Тема проекта</th>
            <th>Оценка</th>
        </tr>
        <tr>
            <td><?= $project['full_name_teacher'] ?></td>
            <td><?= $project['name_object'] ?></td>
            <td><?= $project['topic'] ?></td>
            <td>
                <?php
                    if ($project['grade'] == null) echo "Нет оценки";
                    else echo $project['grade'];
                    ?>
            </td>
        </tr>
    </table>
    <?php
    endif;
endif;
?>
    <?php
if (isset($count_row) && $count_row == 0) echo '<div class="no-project-message">У вас не назначен проект.</div>';
endif;
?>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
    integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(window).resize(function() {
        screenAdaptation()
    });

    function screenAdaptation() {
        var desktopScreenContent = $('#desktopContent')
        var mobileContent = $('#mobileContent')
        var albumContent = $('#albumContent')

        if (window.innerWidth > 1024) {
            desktopScreenContent.css('display', 'block')
            mobileContent.css('display', 'none')
            albumContent.css('display', 'none')
        } else if (window.innerWidth <= 1024 && window.innerWidth > 650) {
            desktopScreenContent.css('display', 'none')
            mobileContent.css('display', 'none')
            albumContent.css('display', 'block')
        } else if (window.innerWidth <= 650) {
            desktopScreenContent.css('display', 'none')
            mobileContent.css('display', 'block')
            albumContent.css('display', 'none')
        }
    }
    screenAdaptation()
});
</script>

</html>