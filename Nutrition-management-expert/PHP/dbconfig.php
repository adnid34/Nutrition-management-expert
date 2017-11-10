<?php

	$DB_HOST = 'localhost';
	$DB_USER = 'root';
	$DB_PASS = '';
	$DB_NAME = 'snc';

	// DB TABLE INFO
	$GLOBALS['hits_table_name'] = "hits_table";
	$GLOBALS['info_table_name'] = "info_table";
	$GLOBALS['base_URL'] = " http://localhost/Nutrition-management-expert/admin_login.php";
	
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$GLOBALS['db'] = $DB_con;
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}