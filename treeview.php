<?php

$interface = new UInterface();

$interface->assign('langVar', 'text_' . $language);

// Get Root Element
$root = Folder::staticGet('id', $_GET['id']);
$interface->assign('root', $root);
$parentChain = $root->getParentChain(true);
$interface->assign('parentChain', $parentChain);

$interface->setTemplate('treeview.tpl');
$interface->display('layout.tpl');
?>