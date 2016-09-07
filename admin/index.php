<?php
$work = new Work();
$work->status = '0';
$cnt = $work->count();
$interface->assign('reviewCnt', $cnt);

$interface->setTrail(array('Home'));
$interface->setTemplate('admin.tpl');

$interface->display('layout-admin.tpl');
?>
