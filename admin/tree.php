<?php
$langVar = 'text_fr';
$interface->assign('langVar', $langVar);

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
    global $langVar;

    $interface->setTrail(array('Home' => 'index.php', 'Classification Tree'));

    $dg = new DataGrid();

    $folder = new Folder();
    $folder->orderBy('sort_order,text_fr');
    //$folder->selectAdd("concat(number, ' ', " . $langVar . ") AS " . $langVar);
    if (isset($_GET['id'])) {
        $folder->parent_id = $_GET['id'];
        $currentFolder = Folder::staticGet('id', $_GET['id']);
        $interface->assign('folder', $currentFolder);
    } else {
        $folder->parent_id = 'NULL';
    }
    $dg->bind($folder);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column($translator->translate('Title'), $langVar, $langVar, null, null, 'printTitle()'));
    $dg->addColumn(new Structures_DataGrid_Column('Edit', null, null, array('width' => '10%', 'align' => 'center'), null, 'printEdit()'));
    $dg->addColumn(new Structures_DataGrid_Column('Move', null, null, array('width' => '10%', 'align' => 'center'), null, 'printMove()'));
    $dg->addColumn(new Structures_DataGrid_Column('References', null, null, array('width' => '10%', 'align' => 'center'), null, 'printRefs()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);

    $interface->setTemplate('folder-list.tpl');
}

/**
 * Action to export the list of subjects as a spreadsheet.
 *
 * @return void
 */
function exportList()
{
    header("Content-type: text/csv; charset=UTF-8");
    header('Content-Disposition: attachment; filename="keywords.csv"');
    // UTF-8 BOM for proper character handling in newer versions of Excel:
    echo chr(hexdec('EF')), chr(hexdec('BB')), chr(hexdec('BF'));
    echo getCsv();
    exit;
}

/**
 * Get CSV lines for a level of the subject tree.  Designed for recursive use,
 * so normally called with default parameters.
 *
 * @param string $parent ID of node whose children we should display ('null' for top
 * level)
 * @param string $prefix Code to prefix to every line of the CSV.
 * @param string $lang   Language code for headings to display.
 *
 * @return string        CSV output for everything under the specified parent level.
 */
function getCsv($parent = 'null', $prefix = '', $lang = 'fr')
{
    $csv = '';

    $tmp = new Folder();
    $tmp->parent_id = $parent;
    if ($tmp->find()) {
        while ($tmp->fetch()) {
            $name = $tmp->number . ' ' . $tmp->{'text_' . $lang};
            if (strlen(trim($name)) < 1) {
                $name = "[blank keyword -- ID #{$tmp->id}]";
            }

            // Escape name for inclusion in CSV:
            $name = str_replace('"', '\"', $name);

            // Update CSV and recurse to next level:
            $csv .= $prefix . '"' . $name . '"' . "\n";
            $csv .= getCsv($tmp->id, $prefix . '"' . $name . '",');
        }
    }

    return $csv;
}

/**
 * Action to export the list of translations as a spreadsheet.
 *
 * @return void
 */
function exportTranslationList()
{
    header("Content-type: text/csv; charset=UTF-8");
    header('Content-Disposition: attachment; filename="keywords.csv"');
    // UTF-8 BOM for proper character handling in newer versions of Excel:
    echo chr(hexdec('EF')), chr(hexdec('BB')), chr(hexdec('BF'));
    echo getTransCsv('null', '', true, isset($_GET['start']) ? $_GET['start'] : null);
    exit;
}

/**
 * Get CSV lines for a level of the subject tree.  Designed for recursive use,
 * so normally called with default parameters.
 *
 * @param string $parent ID of node whose children we should display ('null' for top
 * level)
 * @param string $prefix Code to prefix to every line of the CSV.
 * @param bool   $header Should we include a header row?
 * @param string $start  ID of top-level record (null to get all records).
 *
 * @return string        CSV output for everything under the specified parent level.
 */
function getTransCsv($parent = 'null', $prefix = '', $header = true, $start = null)
{
    $csv = '';

    $tmp = new Folder();
    if (is_null($start)) {
        $tmp->parent_id = $parent;
        if ($tmp->find()) {
            while ($tmp->fetch()) {
                $csv .= getTransCsvInner($tmp, $prefix, $header);
                $header = false;        // only display header once
            }
        }
    } else {
        $tmp->get($start);
        $csv .= getTransCsvInner($tmp, $prefix, $header);
    }

    return $csv;
}

/**
 * Inner logic for getTransCsv
 */
function getTransCsvInner($tmp, $prefix, $header)
{
    $csv = '';

    $name = $tmp->number . ' ' . $tmp->text_fr;
    if (strlen(trim($name)) < 1) {
        $name = "[blank keyword -- ID #{$tmp->id}]";
    }

    $csvRow = array($prefix);
    foreach ($tmp as $k => $v) {
        if (strlen($k) > 1 && substr($k, 0, 1) != '_') {
            $csvRow[] = $v;
        }
    }
    foreach ($csvRow as $k => $v) {
        $csvRow[$k] = str_replace('"', '\"', $v);
    }

    // Update CSV and recurse to next level:
    if ($header) {
        $csv .= getTransCsvHeader($tmp, array('parent path'));
    }
    $csv .= implode(',', $csvRow) . "\n";
    $csv .= getTransCsv($tmp->id, empty($prefix) ? $name : $prefix . ' > ' . $name, false);

    return $csv;
}

/**
 * Get a header row for a CSV file based on a DB object.
 *
 * @param object $row    Row to use for header generation.
 * @param array  $prefix Array of headings to prepend to list.
 *
 * @return string
 */
function getTransCsvHeader($row, $prefix = array())
{
    foreach ($row as $k => $v) {
        if (strlen($k) > 1 && substr($k, 0, 1) != '_') {
            $prefix[] = $k;
        }
    }
    foreach ($prefix as $k => $v) {
        $prefix[$k] = str_replace('"', '\"', $v);
    }
    return implode(',', $prefix) . "\n";
}

/**
 * Normalize text from a TSV file.
 *
 * @param string $newText Text to normalize
 *
 * @return string
 */
function normalizeTsvText($newText)
{
    $newText = trim($newText);
    // Normalize quotes -- TSV has single quotes around phrases containing commas, but triple-quotes
    // around phrases that are actually supposed to be surrounded by quotes!
    if (preg_match('/".*"/', $newText)) {
        if (preg_match('/.*""".*/', $newText)) {
            $newText = str_replace('"""', '"', $newText);
        } else {
            $newText = str_replace('"', '', $newText);
        }
    }
    return $newText;
}

/**
 * Load new translations from a tab-separated file.  Disabled for now but retained for future reference.
function loadTsv()
{
    $lines = file($_GET['filename']);
    $force = isset($_GET['force']) ? true : false;  // flag to force updates; normally we show warnings when text doesn't match.
    foreach ($lines as $line) {
        $tr = array();
        list ($id, $tr['en'], $fr, $tr['de'], $tr['nl'], $tr['es'], $tr['it']) = explode("\t", $line);
        if (intval($id) > 0) {
            $tmp = new Folder();
            $tmp->id = $id;
            if ($tmp->find() && $tmp->fetch()) {
                $changedLangs = array();
                foreach ($tr as $lng => $newText) {
                    $newText = normalizeTsvText($newText);
                    if (!empty($newText)) {
                        $prop = 'text_' . $lng;

                        // Skip translations that have already been applied:
                        if ($tmp->$prop == $newText) {
                            continue;
                        }

                        // Normally we only allow overwriting of strings starting with '[' (which
                        // indicates an incomplete translation).  However, we'll overwrite everything
                        // in force mode.
                        if (substr($tmp->$prop, 0, 1) != '[' && !$force) {
                            echo $id . ' has inconsistent ' . $lng . ' translation; current = ' . $tmp->$prop . '; new = ' . $newText . '<br/>';
                        } else {
                            $tmp->$prop = $newText;
                            $changedLangs[] = $lng;
                        }
                    }
                }
                if (count($changedLangs) > 0) {
                    $fr = normalizeTsvText($fr);
                    if ($tmp->text_fr != $fr && !$force) {
                        echo $id . ' has original French mismatch; current = ' . $tmp->text_fr . '; new = ' . $fr . '<br/>';
                    } else {
                        // Normally we don't want to change the original French text, but if we are forcing
                        // changes, we should do so now:
                        if ($tmp->text_fr != $fr && $force) {
                            $tmp->text_fr = $fr;
                            $changedLangs[] = 'fr';
                        }
                        echo count($changedLangs) . ' changes to ' . $id . ' (' . implode(', ', $changedLangs) . ')<br/>';
                        $tmp->update();
                    }
                }
            } else {
                echo 'Could not fetch ' . $id . '<br/>';
            }
        }
    }
}
 */

function getParentFolderList($folder)
{
    // Parent Branch List
    $folderList = array();
    if ($folder->parent_id != '' && $folder->parent_id != 'null') {
        $parent = Folder::staticGet('id', $folder->parent_id);
        $folderList = $parent->getSiblings();
    } else {
        $tmp = new Folder();
        $tmp->parent_id = 'null';
        if ($tmp->find()) {
            while ($tmp->fetch()) {
                $folderList[] = clone($tmp);
            }
        }
        unset($tmp);
    }
    return $folderList;
}

function showForm(&$interface)
{
    global $langVar;

    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $folder = Folder::staticGet('id', $_GET['id']);
        $interface->setTrail(array('Home' => 'index.php', 'Classification Tree' => 'tree.php', 'Edit Subject Branch'));
    } else {
        $folder = new Folder();
        if (isset($_GET['parent_id'])) {
            $folder->parent_id = $_GET['parent_id'];
        }
        $interface->setTrail(array('Home' => 'index.php', 'Classification Tree' => 'tree.php', 'Add Subject Branch'));
    }

    $interface->assign('folderList', getParentFolderList($folder));

    $interface->assign('folder', $folder);

    $interface->setTemplate('folder-form.tpl');
}

