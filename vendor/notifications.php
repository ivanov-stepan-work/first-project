<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        #alert-error-empty-topic, #alert-success{
            z-index: 99;
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
        #alert-error-empty-topic.show, #alert-success.show{
            top: 0;
        }

        /* Анимация при исчезновении */
        #alert-error-empty-topic.hide, #alert-success.hide {
            top: -100px;
        }
    </style>
</head>
<body>
<div id="alert-success" class="alert alert-success" role="alert"></div>
<div id="alert-error-empty-topic" class="alert alert-danger hide" role="alert"></div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>