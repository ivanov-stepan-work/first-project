<?php
require_once "../../connect.php";
session_start();
if (!in_array('1', $_SESSION['user']['role']))
    header("Location:../../../index.php");
$stmt = $connect->prepare("INSERT INTO `users`(
    `login`,
    `password`,
    `lastname`,
    `firstname`,
    `middlename`,
    `role_id`
)
VALUES(
    :login,
    :password,
    :lastname,
    :firstname,
    :middlename,
    '2'
)");
$stmt->bindValue(":login", $_POST['login'], PDO::PARAM_STR);
$stmt->bindValue(":password", generateRandomPassword(), PDO::PARAM_STR);
$stmt->bindValue(":lastname", $_POST['lastname'], PDO::PARAM_STR);
$stmt->bindValue(":firstname", $_POST['firstname'], PDO::PARAM_STR);
$stmt->bindValue(":middlename", $_POST['middlename'], PDO::PARAM_STR);
$stmt->execute();
header("Location: front_table_HOD.php");

function generateRandomPassword($length = 8, $useUpperCase = true, $useLowerCase = true, $useNumbers = true, $useSymbols = false) {
    $password = '';
    
    // Создание массивов символов, которые можно использовать в пароле
    $upperCaseCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowerCaseCharacters = 'abcdefghijklmnopqrstuvwxyz';
    $numberCharacters = '0123456789';
    $symbolCharacters = '!@#$%^&*()_+=-{}[]|\:;"\'<>,.?/';
    
    $characters = '';
    
    if ($useUpperCase) {
        $characters .= $upperCaseCharacters;
    }
    
    if ($useLowerCase) {
        $characters .= $lowerCaseCharacters;
    }
    
    if ($useNumbers) {
        $characters .= $numberCharacters;
    }
    
    if ($useSymbols) {
        $characters .= $symbolCharacters;
    }
    
    $characterCount = strlen($characters);
    
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, $characterCount - 1);
        $password .= $characters[$index];
    }
    
    return $password;
}
$randomPassword = generateRandomPassword(10, true, true, true, false);