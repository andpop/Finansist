<?php
require_once("cred_limit_scripts.php");

if ((!isset($_POST['Company_Id'])) || (!ctype_digit($_POST['Company_Id'])))
{
    $error_message = urlencode("При сохранении баланса был указан некорректный идентификатор компании");
    redirect(HTML_PATH_FINANCE_GSZ_LIST_FORM."?error={$error_message}");
}
if ((!isset($_POST['Balance_Date'])) || (!is_Date($_POST['Balance_Date'])))
{
    $error_message = urlencode("При сохранении баланса была указана некорректная дата баланса");
    redirect(HTML_PATH_FINANCE_GSZ_LIST_FORM."?error={$error_message}");
}

$Company_Id = $_POST['Company_Id'];
$Balance_Date = $_POST['Balance_Date'];

// Удаляем записи по данной компании за эту дату в таблице Corp_Balance_Results
delete_Balance_Values($Company_Id, $Balance_Date);

// Записываем в Corp_Balance_Results по одной записи для каждого кода
foreach ($_POST as $code => $value) {
    // Обрабатываем в пришедших параметрах только коды статей баланса
    if (!is_numeric($code)) continue;
    
    // Получаем строку для данного кода из справочника статей баланса Corp_Balance_Articles
    $query = "SELECT * FROM `Corp_Balance_Articles` WHERE `Code`='{$code}'";
    $data = getRow($query);

    // Меняем нужные поля (значения пришли из формы) и записываем эту строку в Corp_Balance_Results
    $data['Id'] = 0;
    $data['Value'] = $value;
    $data['Company_Id'] = $Company_Id;
    $data['Date_Balance'] = $Balance_Date;
    
    addRow("Corp_Balance_Results", $data);
}

// Вычисляем балансы по активу и пассиву, сравниваем эти балансы друг с другом
$Balance_Active = calculate_Balance($Company_Id, $Balance_Date, "active");
$Balance_Passive = calculate_Balance($Company_Id, $Balance_Date, "passive");
$url_param = ['Company_Id' => $Company_Id, 'date' => $Balance_Date];

if ($Balance_Active != $Balance_Passive) {
    $url_param['warning'] = "Баланс не сходится! Актив: {$Balance_Active}, пассив: {$Balance_Passive}";
}
$url = HTML_PATH_BALANCE_CORPORATION_FORM."?".http_build_query($url_param);
// echo $url;
redirect($url);

