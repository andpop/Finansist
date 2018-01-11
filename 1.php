<?php
require_once("./script/app_config.php");
$mysqli = db_connect();
$mysqli->set_charset("utf8");

$s ='Группа 1 "С кавычками"';
// echo $s;
$s1 = $mysqli->real_escape_string($s);
echo $s1;