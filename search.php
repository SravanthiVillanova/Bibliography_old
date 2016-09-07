<?php
$interface = new UInterface();

$langVar = 'text_' . $language;

if ($_POST['lookfor']) {
    $folderList = array();
    $folder = new Folder();
    
    $phrase = str_replace('*', '%', $_POST['lookfor']);
    
    // Search for a phrase at the beginning of a title
    $folder->whereAdd("UPPER($langVar) LIKE '" . strtoupper($phrase) . " %'");
    
    // Search for a phrase in the middle of a title
    $folder->whereAdd("UPPER($langVar) LIKE '% " . strtoupper($phrase) . " %'", 'OR');
    
    // Search for a phrase at the end  of a title
    $folder->whereAdd("UPPER($langVar) LIKE '% " . strtoupper($phrase) . "'", 'OR');

    // Search for an exact phrase for a title
    $folder->whereAdd("UPPER($langVar) = '" . strtoupper($phrase) . "'", 'OR');
    if ($folder->find()) {
        while ($folder->fetch()) {
            $folderList[] = $folder;
        }
    }
    $interface->assign('folderList', $folderList);
    $interface->setTemplate('search-result.tpl');
} else {
    $interface->setTemplate('search.tpl');
}

$interface->display('layout.tpl');
?>