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
			case "edit_form":    // Форма для редактирования записи
				edit_company_form(); 
				break;
			
			default:
				show_company_list();
				break;
		}
		$mysqli->close();		
		
		//Вывод всех компаний из определенной группы связанных заемщиков
		function show_company_list()
		{
			
			echo '<div class="container">'.PHP_EOL;
			echo '<header>'.PHP_EOL;
			echo '<h2 class="text-center">КОМПАНИИ ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>'.PHP_EOL;
			echo '</header>'.PHP_EOL;

			$GSZ_Id = $_GET["GSZ_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $GSZ_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			
			echo '<div class="jumbotron">'.PHP_EOL;
			
			if (isset($_GET['error']))
			{
				$s = '<div id="error_message" class="alert alert-danger" role="alert">При сохранении данных произошла ошибка: ';
				$s .= htmlspecialchars(urldecode($_GET['error'])).'. ';
				$s .= '<button id="btnError_message" type="button" class="btn btn-info btn-xs";">Закрыть</button></div>'.PHP_EOL;
				echo $s;
			}

			global $mysqli;

			$query = "SELECT `Brief_Name` FROM `gsz` WHERE `Id`={$GSZ_Id}";
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();

			echo "<h3>{$row['Brief_Name']}</h3>".PHP_EOL;


			echo '<table class="table">'.PHP_EOL;
			echo '<tr><th>Название</th><th>ИНН</th><th>ОПФ</th><th>СНО</th></tr>'.PHP_EOL;


			$query = "SELECT `A`.`Id` AS `Id`, `A`.`Name` AS `Name`, `A`.`INN` AS `INN`, `B`.`Brief_Name` AS `OPF`, `C`.`Brief_Name` AS `SNO` ";
			$query .= "FROM `Company` `A`, `OPF` `B`, `SNO` `C` ";
			$query .= "WHERE (`A`.`GSZ_Id`={$GSZ_Id}) AND (`A`.`OPF_Id`=`B`.`Id`) AND (`A`.`SNO_Id`=`C`.`Id`)";

			$result_set = $mysqli->query($query);

			while (($row = $result_set->fetch_assoc()) != false) 
			{
				$id = $row['Id'];
				$s = "<tr><td>{$row['Name']}</td><td>{$row['INN']}</td><td>{$row['OPF']}</td><td>{$row['SNO']}</td>".PHP_EOL;
				$s .= "<td><a class=\"btn btn-link btn-xs\" href=\"company_edit.php?Company_Id={$id}\">Изменить</a></td>".PHP_EOL;
				$s .= "<td><a class=\"btn btn-link btn-xs\" href=\"company_confirm_delete.php?Company_Id={$id}\">Удалить</a></td>".PHP_EOL;
				$s .= "</tr>".PHP_EOL;
				echo $s;
			} //end of while $row
			echo "</table>".PHP_EOL;
			echo "<a class=\"btn btn-primary\" href=\"company_add.php?GSZ_Id={$GSZ_Id}\">Добавить</a> ";
			echo '<a class="btn btn-warning" href=".\gsz_forms.php">Вернуться</a>';
			echo "</div>"; //end of Jumbotron
			echo "</div>"; 	//end of class="container"
			
		} //end of function show_gsz_forms

		
		

		/**
		* Printing HTML-form for editing company of the GSZ 
		*/
		function edit_company_form()
		{
			// !!!!! Добавить ограничения длины полей ввода в форме
			echo '<div class="container">'.PHP_EOL;
			echo '<header>'.PHP_EOL;
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>'.PHP_EOL;
			echo '</header>'.PHP_EOL;
			
			$Company_Id = $_GET["Company_Id"];
			// !!!!!!!!!!!!! Доделать проверку !!!!!!!!!!!!!!!!!!!!!
			if (!preg_match("/^\d+$/", $Company_Id))
			{
				exit("Неверный формат URL-запроса");
			}
			
			global $mysqli;
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

			echo '<div class="jumbotron">'.PHP_EOL;

			$s = '<div id="info_message" class="alert alert-info" role="alert"><strong>Внимание! Компания с системой налогооблажения ЕНВД не участвует в расчете кредитного лимита! </strong>';
			// $s .= htmlspecialchars(urldecode($_GET['error'])).'. ';
			$s .= '<button id="btnError_message" type="button" class="btn btn-default btn-xs";">Закрыть</button></div>'.PHP_EOL;
			echo $s;


			echo '<h3>Компания из ГСЗ: '.get_GSZ_name_by_id($GSZ_Id).'</h3>'.PHP_EOL;

			echo '<form name="edit_form" action="script/company_save_item.php?action=update" method="POST">'.PHP_EOL;
			echo "<input type=\"hidden\" name=\"Company_Id\" Id=\"Company_Id\" value=\"{$Company_Id}\">".PHP_EOL;
			echo "<input type=\"hidden\" name=\"GSZ_Id\" Id=\"GSZ_Id\" value=\"{$GSZ_Id}\">".PHP_EOL;
	        echo '<div class="form-group">'.PHP_EOL;
            echo '<label for="Company_Name">Название</label>'.PHP_EOL;
            echo "<input type=\"text\" class=\"form-control\" name=\"Company_Name\" id=\"Company_Name\"  maxlength=".MAX_LENGTH_COMPANY_NAME." value=\"{$Name}\">".PHP_EOL;
        	echo '</div>'.PHP_EOL;

	        echo '<div class="form-group">'.PHP_EOL;
            echo '<label for="INN">ИНН</label>'.PHP_EOL;
            echo '<input type="text" class="form-control" name="INN" id="INN" maxlength=12 minlength=10 value="'.$INN.'">'.PHP_EOL;
        	echo '</div>'.PHP_EOL;

            echo '<div class="form-group">'.PHP_EOL;
            echo '    <label for="OPF">Организационно-правовая форма</label>'.PHP_EOL;
            echo '    <select class="form-control"  name="OPF" id="OPF">'.PHP_EOL;
            foreach (get_OPF_names() as $OPF_name) 
            	if ($OPF_name==$OPF)
            		echo "      <option selected>{$OPF_name}</option>".PHP_EOL;
            	else
            		echo "      <option>{$OPF_name}</option>".PHP_EOL;
            echo '    </select>                           '.PHP_EOL;
            echo '</div>'.PHP_EOL;


            echo '<div class="form-group">'.PHP_EOL;
            echo '    <label for="SNO">Система налогооблажения</label>'.PHP_EOL;
            echo '    <select class="form-control"  name="SNO" id="SNO">'.PHP_EOL;
            foreach (get_SNO_names() as $SNO_name) 
            	if ($SNO_name==$SNO)
            		echo "      <option selected>{$SNO_name}</option>".PHP_EOL;
            	else
            		echo "      <option>{$SNO_name}</option>".PHP_EOL;
            echo '    </select>                           '.PHP_EOL;
            echo '</div>'.PHP_EOL;


        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> '.PHP_EOL;
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>'.PHP_EOL.PHP_EOL;
        	echo '</form>'.PHP_EOL;
			echo '</div>'.PHP_EOL; // end of Jumbotron
			echo '</div>'.PHP_EOL; 	//class="container"
		}

		?>


	<script type="text/javascript" src="/js/jquery-1.12.2.min.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.min.js"></script> 
	<script type="text/javascript" src="js/cred_limit.js"></script>
</body>
</html>