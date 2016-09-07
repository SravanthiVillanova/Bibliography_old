<?php
require_once('classes/Workattribute_option.php');

$option = new Workattribute_option();
$option->find();
while($option->fetch()) {
    $option->title = iconv(mb_detect_encoding($option->title, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $option->title);
   
    $tmp = new Workattribute_option();
    $tmp->title = $option->title;
    if (!$tmp->find()) {
        $option->update();
    }
    unset($tmp);
}
?>
