<?php
require_once('classes/Agent.php');

$agent = new Agent();
$agent->find();
while($agent->fetch()) {
    $agent->fname = iconv(mb_detect_encoding($agent->fname, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $agent->fname);
    $agent->lname = iconv(mb_detect_encoding($agent->lname, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $agent->lname);
   
    $tmp = new Agent();
    $tmp->fname = $agent->fname;
    $tmp->lname = $agent->lname;
    if (!$tmp->find()) {
        $agent->update();
    }
    unset($tmp);
}
?>
