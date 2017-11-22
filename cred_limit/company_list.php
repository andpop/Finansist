<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Компании из ГСЗ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="../css/bootstrap.min.css" rel="stylesheet"/> 
	<link href="../css/style.css" rel="stylesheet"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
		require_once '../script/app_config.php';
		require_once './cred_limit_scripts.php';

		// $MAX_LENGTH_BRIEF_NAME = 30;
		$MAX_LENGTH_COMPANY_NAME = 150;

		if (!isset($_GET["action"])) 
				{
					$_GET["action"] = "show_list";
					$_GET["GSZ_Id"] = -1;
				}

		switch ($_GET["action"]) 
		{
			case 'show_list':  //Список всех записей из таблицы
				show_company_list();
				break;
			case "add_form":     // Форма для добавления новой записи
				add_item_form(); 
				break;
			case "edit_form":    // Форма для редактирования записи
				edit_item_form(); 
				break;
			case "confirm_delete":    // Форма для редактирования записи
				confirm_delete_form(); 
				break;
			
			default:
				show_company_list();
				break;
		}
		
		//Вывод всех записей из таблицы GSZ
		function show_company_list()
		{
			$mysqli = db_connect();
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';

			$GSZ_Id = $_GET["GSZ_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $GSZ_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			
			echo '<div class="jumbotron">';
			
			if (isset($_GET['error']))
			{
				$s = '<div id="error_message" class="alert alert-danger" role="alert">При сохранении данных произошла ошибка: ';
				$s .= htmlspecialchars(urldecode($_GET['error'])).'. ';
				$s .= '<button id="btnError_message" type="button" class="btn btn-info btn-xs";">Закрыть</button></div>';
				echo $s;
				// echo '<div class="alert alert-danger" role="alert">При сохранении данных произошла ошибка</div>';
			}

			$query = 'SELECT `Brief_Name` FROM `gsz` WHERE `Id`='.$GSZ_Id;
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();

			echo '<h3>'.$row['Brief_Name'].'</h3>';


			echo '<table class="table">';
			echo '<tr><th>Название</th><th>ИНН</th><th>ОПФ</th><th>СНО</th></tr>';


			$query = 'SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ';
			$query .= 'FROM `Company` `A`, `OPF` `B`, `SNO` `C` ';
			$query .= 'WHERE (`A`.`GSZ_Id`='.$GSZ_Id.') AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)';

			$result_set = $mysqli->query($query);

			while (($row = $result_set->fetch_assoc()) != false) 
			{
				$s = '<p>'.$row['Name'].' '.$row['INN'].' '.$row['OPF'].'</p>';
				
				$id = $row['Id'];
				$s = '<tr><td>'.$row['Name'].'</td>';
				$s .= '<td>'.$row['INN'].'</td>';
				$s .= '<td>'.$row['OPF'].'</td>';
				$s .= '<td>'.$row['SNO'].'</td>';
				$s .= '<td><a class="btn btn-link btn-xs" href="'.$_SERVER['PHP_SELF'].'?action=edit_form&Company_Id='.$id.'">Изменить</a></td>';
				$s .= '<td><a class="btn btn-link btn-xs" href="'.$_SERVER['PHP_SELF'].'?action=confirm_delete&Company_Id='.$id.'">Удалить</a></td>';
				$s .= "</tr>\n";
				echo $s;
			} //end of while $row
			echo '</table>';
			echo '<a class="btn btn-primary" href="'.$_SERVER['PHP_SELF'].'?action=add_form&GSZ_Id='.$GSZ_Id.'">Добавить</a> ';
			echo '<a class="btn btn-warning" href=".\gsz_list.php">Вернуться</a>';
			echo '</div>'; //end of Jumbotron
			echo '</div>'; 	//class="container"
			$mysqli->close();		
		} //end of function show_gsz_list

		
		// Вывод формы для добавления компании в БД
		function add_item_form()
		{
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';

			$GSZ_Id = $_GET["GSZ_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $GSZ_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			$mysqli = db_connect();

			echo '<div class="jumbotron">';

			echo '<h3>Новая компания из ГСЗ: '.get_GSZ_name_by_id($GSZ_Id).'</h3>';
			echo '<form name="add_form" action="company_save_item.php?action=add" method="POST">';

			echo '<input type="hidden" name="GSZ_Id" id="CSZ_Id" value='.$GSZ_Id.'>';
	        echo '<div class="form-group">';
            echo '<label for="Company_Name">Название</label>';
            echo '<input type="text" class="form-control" name="Company_Name" id="Company_Name" maxlength='.$GLOBALS[MAX_LENGTH_COMPANY_NAME].' placeholder="Наименование компании">';
        	echo '</div>';

	        echo '<div class="form-group">';
            echo '<label for="INN">ИНН</label>';
            echo '<input type="text" class="form-control" name="INN" id="INN" maxlength=12 placeholder="123456789012">';
        	echo '</div>';

            echo '<div class="form-group">';
            echo '    <label for="OPF">Организационно-правовая форма</label>';
            echo '    <select class="form-control"  name="OPF" id="OPF">';
            foreach (get_OPF_names() as $OPF_name) 
            	echo '      <option>'.$OPF_name.'</option>';
            echo '    </select>                           ';
            echo '</div>';


            echo '<div class="form-group">';
            echo '    <label for="SNO">Система налогооблажения</label>';
            echo '    <select class="form-control"  name="SNO" id="SNO">';
            foreach (get_SNO_names() as $SNO_name) 
            	echo '      <option>'.$SNO_name.'</option>';
            echo '    </select>                           ';
            echo '</div>';

        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> ';
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
        	echo '</form>';
			echo '</div>'; // end of Jumbotron
			echo '</div>'; 	//class="container"
		} //end of function get_add_item_form()


		// Функция формирует форму для редактирования записи в таблице БД
		function edit_item_form()
		{
			// !!!!! Добавить ограничения длины полей ввода в форме
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';
			
			$Company_Id = $_GET["Company_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $Company_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			$mysqli = db_connect();
			$query = 'SELECT `Name`, `INN`, `GSZ_Id`, `OPF_Id`, `SNO_Id` FROM `Company` WHERE `Id`='.$Company_Id;
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

			echo '<div class="jumbotron">';
			echo '<h3>Компания из ГСЗ: '.get_GSZ_name_by_id($GSZ_Id).'</h3>';

			echo '<form name="edit_form" action="company_save_item.php?action=update" method="POST">';
			echo '<input type="hidden" name="Company_Id" Id="Company_Id" value="'.$Company_Id.'">';
			echo '<input type="hidden" name="GSZ_Id" Id="GSZ_Id" value="'.$GSZ_Id.'">';
	        echo '<div class="form-group">';
            echo '<label for="Company_Name">Название</label>';
            echo '<input type="text" class="form-control" name="Company_Name" id="Company_Name"  maxlength='.$GLOBALS[MAX_LENGTH_COMPANY_NAME].' value="'.$Name.'">';
        	echo '</div>';

	        echo '<div class="form-group">';
            echo '<label for="INN">ИНН</label>';
            echo '<input type="text" class="form-control" name="INN" id="INN" maxlength=12 value="'.$INN.'">';
        	echo '</div>';

            echo '<div class="form-group">';
            echo '    <label for="OPF">Организационно-правовая форма</label>';
            echo '    <select class="form-control"  name="OPF" id="OPF">';
            foreach (get_OPF_names() as $OPF_name) 
            	if ($OPF_name==$OPF)
            		echo '      <option selected>'.$OPF_name.'</option>';
            	else
            		echo '      <option>'.$OPF_name.'</option>';
            echo '    </select>                           ';
            echo '</div>';


            echo '<div class="form-group">';
            echo '    <label for="SNO">Система налогооблажения</label>';
            echo '    <select class="form-control"  name="SNO" id="SNO">';
            foreach (get_SNO_names() as $SNO_name) 
            	if ($SNO_name==$SNO)
            		echo '      <option selected>'.$SNO_name.'</option>';
            	else
            		echo '      <option>'.$SNO_name.'</option>';
            echo '    </select>                           ';
            echo '</div>';


        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> ';
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
        	echo '</form>';
			echo '</div>'; // end of Jumbotron
			echo '</div>'; 	//class="container"
		}

		// Форма для подтверждения удаления компании из ГСЗ 
		function confirm_delete_form()
		{
			//$s .= '<td><a class="btn btn-link btn-xs" href="company_save_item.php?action=delete&Company_Id='.$id.'&GSZ_Id='.$GSZ_Id.'">Удалить</a></td>';
			echo '<div class="container">';
			echo '	<header>';
			echo '		<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '	</header>';

			$Company_Id = $_GET["Company_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $Company_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			$mysqli = db_connect();
			$query = 'SELECT `Name`, `INN`, `GSZ_Id` FROM `Company` WHERE `Id`='.$Company_Id;
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			// Попробовать extract() для получения переменных
			$Name = htmlspecialchars($row['Name']);
			$INN = $row['INN'];
			$GSZ_Id = $row['GSZ_Id'];

			echo '<div class="jumbotron">';
			echo '	<h3>Удалить компанию '.$Name.' (ИНН '.$INN.') из ГСЗ '.get_GSZ_name_by_id($GSZ_Id).'?</h3>';
			echo '	<a class="btn btn-primary" href="company_save_item.php?action=delete&Company_Id='.$Company_Id.'&GSZ_Id='.$GSZ_Id.'">Удалить</a> ';
			echo '	<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
			echo '</div>'; //class="jumbotron"
			echo '</div>'; 	//class="container"

		}
		?>


	<script type="text/javascript" src="../js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="../js/cred_limit.js"></script>
</body>
</html>