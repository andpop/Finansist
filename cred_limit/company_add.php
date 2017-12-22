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
	
	// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
	$GSZ_Id = $_GET["GSZ_Id"];
	if (!preg_match("/^\d+$/", $GSZ_Id))
	{
		exit("Неверный формат URL-запроса");
	}
	?>

	<div class="container">
		<header>
			<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
	
		<div class="jumbotron">
		
			<h3>Новая компания из ГСЗ: <?=get_GSZ_name_by_id($GSZ_Id)?></h3>
			<form name="add_form" action="script/company_save_item.php?action=add" method="POST">
		
				<input type="hidden" name="GSZ_Id" id="GSZ_Id" value=<?=$GSZ_Id?>>
				<div class="form-group">
					<label for="Company_Name">Название</label>
					<input type="text" class="form-control" name="Company_Name" id="Company_Name" maxlength="<?=MAX_LENGTH_COMPANY_NAME?>" placeholder="Наименование компании">
				</div>
		
				<div class="form-group">
					<label for="INN">ИНН</label>
					<input type="text" class="form-control" name="INN" id="INN" maxlength=12 minlength=10 placeholder="123456789012">
				</div>
			
				<div class="form-group">
					<label for="OPF">Организационно-правовая форма</label>
					<select class="form-control"  name="OPF" id="OPF">
						<?php
						foreach (get_OPF_names() as $OPF_name) 
							echo "      <option>{$OPF_name}</option>".PHP_EOL;
						?>
					</select>
				</div>'
			
				<div class="form-group">
					<label for="SNO">Система налогооблажения</label>
					<select class="form-control"  name="SNO" id="SNO">
						<?php
						foreach (get_SNO_names() as $SNO_name) 
						echo "      <option>{$SNO_name}</option>".PHP_EOL;
						?>
					</select>
				</div>
			
				<button type="submit" class="btn btn-primary">Сохранить</button> 
				<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
			</form>
		</div> 
	</div> 	
		
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>