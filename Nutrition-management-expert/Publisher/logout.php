<?php
require_once '../PHP/dbconfig.php';
session_start();
unset($_SESSION['login_user_publisher']);
header("Location: ".$GLOBALS['base_URL']);
?>