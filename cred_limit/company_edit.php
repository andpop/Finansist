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
	
	$mysqli = db_connect();

	$Company_Id = $_GET["Company_Id"];
	// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
	if (!preg_match("/^\d+$/", $Company_Id))
	{
		exit("Неверный формат URL-запроса");
	}
	
	$query = "SELECT `Name`, `INN`, `GSZ_Id`, `OPF_Id`, `SNO_Id` FROM `Company` WHERE `Id`={$Company_Id}";
	$result_set = $mysqli->query($query);
	$row = $result_set->fetch_assoc();
	// Попробовать extract() для получения переменных
	$Name = htmlspecialchars($row['Name']);
	$INN = $row['INN'];
	$GSZ_Id = $row['GSZ_Id'];
	$OPF_Id = $row['OPF_Id'];
	$SNO_Id = $row['SNO_Id'];
	$OPF = get_OPF_name_by_id($OPF_Id);
	$SNO = get_SNO_name_by_id($SNO_Id);
	$mysqli->close();		
	?>	

	 <!-- !!!!! Добавить ограничения длины полей ввода в форме -->
	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">

			<div id="info_message" class="alert alert-info" role="alert">
				<strong>Внимание! Компания с системой налогооблажения ЕНВД не участвует в расчете кредитного лимита! </strong>
				<button id="btnError_message" type="button" class="btn btn-default btn-xs">Закрыть</button>
			</div>

			<h3>Компания из ГСЗ: <?=get_GSZ_name_by_id($GSZ_Id)?></h3>

			<form name="edit_form" action="script/company_save_item.php?action=update" method="POST">
				<input type="hidden" name="Company_Id" Id="Company_Id" value="<?=$Company_Id?>">
				<input type="hidden" name="GSZ_Id" Id="GSZ_Id" value="<?=$GSZ_Id?>">
				<div class="form-group">
					<label for="Company_Name">Название</label>
					<input type="text" class="form-control" name="Company_Name" id="Company_Name"  maxlength="<?=MAX_LENGTH_COMPANY_NAME?>" value="<?=$Name?>">
				</div>

				<div class="form-group">
					<label for="INN">ИНН</label>
					<input type="text" class="form-control" name="INN" id="INN" maxlength=12 minlength=10 value="<?=$INN?>">
				</div>

				<div class="form-group">
				    <label for="OPF">Организационно-правовая форма</label>
				    <select class="form-control"  name="OPF" id="OPF">
						<?php
						foreach (get_OPF_names() as $OPF_name) 
						if ($OPF_name==$OPF)
							echo "      <option selected>{$OPF_name}</option>".PHP_EOL;
						else
							echo "      <option>{$OPF_name}</option>".PHP_EOL;
						?>
					</select>
				</div>

				<div class="form-group">
			    	<label for="SNO">Система налогооблажения</label>
			    	<select class="form-control"  name="SNO" id="SNO">
					<?php
					foreach (get_SNO_names() as $SNO_name) 
						if ($SNO_name==$SNO)
							echo "      <option selected>{$SNO_name}</option>".PHP_EOL;
						else
					echo "      <option>{$SNO_name}</option>".PHP_EOL;
					?>
					</select>
				</div>

				<button type="submit" class="btn btn-primary">Сохранить</button> 
				<button ts="btn btn-warning" onClick="history.back();">Отменить</button>;
			</form>
		</div> 
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>