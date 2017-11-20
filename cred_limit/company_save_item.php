<?php
	require_once '../script/app_config.php';
	$mysqli = db_connect();
	if (!isset($_REQUEST["action"])) break;

	switch ($_REQUEST["action"])
	{
		case 'add':
			$Name = mysql_escape_string($_REQUEST['Company_Name']);
			$INN = mysql_escape_string($_REQUEST['INN']);
			$OPF = mysql_escape_string($_REQUEST['OPF']);
			$SNO = mysql_escape_string($_REQUEST['SNO']);
			$GSZ_Id=$_REQUEST['GSZ_Id'];

			$query = 'SELECT `Id` FROM `opf` WHERE `Brief_Name`="'.$OPF.'"';
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			$OPF_Id = $row['Id'];

			$query = 'SELECT `Id` FROM `sno` WHERE `Brief_Name`="'.$SNO.'"';
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			$SNO_Id = $row['Id'];

			$query = 'INSERT INTO `Company` (`Name`, `INN`, `OPF_Id`, `SNO_Id`, `GSZ_Id`) ';
			$query .= 'VALUES ("'.$Name.'", '.$INN.', '.$OPF_Id.', '.$SNO_Id.', '.$GSZ_Id.')';
			break;
		case 'update':
			$Brief_Name = mysql_escape_string( $_REQUEST['GSZ_Brief_Name'] );
			$Full_Name = mysql_escape_string( $_REQUEST['GSZ_Full_Name'] );

			//Проверяем, является ли параметр Id целым числом
			if (!preg_match("/^\d+$/", $_REQUEST['Id']))
			{
				exit("Неверный формат URL-запроса");
			}
			
			$query = 'UPDATE `GSZ` SET `Brief_Name`="'.$Brief_Name.'", `Full_Name`="'.$Full_Name.'" WHERE `Id`='.$_REQUEST['Id'];
			break;
		case 'delete':
			//Проверяем, является ли параметр Id целым числом
			if (!preg_match("/^\d+$/", $_REQUEST['Id']))
			{
				exit("Неверный формат URL-запроса");
			}

			$query = 'DELETE FROM `GSZ` WHERE `Id`='.$_REQUEST['Id'];
			break;
		default:
			break;
	}
	
	//echo $query;

	$mysqli->query($query);
	header( 'Location: company_list.php?action=show_list&GSZ_Id='.$GSZ_Id);
 	die();
?>