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
				$s .= '<td><a class="btn btn-link btn-xs" href="'.$_SERVER['PHP_SELF'].'?action=edit_form&id='.$id.'">Изменить</a></td>';
				$s .= '<td><a class="btn btn-link btn-xs" href="gsz_save_item.php?action=delete&Id='.$id.'">Удалить</a></td>';
				$s .= "</tr>\n";
				echo $s;
			} //end of while $row
			echo '</table>';
			echo '<a class="btn btn-primary" href="'.$_SERVER['PHP_SELF'].'?action=add_form&GSZ_Id='.$GSZ_Id.'">Добавить</a> ';
			echo '<a class="btn btn-warning" onClick="history.back();">Вернуться</a>';
			echo '</div>'; //end of Jumbotron
			$mysqli->close();		
		} //end of function show_gsz_list

		
		// Функция формирует форму для добавления записи в таблице БД
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
			$query = 'SELECT `Brief_Name` FROM `gsz` WHERE `Id`='.$GSZ_Id;
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();

			echo '<div class="jumbotron">';

			echo '<h3>Новая компания из ГСЗ: '.$row['Brief_Name'].'</h3>';
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
			$query = 'SELECT `Brief_Name` FROM `opf`';
			$result_set = $mysqli->query($query);
			while (($row = $result_set->fetch_assoc()) != false) 
			{
				echo '      <option>'.$row['Brief_Name'].'</option>';				
			}
            echo '    </select>                           ';
            echo '</div>';


            echo '<div class="form-group">';
            echo '    <label for="SNO">Система налогооблажения</label>';
            echo '    <select class="form-control"  name="SNO" id="SNO">';
			$query = 'SELECT `Brief_Name` FROM `sno`';
			$result_set = $mysqli->query($query);
			while (($row = $result_set->fetch_assoc()) != false) 
			{
				echo '      <option>'.$row['Brief_Name'].'</option>';				
			}
            echo '    </select>                           ';
            echo '</div>';

        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> ';
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
        	echo '</form>';
			echo '</div>'; // end of Jumbotron
		} //end of function get_add_item_form()


		// Функция формирует форму для редактирования записи в таблице БД
		function edit_item_form()
		{
			// !!!!! Добавить ограничения длины полей ввода в форме
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';
			echo '<div class="jumbotron">';


			echo '<h3>Изменение записи	</h3>';
			$mysqli = db_connect();
			$query = 'SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`='.$_GET['id'];
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			
			echo '<form name="edit_form" action="gsz_save_item.php?action=update" method="POST">';
			echo '<input type="hidden" name="Id" Id="Id" value="'.$_GET['id'].'">';
	        echo '<div class="form-group">';
            echo '<label for="GSZ_Brief_Name">Название</label>';
            echo '<input type="text" class="form-control" name="GSZ_Brief_Name" id="GSZ_Brief_Name"  maxlength='.$GLOBALS[MAX_LENGTH_BRIEF_NAME].' value="'.$row['Brief_Name'].'">';
        	echo '</div>';
        	echo '<div class="form-group">';
            echo '<label for="GSZ_Full_Name">Описание</label>';
            echo '<input type="text" class="form-control" name="GSZ_Full_Name" id="GSZ_Full_Name"  maxlength='.$GLOBALS[MAX_LENGTH_FULL_NAME].' value="'.$row['Full_Name'].'">';
        	echo '</div>';
        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> ';
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
        	echo '</form>';
			echo '</div>'; // end of Jumbotron
		}

		?>


</div> 
</body>
</html>