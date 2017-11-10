<?php
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
	require_once '../PHP/dbconfig.php'; 
	session_start();// Starting Session
	// Storing Session
	$user_check=$_SESSION['login_user_publisher'];
	// SQL Query To Fetch Complete Information Of User
	$stmt = $DB_con->prepare('SELECT user.*, user_info.* 
							  FROM user 
							  LEFT JOIN user_info
	                            ON user.user_id = user_info.user_id
	                          WHERE user.username = :ausername');
	$stmt->bindParam(':ausername', $user_check);
	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($results);
	
	if ($stmt->rowCount() > 0) {
	  $login_session = $username;
	  $login_session_id = $user_id;
	  $login_session_fullname = $full_name;
	} else {
	   header('Location: http://localhost/snc/admin_login.php'); // Redirecting To Home Page
	}     
?>