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
	<?php require_once('./script/cred_limit_scripts.php'); 	?>

	<div class="container">
		<header>
			<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>
		<div class="jumbotron">
			<h3>Новая группа</h3>
			<form name="add_form" action="script/gsz_save_item.php?action=add" method="POST">
			<div class="form-group">
				<label for="GSZ_Brief_Name">Название</label>
				<input type="text" class="form-control" name="GSZ_Brief_Name" id="GSZ_Brief_Name" maxlength="<?=MAX_LENGTH_GSZ_BRIEF_NAME?>" placeholder="Краткое название ГСЗ">
			</div>
			<div class="form-group">
				<label for="GSZ_Full_Name">Описание</label>
				<input type="text" class="form-control" name="GSZ_Full_Name" id="GSZ_Full_Name" maxlength="<?=MAX_LENGTH_GSZ_FULL_NAME?>" placeholder="Описание ГСЗ">
			</div>
			<button type="submit" class="btn btn-primary">Сохранить</button> 
			<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>
			</form>
		</div> 
	</div> 
</div> 
</body>
</html>