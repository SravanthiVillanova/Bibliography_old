<?php
require_once('classes/Workattribute.php');
require_once('classes/Agent.php');
require_once('classes/Publisher.php');
require_once('classes/Publisher_location.php');

// Process Action
$action = getRequest('action');
if (!is_callable($action)) {
    $action = "showList";
}
$interface->assign('action', $action);
call_user_func_array($action, array(&$interface));

function showList(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'Works'));

    // Show Letters
    $work = new Work();
    $letterWhere = isset($_GET['noFolder']) ? 'WHERE id NOT IN (SELECT DISTINCT work_id FROM work_folder)' : '';
    $work->query("SELECT DISTINCT upper(substring(title, 1, 1)) AS letter FROM work $letterWhere ORDER BY title");
    if ($work->N) {
        while ($work->fetch()) {
            $letterList[] = $work->letter;
        }
    }
    $interface->assign('letterList', $letterList);

    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $min = ($page-1)*20;
    $max = ($page*20)-1;
    $dg = new DataGrid(20, $page);

    // Get List of Works
    $work = new Work();
    if (isset($_GET['status'])) {
        $where = "WHERE work.status='" . $_GET['status'] . "'";
    }
    if (isset($_GET['letter'])) {
        $where = "WHERE upper(substring(work.title, 1, 1)) = '" . addslashes($_GET['letter']) . "'";
    }
    if (isset($_GET['title'])) {
        $where = "WHERE upper(work.title) LIKE '" . addslashes(mb_strtoupper($_GET['title'], 'UTF-8')) . "%'";
    }
    if (isset($_GET['orderBy'])) {
        $order .= "ORDER BY " . $_GET['orderBy'] . " " . $_GET['direction'];
    }
    if (isset($_GET['noFolder'])) {
        if (isset($where)) {
            $where .= ' AND ';
        } else {
            $where = 'WHERE ';
        }
        $where .= 'work.id NOT IN (SELECT DISTINCT work_id FROM work_folder)';
    }
    $sql = "SELECT `work`.*, worktype.type FROM `work` LEFT OUTER JOIN worktype ON `work`.type_id = worktype.id $where $order LIMIT $min, 20";
    $work->query($sql);
    $dg->bind($work);

    // Set DataGrid Columns
    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '30'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Title', 'title', 'title', array('nowrap' => 'true'), null, 'printTitle()'));
    $dg->addColumn(new Structures_DataGrid_Column('Type', 'type', 'type', array('width' => '90', 'align' => 'center')));
    $dg->addColumn(new Structures_DataGrid_Column('Status', 'status', 'status', array('width' => '60', 'align' => 'center'), null, 'printStatus()'));
    $dg->addColumn(new Structures_DataGrid_Column('Created', 'create_date', 'create_date', array('align' => 'center', 'nowrap' => 'true'), null, 'printDate', array('value' => 'create')));
    $dg->addColumn(new Structures_DataGrid_Column('Modified', 'modify_date', 'modify_date', array('align' => 'center', 'nowrap' => 'true'), null, 'printDate', array('value' => 'modify')));

    $interface->assign('dg', $dg->getOutput());

    $work = new Work();
    $sqlCnt = "SELECT count(*) AS cnt FROM `work` LEFT OUTER JOIN worktype ON `work`.type_id = worktype.id $where";
    $work->query($sqlCnt);
    $work->fetch();
    $options = array('mode' => 'sliding',
                     'delta' => 5,
                     'separator' => '|',
                     'prevImg' => '<<',
                     'nextImg' => '>>',
                     'currentPage' => $page,
                     'totalItems' => $work->cnt);
    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER, array('pagerOptions' => $options));
    $interface->assign('paging', $paging);

    $interface->assign('recordStart', $min+1);
    $interface->assign('recordEnd', $max+1);
    $interface->assign('recordCount', $work->cnt);
    $interface->assign('noFolder', isset($_GET['noFolder']));

    $interface->setTemplate('work-list.tpl');
}

function showSearch(&$interface)
{
    $interface->setTemplate('work-find.tpl');
}

function showDelete(&$interface)
{
    $workList = array();
    foreach ($_POST['id'] as $id) {
        $workList[] = Work::staticGet('id', $id);
    }
    $interface->assign('workList', $workList);

    $interface->setTemplate('work-delete.tpl');
}

function handleDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $work = new Work();
            $work->id = $id;

            $sql = "DELETE FROM work_agent WHERE work_id = '$id'";
            $work->query($sql);

            $sql = "DELETE FROM work_folder WHERE work_id = '$id'";
            $work->query($sql);

            $sql = "DELETE FROM work_workattribute WHERE work_id = '$id'";
            $work->query($sql);

            $work->delete();
        }
        $interface->assign('message', 'Works deleted');
    } else {
        $interface->assign('message', 'No Works selected for deletion');
    }

    $_GET['action'] = 'showList';
    showList($interface);
}

function showSummary(&$interface)
{
    $work = Work::staticGet('id', $_GET['id']);
    $interface->setTrail(array('Home' => 'index.php', 'Works' => 'work.php', 'Review Work'));

    $interface->assign('work', $work);

    // Get Parent Work
    if ($work->work_id != '') {
        $parent = Work::staticGet('id', $work->work_id);
        $interface->assign('parent', $parent);
    }

    // Get Publishers
    $publishList = $work->getPublishers();
    $interface->assign('publishList', $publishList);

    // Get tree branch list
    $_COOKIE['language'] = 'fr';
    $branchList = $work->getBranchStrings(null, null, false);
    $interface->assign('branchList', $branchList);

    // Get Work Type
    $type = $work->getWorkType();
    $interface->assign('worktype', $type);

    $interface->setTemplate('work-summary.tpl');
}

function showForm(&$interface)
{
    global $user;

    // View
    $view = (isset($_POST['view'])) ? $_POST['view'] : $_GET['view'];
    $view = ($view != '') ? $view : 'general';

    // Fetch work specified by query string
    if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
        $work = Work::staticGet('id', $_POST['id']);
        $interface->setTrail(array('Home' => 'index.php', 'Works' => 'work.php', 'Edit Work'));
    } elseif (isset($_GET['id'])) {
        $work = Work::staticGet('id', $_GET['id']);
        $interface->setTrail(array('Home' => 'index.php', 'Works' => 'work.php', 'Add Work'));
    } else {
        $work = new Work();
        $work->publish_date = '--';
        $interface->setTrail(array('Home' => 'index.php', 'Works' => 'work.php', 'Add Work'));
    }

    // Security Check
    if (($work->status == '1') && (!$user->hasAccess('0'))) {
        PEAR::raiseError(new PEAR_Error('This work has been completed, you do not have access to edit this.'));
    }

    // Populate work data
    if (isset($_POST['searchBtn']) || isset($_GET['record'])) {
        // Data from Z39.50 Search
        $work->create_date = date('Y-m-d H:i:s');
        $work->create_user_id = $user->id;
        $work->insert();
        if (is_array($_GET['record'])) {
            $work->populate($_GET['record']);
        } else {
            $work->populate(unserialize(urldecode($_GET['record'])));
        }
        $work->update();

        if (PEAR::isError($result)) {
            $interface->assign('message', $result->getMessage());
        }
    } elseif (isset($_POST['id'])) {
        // Data From Web
        if (($_POST['id'] != '') || ($_POST['title'] != '')) {
            $work = _processWorkForm($interface);
        }
    }

    $interface->assign('work', $work);

    // Remove From Folders
    if (isset($_POST['removeFolderBtn'])) {
        foreach ($_POST['removeFolder'] as $folderId) {
            if ($key = array_search($folderId, $_POST['new_folder_id'])) {
                unset($_POST['new_folder_id'][$key]);
            }
            $folder = new Folder();
            $folder->id = $folderId;
            $folder->removeWork($work);
        }
    }

    // Remove Agents
    if (isset($_POST['removeAgentBtn'])) {
        foreach ($_POST['removeAgent'] as $agentId) {
            $work->removeAgent($agentId);
        }
    }

    // Remove Parent Work
    if (isset($_POST['removeParentBtn'])) {
        $work->dropParent();
    }

    // Remove Citation Option Value
    if (isset($_POST['removeOptionBtn'])) {
        $attribute = new Workattribute();
        $attribute->id = $_POST['attribute_id'];
        $work->dropAttributeValue($attribute);
    }

    // Retrieve Data to Display
    switch ($view) {
        case 'agent':
            $type = new Agenttype();
            $type->find();
            while ($type->fetch()) {
                $agentTypeList[$type->id] = $type->type;
            }
            $interface->assign('agentTypeList', $agentTypeList);
            break;
        case 'publisher':
            $pub = new Publisher();
            $publishList = $work->getPublishers();
            $interface->assign('publishList', $publishList);
            break;
        case 'category':
            $interface->assign('langVar', 'text_fr');

            // Retrieve All Folders
            $folderList = array();
            if (isset($_POST['folder_id']) && ($_POST['folder_id'] != '')) {
                foreach ($_POST['folder_id'] as $parentId => $folderId) {
                    if ($folderId != '') {
                        $folder = Folder::staticGet('id', $folderId);
                        $folderList = array($folder);
                        $folderList = array_merge($folderList, $folder->getChildren());
                        if (!count($folderList)) {
                            $folderList = array($folder);
                        }
                    }
                }
            } else {
                $folder = new Folder();
                $folder->parent_id = 'null';
                $folder->find();
                while ($folder->fetch()) {
                    $folderList[] = clone($folder);
                }
            }
            $interface->assign('folderList', $folderList);

            // Detertmine Selected Folders
            $selectedFolderList = array();
            if (isset($_POST['new_folder_id'])) {
                foreach ($_POST['new_folder_id'] as $folderId) {
                    if ($folderId != '') {
                        $selectedFolderList[] = Folder::staticGet('id', $folderId);
                    }
                }
            } else {
                $selectedFolderList = $work->getFolders();
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

            break;
        case 'citation':
            if (($work->type_id) && ($work->type_id != 'null')) {
                $type = $work->getWorkType();
            } else {
                $type = new Worktype();
            }
            $interface->assign('worktype', $type);
            break;
        case 'general':
            if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
                $interface->assign('isIE', true);
            } else {
                $interface->assign('isIE', false);
            }

            // Get All Types
            $type = new Worktype();
            if ($type->find()) {
                while ($type->fetch()) {
                    $typeList[] = clone($type);
                }
            }
            $interface->assign('typeList', $typeList);

            if ($work->work_id != '') {
                $parent = Work::staticGet('id', $work->work_id);
                $interface->assign('parent', $parent);
            }

            break;
    }

    $interface->setTemplate("work-form-$view.tpl");
}

