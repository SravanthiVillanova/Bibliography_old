<?php
require_once('classes/Workattribute.php');

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

    $interface->setTrail(array('Home' => 'index.php', 'Work Types'));

    $dg = new DataGrid(20);

    $type = new Worktype();
    $dg->bind($type);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Work Type', 'type', 'type', null, null, 'printEditLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Attributes', null, null, array('width' => '25%', 'align' => 'center'), null, 'printLink()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('worktype-list.tpl');
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Work Type' => 'worktype.php', 'Delete Type'));

    $typeList = array();
    foreach ($_POST['id'] as $id) {
        $typeList[] = Worktype::staticGet('id', $id);
    }
    $interface->assign('typeList', $typeList);

    $interface->setTemplate('worktype-delete.tpl');
}

function handleDelete(&$interface)
{
    global $translator;

    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $type = Worktype::staticGet('id', $id);

            $sql = "DELETE FROM worktype_workattribute WHERE worktype_id = '$id'";
            $type->query($sql);

            unset($translator->langCode);
            $translator->load('../translations');
            $translator->removeTranslation($type->type);
            $translator->save();

            $type->delete();
        }

        $interface->assign('msg', 'Work Types Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}


function showForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php',
                               'Work Types' => 'worktype.php',
                               'Work Type'));

    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $type = Worktype::staticGet('id', $_GET['id']);
    } else {
        $type = new Worktype();
    }
    $interface->assign('type', $type);

    $interface->setTemplate('worktype-form.tpl');
}

function handleForm(&$interface)
{
    global $translator;

    // Fetch work specified by query string
    if (isset($_POST['submit'])) {
        $type = new Worktype();
        $type->type = $_POST['type'];
        if ($_POST['id'] != '') {
            $type->id = $_POST['id'];
            $type->update();
        } else {
            $type->insert();

            $translator->setTranslation($_POST['type'], $_POST['type'], 'en');
            $translator->save();
        }
    }

    $interface->assign('message', 'Work Type saved');

    $_GET['action'] = 'showList';
    showList($interface);
}

function showAttributes(&$interface)
{
    require_once('classes/Workattribute.php');

    $interface->setTrail(array('Home' => 'index.php', 'Work Types' => 'worktype.php', 'Attributes'));

    $dg =& new DataGrid(20);

    // Get Attributes
    $attr = new Workattribute();
    if (isset($_GET['id'])) {
        $sql = "SELECT workattribute.* FROM workattribute, worktype_workattribute WHERE workattribute.id = worktype_workattribute.workattribute_id AND worktype_workattribute.worktype_id = '" . $attr->escape($_GET['id']) . "'";
        $attr->query($sql);
    }
    $dg->bind($attr);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Attribute', 'field', 'field', null, null, 'printEditAttrLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Options', null, null, array('width' => '25%', 'align' => 'center'), null, 'printOptionsLink()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('worktype-attributelist.tpl');
}

function mergeDuplicateOptions(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $interface->setTrail(array('Home' => 'index.php', 'Work Types' => 'worktype.php', 'Attributes' => 'worktype.php?action=showAttributes', 'Merge'));

    $attr = new Workattribute_option();

    if (isset($_GET['id'])) {
        // Not sure what the value field is for, so let's avoid entries where it is set!
        $sql = "SELECT title FROM workattribute_option where (value is null or value = '') and workattribute_id='" . $attr->escape($_GET['id']) .
            "' group by title having count(title) > 1 order by title";
        $attr->query($sql);
    }

    $titles = array();
    while ($attr->fetch()) {
        if ($_GET['forreal'] == 1) {
            _mergeDuplicateOption($attr->title, $_GET['id']);
        }
        $titles[] = $attr->title;
    }
    $interface->assign('merged', $titles);
    $interface->assign('attrib_id', $_GET['id']);
    $interface->assign('forReal', $_GET['forreal']);
    $interface->setTemplate('worktype-attributemerge.tpl');
}

