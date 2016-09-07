<?php
require ('classes/Publisher.php');
require ('classes/Publisher_location.php');

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

    $interface->setTrail(array('Home' => 'index.php', 'Publishers'));

    // Show Letters
    $work = new Work();
    $work->query("SELECT DISTINCT upper(substring(name, 1, 1)) AS letter FROM publisher ORDER BY name");
    if ($work->N) {
        while ($work->fetch()) {
            $letterList[] = $work->letter;
        }
    }
    $interface->assign('letterList', $letterList);

    $dg = new DataGrid(20);

    $publisher = new Publisher();
    if (isset($_POST['submit'])) {
        if ($_POST['name'] != '') {
            $publisher->whereAdd("UPPER(name) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['name']), 'UTF-8') . "'");
        }
        if ($_POST['location'] != '') {
            $publisher->whereAdd("id IN (select publisher_id FROM publisher_location WHERE UPPER(location) LIKE '" . mb_strtoupper(str_replace('*', '%', $_POST['location']), 'UTF-8') . "')");
        }
    }

    if (isset($_GET['letter'])) {
        $publisher->whereAdd("upper(name) LIKE '" . addslashes($_GET['letter']) . "%'");
    }

    $dg->bind($publisher);

    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Name', 'name', 'name', null, null, 'printLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Locations', null, null, null, null, 'printManageLocationLink()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('publisher-list.tpl');
}

function showLocations(&$interface)
{
    global $translator;

    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Publisher Locations'));

    $id = (isset($_POST['pub_id'])) ? $_POST['pub_id'] : $_GET['id'];
    $publisher = Publisher::staticGet('id', $id);
    $interface->assign('publisher', $publisher);

    $dg = new DataGrid(20);
    $location = new Publisher_location();
    $location->publisher_id = $publisher->id;
    $dg->bind($location);
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Location', 'location', 'location', null, null, 'printLocationLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Source', null, null, array('width' => '10', 'align' => 'center'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Destination', null, null, array('width' => '10', 'align' => 'center'), null, 'printRadioLocation()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('publisher-location-list.tpl');
}

function processLocations(&$interface)
{
    switch ($_POST['submit']) {
        case 'Delete':
            showLocationDelete($interface);
            break;
        case 'Merge':
            showLocationMerge($interface);
            break;
        default:
            showLocations($interface);
            break;
    }
}

function showLocationMerge(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Publisher Locations' => 'publisher.php?action=showLocations&id=' . $_POST['pub_id'], 'Location Merge'));

    if ($_POST['master_id']) {
        $master = Publisher_location::staticGet('id', $_POST['master_id']);
        $interface->assign('master', $master);

        foreach ($_POST['id'] as $id) {
            $locationList[] = Publisher_location::staticGet('id', $id);
        }
        $interface->assign('locationList', $locationList);
        $interface->assign('publisherId', $_POST['pub_id']);

        $interface->setTemplate('publisher-location-merge.tpl');
    } else {
        $interface->assign('msg', 'You must select a Destination location before processing the merge');
        showLocations($interface);
    }
}

function handleLocationMerge(&$interface)
{
    if ($_POST['submit'] == 'Merge') {
        $master = new Publisher_location();
        $master->id = $_POST['master_id'];
        if ($master->id != '') {
            for ($i = 0; $i<count($_POST['id']); $i++) {
                $location = new Publisher_location();
                $location->id = $_POST['id'][$i];
                if ($location->id != $master->id) {
                    $sql = "UPDATE work_publisher SET location_id = '$master->id' WHERE location_id = '$location->id' AND publisher_id = '" . $_POST['pub_id'] . "'";
                    $master->query($sql);
                    $location->delete();
                }
            }
            $interface->assign('msg', 'Locations Merged');
        }
    } else {
        $interface->assign('msg', 'Merge canceled');
    }


    showLocations($interface);
    return true;
}

function showFind(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Find Publisher'));

    $interface->setTemplate('publisher-find.tpl');
}

function showForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Edit Publisher'));

    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $publisher = Publisher::staticGet('id', $_GET['id']);
    } else {
        $publisher = new Publisher();
    }

    $interface->assign('publisher', $publisher);

    $interface->setTemplate('publisher-form.tpl');
}

