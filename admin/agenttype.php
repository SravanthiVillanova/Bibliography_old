<?php
require ('classes/Agenttype.php');

// Process Action
$action = getRequest('action');
if (!is_callable($action)) {
    $action = "showList";
}
$interface->assign('action', $action);
call_user_func_array($action, array(&$interface));

function showList(&$interface)
{
    global $translator;

    $interface->setTrail(array('Home' => 'index.php', 'Agent Types'));
        
    $dg =& new DataGrid(20, $_GET['page']);
    
    $type = new Agenttype();
    $dg->bind($type);
    
    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Agent Type (English)', 'type', null, null, null, 'printLink()'));
    
    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);
        
    $interface->setTemplate('agenttype-list.tpl');
}

function showForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 
                               'Agent Types' => 'agenttype.php',
                               'Agent Type'));
    
    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $type = Agenttype::staticGet('id', $_GET['id']);
    } else {
        $type = new Agenttype();
    }
    $interface->assign('type', $type);
    
    $interface->setTemplate('agenttype-form.tpl');
}

function handleForm(&$interface)
{
    global $translator;
    
    // Fetch work specified by query string
    if (isset($_POST['submit'])) {
        $type = new Agenttype();
        $type->type = $_POST['type'];
        if ($_POST['id'] != '') {
            $type->id = $_POST['id'];
            $type->update();
        } else {
            $type->insert();
            
            // Add Translation Term
            $translator->setTranslation($type->type, $type->type, 'en');
            $translator->save();
        }
    }
    
    $interface->assign('message', 'Agent Type saved');
    
    $_GET['action'] = 'showList';
    showList($interface);
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Agent Types' => 'agent.php', 'Delete Type'));
        
    $typeList = array();
    foreach ($_POST['id'] as $id) {
        $typeList[] = Agenttype::staticGet('id', $id);
    }
    $interface->assign('typeList', $typeList);
        
    $interface->setTemplate('agenttype-delete.tpl');
}

function handleDelete(&$interface)
{
    global $translator;
    
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $type = Agenttype::staticGet('id', $id);
            
            $sql = "DELETE FROM work_agent WHERE agenttype_id = '$id'";
            $type->query($sql);
            
            unset($translator->langCode);
            $translator->load('../translations');
            $translator->removeTranslation($type->type);
            $translator->save();
            
            $type->delete();
        }
        
        $interface->assign('msg', 'Agent Types Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }
    
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

function printLink($params)
{
    extract($params);
    return '<a href="agenttype.php?action=showForm&id=' . $record['id'] . '">' . $record['type'] . '</a>';
}

?>
