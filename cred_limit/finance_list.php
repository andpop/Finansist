<?php
    require_once('./script/cred_limit_scripts.php');
    $GSZ_set = get_GSZ_set();
	$error_message = get_error_message();
?>
<!-- ==================================================================================================== -->
<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Финансовые данные ГСЗ</title>
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
			<h2 class="text-center">ФИНАНСОВЫЕ ДАННЫЕ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>

		<div class="jumbotron">
			<div id="error_message_div" class="alert alert-danger" role="alert">
				<span id="error_message"><?=$error_message?></span>
				<button id="btnError_message" type="button" class="btn btn-info btn-xs">Закрыть</button>
			</div>

			<h3><?=$GSZ_item->Brief_Name?></h3>
			<table class="table">
				<tr>
					<th>Название</th><th>ИНН</th><th>ОПФ</th><th>СНО</th><th>Дата регистрации</th><th>Начало деятельности</th>
				</tr>

				<?php 
				foreach ($company_set as $company) { ?>
				<tr>
					<td><?=$company['Name']?></td><td><?=$company['INN']?></td><td><?=$company['OPF']?></td><td><?=$company['SNO']?></td>
					<td><?=$company['Date_Registr']?></td><td><?=$company['Date_Begin_Work']?></td>
					<td><a class="btn btn-link btn-xs" href="<?=HTML_PATH_COMPANY_EDIT_FORM?>?Company_Id=<?=$company['Id']?>">Изменить</a></td>
					<td><a class="btn btn-link btn-xs" href="<?=HTML_PATH_COMPANY_DELETE_FORM?>?Company_Id=<?=$company['Id']?>">Удалить</a></td>
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