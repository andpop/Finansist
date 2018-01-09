<?php
// Параметры подключения к БД
require_once 'connection_params.php';

// Настройка кодировки и уровня обработки ошибок
mb_internal_encoding("UTF-8");
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Защита от xss
$request = xss($_REQUEST);
$post = xss($_POST);
$get = xss($_GET);


// ===========================================================================================
// Служебные функции
// ===========================================================================================

function xss($data)
{
    if (is_array($data)) 
    {
        $escaped = array();
        foreach ($data as $key => $value)
        {
            $escaped[$key] = xss($value);
        }
        return $escaped;
    }
    return trim(htmlspecialchars($data));
}

function redirect($link) 
{
    header("Location: $link");
    exit;
}


function db_connect(){
	$mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
	
	if ($mysqli->connect_errno) {
		exit("Ошибка при подключении к БД: ".$mysqli->connect_error);
	}	
	
    if (!$mysqli->set_charset("utf8")){
        printf("Error: ".$mysqli->error);
    }
    
   return $mysqli; 
}
?>