/* Support function for mergeDuplicateOptions; merge a single duplicate: */
function _mergeDuplicateOption($title, $id)
{
    // Create two database connections -- one for iterating through matches,
    // one for performing individual update operations:
    $attr = new Workattribute_option();
    $tmp = new Workattribute_option();

    // Find all the title matches for the current ID:
    $sql = "SELECT id FROM workattribute_option WHERE (value is null or value = '') and title='" . $attr->escape($title) . "' AND workattribute_id='" . $attr->escape($id) . "'";
    $attr->query($sql);

    // Fetch the first match -- this will become our master value:
    $attr->fetch();
    $first = $attr->id;

    // Convert all subsequent matches into the first value:
    while ($attr->fetch()) {
        $sql = "UPDATE work_workattribute SET value='" . $attr->escape($first) . "' WHERE workattribute_id='" . $attr->escape($id) . "' AND value='" . $attr->escape($attr->id) . "';";
        $tmp->query($sql);
        $sql = "DELETE FROM workattribute_option WHERE id='" . $attr->id . "';";
        $tmp->query($sql);
    }
}

function showAttrForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php',
                               'Work Types' => 'worktype.php',
                               'Attributes' => 'worktype.php?action=showAttributes',
                               'Edit Attribute'));

    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $attribute = Workattribute::staticGet('id', $_GET['id']);
    } else {
        $attribute = new Workattribute();
    }
    $interface->assign('attribute', $attribute);

    $interface->setTemplate('worktype-attributeform.tpl');
}

function handleAttrForm(&$interface)
{
    global $translator;

    $attribute = new Workattribute();
    $attribute->id = $_POST['id'];
    $attribute->field = $_POST['attribute'];
    $attribute->type = $_POST['type'];
    if ($attribute->id != '') {
        $attribute->update();
    } else {
        $attribute->insert();

        // Add Translation Term
        $translator->setTranslation($attribute->field, $attribute->field, 'en');
        $translator->save();
    }

    unset($_GET['id']);
    $_GET['action'] = 'showAttributes';

    showAttributes($interface);
}

function showAttrDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php',
                               'Work Types' => 'worktype.php',
                               'Attributes' => 'worktype.php?action=showAttributes',
                               'Delete Attribute'));


    $attrList = array();
    foreach ($_POST['id'] as $id) {
        $attrList[] = Workattribute::staticGet('id', $id);
    }
    $interface->assign('attrList', $attrList);

    $interface->setTemplate('worktype-attributedelete.tpl');
}

function handleAttrDelete(&$interface)
{
    global $translator;

    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $attr = Workattribute::staticGet('id', $id);

            $sql = "DELETE FROM worktype_workattribute WHERE workattribute_id = '$id'";
            $attr->query($sql);

            unset($translator->langCode);
            $translator->load('../translations');
            $translator->removeTranslation($attr->field);
            $translator->save();

            $attr->delete();
        }

        $interface->assign('msg', 'Work Attributes Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showAttributes';
    showAttributes($interface);
}

