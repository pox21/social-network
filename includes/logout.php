<?php
include_once "functions.php";
setStatus($_SESSION['id'], 'Отошел');
session_destroy();
header("Location: /page_login.php");
