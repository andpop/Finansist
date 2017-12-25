<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');

define('MAX_LENGTH_COMPANY_NAME', 150);
define('MAX_LENGTH_GSZ_BRIEF_NAME', 30);
define('MAX_LENGTH_GSZ_FULL_NAME', 150);
define('ERROR_MESSAGE_PREFIX', 'Ошибка при выполнении последней операции: ');
define('NO_ERRORS_MESSAGE', 'NO_ERRORS');


class GSZ_Item 
{
	public $id, $Brief_Name, $Full_Name;

	function __construct($id)
	{
		$mysqli = db_connect();
		// $query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$_GET['id']}";
		$query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$id}";
		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		
		$this->Brief_Name = htmlspecialchars($row['Brief_Name']);
		$this->Full_Name = htmlspecialchars($row['Full_Name']);
		$this->id = $id;
		
		$mysqli->close();		
	}
}

function get_error_message() 
{
	if (isset($_GET['error']))
		return (ERROR_MESSAGE_PREFIX . '<strong>'.htmlspecialchars(urldecode($_GET['error'])).'.</strong>');
	else
		return NO_ERRORS_MESSAGE;
}


function get_GSZ_set()
{
	$mysqli = db_connect();
	$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
	$GSZ_set = $mysqli->query($query);
	$mysqli->close();		
	return $GSZ_set;
}

function get_GSZ_name_by_id($GSZ_Id)
{
	$mysqli = db_connect();
	$query = 'SELECT `Brief_Name` FROM `GSZ` WHERE `Id`='.$GSZ_Id;

	if (!$result_set = $mysqli->query($query)) 
		return '';

	$row = $result_set->fetch_assoc();
	$GSZ_Name = $row['Brief_Name'];
	$result_set->close();
	return $GSZ_Name;	
}

function get_OPF_name_by_id($OPF_Id)
{
	$mysqli = db_connect();
	$query = 'SELECT `Brief_Name` FROM `OPF` WHERE `Id`='.$OPF_Id;

	if (!$result_set = $mysqli->query($query)) 
		return '';

	$row = $result_set->fetch_assoc();
	$OPF_Name = $row['Brief_Name'];
	$result_set->close();
	return $OPF_Name;	
}

function get_SNO_name_by_id($SNO_Id)
{
	$mysqli = db_connect();
	$query = 'SELECT `Brief_Name` FROM `SNO` WHERE `Id`='.$SNO_Id;

	if (!$result_set = $mysqli->query($query)) 
		return '';

	$row = $result_set->fetch_assoc();
	$SNO_Name = $row['Brief_Name'];
	$result_set->close();
	return $SNO_Name;	
}


function get_OPF_Id_by_Name($OPF_Name)
{
	$mysqli = db_connect();
	$query = 'SELECT `Id` FROM `OPF` WHERE `Brief_Name`="'.$OPF_Name.'"';

	if (!$result_set = $mysqli->query($query)) 
		return -1;

	$row = $result_set->fetch_assoc();
	$OPF_Id = $row['Id'];
	$result_set->close();
	return $OPF_Id;	
}

function get_SNO_Id_by_Name($SNO_Name)
{
	$mysqli = db_connect();
	$query = 'SELECT `Id` FROM `SNO` WHERE `Brief_Name`="'.$SNO_Name.'"';

	if (!$result_set = $mysqli->query($query)) 
		return -1;

	$row = $result_set->fetch_assoc();
	$SNO_Id = $row['Id'];
	$result_set->close();
	return $SNO_Id;	
}

function get_OPF_names()
{
	$mysqli = db_connect();
	$query = 'SELECT `Brief_Name` FROM `OPF`';
	if (!$result_set = $mysqli->query($query)) 
		return '';
	$array_OPF_names = [];
	while (($row = $result_set->fetch_assoc()) != false) 	
	{
		$array_OPF_names[]=$row['Brief_Name'];
	}
	$result_set->close();
	return $array_OPF_names;	
}

function get_SNO_names()
{
	$mysqli = db_connect();
	$query = 'SELECT `Brief_Name` FROM `SNO`';
	if (!$result_set = $mysqli->query($query)) 
		return '';
	$array_SNO_names = [];
	while (($row = $result_set->fetch_assoc()) != false) 	
	{
		$array_SNO_names[]=$row['Brief_Name'];
	}
	$result_set->close();
	return $array_SNO_names;	
}

?>