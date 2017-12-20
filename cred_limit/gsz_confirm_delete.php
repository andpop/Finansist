<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Группы связанных заемщиков</title>
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
		//require_once('./script/cred_limit_scripts.php');
		$mysqli = db_connect();
		$GSZ_Id = $_GET["GSZ_Id"];
		// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
		if (!preg_match("/^\d+$/", $GSZ_Id))
		{
			exit("Неверный формат URL-запроса");
		}

		$query = "SELECT `Brief_Name` FROM `gsz` WHERE `Id`={$GSZ_Id}";
		$result_set = $mysqli->query($query);
		$row = $result_set->fetch_assoc();
		$Name = htmlspecialchars($row['Brief_Name']);
		$mysqli->close();		
	?>

	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<div class="alert alert-info" role="alert">
				<h3>Удалить группу <?=$Name?>?</h3>
			</div>
			<a class="btn btn-primary" href="script/gsz_save_item.php?action=delete&Id=<?=$GSZ_Id?>">Удалить</a> 
			<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
		</div> 
	</div> 	

</div> 
</body>
</html>