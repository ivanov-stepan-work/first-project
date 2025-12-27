<?php
$name_roles = array(1 => 'Администратор', 2 => 'Зав. кафедрой', 3 => 'Преподаватель', 4 => 'Методист', 5 => 'Студент');
?>
<style>
#logo {
    max-width: 50px;
    max-height: 50px;
    padding-left: 10px;
}

.navbar {
    margin-bottom: 5vh;
}

.navbar-nav .dropdown-menu {
    position: absolute !important;
}

@media (max-width: 991px) {
    .navbar-nav .dropdown-menu {
        position: absolute !important;
    }
}

@media (max-width: 1024px) {

    #user-info {
        margin-right: 10px;
    }
}
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 0;">
    <div class="container-fluid">
        <a class="navbar-brand ml-auto" href="http://<?= $_SERVER['SERVER_NAME'] ?>/index.php">
            <img id="logo" src="https://<?= $_SERVER['SERVER_NAME'] ?>/favicon.png" alt="Логотип">
        </a>
        <ul class="navbar-nav ml-auto help">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle navbar-user-info" href="#" id="userMenu" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="user-info"><?= $_SESSION['user']['full_name']?>
                    </span>
                    <span id="roles-info">
                        <?php
$data_person = '';
$data_person .= "[";
foreach ($_SESSION['user']['role'] as $role) {
    $data_person .= $name_roles[intval($role)] . ", ";
}
$data_person = substr($data_person, 0, -2);
$data_person .=  "]";
echo $data_person;
?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                    <li><a class="dropdown-item"
                            href="https://<?= $_SERVER['SERVER_NAME'] ?>/vendor/signout.php">Выход</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.7.1.slim.js"
    integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $(window).resize(function() {
        checkWindowSize();
    });
    const userInfo = $("#user-info");
    const rolesInfo = $("#roles-info")
    const text = userInfo.text();
    const roles = rolesInfo.text();
    let tooltipVisible = false;

    rolesInfo.tooltip({
        title: roles,
        trigger: 'manual'
    });

    function checkWindowSize() {

        if ($(window).width() <= 1024) {
            if ($("#user-info").hasClass("slim"))
                return;
            if (roles.includes(',')) {
                const ellipsisText = rolesInfo.text().replace(/\[.*?\]/g, "[...]");
                rolesInfo.text(ellipsisText);
                rolesInfo.on('click', function(event) {
                    event.stopPropagation();
                    event.preventDefault();

                    if (tooltipVisible) {
                        rolesInfo.tooltip('hide');
                        tooltipVisible = false;
                        clearTimeout(timeoutId);
                    } else {
                        rolesInfo.tooltip('show');
                        tooltipVisible = true;
                        timeoutId = setTimeout(function() {
                            rolesInfo.tooltip('hide');
                            tooltipVisible = false;
                        }, 2000);
                    }
                })
            }
            const userInfoArray = userInfo.text().split(' ');
            const surnameInitials = userInfoArray[0] + ' ' + userInfoArray[1].charAt(0) + '.' +
                userInfoArray[2]
                .charAt(0) + '. '
            $("#user-info").text(surnameInitials);
            $("#user-info").addClass("slim");
        } else {
            rolesInfo.off('click');
            $("#roles-info").text(roles)
            $("#user-info").text(text);
            $("#user-info").removeClass("slim");
        }
    }
    checkWindowSize();

});
</script>