<?php
if ($user->isAdmin()) {
    // Process Action
    $action = getRequest('action');
    if (!is_callable($action)) {
        $action = "showList";
    }
    $interface->assign('action', $action);
    call_user_func_array($action, array(&$interface));
}


function showList(&$interface)
{
    global $translator;

    $interface->setTrail(array('Home' => 'index.php', 'Languages'));
        
    $data = array();
    $langList = $translator->getLanguages();
    $i = 0;
    include($translator->path . '/en.inc');
    //include('translations.inc');
    foreach (array_keys($I18N_Translator_Text_en) as $term) {
      //foreach (array_keys($text['en']) as $term) {
      //LACY
      //$interface->assign('term_'.$i, $term);
      //END
        foreach ($langList as $lang) {
            include($translator->path . '/' . $lang . '.inc');
            $name = 'I18N_Translator_Text_' . $lang;
            $ar = $$name;
            $data[$i][$lang] = $ar[$term];
        }
        $i++;
    }

    $dg =& new DataGrid(20);
    $dg->bind($data);

    // Columns
    foreach ($langList as $lang) {
        $dg->addColumn(new Structures_DataGrid_Column($lang, $lang, $lang));
    }
    $dg->addColumn(new Structures_DataGrid_Column('Actions', null, null, array('align' => 'center'), null, 'printActions()'));
    
    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);
        
    $interface->setTemplate('lang-list.tpl');
}

function showForm(&$interface)
{
    global $translator;

    unset($translator->langCode);
    $translator->load('../translations');
    
    $interface->setTrail(array('Home' => 'index.php', 'Language' => 'language.php', 'Edit Term'));
    
    $interface->assign('term', $_GET['term']);
    
    $interface->setTemplate('lang-form.tpl');
}

function handleForm(&$interface)
{
    global $translator;

    unset($translator->langCode);
    $translator->load('../translations');
        
    // Determine which term is the base
    // By default, use the English term
    $term = ($_POST['term'] != '') ? $_POST['term'] : $_POST['translation']['en'];
    
    foreach ($_POST['translation'] as $lang => $phrase) {
        $translator->setTranslation($term, $phrase, $lang);
    }
    $translator->save();

    $interface->assign('message', 'Translations Saved');
    
    $_GET['action'] = 'showList';
    showList($interface);    
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Language' => 'language.php', 'Delete Term'));
    
    $interface->assign('term', $_GET['term']);
    
    $interface->setTemplate('lang-delete.tpl');
}

function handleDelete(&$interface)
{
    global $translator;

    unset($translator->langCode);
    $translator->load('../translations');
    $translator->removeTranslation($_POST['term']);
    $translator->save();
    
    $_GET['action'] = 'showList';
    showList($interface);
}

// Display page
$interface->display('layout-admin.tpl');

function printCheckbox($params)
{
    extract($params);
    return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
}

function printActions($params)
{
    extract($params);
    return '<a href="language.php?action=showForm&term=' . $record['en'] . '">Edit</a> | ' . 
           '<a href="language.php?action=showDelete&term=' . $record['en'] . '">Delete</a>';
}


?>