function handleForm(&$interface)
{
    global $user;

    _processWorkForm($interface);
    $interface->assign('message', 'Work data saved');

    $_GET['action'] = 'showList';
    showList($interface);
}

function _processWorkForm(&$interface)
{
    global $user;

    if ($_POST['id'] != '') {
        $work = Work::staticGet('id', $_POST['id']);
    } else {
        $work = new Work();
        $work->id = $_POST['id'];
    }

    switch ($_POST['tab']) {
        case 'general':
            $work->title = $_POST['title'];
            $work->subtitle = $_POST['subtitle'];
            $work->paralleltitle = $_POST['ptitle'];
            $work->description = $_POST['description'];
            $work->type_id = ($_POST['type']) ? $_POST['type'] : 'null';
            $work->work_id = ($_POST['work_id']) ? $_POST['work_id'] : 'null';
            $work->status = ($_POST['status'] === '') ? 'null' : $_POST['status'];
            if ($work->id == '') {
                $work->create_date = date('Y-m-d H:i:s');
                $work->create_user_id = $user->id;
                $work->insert();
            } else {
                $work->modify_date = date('Y-m-d H:i:s');
                $work->modify_user_id = $user->id;
                $work->update();
            }
            break;
        case 'category':
            $work->dropAllFolders();
            if (count($_POST['new_folder_id'])) {
                foreach ($_POST['new_folder_id'] as $folderId) {
                    if ($folderId != '') {
                        $folder = new Folder();
                        $folder->id  = $folderId;
                        $folder->addWork($work);
                    }
                }
                $work->modify_date = date('Y-m-d H:i:s');
                $work->modify_user_id = $user->id;
                $work->update();
            }
            break;
        case 'publisher':
            $work->dropPublishers();

            // Define Publishings
            $i = 1;
            foreach ($_POST['publish'] as $publish) {
                if (!$_POST['removePub'][$i]) {
                    $publisher = new Publisher();
                    $location = new Publisher_location();
                    if ($publish['name'] != '') {
                        $publisher = new Publisher();
                        $publisher->name = $publish['name'];
                        if ($publisher->find()) {
                            $publisher->fetch();
                        } else {
                            $publisher->insert();
                        }
                        if ($publish['location'] != '') {
                            $location->publisher_id = $publisher->id;
                            $location->location = $publish['location'];
                            if ($location->find()) {
                                $location->fetch();
                            } else {
                                $location->insert();
                            }
                        }
                    }

                    $work->setPublisher($publisher, $location, $publish['start'], $publish['end']);
                }
                $i++;
            }

            $work->modify_date = date('Y-m-d H:i:s');
            $work->modify_user_id = $user->id;
            $work->update();

            break;
        case 'agent':
            $work->dropAgents();

            if (count($_POST['agent'])) {
                $errorCnt = 0;
                $actionCnt = 0;
                foreach($_POST['agent'] as $agent) {
                    if ($agent['type'] != '') {
                        $newagent = new Agent();
                        $newagent->fname = $agent['fname'];
                        $newagent->lname = $agent['lname'];
                        if ($newagent->find()) {
                            $newagent->fetch();
                            if (!$work->hasAgent($newagent, $agent['type'])) {
                                $work->addAgent($newagent, $agent['type']);
                                $actionCnt++;
                            }
                        } else {
                            $newagent->alternate_name = $agent['altname'];
                            $newagent->organization_name = $agent['orgname'];
                            $newagent->insert();
                            $work->addAgent($newagent, $agent['type']);
                            $actionCnt++;
                        }
                    } elseif (($agent['fname'] != '') || ($agent['lname'] != '')) {
                        $errorCnt++;
                    }
                }
            }
            if ($actionCnt) {
                $work->modify_date = date('Y-m-d H:i:s');
                $work->modify_user_id = $user->id;
                $work->update();
            }
            if ($errorCnt) {
                $interface->assign('message', '<p class="error">Some Agents were not saved due to missing Agent Type</p>');
            }
            break;
        case 'citation':
            require_once 'classes/Workattribute_option.php';

            $work->deleteAttributeValues();

            $actionCnt = 0;
            foreach ($_POST['field'] as $fieldId => $value) {
                if ($_POST['option'][$fieldId] != '') {
                    $attribute = Workattribute::staticGet('id', $fieldId);
                    $option = Workattribute_option::staticGet('id', $_POST['option'][$fieldId]);
                    $work->addAttributeValue($attribute, $option->title);
                    $actionCnt++;
                } else {
                    if ($value != '')  {
                        if (is_array($value) && ($value[0] != '' || $value[1] != '')) {
                            $option = new Workattribute_option();
                            $option->title = $value[0];
                            $option->workattribute_id = $fieldId;
                            $option->insert();
                            $attribute = Workattribute::staticGet('id', $fieldId);
                            $work->addAttributeValue($attribute, $option->title);
                            $actionCnt++;
                        } elseif (!is_array($value) && $value != '') {
                            $attribute = Workattribute::staticGet('id', $fieldId);
                            $work->addAttributeValue($attribute, $value);
                            $actionCnt++;
                        }
                    }
                }
            }

            if ($actionCnt) {
                $work->modify_date = date('Y-m-d H:i:s');
                $work->modify_user_id = $user->id;
                $work->update();
            }
            break;
    }

    return $work;
}

