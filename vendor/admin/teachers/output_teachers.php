<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
require "../../autoload.php";
$mpdf = new \Mpdf\Mpdf();
?><?php
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Списки преподавателей</title>
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
        width:100%;
        font-size: 14pt;
    }
    
    #table td,
    #table th {
        font-size: 14pt;
    }
</style>
</head>
<body>
';

    $tests = $connect->query("SELECT `users`.`login`, `users`.`password`, CONCAT(
        `users`.`lastname`,
        ' ',
        `users`.`firstname`,
        ' ',
        `users`.`middlename`
    ) AS full_name_student, `departments`.`name`
FROM `roles`
INNER JOIN `roles_users` ON `roles`.`id_role` = `roles_users`.`role_id`                 
INNER JOIN `users` ON `roles_users`.`user_id` = `users`.`id_user`
INNER JOIN `department_teachers` ON `users`.`id_user` = `department_teachers`.`teacher_id` 
INNER JOIN `departments` ON `department_teachers`.`department_id` = `departments`.`id_department`
WHERE `roles`.`id_role` = '3'
ORDER BY `departments`.`name` ASC
")->fetchAll();

    $html .= '
    <br>
    <table id="table" class="dynamic-table">
    <tr>
        <th style="min-width:10%; font-size: 14px;"></th>
        <th style="max-width:20%; font-size: 14px;">Логин</th>
        <th style="max-width:15%; font-size: 14px;">Пароль</th>
        <th style="max-width:30%; font-size: 14px;">ФИО преподавателя</th>
        <th style="max-width:20%; font-size: 14px;">Кафедра</th>
    </tr>';

    $count = 1;
    foreach($tests as $test) {
        $html .= 
        '<tr>
        <td style="min-width:10%; font-size: 14px;">'.$count.'</td>
        <td style="max-width:20%; font-size: 14px;">'. $test['login'] .'</td> 
        <td style="max-width:15%; font-size: 14px;">'. $test['password'] .'</td>
        <td style="max-width:20%; font-size: 14px;">'. $test['full_name_student'] .'</td>
        <td style="max-width:30%; font-size: 14px;">'. $test['name'] .'</td>
    </tr>';
        $count++;
    }

    $html .= '</table>
    <br>
    <br>
    ';
$html .= '<table class="rightLeft">
<!--<tr>
<td style="font-size: 17px;">Директор</td>
<td style="text-align:right; font-size: 17px;">Г.Ф. Кудрявцева</td>
</tr> -->
</table>';
// echo $html;
$mpdf->WriteHTML($html);
$mpdf->Output('Учетные данные преподавателей ИПС.pdf', 'I');
?>
