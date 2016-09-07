<?php
mysql_connect('localhost','root','');
mysql_select_db('panta_rhei');

$inHandle = fopen('./ls1.csv', 'r');
$outHandle = fopen('./output.txt', 'w');
$outHandle2 = fopen('./output2.txt', 'w');

$row = 1;
$id = [];
if (($inHandle = fopen('./ls1.csv', 'r')) !== FALSE) {
    while (($data = fgetcsv($inHandle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";   
        $row++;
        for ($c=0; $c < $num; $c++) {
            $id = utf8_encode($data[$c]);
       }
		$q = "select id from workattribute_option where title = '$id' and workattribute_id = 5";
		$result = mysql_query($q);
		if ($result != NULL) {
			while($item = mysql_fetch_array($result)) {
			   fwrite($outHandle, $item['id'].",");
		    }
		}
		else {
			fwrite($outHandle,",");
		}
		fwrite($outHandle,"\n");
	    
		$q2 = "select work_id from work_workattribute where value = $item[0] and workattribute_id = 5";
		$result2 = mysql_query($q2);
		if($result2 != NULL){
		while($item2 = mysql_fetch_array($result2)) {
			fwrite($outHandle2, $item2['work_id'].",");
		}
		}
		else {
			fwrite($outHandle2,",");
		}
		fwrite($outHandle2,"\n");
    }
}
fclose($inHandle);
fclose($outHandle);
fclose($outHandle2);
?>