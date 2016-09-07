<table>
  <tr><th>Original</th><th>Converted</th></tr>
<?php

$work = new Work();
$work->find();
while($work->fetch()) {
    echo "  <tr><td>" . mb_detect_encoding($work->title, 'ASCII, UTF-8, ISO-8859-1') . ": $work->title</td>" . 
         "<td>" . iconv(mb_detect_encoding($work->title, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $work->title) . "</td></tr>\n";
}

?>
</table>
