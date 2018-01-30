<?php
    require_once('./script/cred_limit_scripts.php');
	fill_calc_limit_dates();
    $GSZ_set = get_GSZ_set_with_calc_limit_date();
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
			<h2 class="text-center">ФИНАНСОВЫЕ ДАННЫЕ ГРУПП СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
		</header>

		<div class="jumbotron">
			<div id="error_message_div" class="alert alert-danger" role="alert">
				<span id="error_message"><?=$error_message?></span>
				<button id="btnError_message" type="button" class="btn btn-info btn-xs">Закрыть</button>
			</div>

			<table class="table">
				<tr>
					<th>Название ГСЗ</th><th>Начало деятельности</th><th>Компаний в группе</th><th>Дата расчета лимита</th>
				</tr>

				<?php 
				foreach ($GSZ_set as $GSZ) { ?>
				<tr>
					<td><?=$GSZ['Brief_Name']?></td><td><?=$GSZ['Date_begin_work']?></td><td><?=$GSZ['Count_company']?></td><td><?=$GSZ['Date_calc_limit']?></td>
				</tr>
				<?php
				} 
				?>
			</table>
		</div>
	</div>
		
	<!-- <script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script> -->
</body>
</html>