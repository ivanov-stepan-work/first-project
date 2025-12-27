<?php
require_once "../connect.php";
require "../autoload.php";
session_start();
// die(var_dump($_SESSION));
if(!(in_array('4', $_SESSION['user']['role']) || in_array('1', $_SESSION['user']['role'])))
header("Location: ../../index.php");
$mpdf = new \Mpdf\Mpdf();
?><?php
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приказ ИПС</title>
    er: 1px solid;
        border-collapse: collapse;
        text-align: center;
        line-height: 1.5;
    }
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: Times New Roman, Times, serif;
        line-height: 1.5;
    }
    
    
    
    .dynamic-table td,
    .dynamic-table th {
         /* Новый размер шрифта для таблиц */
        border: 1px solid;
        text-align: center;
        padding-left: 5px;
        padding-right: 5px;
    }
    
    .center {
        text-align: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .center * {
        max-width: 100%;
        max-height: 100%;
        display: inline-block;
        vertical-align: middle;
        width: auto !important;
        height: auto !important;
    }
    
    .image-container {
        max-width: 20%; /* Максимальная ширина контейнера изображения */
        max-height: 20%; /* Максимальная высота контейнера изображения */
    }
    
    #blueText {
        margin-top: -10px;
        color: #55a;
    }
    
    p {
        margin: 5;
        line-height: 1.5;
    }
    
    hr {
        color: #55c;
    }
    
    .rightLeft {
        width: 100%;
    }
    
    .main-txt {
        font-size: 17px;
        text-indent: 20px;
    }
    
    .list li {
        font-size: 16px;
    }
    
    .margin {
        margin-top: 50px;
    }
    .table-font {
        font-size: 1pt;
    }
    .dynamic-table {
        font-size: 14pt;
        border: 1px solid;
        border-collapse: collapse;
        text-align: center;
        line-height: 1.5;
    }
    #table {
        font-size: 14pt;
    }
    
    #table td,
    #table th {
        font-size: 14pt;
    }
</style>
</head>
<body>
<table class="rightLeft">
<tr>
<td style="font-size: 17px;"></td>
<td style="text-align:right; font-size: 15px; font-weight: bold;">Приложение №1</td>
</tr>
</table>';

$groups = $connect->query("SELECT * FROM `groups`")->fetchAll();
foreach ($groups as $group) {
    $tests = $connect->query("SELECT 
        `objects`.`name`,
        (
            SELECT CONCAT(
                `users`.`lastname`,
                ' ',
                LEFT(`users`.`firstname`,1),
                '. ',
                LEFT(`users`.`middlename`,1), '.'
            ) AS full_name_student
            FROM `users`
            WHERE `users`.`id_user` = `projects`.`teacher_id`
        ) AS full_name_teacher,
        `projects`.`topic`,
        (
            SELECT CONCAT(
                `users`.`lastname`,
                ' ',
                `users`.`firstname`,
                ' ',
                `users`.`middlename`
            ) AS full_name_student
            FROM `users`
            WHERE `users`.`id_user` = `projects`.`student_id`
        ) AS full_name_student
    FROM
        `objects`
    INNER JOIN `projects` ON `projects`.`object_id` = `objects`.`id_object`
    INNER JOIN `student_groups` ON `projects`.`student_id` = `student_groups`.`student_id`
    WHERE `student_groups`.`group_id` = '". $group['id_group'] ."'")->fetchAll();

    $html .= '
    <div class="center margin" style="height:1vh; font-weight: bold; margin-top: 0vh; font-size: 15pt;">' . $group['name'] . '</div>
    <br>
    <table id="table" class="dynamic-table">
    <tr>
        <th style="min-width:10%; font-size: 14px;"></th>
        <th style="width:20%; font-size: 14px;">Общеобразовательная дисциплина</th>
        <th style="width:20%; font-size: 14px;">Преподаватель</th>
        <th style="width:30%; font-size: 14px;">Тема индивидуального проекта </th>
        <th style="width:20%; font-size: 14px;">Обучающийся</th>
    </tr>';

    $count = 1;
    foreach($tests as $test) {
        $html .= 
        '<tr>
        <td style="min-width:10%; font-size: 14px;">'.$count.'</td>
        <td style="width:20%; font-size: 14px;">'. $test['name'] .'</td> 
        <td style="width:20%; font-size: 14px;">'. $test['full_name_teacher'] .'</td>
        <td style="width:30%; font-size: 14px;">'. $test['topic'] .'</td>
        <td style="width:20%; font-size: 14px;">'. $test['full_name_student'] .'</td>
    </tr>';
        $count++;
    }

    $html .= '</table>
    <br>
    <br>
    ';
}
$html .= '<table class="rightLeft">
<!--<tr>
<td style="font-size: 17px;">Директор</td>
<td style="text-align:right; font-size: 17px;">И.А. Сенцова</td>
</tr> -->
</table>';

$dt = Date('d-m-y');
$mpdf->WriteHTML($html);
$mpdf->Output('ИПС-Приказ_'.$dt.'.pdf', 'I');
?>