function handleForm(&$interface)
{
    $folder = new Folder();
    $folder->id = $_POST['id'];
    if ($_POST['parent_id'] != '') {
        $folder->parent_id = $_POST['parent_id'];
        $_GET['id'] = $folder->parent_id;
    } else {
        $folder->parent_id = 'null';
    }

    $folder->sort_order = $_POST['number'];
    $folder->text_en = $_POST['title_en'];
    $folder->text_fr = $_POST['title_fr'];
    $folder->text_de = $_POST['title_de'];
    $folder->text_nl = $_POST['title_nl'];
    $folder->text_es = $_POST['title_es'];
    $folder->text_it = $_POST['title_it'];

    // Disallow blank text:
    if (empty($_POST['title_en']) || empty($_POST['title_fr']) ||
        empty($_POST['title_de']) || empty($_POST['title_nl']) ||
        empty($_POST['title_es']) || empty($_POST['title_it'])) {
        $interface->assign('folderList', getParentFolderList($folder));
        $interface->assign('folder', $folder);
        $interface->assign('message', 'Please fill in all of the text fields before saving.');
        $interface->setTemplate('folder-form.tpl');
    // Process update if legal information provided:
    } else {
        if ($folder->id != '') {
            $folder->update();
        } else {
            $folder->insert();
        }

        $_GET['action'] = 'showList';
        showList($interface);
    }
}

