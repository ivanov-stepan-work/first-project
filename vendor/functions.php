<?php
function checkRoleHeadOfDep(){
require "connect.php";
$login = $_SESSION['user'];
$check_user = $connect->query("Select `roles`.`id_role` = 2 as result FROM `users` INNER JOIN `roles` on `users`.`role_id` = `roles`.`id_role` WHERE `users`.`login` = '$login'");
$check_user = $check_user->fetchAll();
if(!$check_user[0]['result'])
header("Location: ../../index.php");
}
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