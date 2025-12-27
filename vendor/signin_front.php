<?php 
session_start();
if(isset($_SESSION['user']))
header("Location: ../index.php");
include_once 'notifications.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 200%;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    .login,
    .input-group {
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    .input-group {
        padding: 0;
    }

    .error-message {
        color: red;
        margin-top: 10px;
        text-align: center;
    }

    #passwordInput {
        box-shadow: none;
    }

    #togglePassword {
        border-color: #ced4da;
        box-shadow: none;
    }

    #passwordInput:focus {
        border-color: #ced4da;
        /* box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
        border-color: #007bff; */
    }

    .btn-outline-secondary {
        height: inherit;

    }

    .input-group.active {
        color: #212529;
        background-color: #fff;
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
        transition: box-shadow 0.1s ease;
    }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Авторизация</h1>
        <form action="signin_back.php" method="post" id="form_signin">
            <input type="text" class="form-control login" placeholder="Введите логин" name="login">
            <div class="input-group">
                <input type="password" class="form-control form-control-sm" id="passwordInput" name="password"
                    placeholder="Password">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye" id="eye-icon"></i>
                </button>
            </div>
            <input type="submit" class="btn btn-primary" value="Войти">
        </form>
    </div>

    <script src="notifications.js"></script>
    <script src="scriptSignin.js"></script>
</body>

</html>