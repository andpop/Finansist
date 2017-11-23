<?php
	require_once '../script/app_config.php';
	require_once './cred_limit_scripts.php';

	$mysqli = db_connect();
	if (!isset($_REQUEST["action"])) exit;

	switch ($_REQUEST["action"])
	{
		case 'add':
			$Name = mysql_escape_string($_POST['Company_Name']);
			$INN = mysql_escape_string($_POST['INN']);
			$OPF = $_POST['OPF'];
			$SNO = $_POST['SNO'];
			$GSZ_Id=$_POST['GSZ_Id'];

			$OPF_Id = get_OPF_Id_by_Name($OPF);
			$SNO_Id = get_SNO_Id_by_Name($SNO);

			$query = 'INSERT INTO `Company` (`Name`, `INN`, `OPF_Id`, `SNO_Id`, `GSZ_Id`) ';
			$query .= 'VALUES ("'.$Name.'", '.$INN.', '.$OPF_Id.', '.$SNO_Id.', '.$GSZ_Id.')';
			break;
		
		case 'update':
			$Id = $_POST['Company_Id'];
			$GSZ_Id = $_POST['GSZ_Id'];

			$Name = mysql_escape_string($_POST['Company_Name']);
			$INN = mysql_escape_string($_POST['INN']);
			//Добавить проверку на -1
			$OPF_Id = get_OPF_Id_by_Name($_POST['OPF']);
			$SNO_Id = get_SNO_Id_by_Name($_POST['SNO']);

			//Проверяем, является ли параметр Id целым числом
			if (!preg_match("/^\d+$/", $Id))
			{
				exit("Неверный формат URL-запроса");
			}
			
			$query = 'UPDATE `Company` SET `Name`="'.$Name.'", `INN`='.$INN.', `OPF_Id`='.$OPF_Id.', `SNO_Id`='.$SNO_Id.' WHERE `Id`='.$Id;
			break;
		
		case 'delete':
			//Проверяем, является ли параметр Id целым числом
			$GSZ_Id = $_GET['GSZ_Id'];
			if (!preg_match("/^\d+$/", $_GET['Company_Id']))
			{
				exit("Неверный формат URL-запроса");
			}

			$query = 'DELETE FROM `Company` WHERE `Id`='.$_GET['Company_Id'];
			break;
		
		default:
			break;
	}
	
	//echo $query;

	$mysqli->query($query);
	if ($mysqli->errno)
	{
		$url_param = "action=show_list&GSZ_Id=${GSZ_Id}&error=".urlencode($mysqli->error);
		header( 'Location: company_list.php?'.$url_param);
		//print_r($url_param);
		//echo 'При выполнении запроса произошла ошибка '.$mysqli->errno.": ".$mysqli->error;
	}
	else
	{
		header( 'Location: company_list.php?action=show_list&GSZ_Id='.$GSZ_Id);
	}
 	die();
?>