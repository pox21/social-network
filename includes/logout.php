<?php
include_once "functions.php";
setStatus($_SESSION['id'], 'offline');
session_destroy();
header("Location: /page_login.php");