function showDelete(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Classification Tree' => 'tree.php', 'Delete Branch'));

    $treeList = array();
    foreach ($_POST['id'] as $id) {
        $folderList[] = Folder::staticGet('id', $id);
    }
    $interface->assign('folderList', $folderList);

    $interface->setTemplate('folder-delete.tpl');
}

function handleDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $folder = new Folder();
            $folder->id = $id;

            $sql = "DELETE FROM work_folder WHERE folder_id = '$id'";
            $folder->query($sql);

            $folder->delete();
        }

        $interface->assign('msg', 'Branches Deleted');
    } else {
        $interface->assign('msg', 'Delete Canceled');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showMove(&$interface)
{
    global $langVar;

    $interface->setTrail(array('Home' => 'index.php', 'Classification Tree' => 'tree.php', 'Move Branch'));
    $folder = Folder::staticGet('id', $_GET['id']);
    $interface->assign('folder', $folder);

    if (isset($_POST['dest_folder'])) {
        if (!empty($_POST['dest_folder'])) {
            $interface->assign('destFolder', Folder::staticGet('id', $_POST['dest_folder']));
        }
    } else {
        if (!empty($folder->parent_id)) {
            $interface->assign('destFolder', Folder::staticGet('id', $folder->parent_id));
        }
    }

    // Get the list for a new subject tree
    $topFolderList = array();
    $folder = new Folder();
    $folder->parent_id = 'null';
    $folder->find();
    while ($folder->fetch()) {
        $topFolderList[] = clone($folder);
    }
    $interface->assign('topFolderList', $topFolderList);

    $interface->setTemplate('folder-move.tpl');
}

function handleMove(&$interface)
{
    $folder = Folder::staticGet('id', $_GET['id']);
    if ($_POST['dest_folder'] === $_GET['id']) {
        return moveError($interface, 'Cannot move a classification into itself.');
    }

    if (!empty($_POST['dest_folder'])) {
        $dest = Folder::staticGet('id', $_POST['dest_folder']);
        $parents = $dest->getParentChain();
        foreach($parents as $parent) {
            if ($parent->id == $folder->id) {
                return moveError($interface, 'Cannot move a classification into its own child.');
            }
        }
    }

    $folder->parent_id = empty($_POST['dest_folder']) ? 'null' : $_POST['dest_folder'];
    $folder->update();

    $interface->assign('message', 'Branch moved successfully');

    $_GET['action'] = 'showList';
    $_GET['id'] = $folder->parent_id == 'null' ? null : $folder->parent_id;
    showList($interface);
}

function showMerge(&$interface)
{
    // Determine Selected Folders
    if (isset($_POST['source_folder']) && !empty($_POST['source_folder'])) {
        $interface->assign('sourceFolder', Folder::staticGet('id', $_POST['source_folder']));
    }
    if (isset($_POST['dest_folder']) && !empty($_POST['dest_folder'])) {
        $interface->assign('destFolder', Folder::staticGet('id', $_POST['dest_folder']));
    }

    // Get the list for a new subject tree
    $topFolderList = array();
    $folder = new Folder();
    $folder->parent_id = 'null';
    $folder->find();
    while ($folder->fetch()) {
        $topFolderList[] = clone($folder);
    }
    $interface->assign('topFolderList', $topFolderList);

    $interface->setTemplate('folder-merge.tpl');
}

function processMerge(&$interface)
{
    // Simple check -- can't merge something with itself:
    if ($_POST['source_folder'] == $_POST['dest_folder']) {
        return mergeError($interface, "Cannot merge -- source and destination are the same.");
    }

    // Load source and destination folders:
    $source = Folder::staticGet('id', $_POST['source_folder']);
    if (!$source) {
        return mergeError($interface, 'Problem loading source folder with ID: ' . $_POST['source_folder']);
    }
    $dest = Folder::staticGet('id', $_POST['dest_folder']);
    if (!$dest) {
        return mergeError($interface, 'Problem loading destination folder with ID: ' . $_POST['dest_folder']);
    }

    // Don't allow merge into your own parent or child:
    $destParents = $dest->getParentChain();
    foreach($destParents as $parent) {
        if ($parent->id == $source->id) {
            return mergeError($interface, 'Cannot merge a classification into its own child.');
        }
    }
    $sourceParents = $source->getParentChain();
    foreach($sourceParents as $parent) {
        if ($parent->id == $dest->id) {
            return mergeError($interface, 'Cannot merge a classification into its own parent.');
        }
    }

    // Has the merge been confirmed?  If not, show confirmation; otherwise, process changes!
    if (!isset($_POST['confirm']) || $_POST['confirm'] != 'yes') {
        $interface->assign('sourceFolder', $source);
        $interface->assign('destFolder', $dest);
        $interface->assign('sourceWorks', count($source->getWorks()));
        $interface->assign('destWorks', count($dest->getWorks()));
        $interface->assign('sourceChildren', count($source->getChildren()));
        $interface->assign('destChildren', count($dest->getChildren()));
        $interface->setTemplate('folder-merge-confirm.tpl');

    } else {
        $do = new DB_DataObject();

        $safeSource = $do->escape($source->id);
        $safeDest = $do->escape($dest->id);

        // Move children
        $sql = "UPDATE folder SET parent_id = '{$safeDest}' WHERE parent_id = '{$safeSource}'";
        $do->query($sql);

        // Move works (but first delete potential duplicates to avoid key violation).
        // Note nested subquery hack to work around MySQL limitation of being unable
        // to select from updated table in single subquery.
        $sql = "DELETE FROM work_folder WHERE folder_id='{$safeDest}' AND work_id IN " .
            "(SELECT work_id FROM (SELECT * FROM work_folder WHERE folder_id='{$safeSource}') AS x)";
        $do->query($sql);
        $sql = "UPDATE work_folder SET folder_id = '{$safeDest}' WHERE folder_id = '{$safeSource}'";
        $do->query($sql);

        // Move references (probably unnecessary -- this feature does not seem to be used):
        $sql = "UPDATE folder_reference SET folder_id = '{$safeDest}' WHERE folder_id = '{$safeSource}'";
        $do->query($sql);
        $sql = "UPDATE folder_reference SET reference_id = '{$safeDest}' WHERE reference_id = '{$safeSource}'";
        $do->query($sql);

        // Track merge history -- update any previous history, then add the current merge:
        $sql = "UPDATE folder_merge_history SET dest_folder_id='{$safeDest}' " .
            "WHERE dest_folder_id='{$safeSource}'";
        $do->query($sql);
        $sql = "INSERT INTO folder_merge_history(source_folder_id, dest_folder_id) " .
            "VALUES ('{$safeSource}', '{$safeDest}')";
        $do->query($sql);

        // Purge
        $sql = "DELETE FROM folder WHERE id = '{$safeSource}'";
        $do->query($sql);

        showList($interface);
        // All done -- report success and display the destination folder!
        $_GET['id'] = $_POST['dest_folder'];
        $interface->assign('message', 'Merge successful.');
        showForm($interface);
    }
}

/**
 * Remove duplicate folders; one-time utility function used during database repair;
 * no longer necessary once proper primary key in place, but retained for future
 * reference.
 */
function dedupeFolders()
{
    $do = new DB_DataObject();

    // Get a count before the operation:
    $countSql = "SELECT DISTINCT * FROM work_folder";
    $do->query($countSql);
    echo "<p>Before: {$do->N}</p>";

    // Find duplicate rows:
    $dupSql = "SELECT *, count(*) AS c FROM work_folder GROUP BY work_id, folder_id HAVING c > 1";
    $c = $do->query($dupSql);
    echo "<p>Found {$do->N} duplicates...</p>";

    while ($do->fetch()) {
        // Delete all but one in each set of duplicate rows:
        $do2 = new DB_DataObject();
        $count = $do->c - 1;
        $sql = "DELETE FROM work_folder WHERE work_id={$do->work_id} AND folder_id={$do->folder_id} LIMIT {$count}";
        $do2->query($sql);
    }

    // Get a count after the operation -- should match "before" number:
    $do->query($countSql);
    echo "<p>After: {$do->N}</p>";
}

function moveError(&$interface, $message)
{
    $interface->assign('message', $message);
    showMove($interface);
}

function mergeError(&$interface, $message)
{
    $interface->assign('message', $message);
    showMerge($interface);
}

function showReferences(&$interface)
{
    global $langVar;

    $folder = Folder::staticGet('id', $_GET['id']);
    $interface->setTrail(array('Home' => 'index.php', 'Classification Tree' => 'tree.php', 'Manage References'));

    $interface->assign('folder', $folder);

    // Detertmine Selected Folders
    $selectedFolderList = array();
    if (isset($_POST['new_folder_id'])) {
        foreach ($_POST['new_folder_id'] as $folderId) {
            if ($folderId != '') {
                $selectedFolderList[] = Folder::staticGet('id', $folderId);
            }
        }
    } else {
        $selectedFolderList = $folder->getReferences();
    }
    $interface->assign('selectedFolderList', $selectedFolderList);

    // Get the list for a new subject tree
    $topFolderList = array();
    $folder = new Folder();
    $folder->parent_id = 'null';
    $folder->find();
    while ($folder->fetch()) {
        $topFolderList[] = clone($folder);
    }
    $interface->assign('topFolderList', $topFolderList);

    $interface->setTemplate('folder-references.tpl');
}


function handleReferences(&$interface)
{
    $folder = new Folder();
    $folder->id = $_POST['id'];

    $folder->removeReferences();
    foreach ($_POST['new_folder_id'] as $id) {
        if ($id != '') {
            $ref = new Folder();
            $ref->id = $id;
            $folder->addReference($ref);
        }
    }

    $interface->assign('message', 'References Set');

    showReferences($interface);
}

// Display page
$interface->display('layout-admin.tpl');

function printCheckbox($params)
{
    extract($params);
    return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
}

function printTitle($params)
{
    global $langVar;

    extract($params);
    return '<a href="tree.php?id=' . $record['id'] . '">' . $record[$langVar] . '</a>';
}

function printEdit($params)
{
    extract($params);
    return '<a href="tree.php?action=showForm&id=' . $record['id'] . '">Edit</a>';
}

function printMove($params)
{
    global $langVar;

    extract($params);
    return '<a href="tree.php?action=showMove&id=' . $record['id'] . '">Move</a>';
}

function printRefs($params)
{
    global $langVar;

    extract($params);
    return '<a href="tree.php?action=showReferences&id=' . $record['id'] . '">Manage</a>';
}


?>
