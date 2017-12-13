<?php 
require_once '../script/app_config.php';

define('MAX_LENGTH_COMPANY_NAME', 150);

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