<?php
require_once('classes/Agent.php');

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

    $interface->setTrail(array('Home' => 'index.php', 'Agents'));

    $agent = new Agent();
    $agent->query("SELECT DISTINCT upper(substring(lname, 1, 1)) AS letter FROM agent ORDER BY lname");
    if ($agent->N) {
        while ($agent->fetch()) {
            $letterList[] = $agent->letter;
        }
    }
    $interface->assign('letterList', $letterList);

    $dg = new DataGrid(20);

    $agent = new Agent();
    $agent->selectAdd("CONCAT(agent.lname, ', ', agent.fname) as fullname");
    if (isset($_POST['submit'])) {
        if ($_POST['fname'] != '') {
            $agent->whereAdd("UPPER(fname) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['fname']), 'UTF-8') . "'");
        }
        if ($_POST['lname'] != '') {
            $agent->whereAdd("UPPER(lname) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['lname']), 'UTF-8') . "'");
        }
        if ($_POST['altname'] != '') {
            $agent->whereAdd("UPPER(alternate_name) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['altname']), 'UTF-8') . "'");
        }
        if ($_POST['orgname'] != '') {
            $agent->whereAdd("UPPER(organization_name) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['orgname']), 'UTF-8') . "'");
        }
    } elseif (isset($_GET['letter'])) {
        $agent->whereAdd("upper(substring(lname, 1, 1)) = '" . $_GET['letter'] . "'");
    }
    $dg->bind($agent);

    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Name', 'fullname', 'fullname', null, null, 'printLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Alternate Name', 'alternate_name', 'alternate_name'));
    $dg->addColumn(new Structures_DataGrid_Column('Organization Name', 'organization_name', 'organization_name'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('agent-list.tpl');
}

function showFind(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Agents' => 'agent.php', 'Find Agent'));

    $interface->setTemplate('agent-find.tpl');
}

function showForm(&$interface)
{
    require_once('../classes/Agenttype.php');

    $interface->setTrail(array('Home' => 'index.php', 'Agents' => 'agent.php', 'Edit Agent'));

    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $agent = Agent::staticGet('id', $_GET['id']);
    } else {
        $agent = new Agent();
    }

    $interface->assign('agent', $agent);

    $type = new Agenttype();
    if ($type->find()) {
        while ($type->fetch()) {
            $typeList[] = $type;
        }
    }
    $interface->assign('typeList', $typeList);

    $interface->setTemplate('agent-form.tpl');
}

function handleForm(&$interface)
{
    $agent = new Agent();
    $agent->fname = $_POST['fname'];
    $agent->lname = $_POST['lname'];
    $agent->alternate_name = $_POST['altname'];
    $agent->organization_name = $_POST['orgname'];

    if ($_POST['id'] != '') {
        $agent->id = $_POST['id'];
        $result = $agent->update();
    } else {
        $result = $agent->insert();
    }

    if (PEAR::isError($result)) {
        $interface->assign('message', 'Error: ' . $result->getMessage());
    } else {
        $interface->assign('message', 'Agent Information Saved');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Agents' => 'agent.php', 'Edit Agent'));

    $agentList = array();
    foreach ($_POST['id'] as $id) {
        $agentList[] = Agent::staticGet('id', $id);
    }
    $interface->assign('agentList', $agentList);

    $interface->setTemplate('agent-delete.tpl');
}

function handleDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $agent = new Agent();

            $sql = "DELETE FROM work_agent WHERE agent_id = '$id'";
            $agent->query($sql);

            $agent->id = $id;
            $agent->delete();
        }

        $interface->assign('msg', 'Agents Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showMerge(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Agents' => 'agent.php', 'Merge Agents'));

    if (isset($_POST['submit'])) {
        if ($_POST['source_id'] != '') {
            $agent = Agent::staticGet('id', $_POST['source_id']);
            $interface->assign('source', $agent);
        } elseif ($_POST['source'] != '') {
            $agent = new Agent();
            $agent->whereAdd("lname LIKE '" . addslashes($_POST['source']) . "%'");
            $dg = new DataGrid(20);
            $dg->bind($agent);
            $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printRadio', array('checked'=>'true', 'prefix'=>'source_')));
            $dg->addColumn(new Structures_DataGrid_Column('First Name', 'fname', 'fname'));
            $dg->addColumn(new Structures_DataGrid_Column('Last Name', 'lname', 'lname'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgSource', $dg->getOutput());
        }

        if ($_POST['end_id'] != '') {
            $agent = Agent::staticGet('id', $_POST['end_id']);
            $interface->assign('end', $agent);
        } elseif ($_POST['end'] != '') {
            $agent = new Agent();
            $agent->whereAdd("lname LIKE '" . addslashes($_POST['end']) . "%'");
            $agent->whereAdd("id != '" . $_POST['source_id'] . "'");
            $dg = new DataGrid(20);
            $dg->bind($agent);
            $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printRadio', array('checked'=>'true', 'prefix'=>'end_')));
            $dg->addColumn(new Structures_DataGrid_Column('First Name', 'fname', 'fname'));
            $dg->addColumn(new Structures_DataGrid_Column('Last Name', 'lname', 'lname'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgDestination', $dg->getOutput());
        }
    }

    $interface->setTemplate('agent-merge.tpl');
}

function processMerge(&$interface)
{
    $do = new DB_DataObject();

    // Switch Agent
    $sql = "UPDATE work_agent SET agent_id = '" . $_POST['end_id'] . "' WHERE agent_id = '" . $_POST['source_id'] . "'";
    $do->query($sql);

    // Purge
    $sql = "DELETE FROM agent WHERE id = '" . $_POST['source_id'] . "'";
    $do->query($sql);

    $interface->assign('message', 'Agents have been merged');

    showList($interface);
}

// Display page
$interface->display('layout-admin.tpl');

function printCheckbox($params)
{
    extract($params);
    if ($checked) {
        return '<input type="checkbox" name="' . $prefix . 'id[]" value="' . $record['id'] . '" checked>';
    } else {
        return '<input type="checkbox" name="' . $prefix . 'id[]" value="' . $record['id'] . '">';
    }
}

function printRadio($params, $args=null)
{
    extract($params);
    extract($args);
    return '<input type="radio" name="' . $prefix . 'id" value="' . $record['id'] . '">';
}


function printLink($params)
{
    extract($params);

    $agent = new Agent();
    $agent->id = $record['id'];

    return '<a href="agent.php?action=showForm&id=' . $record['id'] . '">' . $record['fullname'] . '</a> (' . $agent->getWorkCount() . ')';
}

function printWorkCount($params)
{
    extract($params);
    $agent = new Agent();
    $agent->id = $record['id'];
    return $agent->getWorkCount();
}
?>
