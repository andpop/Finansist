<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');

define('MAX_LENGTH_COMPANY_NAME', 150);
define('MAX_LENGTH_GSZ_BRIEF_NAME', 30);
define('MAX_LENGTH_GSZ_FULL_NAME', 150);
define('ERROR_MESSAGE_PREFIX', 'Ошибка при выполнении последней операции: ');
define('NO_ERRORS_MESSAGE', 'NO_ERRORS');
define('HTML_PATH_GSZ_LIST_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/gsz_list.php');
define('HTML_PATH_GSZ_ADD_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/gsz_add.php');
define('HTML_PATH_GSZ_EDIT_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/gsz_edit_item.php');
define('HTML_PATH_GSZ_DELETE_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/gsz_confirm_delete.php');
define('HTML_PATH_GSZ_SAVE_ITEM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/script/gsz_save_item.php');
define('HTML_PATH_COMPANY_LIST_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/company_list.php');
define('HTML_PATH_COMPANY_ADD_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/company_add.php');
define('HTML_PATH_COMPANY_EDIT_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/company_edit.php');
define('HTML_PATH_COMPANY_DELETE_FORM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/company_confirm_delete.php');
define('HTML_PATH_COMPANY_SAVE_ITEM', 'http://'.$_SERVER['HTTP_HOST'].'/cred_limit/script/company_save_item.php');

// Подключение к БД
$mysqli = db_connect();


class GSZ_Item 
{
	public $Id, $Brief_Name, $Full_Name;

	function __construct($id)
	{
		global $mysqli;
		$query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$id}";
		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		
		$this->Brief_Name = htmlspecialchars($row['Brief_Name']);
		$this->Full_Name = htmlspecialchars($row['Full_Name']);
		$this->Id = $id;

		$result_set->close();
	}
}

class Company_Item 
{
	public $Id, $Name, $INN, $GSZ_Id, $OPF_Id, $OPF, $SNO_Id, $SNO;
	
	function __construct($Company_Id)
	{
		global $mysqli;
		
		$query = "SELECT `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `A`.`GSZ_Id` AS `GSZ_Id`, `A`.`OPF_Id` AS `OPF_Id`, `A`.`SNO_Id` AS `SNO_Id`, `B`.`Brief_Name` AS `OPF`, ";
		$query .= " `C`.`Brief_Name` AS `SNO`, `D`.`Brief_Name` AS  `GSZ_Name` ";
		$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` , `GSZ` `D` ";
		$query .= "WHERE `A`.`Id`={$Company_Id} AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`) AND (`A`.`GSZ_Id`=`D`.`Id`)";
		
		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		
		$this->Id = $Company_Id;
		$this->Name = htmlspecialchars($row['Name']);
		$this->INN = $row['INN'];
		$this->GSZ_Id = $row['GSZ_Id'];
		$this->GSZ_Name = htmlspecialchars($row['GSZ_Name']);
		$this->OPF_Id = $row['OPF_Id'];
		$this->SNO_Id = $row['SNO_Id'];
		$this->OPF = $row['OPF'];
		$this->SNO = $row['SNO'];
		
		$result_set->close();
	}
}

function get_GSZ_set()
{
	// GSZ_row := {Id, Brief_Name, Full_Name}
	global $mysqli;
	$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
	$GSZ_set = $mysqli->query($query);
	
	return $GSZ_set;
}

function get_company_set($GSZ_Id)
{
	// company_row := {Id, Name, INN, OPF, SNO}
	global $mysqli;
	$query = "SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ";
	$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
	$query .= "WHERE (`A`.`GSZ_Id`={$GSZ_Id}) AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";
	$company_set = $mysqli->query($query);
	return $company_set;
}

function get_error_message() 
{
	global $get;
	if (isset($get['error']))
		return (ERROR_MESSAGE_PREFIX . '<strong>'.htmlspecialchars(urldecode($_GET['error'])).'.</strong>');
	else
		return NO_ERRORS_MESSAGE;
}


function get_OPF_Id_by_Name($OPF_Name)
{
	global $mysqli;
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
	global $mysqli;
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
	// array_OPF_names := {Brief_Name => INN_Length}
	global $mysqli;
	$array_OPF_names = [];
	$query = 'SELECT `Brief_Name`, `INN_Length` FROM `OPF`';
	if (!$result_set = $mysqli->query($query)) 
		return $array_OPF_names;
	while (($row = $result_set->fetch_assoc()) != false) 	
	{
		$array_OPF_names[$row['Brief_Name']]=$row['INN_Length'];
	}
	$result_set->close();
	return $array_OPF_names;	
}

function get_SNO_names()
{
	// array_SNO_names := {Brief_Name => Cred_Limit_Affect}
	global $mysqli;
	$array_SNO_names = [];
	$query = 'SELECT `Brief_Name`, `Cred_Limit_Affect` FROM `SNO`';
	if (!$result_set = $mysqli->query($query)) 
		return $array_SNO_names;	
	while (($row = $result_set->fetch_assoc()) != false) 	
	{
		$array_SNO_names[$row['Brief_Name']]=$row['Cred_Limit_Affect'];
	}
	$result_set->close();
	return $array_SNO_names;	
}

?>