function showAgentLookup(&$interface)
{
    $interface->display('agent-lookup.tpl');
    exit();
}

function handleAgentLookup(&$interface)
{
    $agent = new Agent();
    if ($_POST['fname'] != '') {
        $agent->whereAdd("UPPER(fname) LIKE '" . $agent->escape(mb_strtoupper(str_replace('*', '%', $_POST['fname']), 'UTF-8')) . "'");
    }
    if ($_POST['lname'] != '') {
        $agent->whereAdd("UPPER(lname) LIKE '" . $agent->escape(mb_strtoupper(str_replace('*', '%', $_POST['lname']), 'UTF-8')) . "'");
    }
    if ($_POST['altname'] != '') {
        $agent->whereAdd("UPPER(alternate_name) LIKE '" . $agent->escape(mb_strtoupper(str_replace('*', '%', $_POST['altname']), 'UTF-8')) . "'");
    }
    if ($_POST['orgname'] != '') {
        $agent->whereAdd("UPPER(organization_name) LIKE '" . $agent->escape(mb_strtoupper(str_replace('*', '%', $_POST['orgname']), 'UTF-8')) . "'");
    }

    $dg = new DataGrid();
    $dg->bind($agent);

    $dg->addColumn(new Structures_DataGrid_Column('Name', 'lname', 'lname', null, null, 'printName()'));
    $dg->addColumn(new Structures_DataGrid_Column('Alternate Name', 'alternate_name', 'alternate_name'));
    $dg->addColumn(new Structures_DataGrid_Column('Organization Name', 'organization_name', 'organization_name'));

    $dghtml = $dg->getOutput();
    $interface->assign('dghtml', $dghtml);

    showAgentLookup($interface);
}

