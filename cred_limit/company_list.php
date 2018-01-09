<?php
	require_once('./script/cred_limit_scripts.php');
	if ((!isset($get["GSZ_Id"])) || (!ctype_digit($get["GSZ_Id"])) )
	{
		$error_message = urlencode("Указан некорректный URL для вывода списка компаний из ГСЗ");
		redirect(HTML_PATH_GSZ_LIST_FORM.'?error='.$error_message);
	}
	$GSZ_item = new GSZ_item($get["GSZ_Id"]);
	$company_set = get_company_set($get["GSZ_Id"]);
	$error_message = get_error_message();
?>
<!-- ==================================================================================================== -->
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
			<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>

		<div class="jumbotron">
			<div id="error_message_div" class="alert alert-danger" role="alert">
				<span id="error_message"><?=$error_message?></span>
				<button id="btnError_message" type="button" class="btn btn-info btn-xs">Закрыть</button>
			</div>

			<h3><?=$GSZ_item->Brief_Name?></h3>
			<table class="table">
				<tr>
					<th>Название</th><th>ИНН</th><th>ОПФ</th><th>СНО</th>
				</tr>

				<?php 
				while (($company_row = $company_set->fetch_assoc()) != false) 
				{
				?>
				<tr>
					<td><?=$company_row['Name']?></td><td><?=$company_row['INN']?></td><td><?=$company_row['OPF']?></td><td><?=$company_row['SNO']?></td>
					<td><a class="btn btn-link btn-xs" href="<?=HTML_PATH_COMPANY_EDIT_FORM?>?Company_Id=<?=$company_row['Id']?>">Изменить</a></td>
					<td><a class="btn btn-link btn-xs" href="<?=HTML_PATH_COMPANY_DELETE_FORM?>?Company_Id=<?=$company_row['Id']?>">Удалить</a></td>
				</tr>
				<?php
				} 
				?>
			</table>
			<a class="btn btn-primary" href="<?=HTML_PATH_COMPANY_ADD_FORM?>?GSZ_Id=<?=$GSZ_item->Id?>">Добавить</a>
			<a class="btn btn-warning" href="<?=HTML_PATH_GSZ_LIST_FORM?>">Вернуться</a>
		</div>
	</div>
		
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>