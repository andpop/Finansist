<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Компании из ГСЗ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="/css/bootstrap.min.css" rel="stylesheet"/> 
	<link href="/css/style.css" rel="stylesheet"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');
	require_once('script/cred_limit_scripts.php');
		
	$Company_Id = $_GET["Company_Id"];
	// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
	if (!preg_match("/^\d+$/", $Company_Id))
	{
		exit("Неверный формат URL-запроса");
	}

	$mysqli = db_connect();
	$query = "SELECT `Name`, `INN`, `GSZ_Id` FROM `Company` WHERE `Id`={$Company_Id}";
	$result_set = $mysqli->query($query);
	$row = $result_set->fetch_assoc();
	// Попробовать extract() для получения переменных
	$Name = htmlspecialchars($row['Name']);
	$INN = $row['INN'];
	$GSZ_Id = $row['GSZ_Id'];
	$mysqli->close();		
	?>
	
	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<div class="alert alert-info" role="alert">
				<h3>Удалить компанию <?=$Name?> (ИНН <?=$INN?>) из ГСЗ <?=get_GSZ_name_by_id($GSZ_Id)?>?</h3>
			</div>
			<a class="btn btn-primary" href="script/company_save_item.php?action=delete&Company_Id=<?=$Company_Id?>&GSZ_Id=<?=$GSZ_Id?>">Удалить</a>
			<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
		</div> 
	</div> 	
	
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>