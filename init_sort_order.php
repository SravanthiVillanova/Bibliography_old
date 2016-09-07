<?php
    mysql_connect('localhost','root','');
    mysql_select_db('panta_rhei');
    
    $file = fopen('./init_order_sql.sql','w');
    
    echo "\n\tSetting all NULL numbers to NULL order...";
    fwrite($file, "UPDATE folder SET sort_order=NULL WHERE number=NULL;\n");    
    //mysql_query('UPDATE folder SET sort_order=NULL WHERE number=NULL') or die(mysql_error());
    echo " Done.\n";
    
    $nq = mysql_query('SELECT * FROM folder WHERE number!=NULL OR number!=""');
    $total = mysql_num_rows($nq);
    echo "\n\tConverting ".$total." non-NULL numbers...\n";
    $count = 0;$prev = -1;
    while($item = mysql_fetch_array($nq)) {        
        $order = preg_replace('/[\.) ]/', '', $item['number']);
        if(is_numeric($order)) {
            $order = ($item['number']+1).'';
        } elseif(preg_match('/[A-H]/', $order) == 1) {
            // Capital letters
            $order = ord($order)-64;
        } elseif(preg_match('/[a-z]/', $order) == 1) {
            // lowercase letters
            $order = ord($order)-96;
        } elseif(preg_match('/^[IVXLCDM]+$/', $order) == 1) {
            // Roman numerals
            $rn = 'IVXLCDM';
            $rv = array(1,5,10,50,100,500,1000);
            $digits = str_split($item['number']);
            foreach($digits as $i=>$d) $digits[$i] = strpos($rn, $d);
            $order = $rv[end($digits)];
            for($i=0;$i<count($digits)-1;$i++) {
                if($digits[$i] >= $digits[$i+1]) {
                    $order += $rv[$digits[$i]];
                } else {
                    $order -= $rv[$digits[$i]];
                }
            }
        }
        $order .= '00';
        fwrite($file, 'UPDATE folder SET sort_order="'.$order.'" WHERE id='.$item['id'].";\t#\t".$item['number']."\n");
        //mysql_query('UPDATE folder SET sort_order="'.$order.'" WHERE id='.$item['id']) or die(mysql_error());
        
        $count++;
        $percent = floor($count*100/$total);
        if($percent > $prev) {
            echo "\t\t".$percent."%\n";
            $prev = $percent;
        }
    } 
            
    $languages = array('text_en','text_de','text_nl','text_es','text_it');
    $master = 'text_fr';
    $empty_count = array();
    $trans_count = 0;
    echo "\n\tChecking for empty rows and columns... ";
    fwrite($file, "\n\n#\tChecking for empty rows and columns...\n\n");
    $query = 'SELECT * FROM folder WHERE '.implode('="" OR ', $languages).'=""';
    $ns = mysql_query($query) or die(mysql_error());
    echo mysql_num_rows($ns).' hits';
    while($item = mysql_fetch_array($ns)) {
        $update = array();
        foreach($languages as $lang) {
            if(strlen($item[$lang]) == 0) {
                $update[] = $lang.'="['.$item[$master].']"';
            }
        }
        if(count($update) > 0 && count($update) < count($languages)) {
            $trans_count++;
            fwrite($file, 'UPDATE folder SET '.implode(',', $update).' WHERE id='.$item['id'].";\n");
            //mysql_query('UPDATE folder SET '.implode(',', $update).' WHERE id='.$item['id']);
        } elseif(strlen($item[$master]) == 0) {
            $empty_count[] = $item['id'];
        }
    }
    fflush($file);
    fclose($file);
    
    echo "\n\n\tDONE!\n\n";
    echo "\tFixed ".$trans_count." empty translations.\n";
    echo "\tFound ".count($empty_count)." empty rows.\n";
    foreach($empty_count as $e) echo "\t\t".$e."\n";
?>