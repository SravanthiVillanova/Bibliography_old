<?php
if (isset($_POST['submitBtn'])) {
    $do = new DB_DataObject();
    $do->query("INSERT INTO test (test) VALUES('" . $_POST['test'] . "')");
}

$do = new DB_DataObject();
$do->query("SELECT * FROM test");
while ($do->fetch()) {
    $testList[] = $do;
}
$interface->assign('testList', $testList);

$interface->setTemplate('test-form.tpl');
$interface->display('layout-admin2.tpl');
?>
