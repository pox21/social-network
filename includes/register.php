<?php

include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {
    if (registerUser($_POST)) {
        loggedIn() ? redirectTo("users.php") : redirectTo("page_login.php");
    }
}
redirectTo('page_register.php');