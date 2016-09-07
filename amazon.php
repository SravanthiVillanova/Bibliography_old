<?php
include('global.inc');

$work = new Work();
$work->isbn = $_GET['isbn'];
$data = $work->getAmazonData();

include('header.inc');

echo '<h1>Amazon.com Data</h1>';

if (!PEAR::isError($data)) {
    echo '<table cellpadding="3" cellspacing="0" border="0">';
    foreach ($data[0] as $label => $value) {
        if (is_array($value)) {
            echo "<tr><td><b>$label: </b></td><td>";
            foreach ($value as $subvalue) {
                echo "$subvalue ";
            }
            echo "</td></tr>\n";
        } else {
            echo "<tr><td><b>$label: </b></td><td>$value</td></tr>\n";
        }
    }
    echo '</table>';
} else {
    echo $data->getMessage();
}

include('footer.inc');
?>