function showAttrSelect(&$interface)
{
    require_once('classes/Workattribute.php');

    global $translator;

    $interface->setTrail(array('Home' => 'index.php',
                               'Work Types' => 'worktype.php',
                               'Choose Attributes'));

    // Get Attributes
    $attrList = array();
    $attr = new Workattribute();
    if ($attr->find()) {
        while ($attr->fetch()) {
            $tmp = new DB_DataObject();
            $tmp->query("SELECT rank FROM worktype_workattribute WHERE worktype_id = '" . $_GET['id'] . "' AND workattribute_id = '$attr->id'");
            $tmp->fetch();
            $attrArray = $attr->toArray();
            $attrArray['rank'] = $tmp->rank;
            $attrList[] = $attrArray;
        }
    }

    // Define Datagrid
    $dg =& new DataGrid();
    $dg->sortRecordSet('rank');
    $dg->bind($attrList);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printSelectCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Order', null, null, array('width' => '30', 'align' => 'center'), null, 'printOrdering()'));
    $dg->addColumn(new Structures_DataGrid_Column('Attribute', 'field', 'field', null, null, 'printEditAttrLink()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $type = Worktype::staticGet('id', $_GET['id']);
    $interface->assign('type', $type);

    $interface->setTemplate('worktype-attribute-selectlist.tpl');
}

function handleAttrSelect(&$interface)
{
    $do = new DB_DataObject();

    $sql = "DELETE FROM worktype_workattribute WHERE worktype_id = '" . $_POST['type_id'] . "'";
    $result = $do->query($sql);
    for ($i = 0; $i < count($_POST['id']); $i++) {
        $rank = (isset($_POST['rank'][$i])) ? $_POST['rank'][$i] : $i;
        $sql = "INSERT INTO worktype_workattribute (worktype_id, workattribute_id, rank) " .
               "VALUES('" . $_POST['type_id'] . "', '" . $_POST['id'][$i] . "', " . $rank . ")";
        $do->query($sql);
    }

    $_GET['action'] = 'showAttrSelect';
    showAttrSelect($interface);
}

function rankAttr(&$interface)
{
    $do = new DB_DataObject();
    $do->query("SELECT rank FROM worktype_workattribute WHERE worktype_id = '" . $_GET['id'] . "' AND workattribute_id = '" . $_GET['attr_id'] . "'");
    $do->fetch();

    $sql = "UPDATE worktype_workattribute SET rank = $do->rank " .
           "WHERE worktype_id = '" . $_GET['id'] . "' AND rank = $do->rank + " . $_GET['rank'] . "";
    $do = new DB_DataObject();
    $do->query($sql);

    $sql = "UPDATE worktype_workattribute SET rank = rank + " . $_GET['rank'] . " " .
           "WHERE worktype_id = '" . $_GET['id'] . "' " .
           "AND workattribute_id = '" . $_GET['attr_id'] . "'";
    $do->query($sql);

    $_GET['action'] = 'showAttrSelect';
    showAttrSelect($interface);
}

function showOptionsList(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $interface->setTrail(array('Home' => 'index.php', 'Work Types' => 'worktype.php', 'Attributes' => 'worktype.php?action=showAttributes', 'Attribute Options'));

    // Define Attribute
    $attribute = Workattribute::staticGet('id', $_GET['id']);
    $interface->assign('attribute', $attribute);

    $dg = new DataGrid(20);

    // Get Attribute Options
    $option = new Workattribute_option();
    $option->workattribute_id = $_GET['id'];
    $dg->bind($option);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Option', 'title', 'title', null, null, 'printEditOptionLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Type', 'value', 'value'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('worktype-attribute-optionlist.tpl');
}

function showOptionDelete(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $optionList = array();
    foreach ($_POST['id'] as $id) {
        $option = Workattribute_option::staticGet('id', $id);
        $optionList[] = $option;
    }
    $interface->assign('optionList', $optionList);

    $interface->setTemplate('worktype-attribute-optiondelete.tpl');
}

function handleOptionDelete(&$interface)
{
    require_once('classes/Workattribute_option.php');

    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $option = new Workattribute_option();
            $option->id = $id;
            $option->delete();
        }
        $interface->assign('message', 'Options Deleted');
    } else {
        $interface->assign('message', 'Options Delete Canceled');
    }

    $_GET['action'] = 'showOptionsList';
    showOptionsList($interface);
}

function showOptionForm(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $interface->setTrail(array('Home' => 'index.php',
                               'Work Types' => 'worktype.php',
                               'Attributes' => 'worktype.php?action=showAttributes',
                               'Attribute Options' => 'worktype.php?action=showOptionsList&id=' . $_GET['attribute_id'],
                               'Add Option'));

    $attribute = new Workattribute();
    $attribute->id = $_GET['attribute_id'];
    $interface->assign('attribute', $attribute);

    if (isset($_GET['id'])) {
        $option = Workattribute_option::staticGet('id', $_GET['id']);
    } else {
        $option = new Workattribute_option();
    }
    $interface->assign('option', $option);

    $interface->setTemplate('worktype-attribute-optionform.tpl');
}

function handleOptionForm(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $option = new Workattribute_option();
    $option->workattribute_id = $_POST['attribute_id'];
    $option->title = $_POST['title'];
    $option->value = $_POST['value'];

    if ($_POST['id'] != '') {
        $option->id = $_POST['id'];
        $option->update();
    } else {
        $option->insert();
    }

    $interface->assign('message', 'Option Saved');

    $_GET['id'] = $_POST['attribute_id'];
    $_GET['action'] = 'showOptionsList';
    showOptionsList($interface);
}

function showOptionLookup(&$interface)
{
    $attribute = new Workattribute();

    // Depending on context, the attribute ID may be in an "id" or "attribute_id"
    // parameter.  We'll accept either one:
    $attribute->id = isset($_GET['id']) ? $_GET['id'] : $_GET['attribute_id'];

    $interface->assign('attribute', $attribute);

    $interface->display('worktype-attribute-optionlookup.tpl');
    exit();
}