function handleForm(&$interface)
{
    $publisher = new Publisher();
    $publisher->name = $_POST['name'];

    if ($_POST['id'] != '') {
        $publisher->id = $_POST['id'];
        $result = $publisher->update();
    } else {
        $result = $publisher->insert();
    }

    if (PEAR::isError($result)) {
        $interface->assign('message', 'Error: ' . $result->getMessage());
    } else {
        $interface->assign('message', 'Publisher Information Saved');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showLocationForm(&$interface)
{

    $publisher = Publisher::staticGet('id', $_GET['pub_id']);
    $interface->assign('publisher', $publisher);

    // Fetch work specified by query string
    if (isset($_GET['location_id'])) {
        $location = Publisher_location::staticGet('id', $_GET['location_id']);
        $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Publisher Locations' => 'publisher.php?action=showLocations&id=' . $_GET['id'], 'Edit Location'));
    } else {
        $location = new Publisher_location();
        $location->publisher_id = $_GET['pub_id'];
        $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Publisher Locations' => 'publisher.php?action=showLocations&id=' . $_GET['id'], 'Add Location'));
    }

    $interface->assign('location', $location);

    $interface->setTemplate('publisher-location-form.tpl');
}

function handleLocationForm(&$interface)
{
    $location = new Publisher_location();
    $location->location = $_POST['location'];
    $location->publisher_id = $_POST['pub_id'];

    if ($_POST['id'] != '') {
        $location->id = $_POST['id'];
        $result = $location->update();
    } else {
        $result = $location->insert();
    }

    if (PEAR::isError($result)) {
        $interface->assign('message', 'Error: ' . $result->getMessage());
    } else {
        $interface->assign('message', 'Publisher Location Saved');
    }

    $_GET['id'] = $_POST['pub_id'];
    $_GET['action'] = 'showLocations';
    showLocations($interface);
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Delete Publisher'));

    $pubList = array();
    foreach ($_POST['id'] as $id) {
        $pubList[] = Publisher::staticGet('id', $id);
    }
    $interface->assign('pubList', $pubList);

    $interface->setTemplate('publisher-delete.tpl');
}

function handleDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $pub = new Publisher();
            $pub->id = $id;
            $pub->delete();
        }

        $interface->assign('msg', 'Publishers Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showLocationDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Publisher Locations' => 'publisher.php?action=showLocations', 'Delete Location'));

    $publisher = Publisher::staticGet('id', $_POST['pub_id']);
    $interface->assign('publisher', $publisher);

    $locList = array();
    foreach ($_POST['id'] as $id) {
        $locList[] = Publisher_location::staticGet('id', $id);
    }
    $interface->assign('locList', $locList);

    $interface->setTemplate('publisher-location-delete.tpl');
}

function handleLocationDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $location = new Publisher_location();
            $location->id = $id;
            $location->delete();
        }

        $interface->assign('msg', 'Locations Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showLocations';
    showLocations($interface);
}

