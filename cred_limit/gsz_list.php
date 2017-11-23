<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Группы связанных заемщиков</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="../css/bootstrap.min.css" rel="stylesheet"/> 
	<link href="../css/style.css" rel="stylesheet"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
		echo phpversion();

		require_once '../script/app_config.php';

		$MAX_LENGTH_BRIEF_NAME = 30;
		$MAX_LENGTH_FULL_NAME = 150;
		
		if (!isset($_GET["action"])) $_GET["action"] = "show_list";
		switch ($_GET["action"]) 
		{
			case 'show_list':  //Список всех записей из таблицы
				show_gsz_list();
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
				show_gsz_list();
				break;
		}
		
		//Вывод всех записей из таблицы GSZ
		function show_gsz_list()
		{
			$mysqli = db_connect();
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';
			echo '<div class="jumbotron">';
			echo '<table class="table">';
			echo '<tr><th>Название</th><th>Описание</th></tr>';

			$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
			$result_set = $mysqli->query($query);
			while (($row = $result_set->fetch_assoc()) != false) 
			{
				$id = $row['Id'];
				$s = '<tr><td>'.$row['Brief_Name'].'</td>';
				$s .= '<td>'.$row['Full_Name'].'</td>';
				$s .= '<td><a class="btn btn-primary btn-xs" href="company_list.php?action=show_list&GSZ_Id='.$id.'">Компании</a></td>';
				$s .= '<td><a class="btn btn-link btn-xs" href="'.$_SERVER['PHP_SELF'].'?action=edit_form&id='.$id.'">Изменить</a></td>';
				$s .= '<td><a class="btn btn-link btn-xs" href="'.$_SERVER['PHP_SELF'].'?action=confirm_delete&GSZ_Id='.$id.'">Удалить</a></td>';
				//$s .= '<td><a class="btn btn-link btn-xs" href="gsz_save_item.php?action=delete&Id='.$id.'">Удалить</a></td>';
				$s .= "</tr>\n";
				echo $s;
			} //end of while $row
			echo '</table>';
			echo '<a class="btn btn-primary" href="'.$_SERVER['PHP_SELF'].'?action=add_form">Добавить</a> ';
			echo '<a class="btn btn-warning" href="limit.html">Вернуться</a>';
			echo '</div>'; //end of Jumbotron
			$mysqli->close();		
		} //end of function show_gsz_list

		
		// Функция формирует форму для добавления записи в таблице БД
		function add_item_form()
		{
			echo '<div class="container">';
			echo '<header>';
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '</header>';
			echo '<div class="jumbotron">';

			echo '<h3>Новая группа</h3>';
			echo '<form name="add_form" action="gsz_save_item.php?action=add" method="POST">';

	        echo '<div class="form-group">';
            echo '<label for="GSZ_Brief_Name">Название</label>';
            echo '<input type="text" class="form-control" name="GSZ_Brief_Name" id="GSZ_Brief_Name" maxlength='.$GLOBALS[MAX_LENGTH_BRIEF_NAME].' placeholder="Краткое название ГСЗ">';
        	echo '</div>';
        	echo '<div class="form-group">';
            echo '<label for="GSZ_Full_Name">Описание</label>';
            echo '<input type="text" class="form-control" name="GSZ_Full_Name" id="GSZ_Full_Name" maxlength='.$GLOBALS[MAX_LENGTH_FULL_NAME].' placeholder="Описание ГСЗ">';
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


			echo '<h3>Изменение данных</h3>';
			$mysqli = db_connect();
			$query = 'SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`='.$_GET['id'];
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			$Brief_Name = htmlspecialchars($row['Brief_Name']);
			$Full_Name = htmlspecialchars($row['Full_Name']);

			echo '<form name="edit_form" action="gsz_save_item.php?action=update" method="POST">';
			echo '<input type="hidden" name="Id" Id="Id" value="'.$_GET['id'].'">';
	        echo '<div class="form-group">';
            echo '<label for="GSZ_Brief_Name">Название</label>';
            echo '<input type="text" class="form-control" name="GSZ_Brief_Name" id="GSZ_Brief_Name"  maxlength='.$GLOBALS[MAX_LENGTH_BRIEF_NAME].' value="'.$Brief_Name.'">';
        	echo '</div>';
        	echo '<div class="form-group">';
            echo '<label for="GSZ_Full_Name">Описание</label>';
            echo '<input type="text" class="form-control" name="GSZ_Full_Name" id="GSZ_Full_Name"  maxlength='.$GLOBALS[MAX_LENGTH_FULL_NAME].' value="'.$Full_Name.'">';
        	echo '</div>';
        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> ';
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
        	echo '</form>';
			echo '</div>'; // end of Jumbotron
		}

		// Форма для подтверждения удаления компании из ГСЗ 
		function confirm_delete_form()
		{
			//$s .= '<td><a class="btn btn-link btn-xs" href="gsz_save_item.php?action=delete&Id='.$id.'">Удалить</a></td>';

			echo '<div class="container">';
			echo '	<header>';
			echo '		<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>';
			echo '	</header>';

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
			$Name = htmlspecialchars($row['Brief_Name']);

			echo '<div class="jumbotron">';
			echo '	<h3>Удалить группу '.$Name.'?</h3>';
			echo '	<a class="btn btn-primary" href="gsz_save_item.php?action=delete&Id='.$GSZ_Id.'">Удалить</a> ';
			echo '	<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>';
			echo '</div>'; //class="jumbotron"
			echo '</div>'; 	//class="container"

		}

		?>


</div> 
</body>
</html>