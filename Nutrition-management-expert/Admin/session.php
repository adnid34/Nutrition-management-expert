<?php
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
	require_once '../PHP/dbconfig.php'; 
	session_start();// Starting Session
	// Storing Session
	$user_check=$_SESSION['login_user_admin'];
	// SQL Query To Fetch Complete Information Of User
	$stmt = $DB_con->prepare('SELECT * FROM user WHERE username = :ausername');
	$stmt->bindParam(':ausername', $user_check);
	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($results);
	
	if ($stmt->rowCount() > 0) {
	  $login_session = $username;
	  $login_session_id = $user_id;
	} else {
	   header('Location: http://localhost/Nutrition-management-expert/admin_login.php'); // Redirecting To Home Page
	}     
?>