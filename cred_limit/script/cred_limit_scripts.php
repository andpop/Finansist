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


class GSZ_Item 
{
	public $Id, $Brief_Name, $Full_Name;

	function __construct($id)
	{
		$mysqli = db_connect();
		$query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$id}";
		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		
		$this->Brief_Name = htmlspecialchars($row['Brief_Name']);
		$this->Full_Name = htmlspecialchars($row['Full_Name']);
		$this->Id = $id;
		
		$mysqli->close();		
	}
}

class Company_Item 
{
	public $Id, $Name, $INN, $GSZ_Id, $OPF_Id, $OPF, $SNO_Id, $SNO;

	function __construct($Company_Id)
	{
		$mysqli = db_connect();

		$query = "SELECT `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `A`.`GSZ_Id` AS `GSZ_Id`, `A`.`OPF_Id` AS `OPF_Id`, `A`.`SNO_Id` AS `SNO_Id`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ";
		$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
		$query .= "WHERE `A`.`Id`={$Company_Id} AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";

		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		
		$this->Id = $Company_Id;
		$this->Name = htmlspecialchars($row['Name']);
		$this->INN = $row['INN'];
		$this->GSZ_Id = $row['GSZ_Id'];
		$this->OPF_Id = $row['OPF_Id'];
		$this->SNO_Id = $row['SNO_Id'];
		$this->OPF = $row['OPF'];
		$this->SNO = $row['SNO'];
		// $OPF = get_OPF_name_by_id($OPF_Id);
		// $SNO = get_SNO_name_by_id($SNO_Id);

		$mysqli->close();		
	}
}
function get_GSZ_set()
{
	// GSZ_row := {Id, Brief_Name, Full_Name}
	$mysqli = db_connect();
	$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
	$GSZ_set = $mysqli->query($query);
	$mysqli->close();		
	return $GSZ_set;
}

function get_company_set($GSZ_Id)
{
	// company_row := {Id, Name, INN, OPF, SNO}
	$mysqli = db_connect();
	$query = "SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ";
	$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
	$query .= "WHERE (`A`.`GSZ_Id`={$GSZ_Id}) AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";
	$company_set = $mysqli->query($query);
	$mysqli->close();		
	return $company_set;
}

function get_error_message() 
{
	if (isset($_GET['error']))
		return (ERROR_MESSAGE_PREFIX . '<strong>'.htmlspecialchars(urldecode($_GET['error'])).'.</strong>');
	else
		return NO_ERRORS_MESSAGE;
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
	$array_OPF_names = [];
	$mysqli = db_connect();
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
	$array_SNO_names = [];
	$mysqli = db_connect();
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