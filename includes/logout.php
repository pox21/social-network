<?php
include_once "functions.php";
if (isset($_SESSION['id'])) {
    setStatus($_SESSION['id'], 'offline');
}
session_destroy();
header("Location: /page_login.php");