function showPublisherLookup(&$interface)
{
    $interface->display('publisher-lookup.tpl');
    exit();
}

function handlePublisherLookup(&$interface)
{
    $publisher = new Publisher();
    $sql = "SELECT publisher.*, publisher_location.location FROM publisher LEFT OUTER JOIN publisher_location ON publisher_location.publisher_id = publisher.id";
    if ($_POST['name'] != '') {
        $sql .= " WHERE UPPER(name) LIKE '" . $publisher->escape(mb_strtoupper(str_replace('*', '%', $_POST['name']), 'UTF-8')) . "'";
    }
    $publisher->query($sql);

    $dg = new DataGrid();
    $dg->bind($publisher);

    $dg->addColumn(new Structures_DataGrid_Column('Publisher', 'name', 'name', null, null, 'printPubName()'));
    $dg->addColumn(new Structures_DataGrid_Column('Location', 'location', 'location'));

    $dghtml = $dg->getOutput();
    $interface->assign('dghtml', $dghtml);

    showPublisherLookup($interface);
}


function showLookup(&$interface)
{
    require_once('lib/marc.php');

    global $serverArray;

    // Do not proceed if yaz is not installed.
    if (!is_callable('yaz_connect')) {
        $error = new PEAR_Error('Yaz Toolkit is not installed');
        PEAR::raiseError($error);
    }

    // Search Z39.50 Servers
    $recordList = array();
    $phrase = '@attr 1=4 "' . $_POST['title'] . '"';
    //$phrase = '@attr 1=4 @attr 2=102  "' . $_POST['title'] . '"';
    $hits = 0;
    foreach ($serverArray as $title => $server) {
        $records = zLookup($server['host'], $phrase);
        $recordList[$title] = $records;
        $hits = $hits + count($records);
    }
    $interface->assign('hits', $hits);
    $interface->assign('title', $_POST['title']);
    $interface->assign('recordCollection', $recordList);

    $interface->setTemplate('work-lookup.tpl');
}

// Display page
$interface->display('layout-admin.tpl');

function zLookup($server, $phrase)
{
    $recordList = array();

    // Connect to Z39.50 Gateway
    $conn = yaz_connect($server, array('persistent' => false));
    if ($conn) {
        // Define Results Format
        yaz_syntax($conn, 'MARC');

        // Run Z39.50 Search in RPN notation
        yaz_search($conn, 'rpn', $phrase);
        $error = yaz_error($conn);
        if (empty($error)) {

            // Wait for results to be returned
            yaz_wait();

            // Retrieve record
            $hits = yaz_hits($conn);
            for ($i=1; $i<=$hits; $i++) {
                $record = yaz_record($conn, $i, 'string');

                // Convert record to array
                $recordList[] = Text_Marc::toArray($record);
            }
        }
    }
    yaz_close($conn);

    return $recordList;
}

function showWorkLookup(&$interface)
{
    $interface->display('work-search.tpl');
    exit();
}

function handleWorkLookup(&$interface)
{
    $work = new Work();
    $sql = "SELECT `work`.id, `work`.title, worktype.type FROM `work` LEFT OUTER JOIN worktype ON `work`.type_id = worktype.id " .
           "WHERE UPPER(title) LIKE '%" . $work->escape(mb_strtoupper(str_replace('*', '%', $_GET['title']), 'UTF-8')) . "%'";
    $work->query($sql);
    $dg = new DataGrid();
    $dg->bind($work);

    $dg->addColumn(new Structures_DataGrid_Column('Work', 'title', 'title', null, null, 'printWorkTitle()'));
    $dg->addColumn(new Structures_DataGrid_Column('Type', 'type', 'type'));
    $dg->addColumn(new Structures_DataGrid_Column('Author', null, null, null, null, 'printParentAuthor()'));

    $interface->assign('dghtml', $dg->getOutput());

    showWorkLookup($interface);
}

