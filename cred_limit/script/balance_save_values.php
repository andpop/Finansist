<?php
print_r($_POST);
foreach ($_POST as $k => $v) {
    echo $k . " " . $v ."<br>";
}
// 1. DELETE FROM `Corp_Balance_Results` WHERE `Date_Balance`=$_POST['Balance_Date'] AND `Company_Id'=$_POST['Balance_Date']
// 2. Копируем все строки из Corp_Balance_Articles в Corp_Balance_Results с добавлением `Date_Balance`=$_POST['Balance_Date'] и `Company_Id'=$_POST['Balance_Date']
// 3. foreach ($_POST as $k => $v) { 
//    UPDATE `Corp_Balance_Results` SET `Value`= $v WHERE `Code`=$k