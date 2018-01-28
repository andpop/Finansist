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
$mysqli->set_charset("utf8");


class GSZ_Item 
{
	public $Id, $Brief_Name, $Full_Name, $Date_Begin_Work, $NumberCompany;

	function __construct($id)
	{
		$query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$id}";
		$row = getRow($query);
	
		$this->Id = $id;
		$this->Brief_Name = htmlspecialchars($row['Brief_Name']);
		$this->Full_Name = htmlspecialchars($row['Full_Name']);

		$query = "SELECT min(`Date_Begin_Work`) FROM `company` WHERE `GSZ_Id`={$id}";
		$Date_Begin_Work = getCell($query);
		$this->Date_Begin_Work = (is_null($Date_Begin_Work) ? "" : $Date_Begin_Work); 

		$query = "SELECT COUNT(*) FROM `company` WHERE `GSZ_Id`={$id}";
		$NumberCompany = getCell($query);
		$this->NumberCompany = $NumberCompany;
	}
}

class Company_Item 
{
	public $Id, $Name, $INN, $GSZ_Id, $OPF_Id, $OPF, $SNO_Id, $SNO;
	
	function __construct($Company_Id)
	{
		$query = "SELECT `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `A`.`GSZ_Id` AS `GSZ_Id`, `A`.`OPF_Id` AS `OPF_Id`, `A`.`SNO_Id` AS `SNO_Id`, `B`.`Brief_Name` AS `OPF`, ";
		$query .= " `C`.`Brief_Name` AS `SNO`, `D`.`Brief_Name` AS  `GSZ_Name`, `A`.`Date_Registr`, `A`.`Date_Begin_Work` ";
		$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` , `GSZ` `D` ";
		$query .= "WHERE `A`.`Id`={$Company_Id} AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`) AND (`A`.`GSZ_Id`=`D`.`Id`)";
		
		$row = getRow($query);
		
		$this->Id = $Company_Id;
		$this->Name = htmlspecialchars($row['Name']);
		$this->INN = $row['INN'];
		$this->GSZ_Id = $row['GSZ_Id'];
		$this->GSZ_Name = htmlspecialchars($row['GSZ_Name']);
		$this->OPF_Id = $row['OPF_Id'];
		$this->SNO_Id = $row['SNO_Id'];
		$this->OPF = $row['OPF'];
		$this->SNO = $row['SNO'];
		$this->Date_Registr = (is_null($row['Date_Registr']) ? "" : $row['Date_Registr']); 
		$this->Date_Begin_Work = (is_null($row['Date_Begin_Work']) ? "" : $row['Date_Begin_Work']); 
	}
}

function get_GSZ_set()
{
	$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
	$GSZ_set = getTable($query);
	return $GSZ_set;
}

function get_company_set($GSZ_Id)
{
	// company_set := array of {Id, Name, INN, OPF, SNO}
	$query = "SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO`, `A`.`Date_Registr`, `A`.`Date_Begin_Work` ";
	$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
	$query .= "WHERE (`A`.`GSZ_Id`={$GSZ_Id}) AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";
	$company_set = getTable($query);
	return $company_set;
}

function get_error_message() 
{
	global $get;
	if (isset($_GET['error']))
		return (ERROR_MESSAGE_PREFIX . '<strong>'.htmlspecialchars(urldecode($_GET['error'])).'.</strong>');
	else
		return NO_ERRORS_MESSAGE;
}

function get_OPF_Id_by_Name($OPF_Name)
{
	$query = 'SELECT `Id` FROM `OPF` WHERE `Brief_Name`="'.$OPF_Name.'"';
	$OPF_Id = getCell($query);
	return ($OPF_Id ? $OPF_Id : -1); 
}

function get_SNO_Id_by_Name($SNO_Name)
{
	$query = 'SELECT `Id` FROM `SNO` WHERE `Brief_Name`="'.$SNO_Name.'"';
	$SNO_Id = getCell($query);
	return ($SNO_Id ? $SNO_Id : -1); 
}

function get_OPF_names()
{
	// array_OPF_names := {Brief_Name => INN_Length}
	$array_OPF_names = [];
	$query = 'SELECT `Brief_Name`, `INN_Length` FROM `OPF`';
	$result_array = getTable($query);
	if (!$result_array) 
		return $array_OPF_names;
	foreach ($result_array as $row)
	{
		$array_OPF_names[$row['Brief_Name']]=$row['INN_Length'];
	}
	return $array_OPF_names;	
}

function get_SNO_names()
{
	// array_SNO_names := {Brief_Name => Cred_Limit_Affect}
	$array_SNO_names = [];
	$query = 'SELECT `Brief_Name`, `Cred_Limit_Affect` FROM `SNO`';
	$result_array = getTable($query);
	if (!$result_array) 
	return $array_SNO_names;
	foreach ($result_array as $row)
	{
		$array_SNO_names[$row['Brief_Name']]=$row['Cred_Limit_Affect'];
	}
	return $array_SNO_names;	
}

function fill_calc_limit_dates()
{
	// Найдем все ГСЗ из таблицы GSZ, для которых не введена дата расчета кредитного лимита в таблице calc_limit_dates
	$query = 'SELECT `GSZ`.`Id` FROM `GSZ` LEFT JOIN `calc_limit_dates` ON `GSZ`.`Id`=`calc_limit_dates`.`GSZ_Id` WHERE `calc_limit_dates`.`GSZ_Id` IS NULL;';
	$GSZ_array = getCol($query);
	// Всем найденным ГСЗ в качестве даты расчета кредитного лимита проставим текущую дату 
	$data = [];
	foreach ($GSZ_array as $GSZ_Id)
	{
		$data["Date_calc_limit"] = date("Y.m.d");
		$data["GSZ_Id"] = $GSZ_Id;
		$result = addRow("calc_limit_dates", $data);
	}
}

?>