<!DOCTYPE html>
<html>
<head>
	<title>Финансист онлайн - Кредитный лимит</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link href="../css/bootstrap.min.css" rel="stylesheet"/> 
	<link href="../css/style.css" rel="stylesheet"/> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
	<header>
		<h2 class="text-center">ГРУППЫ СВЯЗАННЫХ ЗАЕМЩИКОВ</h2>
	</header>
	<div class="jumbotron">
	<?php
		require_once '../script/app_config.php';
		
		if (!isset($_GET["action"])) $_GET["action"] = "show_list";
		switch ($_GET["action"]) 
		{
			case 'show_list':
				show_gsz_list();
				break;
			
			default:
				show_gsz_list();
				break;
		}
		
		//Вывод всех записей из таблицы GSZ
		function show_gsz_list()
		{
			$mysqli = db_connect();
			echo '<table class="table">';
			echo "<tr><th>ID</th><th>Название</th><th>Описание</th></tr>";

			$query = "SELECT * FROM `gsz` ORDER BY `Brief_Name`";
			$result_set = $mysqli->query($query);
			while (($row = $result_set->fetch_assoc()) != false) 
			{
				$id = $row['Id'];
				$s = '<tr><td>'."$id".'</td>';
				$s .= '<td>'.$row['Brief_Name'].'</td>';
				$s .= '<td>'.$row['Full_Name'].'</td>';
				$s .= '<td><a href="'.$_SERVER['PHP_SELF'].'?action=edit_form&id='.$id.'">Изменить</a></td>';
				$s .= '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id='.$id.'">Удалить</a></td>';
				$s .= "</tr>\n";
				echo $s;
			} //end of while $row
		
			echo "</table>";
			echo '<p><a href="'.$_SERVER['PHP_SELF'].'?action=add_form">Добавить</a></p>'; 

			$mysqli->close();		
		} //end of function show_gsz_list

		?>

	</div> <!-- Конец jumbotron -->

</div>
</body>
</html>