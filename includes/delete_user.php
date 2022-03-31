<?php

include_once "functions.php";

$id = $_GET['id'] ?? '';

if (loggedIn() && $id == $_SESSION['id'] || isAdmin()) {
    deleteUser($id);
}

redirectTo("users.php");