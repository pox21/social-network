<?php

include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {

    if (setStatus($_POST['id'], $_POST['status'])) {
        setFlashMessage('updateData', 'Статус успешно изменен');
        loggedIn() ? redirectTo("users.php") : redirectTo("page_login.php");
    }
}

redirectTo('users.php');