<?php
require_once('classes/Publisher.php');

$pub = new Publisher();
$pub->find();
while($pub->fetch()) {
    $pub->name = iconv(mb_detect_encoding($pub->name, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $pub->name);
   
    $tmp = new Publisher();
    $tmp->name = $pub->name;
    if (!$tmp->find()) {
        $pub->update();
    }
    unset($tmp);
}
?>
