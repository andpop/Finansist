<?php
	require_once '../script/app_config.php';
		// Функция добавляет новую запись в таблицу БД 
	$mysqli = db_connect();
	$Brief_Name = mysql_escape_string( $_POST['GSZ_Brief_Name'] );
	$Full_Name = mysql_escape_string( $_POST['GSZ_Full_Name'] );
	$query = "INSERT INTO GSZ (Brief_Name, Full_Name) VALUES ('".$Brief_Name."', '".$Full_Name."');";
	$mysqli->query($query);
	header( 'Location: gsz_list.php');
 	die();
?>