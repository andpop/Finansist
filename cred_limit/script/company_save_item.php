<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');
	require_once('cred_limit_scripts.php');

	// $mysqli = db_connect();
	if (!isset($request["action"])) exit;

	switch ($request["action"])
	{
		case 'add':
			if ((!isset($post['GSZ_Id'])) || (!ctype_digit($post['GSZ_Id'])))
			{
				$error_message = urlencode("Указан некорректный код ГСЗ");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$GSZ_Id = $post['GSZ_Id'];
			
			$data = [];
			$data["Name"] = $mysqli->real_escape_string($post['Company_Name']);
			$data["INN"] = $mysqli->real_escape_string($post['INN']);
			// $data["OPF"] = $post['OPF'];
			// $data["SNO"] = $post['SNO'];
			$data["GSZ_Id"] = $post['GSZ_Id'];
			$data["OPF_Id"] = get_OPF_Id_by_Name($post['OPF']);
			$data["SNO_Id"] = get_SNO_Id_by_Name($post['SNO']);
			$result = addRow("Company", $data);
			if (!$result) $error_message = urlencode("Ошибка при добавлении компании в ГСЗ");

			// $query = 'INSERT INTO `Company` (`Name`, `INN`, `OPF_Id`, `SNO_Id`, `GSZ_Id`) ';
			// $query .= 'VALUES ("'.$Name.'", '.$INN.', '.$OPF_Id.', '.$SNO_Id.', '.$GSZ_Id.')';
			break;
		
		case 'update':
			if ((!isset($post['GSZ_Id'])) || (!ctype_digit($post['GSZ_Id'])))
			{
				$error_message = urlencode("Указан некорректный код ГСЗ");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$GSZ_Id = $post['GSZ_Id'];

			if ((!isset($post['Company_Id'])) || (!ctype_digit($post['Company_Id'])))
			{
				$error_message = urlencode("Указан некорректный код обновляемой компании");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$data = [];
			$data["Id"] = $post['Company_Id'];
			$data["GSZ_Id"] = $post['GSZ_Id'];
			$data["Name"] = $mysqli->real_escape_string($post['Company_Name']);
			$data["INN"] = $mysqli->real_escape_string($post['INN']);
			
			$data["OPF_Id"] = get_OPF_Id_by_Name($post['OPF']);
			$data["SNO_Id"] = get_SNO_Id_by_Name($post['SNO']);
			if ($data["OPF_Id"] == -1) 
			{
				$error_message = urlencode("Не найден код ОПФ");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			elseif ($data["SNO_Id"] == -1)
			{
				$error_message = urlencode("Не найден код СНО");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}

			$result = setRow("Company", $post['Company_Id'], $data);
			// $query = 'UPDATE `Company` SET `Name`="'.$Name.'", `INN`='.$INN.', `OPF_Id`='.$OPF_Id.', `SNO_Id`='.$SNO_Id.' WHERE `Id`='.$Id;
			break;
		
		case 'delete':
			if ((!isset($get['GSZ_Id'])) || (!ctype_digit($get['GSZ_Id'])))
			{
				$error_message = urlencode("Указан некорректный код ГСЗ удаляемой компании");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$GSZ_Id = $get['GSZ_Id'];
			
			if ((!isset($get['Company_Id'])) || (!ctype_digit($get['Company_Id'])))
			{
				$error_message = urlencode("Указан некорректный код удаляемой компании");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}

			$result = deleteRow("Company", $get['Company_Id']);
			if (!$result) $error_message = urlencode("Ошибка при удалении компании из ГСЗ");
			// $query = 'DELETE FROM `Company` WHERE `Id`='.$get['Company_Id'];
			break;
		
		default:
			$error_message = urlencode("Указан неверный код операции с компанией из ГСЗ");
			redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
	}
	$result ? redirect(HTML_PATH_COMPANY_LIST_FORM.'?GSZ_Id='.$GSZ_Id) : redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");	
	// $mysqli->query($query);
	// if ($mysqli->errno)
	// {
	// 	$url_param = "GSZ_Id={$GSZ_Id}&error=".urlencode($mysqli->error);
	// 	header( 'Location: '.HTML_PATH_COMPANY_LIST_FORM.'?'.$url_param);
	// }
	// else
	// {
	// 	redirect(HTML_PATH_COMPANY_LIST_FORM.'?GSZ_Id='.$GSZ_Id);
	// }
 	// die();
?>