<?php
require_once 'Structures/DataGrid.php';

ini_set('memory_limit', '20M');
ini_set('max_execution_time', 120);

header ('Content-type: text/text');
header('Content-Disposition: attachment; filename="categories.csv"');

$sql = 'SELECT CONCAT(f1.number, \' \', f1.text_fr) AS "Level 1",
       CONCAT(f2.number, \'. \', f2.text_fr) AS "Level 2",
       CONCAT(f3.text_fr) AS "Level 3",
       CONCAT(f4.text_fr) AS "Level 4",
       CONCAT(f5.text_fr) AS "Level 5",
       CONCAT(f6.text_fr) AS "Level 6",
       CONCAT(f7.text_fr) AS "Level 7",
       CONCAT(f8.text_fr) AS "Level 8"
  FROM folder AS f1
       LEFT JOIN folder AS f2 ON f1.id = f2.parent_id
       LEFT JOIN folder AS f3 ON f2.id = f3.parent_id
       LEFT JOIN folder AS f4 ON f3.id = f4.parent_id
       LEFT JOIN folder AS f5 ON f4.id = f5.parent_id
       LEFT JOIN folder AS f6 ON f5.id = f6.parent_id
       LEFT JOIN folder AS f7 ON f6.id = f7.parent_id
       LEFT JOIN folder AS f8 ON f7.id = f8.parent_id
 WHERE f1.parent_id IS NULL';

if ($conn = mysql_connect('localhost', 'root', 'libd8a')) {
    mysql_select_db('panta_rhei');
    if ($result = mysql_query($sql)) {
        //$sdg =& new Structures_DataGrid(null, null, 'CSV');
        //while ($row = mysql_fetch_assoc($result)) {
        //    $sdg->addRecord($row);
        //}
        //$sdg->render();
        while ($row = mysql_fetch_array($result)) {
            for ($i=0; $i<count($row); $i++) {
                if ($i == count($row)-1) {
                    echo '"' . $row[$i] . '"' . "\n"; 
                } else {
                    echo '"' . $row[$i] . '", '; 
                }
            }
        }
    } else {
        echo 'Invalid Query: ' . $sql . "\n";
    }
} else {
    echo "Cannot Connect to DB\n";
}
?>
