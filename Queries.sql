

-- Статьи для ввода значений 
SELECT 
	`Code`, `Description`, `Value`
FROM 
	`Corp_Balance_Articles` 
WHERE 
	(`Has_Children` = 0) 
	AND (`Is_Sum_Section` = 0)
ORDER BY `Code`

$sql = "SELECT \n"
    . " `Code`, `Description`, `Value`\n"
    . "FROM \n"
    . " `Corp_Balance_Articles` \n"
    . "WHERE \n"
    . " (`Has_Children` = 0) \n"
    . " AND (`Is_Sum_Section` = 0)\n"
    . "ORDER BY `Code`";

-- Синтетические статьи (нужно вычислять как сумму значений подстатей)


-- Суммирование
SELECT `Parent_Code`, SUM(`Value`)
FROM `Corp_Balance_Articles`
WHERE (`Has_Children` = 0) AND (`Parent_Code`<>'0')
GROUP BY `Parent_Code`