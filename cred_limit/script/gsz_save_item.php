<?php
	// require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');
	require_once("cred_limit_scripts.php");
	$mysqli = db_connect();
	if (!isset($_REQUEST["action"])) exit;

	switch ($_REQUEST["action"])
	{
		case 'add':
			$Brief_Name = $mysqli->real_escape_string( $_REQUEST['GSZ_Brief_Name'] );
			$Full_Name = $mysqli->real_escape_string( $_REQUEST['GSZ_Full_Name'] );
			$query = "INSERT INTO `GSZ` (`Brief_Name`, `Full_Name`) VALUES ('".$Brief_Name."', '".$Full_Name."')";
			break;
		case 'update':
			$Brief_Name = $mysqli->real_escape_string( $_REQUEST['GSZ_Brief_Name'] );
			$Full_Name = $mysqli->real_escape_string( $_REQUEST['GSZ_Full_Name'] );

			//Проверяем, является ли параметр Id целым числом
			if (!ctype_digit($_REQUEST['Id']))
			{
				$error_message = urlencode("Указан некорректный URL");
				header("Location: ".HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			
			$query = 'UPDATE `GSZ` SET `Brief_Name`="'.$Brief_Name.'", `Full_Name`="'.$Full_Name.'" WHERE `Id`='.$_REQUEST['Id'];
			break;
			
			case 'delete':
			//Проверяем, является ли параметр Id целым числом
			if (!ctype_digit($_REQUEST['Id']))
			{
				$error_message = urlencode("Указан некорректный URL");
				header("Location: ".HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			
			$query = 'DELETE FROM `GSZ` WHERE `Id`='.$_REQUEST['Id'];
			break;
			default:
			break;
		}
		
		$mysqli->query($query);
		$mysqli->close();
		header("Location: ".HTML_PATH_GSZ_LIST_FORM);
 	die();
?>