function printCheckbox($params)
{
    global $user;
    extract($params);

    if (($record['status'] == '1') && (!$user->hasAccess('0'))) {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '" DISABLED>';
    } else {
        return '<input type="checkbox" name="id[]" value="' . $record['id'] . '">';
    }
}

function printTitle($params)
{
    global $user;
    extract($params);

    if (strlen($record['title']) > 100) {
        $title = mb_substr($record['title'], 0, 100, 'UTF-8') . '...';
    } else {
        $title = $record['title'];
    }

    if ($record['status'] == '1') {
        if ($user->hasAccess('0')) {
            return '<a href="work.php?action=showForm&id=' . $record['id'] . '">' . $title . '</a>';
        } else {
            return '<a href="work.php?action=showSummary&id=' . $record['id'] . '">' . $title . '</a>';
        }
    } else {
        return '<a href="work.php?action=showForm&id=' . $record['id'] . '">' . $title . '</a>';
    }
}

function printName($params)
{
    extract($params);
    return '<a href="work.php" onClick="' .
           'window.opener.document.workForm.elements[\'agent[' . $_GET['row'] . '][fname]\'].value=\'' . addslashes($record['fname']) . '\'; ' .
           'window.opener.document.workForm.elements[\'agent[' . $_GET['row'] . '][lname]\'].value=\'' . addslashes($record['lname']) . '\'; ' .
           'window.opener.document.workForm.elements[\'agent[' . $_GET['row'] . '][altname]\'].value=\'' . addslashes($record['alternate_name']) . '\'; ' .
           'window.opener.document.workForm.elements[\'agent[' . $_GET['row'] . '][orgname]\'].value=\'' . addslashes($record['organization_name']) . '\'; ' .
           'window.close(); return false;">' . $record['fname']  . ' ' . $record['lname'] . '</a>';
}

function printPubName($params)
{
    extract($params);
    return '<a href="work.php" onClick="' .
           'window.opener.document.workForm.elements[\'publish[' . $_GET['row'] . '][name]\'].value=\'' . addslashes($record['name']) . '\'; ' .
           'window.opener.document.workForm.elements[\'publish[' . $_GET['row'] . '][location]\'].value=\'' . addslashes($record['location']) . '\'; ' .
           'window.close(); return false;">' . $record['name'] . '</a>';
}

function printWorkTitle($params)
{
    extract($params);
    return '<a href="work.php" onClick="' .
           'window.opener.document.workForm.elements[\'work_id\'].value=\'' . $record['id'] . '\'; ' .
           'window.opener.document.workForm.submit(); ' .
           'window.close(); return false;">' . $record['title'] . '</a>';
}

function printStatus($params)
{
    extract($params);
    if ($record['status'] == "1") {
        return '<img src="images/active.gif" alt="Active" title="Active">';
    } elseif ($record['status'] == "0" || $record['status'] == "2") {
        return '<img src="images/review.gif" alt="Needs Review" title="Needs Review">';
    } else {
        return '<img src="images/inactive.gif" alt="Inactive" title="Inactive">';
    }
}

function printDate($params, $args=array())
{
    extract($params);
    extract($args);

    if ($record[$value . '_user_id']) {
        $user = User::staticGet('id', $record[$value . '_user_id']);
        if (date('M j, y', strtotime($record[$value . '_date'])) == date('M j, y')) {
            return $user->username . ' ' . date('g:ia', strtotime($record[$value . '_date']));
        } else {
            return $user->username . ' ' . date('M j, y', strtotime($record[$value . '_date']));
        }
    } else {
        return ' ----- ';
    }
}

function printParentAuthor($params)
{
    extract($params);
    $work = new Work();
    $work->id = $record['id'];
    if ($agentList = $work->getAgents('Author')) {
        $firstAuthor = $agentList[0];
        return "$firstAuthor->lname, $firstAuthor->fname";
    } else {
        return null;
    }
}

?>
