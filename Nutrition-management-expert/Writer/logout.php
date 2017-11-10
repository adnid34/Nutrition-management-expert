<?php
require_once '../PHP/dbconfig.php';
session_start();
unset($_SESSION['login_user']);
header("Location: ".$GLOBALS['base_URL']);
?>