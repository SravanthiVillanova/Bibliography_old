<?php

$interface = new UInterface();

// Get Root Elements
$folder = new Folder();
$folder->parent_id = 'null';
if ($result = $folder->find()) {
    while ($folder->fetch()) {
        $rootList[] = clone($folder);
    }
}

$cellPerRow = 3;
$childrenPerCell = 3;

$interface->assign('rootList', $rootList);
$interface->assign('cellPerRow', 3);
$interface->assign('childrenPerCell', 3);

$interface->assign('langVar', 'text_' . $language);

$interface->setTemplate('main.tpl');
$interface->display('layout.tpl');

?>
