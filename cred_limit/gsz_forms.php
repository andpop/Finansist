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
	<?php

		require_once($_SERVER['DOCUMENT_ROOT'].'/script/app_config.php');
		require_once('./script/cred_limit_scripts.php');

		$mysqli = db_connect();

		if (!isset($_GET["action"])) $_GET["action"] = "show_list";
		switch ($_GET["action"]) 
		{
			case 'show_list':  //Список всех записей из таблицы
				show_gsz_list();
				break;
			case "edit_form":    // Форма для редактирования записи
				edit_item_form(); 
				break;
			
			default:
				show_gsz_list();
				break;
		}
		$mysqli->close();		
		
		//Вывод всех записей из таблицы GSZ
		function show_gsz_list()
		{
			echo '<div class="container">'.PHP_EOL;
			echo '<header>'.PHP_EOL;
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>'.PHP_EOL;
			echo '</header>'.PHP_EOL;
			echo '<div class="jumbotron">'.PHP_EOL;
			echo '<table class="table">'.PHP_EOL;
			echo '<tr><th>Название</th><th>Описание</th></tr>';

			global $mysqli;
			$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
			$result_set = $mysqli->query($query);
			while (($row = $result_set->fetch_assoc()) != false) 
			{
				$id = $row['Id'];
				$s = "<tr><td>{$row['Brief_Name']}</td>";
				$s .= "<td>{$row['Full_Name']}</td>";
				$s .= "<td><a class=\"btn btn-primary btn-xs\" href=\"company_forms.php?action=show_list&GSZ_Id={$id}\">Компании</a></td>";
				$s .= "<td><a class=\"btn btn-link btn-xs\" href=\"{$_SERVER['PHP_SELF']}?action=edit_form&id={$id}\">Изменить</a></td>";
				$s .= "<td><a class=\"btn btn-link btn-xs\" href=\"gsz_confirm_delete.php?GSZ_Id={$id}\">Удалить</a></td>";
				$s .= "</tr>".PHP_EOL;
				echo $s;
			} //end of while $row
			echo '</table>'.PHP_EOL;
			// echo "<a class=\"btn btn-primary\" href=\"{$_SERVER['PHP_SELF']}?action=add_form\">Добавить</a> ".PHP_EOL;
			echo "<a class=\"btn btn-primary\" href=\"gsz_add.php\">Добавить</a> ".PHP_EOL;
			
			echo '<a class="btn btn-warning" href="limit.html">Вернуться</a>'.PHP_EOL;
			echo '</div>'.PHP_EOL; //end of Jumbotron
			echo '</div>'.PHP_EOL; //class="container"
			
		} //end of function show_gsz_list

		
		// Функция формирует форму для редактирования записи в таблице БД
		function edit_item_form()
		{
			// !!!!! Добавить ограничения длины полей ввода в форме
			echo '<div class="container">'.PHP_EOL;
			echo '<header>'.PHP_EOL;
			echo '<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>'.PHP_EOL;
			echo '</header>'.PHP_EOL;
			echo '<div class="jumbotron">'.PHP_EOL;

			echo '<h3>Изменение данных</h3>'.PHP_EOL;
			
			global $mysqli;

			$query = "SELECT `Brief_Name`, `Full_Name` FROM GSZ WHERE `Id`={$_GET['id']}";
			$result_set = $mysqli->query($query);
			$row = $result_set->fetch_assoc();
			$Brief_Name = htmlspecialchars($row['Brief_Name']);
			$Full_Name = htmlspecialchars($row['Full_Name']);

			echo '<form name="edit_form" action="script/gsz_save_item.php?action=update" method="POST">'.PHP_EOL;
			echo "<input type=\"hidden\" name=\"Id\" Id=\"Id\" value=\"{$_GET['id']}\">";
	        echo '<div class="form-group">'.PHP_EOL;
            echo '<label for="GSZ_Brief_Name">Название</label>'.PHP_EOL;
            echo "<input type=\"text\" class=\"form-control\" name=\"GSZ_Brief_Name\" id=\"GSZ_Brief_Name\"  maxlength=".MAX_LENGTH_GSZ_BRIEF_NAME." value=\"{$Brief_Name}\">";
        	echo '</div>'.PHP_EOL;
        	echo '<div class="form-group">'.PHP_EOL;
            echo '<label for="GSZ_Full_Name">Описание</label>'.PHP_EOL;
            echo "<input type=\"text\" class=\"form-control\" name=\"GSZ_Full_Name\" id=\"GSZ_Full_Name\"  maxlength=".MAX_LENGTH_GSZ_FULL_NAME." value=\"{$Full_Name}\">";
        	echo '</div>'.PHP_EOL;
        	echo '<button type="submit" class="btn btn-primary">Сохранить</button> '.PHP_EOL;
        	echo '<button type="button" class="btn btn-warning" onClick="history.back();">Отменить</button>'.PHP_EOL;
        	echo '</form>'.PHP_EOL;
			echo '</div>'.PHP_EOL; // end of Jumbotron
			echo '</div>'.PHP_EOL; //class="container"
		}

		?>


</div> 
</body>
</html>