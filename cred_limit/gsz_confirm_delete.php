<?php
	require_once('./script/cred_limit_scripts.php');
	// $GSZ_Id = $_GET["GSZ_Id"];
	if (!ctype_digit($_GET["GSZ_Id"]))
	{
		$error_message = urlencode("Указан некорректный URL");
		header( 'Location: gsz_list.php?error='.$error_message);
	}
	$GSZ_item = new GSZ_item($_GET["GSZ_Id"]);
?>
<!-- =========================================================================== -->
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
	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<div class="alert alert-info" role="alert">
				<h3>Удалить группу <?=$GSZ_item->Brief_Name?>?</h3>
			</div>
			<a class="btn btn-primary" href="script/gsz_save_item.php?action=delete&Id=<?=$GSZ_item->id?>">Удалить</a> 
			<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
		</div> 
	</div> 	

</div> 
</body>
</html>