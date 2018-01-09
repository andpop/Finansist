<?php
	require_once('script/cred_limit_scripts.php');

	if ((!isset($get["Company_Id"])) || (!ctype_digit($get["Company_Id"])))
	{
		$error_message = urlencode("Указаны некорректные параметры удаления компании из ГСЗ");
		redirect(HTML_PATH_GSZ_LIST_FORM.'?error='.$error_message);
	}
	
	$Company_item = new Company_item($get["Company_Id"]);
?>

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
	
	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<div class="alert alert-info" role="alert">
				<h3>Удалить компанию <?=$Company_item->Name?> (ИНН <?=$Company_item->INN?>) из ГСЗ <?=$Company_item->GSZ_Name?>?</h3>
			</div>
			<a class="btn btn-primary" href="<?=HTML_PATH_COMPANY_SAVE_ITEM?>?action=delete&Company_Id=<?=$Company_item->Id?>&GSZ_Id=<?=$Company_item->GSZ_Id?>">Удалить</a>
			<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
		</div> 
	</div> 	
	
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>