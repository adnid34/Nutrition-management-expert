<?php
require_once '../PHP/dbconfig.php';
session_start();
unset($_SESSION['login_user_manager']);
header("Location: ".$GLOBALS['base_URL']);
?>