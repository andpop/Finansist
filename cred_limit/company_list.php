<?php
	require_once('./script/cred_limit_scripts.php');
	$GSZ_Id = $_GET["GSZ_Id"];
	if (!ctype_digit($_GET["GSZ_Id"]))
	{
		$error_message = urlencode("Указан некорректный URL");
		header( 'Location: '.HTML_PATH_COMPANY_LIST_FORM.'?error='.$error_message);
	}
	$GSZ_item = new GSZ_item($_GET["GSZ_Id"]);
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
	<?php
		

		$mysqli = db_connect();
		$query = "SELECT `Brief_Name` FROM `gsz` WHERE `Id`={$GSZ_Id}";
		$gsz_result_set = $mysqli->query($query);
		$gsz_row = $gsz_result_set->fetch_assoc();

		$query = "SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ";
		$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
		$query .= "WHERE (`A`.`GSZ_Id`={$GSZ_Id}) AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";
		$company_result_set = $mysqli->query($query);

		$mysqli->close();		
	?>		

	<div class="container">
		<header>
			<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>

		<div class="jumbotron">
			<?php
			if (isset($_GET['error']))
			{
				$message = htmlspecialchars(urldecode($_GET['error'])).'. ';
			?>

			<div id="error_message" class="alert alert-danger" role="alert">
				При сохранении данных произошла ошибка: <?=$message?>
				<button id="btnError_message" type="button" class="btn btn-info btn-xs">Закрыть</button>
			</div>
			<?php
			} //if (isset($_GET['error']))
			?>

			<h3><?=$gsz_row['Brief_Name']?></h3>
			<table class="table">
				<tr>
					<th>Название</th><th>ИНН</th><th>ОПФ</th><th>СНО</th>
				</tr>

				<?php
				while (($row = $company_result_set->fetch_assoc()) != false) 
				{
					$id = $row['Id'];
				?>
				<tr>
					<td><?=$row['Name']?></td><td><?=$row['INN']?></td><td><?=$row['OPF']?></td><td><?=$row['SNO']?></td>
					<td><a class="btn btn-link btn-xs" href="company_edit.php?Company_Id=<?=$id?>">Изменить</a></td>
					<td><a class="btn btn-link btn-xs" href="company_confirm_delete.php?Company_Id=<?=$id?>">Удалить</a></td>
				</tr>
				<?php
				} 
				?>
			</table>
			<a class="btn btn-primary" href="company_add.php?GSZ_Id=<?=$GSZ_Id?>">Добавить</a>
			<a class="btn btn-warning" href=".\gsz_list.php">Вернуться</a>
		</div>
	</div>
		
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>