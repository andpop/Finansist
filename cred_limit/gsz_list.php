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
		require_once('./script/cred_limit_scripts.php');

		$mysqli = db_connect();
		$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
		$result_set = $mysqli->query($query);
		$mysqli->close();		
	?>

		
	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<table class="table">
				<tr><th>Название</th><th>Описание</th></tr>'
	<?php	
		while (($row = $result_set->fetch_assoc()) != false) 
		{
			$id = $row['Id'];
	?>
				<tr>
					<td><?=$row['Brief_Name']?></td>
					<td><?=$row['Full_Name']?></td>
					<td><a class="btn btn-primary btn-xs" href="company_forms.php?action=show_list&GSZ_Id=<?=$id?>">Компании</a></td>
					<td><a class="btn btn-link btn-xs" href="gsz_edit_item.php?id=<?=$id?>">Изменить</a></td>
					<td><a class="btn btn-link btn-xs" href="gsz_confirm_delete.php?GSZ_Id=<?=$id?>">Удалить</a></td>
				</tr>
	<?php
			} //end of while $row
	?>
			</table>
			<a class="btn btn-primary" href="gsz_add.php">Добавить</a>
			<a class="btn btn-warning" href="limit.html">Вернуться</a>
		</div>
	</div>
			
</body>
</html>