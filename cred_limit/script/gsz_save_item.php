<?php
	require_once("cred_limit_scripts.php");
	if (!isset($request["action"])) exit;

	switch ($request["action"])
	{
		case 'add':
			if ((!isset($request['GSZ_Brief_Name'])) || (!isset($request['GSZ_Full_Name'])))
			{
				$error_message = urlencode("Не указаны наименования ГСЗ для добавления");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}

			$Brief_Name = $mysqli->real_escape_string( $request['GSZ_Brief_Name'] );
			$Full_Name = $mysqli->real_escape_string( $request['GSZ_Full_Name'] );
			$query = "INSERT INTO `GSZ` (`Brief_Name`, `Full_Name`) VALUES ('".$Brief_Name."', '".$Full_Name."')";
			break;
		case 'update':
			if ((!isset($request['GSZ_Brief_Name'])) || (!isset($request['GSZ_Full_Name'])))
			{
				$error_message = urlencode("Не указаны наименования ГСЗ для обновления");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}

			$Brief_Name = $mysqli->real_escape_string( $request['GSZ_Brief_Name'] );
			$Full_Name = $mysqli->real_escape_string( $request['GSZ_Full_Name'] );

			//Проверяем, является ли параметр Id целым числом
			if ((!isset($request['Id'])) || (!ctype_digit($request['Id'])))
			{
				$error_message = urlencode("Указан некорректный URL");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			
			$query = 'UPDATE `GSZ` SET `Brief_Name`="'.$Brief_Name.'", `Full_Name`="'.$Full_Name.'" WHERE `Id`='.$request['Id'];
			break;
			
		case 'delete':
			//Проверяем, является ли параметр Id целым числом
			if ((!isset($request['Id'])) || (!ctype_digit($request['Id'])))
			{
				$error_message = urlencode("Указан некорректный URL");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			
			$query = 'DELETE FROM `GSZ` WHERE `Id`='.$request['Id'];
			break;
		default:
			$error_message = urlencode("Указан неверный код операции с ГСЗ");
			redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
	}
		
	$mysqli->query($query);
	redirect(HTML_PATH_GSZ_LIST_FORM);
?>