function handleOptionLookup(&$interface)
{
    require_once('classes/Workattribute_option.php');

    $option = new Workattribute_option();
    $option->workattribute_id = $_GET['attribute_id'];

    // For optimal case-insensitive matching, we'll uppercase everything inside
    // the database.  This provides more consistent handling of diacritics than
    // doing part of the work in PHP:
    $where = "UPPER(title) LIKE UPPER('%" . $option->escape(str_replace('*', '%', $_GET['title'])) . "%')";
    $option->whereAdd($where);

    $dg = new DataGrid();
    $dg->bind($option);

    $dg->addColumn(new Structures_DataGrid_Column('Option', 'title', 'title', null, null, 'printOptionTitle()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dghtml', $dghtml);

    showOptionLookup($interface);
}
// Display page
$interface->display('layout-admin.tpl');

function printCheckbox($params)
{
    extract($params);
    return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
}

function printSelectCheckbox($params)
{
    extract($params);
    /*
    if ($record['worktype_id'] === null) {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
    } else {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '" CHECKED>';
    }
    */

    $do = new DB_DataObject();

    $sql = "SELECT * FROM worktype_workattribute WHERE workattribute_id = '" . $record['id'] . "' AND worktype_id = '" . $_GET['id'] . "'";
    $do->query($sql);
    if ($do->N) {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '" CHECKED>';
    } else {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
    }
}

function printEditLink($params)
{
    extract($params);
    return '<a href="worktype.php?action=showForm&id=' . $record['id'] . '">' . $record['type'] . '</a>';
}

function printEditAttrLink($params)
{
    extract($params);
    return '<a href="worktype.php?action=showAttrForm&id=' . $record['id'] . '">' . $record['field'] . '</a>';
}

function printLink($params)
{
    extract($params);
    return '<a href="worktype.php?action=showAttrSelect&id=' . $record['id'] . '">Manage Attributes</a>';
}

function printOptionsLink($params)
{
    extract($params);
    return '<a href="worktype.php?action=showOptionsList&id=' . $record['id'] . '">Manage&nbsp;Options</a>' .
        '<br/><a href="worktype.php?action=MergeDuplicateOptions&id=' . $record['id'] . '">Merge&nbsp;Duplicate&nbsp;Values</a>';
}

function printEditOptionLink($params)
{
    extract($params);
    return '<a href="worktype.php?action=showOptionForm&id=' . $record['id'] . '&attribute_id=' . $record['workattribute_id'] . '">' . $record['title'] . '</a>';
}

function printOrdering($params)
{
    extract($params);

    $do = new DB_DataObject();

    $sql = "SELECT rank FROM worktype_workattribute WHERE workattribute_id = '" . $record['id'] . "' AND worktype_id = '" . $_GET['id'] . "'";
    $do->query($sql);
    if ($do->N) {
        $do->fetch();
        if ($do->rank) {
            return '<a href="worktype.php?action=rankAttr&id=' . $_GET['id'] . '&attr_id=' . $record['id'] . '&rank=-1">&uarr;</a> ' .
                   '<a href="worktype.php?action=rankAttr&id=' . $_GET['id'] . '&attr_id=' . $record['id'] . '&rank=1">&darr;</a>' .
                   '<input type="hidden" name="rank[]" value="' . $record['rank'] . '">';
        } else {
            return '&nbsp;&nbsp;<a href="worktype.php?action=rankAttr&id=' . $_GET['id'] . '&attr_id=' . $record['id'] . '&rank=1">&darr;</a>' .
                   '<input type="hidden" name="rank[]" value="' . $record['rank'] . '">';
        }
    }
}

function printOptionTitle($params)
{
    extract($params);
    return '<a href="worktype.php" onClick="' .
           'window.opener.document.workForm.elements[\'option[' . $record['workattribute_id'] . ']\'].value=\'' . $record['id'] . '\'; ' .
           'window.opener.document.workForm.view.value=\'citation\'; ' .
           'window.opener.document.workForm.submit(); ' .
           'window.close(); return false;">' . $record['title'] . '</a>';
}

?>
