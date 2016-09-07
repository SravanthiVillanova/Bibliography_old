<?php
//require phpexcel file from PHPExcel Lib
require_once '\vendor\PHPExcel_1.8.0_doc\Classes\PHPExcel.php';
 
mysql_connect('localhost','root','');
mysql_select_db('panta_rhei');
 
$fileType = 'Excel2007';
$fileName = 'lang.xlsx';

// initialize reader object
$objReader = PHPExcel_IOFactory::createReader($fileType);

//create a PHPExcel object and load the required file
$objPHPExcel = $objReader->load($fileName);

//set active index to first sheet
$sheet1 = $objPHPExcel->setActiveSheetIndex(0);

//get no of rows in sheet
$row = $objPHPExcel->getActiveSheet()->getHighestRow();

$cell = [];
for($i=1,$j=0;$i<=$row;$i++,$j++){
        $cell[$j] = $sheet1->getCell('A'.$i);
		$q = "select id from workattribute_option where title = '$cell[$j]'";
		$result = mysql_query($q);
		$item = mysql_fetch_array($result);
		$sheet1->setCellValue('C'.$i,$item[0]);    
    }
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
//$objWriter->save($fileName);

for($i=1,$j=0;$i<=$row;$i++,$j++){
        $cell[$j] = $sheet1->getCell('C'.$i);
        $q2 = "select work_id from work_workattribute where value = '$cell[$j]'";
		$result2 = mysql_query($q2);
		$item2 = mysql_fetch_array($result2);
		$cnt = count($item2);
		//echo $cnt . '<br />';
		while($cnt>0) {
		for($k=0;$k<=$cnt;$k++) {
			$commasep = implode(", ",$item2[$k]);
			//echo '<br />' . $item2[$k];
		}
		$sheet1->setCellValue('D'.$i,$commasep);
		} 
}		
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
$objWriter->save($fileName);


?>
