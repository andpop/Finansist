<?php
	require_once('./script/cred_limit_scripts.php');
	if ((!isset($get["Company_Id"])) || (!ctype_digit($get["Company_Id"])) )
	{
		$error_message = urlencode("Указан некорректный URL для вывода списка компаний из ГСЗ");
		redirect(HTML_PATH_GSZ_LIST_FORM.'?error='.$error_message);
	}
    $company = new Company_Item($get["Company_Id"]);

    $GSZ = new GSZ_Item($company->GSZ_Id);
	$Balance_Dates = get_Balance_Dates($GSZ->Date_calc_limit, $company->Is_Corporation);
	$error_message = get_error_message();
?>
<!-- ==================================================================================================== -->
<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Баланс</title>
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
			<h2 class="text-center">БАЛАНС ОРГАНИЗАЦИИ</h2>
		</header>

		<div class="jumbotron">
			<div id="error_message_div" class="alert alert-danger" role="alert">
				<span id="error_message"><?=$error_message?></span>
				<button id="btnError_message" type="button" class="btn btn-info btn-xs">Закрыть</button>
			</div>

            <h3><?=$company->Name?></h3>
            <h4>ИНН: <?=$company->INN?></h4>
            <h4>Организационно-правовая форма: <?=$company->OPF?></h4>
            <h4>Дата начала деятельности: <?=$company->Date_Begin_Work?></h4>
            <h4>Дата расчета лимита: <?=$GSZ->Date_calc_limit?></h4>
            <h4>Даты для ввода баланса: <?=$Balance_Dates[0].", ".$Balance_Dates[1].", ".$Balance_Dates[2]?></h4>
		</div>
	</div>
		
	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>