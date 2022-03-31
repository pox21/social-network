<?php

include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {

    if (editUser($_POST['id'], $_POST['username'], $_POST['job'], $_POST['phone'], $_POST['address'])) {
        setFlashMessage('updateData', 'Профиль успешно обновлен');
        loggedIn() ? redirectTo("users.php") : redirectTo("page_login.php");
    }
}
redirectTo('users.php');