<?php 
	require_once '../script/functions.php';
	$type_platezh = $_POST['type_platezh'];
	$str_beg_date = "01.".$_POST['str_beg_date'];
	$sum_kred = $_POST['sum_kred'];
	$col_month = $_POST['col_month'];
	$proc = $_POST['proc'];
	
	$arr_payments = array_fill(0, $col_month, 0);
	$n = 0;
	if ($type_platezh == 'flex') {
		foreach($_POST['flex_payment_schedule'] as $flex_payment) {
			$arr_payments[$n] = round((float)$flex_payment, 2);
			$n++;
		
		}
	}

	// Формируем массив с данными о платежах в каждом месяце
	$arr_all_platezh = Payment_Schedule($type_platezh, $str_beg_date, $sum_kred, $col_month, $proc, $arr_payments);

	// Формируем html-код для табличной части расчета платежей для всплывающего окна
	$platezhi_in_html = Platezh_to_html($str_beg_date, $sum_kred, $col_month, $proc, $arr_all_platezh);

	// Выводим html-код, который вернется через Ajax и будет послан во всплывающее окно (в том числе кнопки для Pdf и xls).
	echo $platezhi_in_html;

 ?>
