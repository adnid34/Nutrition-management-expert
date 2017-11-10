<?php
require_once '../PHP/dbconfig.php';
session_start();
unset($_SESSION['login_user_editor']);
header("Location: ".$GLOBALS['base_URL']);
?>