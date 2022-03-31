<?php
include_once "functions.php";

if (isset($_POST) && !empty($_POST)) {
    if (login($_POST)) {
        redirectTo("users.php");
    }
}
redirectTo('page_login.php');