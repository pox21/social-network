<?php

include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {
    if (addSocialLinks($_POST['id'], $_POST['vk'], $_POST['tg'], $_POST['inst'])) {
        setFlashMessage('updateData', 'Профиль успешно обновлен');
        loggedIn() ? redirectTo("users.php") : redirectTo("page_login.php");
    }
}
redirectTo('users.php');