function showMerge(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Publishers' => 'publisher.php', 'Merge Publishers'));

    if (isset($_POST['submit'])) {
        if ($_POST['source_publisher_id'] != '') {
            $publisher = Publisher::staticGet('id', $_POST['source_publisher_id']);
            $interface->assign('source_publisher', $publisher);

            $location = new Publisher_location();
            $location->publisher_id = $publisher->id;
            $dg = new DataGrid(20);
            $dg->bind($location);
            $dg->addColumn(new Structures_DataGrid_Column('Move', null, null, array('width' => '10', 'align' => 'center'), null, 'printMergeRadio', array('type' => 'move')));
            $dg->addColumn(new Structures_DataGrid_Column('Merge', null, null, array('width' => '10', 'align' => 'center'), null, 'printMergeRadio', array('type' => 'merge')));
            $dg->addColumn(new Structures_DataGrid_Column('Location', 'location', 'location'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgSourceLocations', $dg->getOutput());
        } elseif ($_POST['source_publisher'] != '') {
            $publisher = new Publisher();
            $publisher->whereAdd("name LIKE '" . addslashes($_POST['source_publisher']) . "%'");
            $dg = new DataGrid(20);
            $dg->bind($publisher);
            $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10', 'align' => 'center'), null, 'printRadio', array('type' => 'source')));
            $dg->addColumn(new Structures_DataGrid_Column('Name', 'name', 'name'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgSource', $dg->getOutput());
        }

        if ($_POST['end_publisher_id'] != '') {
            $publisher = Publisher::staticGet('id', $_POST['end_publisher_id']);
            $interface->assign('end_publisher', $publisher);

            $location = new Publisher_location();
            $location->publisher_id = $publisher->id;
            $dg = new DataGrid(20);
            $dg->bind($location);
            $dg->addColumn(new Structures_DataGrid_Column('Merge', null, null, array('width' => '10', 'align' => 'center'), null, 'printRadio', array('type' => 'merge')));
            $dg->addColumn(new Structures_DataGrid_Column('Location', 'location', 'location'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgDestinationLocations', $dg->getOutput());
        } elseif ($_POST['end_publisher'] != '') {
            $publisher = new Publisher();
            $publisher->whereAdd("name LIKE '" . addslashes($_POST['end_publisher']) . "%'");
            $publisher->whereAdd("id != '" . $_POST['source_publisher_id'] . "'");
            $dg =& new DataGrid(20);
            $dg->bind($publisher);
            $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10', 'align' => 'center'), null, 'printRadio', array('type' => 'end')));
            $dg->addColumn(new Structures_DataGrid_Column('Name', 'name', 'name'));
            $dg->addColumn(new Structures_DataGrid_Column('Works', null, null, null, null, 'printWorkCount()'));
            $interface->assign('dgDestination', $dg->getOutput());
        }
    }

    $interface->setTemplate('publisher-merge.tpl');
}

function processMerge(&$interface)
{
    $do = new DB_DataObject();

    // Update all references to the publisher
   foreach ($_POST['source_location_id'] as $sourceId => $action) {
       if ($action == 'move') {
            $sql = "UPDATE work_publisher SET publisher_id = '" . $_POST['end_publisher_id'] . "' WHERE publisher_id = '" . $_POST['source_publisher_id'] . "' AND location_id = '$sourceId'";
            $do->query($sql);
            $sql = "UPDATE publisher_location SET publisher_id = '" . $_POST['end_publisher_id'] . "' WHERE publisher_id = '" . $_POST['source_publisher_id'] . "' AND id = '$sourceId'";
            $do->query($sql);
        } elseif ($action == 'merge') {
            $sql = "UPDATE work_publisher SET publisher_id = '" . $_POST['end_publisher_id'] . "', location_id = '" . $_POST['merge_publisher_id'] . "' WHERE publisher_id = '" . $_POST['source_publisher_id'] . "' AND location_id = '$sourceId'";
            $do->query($sql);
            $sql = "DELETE FROM publisher_location WHERE id = '$sourceId'";
            $do->query($sql);
        }
    }

    // Remove old publisher
    $sql = "SELECT COUNT(*) AS cnt FROM work_publisher WHERE id = '" . $_POST['source_publisher_id'] . "'";
    $do->query($sql);
    $do->fetch();
    if (!$do->cnt) {
        $sql = "DELETE FROM publisher WHERE id = '" . $_POST['source_publisher_id'] . "'";
        $do->query($sql);
    }

    $interface->assign('message', 'Publishers have been merged');

    $_GET['id'] = $_POST['end_publisher_id'];
    showLocations($interface);
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

function printRadio($params, $args)
{
    extract($params);
    extract($args);
    return '<input type="radio" name="' . $type . '_publisher_id" value="' . $record['id'] . '">';
}

function printMergeRadio($params, $args)
{
    extract($params);
    extract($args);
    if ($checked) {
        return '<input type="radio" name="source_location_id[' . $record['id'] . ']" value="' . $type . '" checked>';
    } else {
        return '<input type="radio" name="source_location_id[' . $record['id'] . ']" value="' . $type . '">';
    }
}

function printRadioLocation($params)
{
    extract($params);
    return '<input type="radio" name="master_id" value="' . $record['id'] . '">';
}

function printLink($params)
{
    extract($params);
    $publisher = new Publisher();
    $publisher->id = $record['id'];
    return '<a href="publisher.php?action=showForm&id=' . $record['id'] . '">' . $record['name'] . '</a> (' . $publisher->getWorkCount() . ')';
}

function printLocationLink($params)
{
    extract($params);

    $location = new Publisher_location();
    $location->id = $record['id'];
    $location->publisher_id = $record['publisher_id'];
    return '<a href="publisher.php?action=showLocationForm&pub_id=' . $record['publisher_id'] . '&location_id=' . $record['id']. '">' .
           $record['location'] . '</a> (' . $location->getWorkCount() . ')';
}

function printManageLocationLink($params)
{
    extract($params);
    return '<a href="publisher.php?action=showLocations&id=' . $record['id'] . '">Manage Locations</a>';
}

function printWorkCount($params)
{
    extract($params);
    if ($record['publisher_id']) {
        $location = new Publisher_location();
        $location->id = $record['id'];
        $location->publisher_id = $record['publisher_id'];
        return $location->getWorkCount();
    } else {
        $publisher = new Publisher();
        $publisher->id = $record['id'];
        return $publisher->getWorkCount();
    }
}

?>
