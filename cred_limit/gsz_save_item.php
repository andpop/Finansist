<?php
	require_once '../script/app_config.php';
		// Функция добавляет новую запись в таблицу БД 
	$mysqli = db_connect();
	if (!isset($_REQUEST["action"])) break;

	switch ($_REQUEST["action"])
	{
		case 'add':
			$Brief_Name = mysql_escape_string( $_REQUEST['GSZ_Brief_Name'] );
			$Full_Name = mysql_escape_string( $_REQUEST['GSZ_Full_Name'] );
			$query = "INSERT INTO `GSZ` (`Brief_Name`, `Full_Name`) VALUES ('".$Brief_Name."', '".$Full_Name."')";
			break;
		case 'update':
			$Brief_Name = mysql_escape_string( $_REQUEST['GSZ_Brief_Name'] );
			$Full_Name = mysql_escape_string( $_REQUEST['GSZ_Full_Name'] );
			$query = 'UPDATE `GSZ` SET `Brief_Name`="'.$Brief_Name.'", `Full_Name`="'.$Full_Name.'" WHERE `Id`='.$_REQUEST['Id'];
			break;
		case 'delete':
			$query = 'DELETE FROM `GSZ` WHERE `Id`='.$_REQUEST['Id'];
			break;
		default:
			break;
	}
	
	//echo $query;

	$mysqli->query($query);
	header( 'Location: gsz_list.php');
 	die();
?>