<?php

include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {

    if ($_POST['pass'] !== $_POST['pass2']) {
        setFlashMessage("passError", "Пароли не совпадают");
        redirectTo('security.php?id=' . $_POST["id"]);
    }

    if (editEmail($_POST['id'], $_POST['email'], $_POST['pass'])) {
        setFlashMessage('updateData', 'Почта и пароль успешно обновлены');
        loggedIn() ? redirectTo("users.php") : redirectTo("page_login.php");
    }
}
redirectTo('users.php');