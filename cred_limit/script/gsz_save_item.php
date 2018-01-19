<?php
	require_once("cred_limit_scripts.php");
	if (!isset($request["action"])) exit;

	switch ($request["action"])
	{
		case 'add':
			if ((!isset($_POST['GSZ_Brief_Name'])) || (!isset($_POST['GSZ_Full_Name'])))
			{
				$error_message = urlencode("Не указаны наименования ГСЗ для добавления");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$data = [];
			$data["Brief_Name"] = $_POST['GSZ_Brief_Name'];
			$data["Full_Name"] = $_POST['GSZ_Full_Name'];
			$data["Date_Begin_Work"] = $_POST['Date_Begin_Work'];
			$result = addRow("GSZ", $data);
			
			if (!$result) $error_message = urlencode("Ошибка при добавлении ГСЗ"); 
			// $Brief_Name = $mysqli->real_escape_string( $request['GSZ_Brief_Name'] );
			// $Full_Name = $mysqli->real_escape_string( $request['GSZ_Full_Name'] );
			// $query = "INSERT INTO `GSZ` (`Brief_Name`, `Full_Name`) VALUES ('".$Brief_Name."', '".$Full_Name."')";
			// $result = $mysqli->query($query);
			break;

		case 'update':
			if ((!isset($_POST['GSZ_Brief_Name'])) || (!isset($_POST['GSZ_Full_Name'])))
			{
				$error_message = urlencode("Не указаны наименования ГСЗ для обновления");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			//Проверяем, является ли параметр Id целым числом
			if ((!isset($_POST['Id'])) || (!ctype_digit($_POST['Id'])))
			{
				$error_message = urlencode("Указаны некорректные параметры для обновления данных о ГСЗ");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$data = [];
			$data["Brief_Name"] = $_POST['GSZ_Brief_Name'];
			$data["Full_Name"] = $_POST['GSZ_Full_Name'];
			$data["Date_Begin_Work"] = $_POST['Date_Begin_Work'];
			$result = setRow("GSZ", $_POST['Id'], $data);
			
			if (!$result) $error_message = urlencode("Ошибка при изменении ГСЗ");
			// $data["Brief_Name"] = $mysqli->real_escape_string( $request['GSZ_Brief_Name'] );
			// $data["Full_Name"] = $mysqli->real_escape_string( $request['GSZ_Full_Name'] );
			// $query = 'UPDATE `GSZ` SET `Brief_Name`="'.$Brief_Name.'", `Full_Name`="'.$Full_Name.'" WHERE `Id`='.$request['Id'];
			break;
			
		case 'delete':
			//Проверяем, является ли параметр Id целым числом
			if ((!isset($_GET['Id'])) || (!ctype_digit($_GET['Id'])))
			{
				$error_message = urlencode("Указан некорректный URL");
				redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
			}
			$result = deleteRow("GSZ", $_GET['Id']);
			if (!$result) $error_message = urlencode("Ошибка при удалении ГСЗ");
			// $query = 'DELETE FROM `GSZ` WHERE `Id`='.$request['Id'];
			break;

		default:
			$error_message = urlencode("Указан неверный код операции с ГСЗ");
			redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
		}
	$result ? redirect(HTML_PATH_GSZ_LIST_FORM) : redirect(HTML_PATH_GSZ_LIST_FORM."?error={$error_message}");
?>