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
    $interface->setTrail(array('Home' => 'index.php', 'System Users'));
        
    $dg = new DataGrid(20);
    
    $user = new User();
    $dg->bind($user);

    $dg->addColumn(new Structures_DataGrid_Column(null, null, null, array('width' => '10'), null, 'printCheckbox()'));
    $dg->addColumn(new Structures_DataGrid_Column('Name', 'name', 'name', null, null, 'printLink()'));
    $dg->addColumn(new Structures_DataGrid_Column('Access Level', 'level', 'level', array('width' => '10%'), null, 'printLevel()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $paging = $dg->getOutput(DATAGRID_RENDER_PAGER);
    $interface->assign('paging', $paging);
        
    $interface->setTemplate('user-list.tpl');
}

function handleList(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        showDelete($interface);
    } else {
        foreach ($_POST['level'] as $id => $level) {
            $user = new User();
            $user->id = $id;
            $user->level = $level;
            $user->update();
        }
        $interface->assign('message', 'Access Levels Saved');
        
        $_GET['action'] = 'showList';
        showList($interface);
    }
}

function showDelete(&$interface)
{
    $userList = array();
    foreach ($_POST['id'] as $id) {
        $userList[] = User::staticGet('id', $id);
    }
    $interface->assign('userList', $userList);
    
    $interface->setTemplate('user-delete.tpl');
}

function handleDelete(&$interface)
{
    if ($_POST['submit'] == 'Delete') {
        foreach ($_POST['id'] as $id) {
            $user = new User();
            $user->id = $id;
            $user->delete();
        }
        $interface->assign('message', 'Users Deleted');
    } else {
        $interface->assign('message', 'Delete Canceled');
    }
    
    $_GET['action'] = 'showList';
    showList($interface);
}

function showForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'System Users' => 'users.php', 'Edit User'));
        
    // Fetch work specified by query string
    if (isset($_GET['id'])) {
        $edituser = User::staticGet('id', $_GET['id']);
        $interface->assign('edituser', $edituser);
        $interface->setTemplate('user-form-edit.tpl');
    } else {
        $interface->setTemplate('user-form.tpl');
    }
   
}

function handleForm(&$interface)
{
    $user = new User();
    $user->name = $_POST['fname'];
    $user->username = $_POST['username'];
    $user->level = ($_POST['level'] != '') ? $_POST['level'] : 'null';
    if ($_POST['password'] != '' && ($_POST['password'] == $_POST['password2'])) {
        $user->password = md5($_POST['password']);
    } elseif ($_POST['password'] != '') {
        $result = new PEAR_Error('Passwords do not match');
    }
        
    if ($_POST['id'] != '') {
        $user->id = $_POST['id'];
        $result = $user->update();
    } else {
        $result = $user->insert();
    }

    if (PEAR::isError($result)) {
        $interface->assign('message', 'Error: ' . $result->getMessage());
        showForm($interface);
    } else {
        $interface->assign('message', 'System User Information Saved');
        $_GET['action'] = 'showList';
        showList($interface);    
    }
}

function showAccess(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'System Users' => 'users.php', 'User Access'));
        
    $dg = new DataGrid(20);
    $data = array(array('Title' => 'Administrator', 'Level' => 1),
                  array('Title' => 'Super User', 'Level' => 0),
                  array('Title' => 'User', 'Level' => null));
    $dg->bind($data);    

    $dg->addColumn(new Structures_DataGrid_Column('Title', 'Title', 'Title'));
    $dg->addColumn(new Structures_DataGrid_Column('Access', null, null, null, null, 'printAccess()'));

    $dghtml = $dg->getOutput();
    $interface->assign('dg', $dghtml);

    $interface->setTemplate('user-access.tpl');
}

function handleAccess(&$interface)
{
    require_once 'XML/Serializer.php';
    
    global $menuList;
    
    $newMenuList = array();
    foreach($menuList as $menu) {
        if (isset($_POST['access'][$menu['Title']]['User'])) {
            $menu['AccessLevel'] = null;
        } elseif (isset($_POST['access'][$menu['Title']]['Super User'])) {
            $menu['AccessLevel'] = 0;
        } else {
            $menu['AccessLevel'] = 1;
        }
        $newMenuList[] = $menu;
    }

    // Create XML
    $serializer = new XML_Serializer();
    $serializer->serialize($newMenuList, array('indent' => '  ', 'rootName' => 'MenuItem', 'mode' => 'simplexml'));
    $xml = $serializer->getSerializedData();
    $xml = "<Menu>\n$xml\n</Menu>";
    
    // Write XML to File
    $fp = fopen('menu.xml', 'w');
    fwrite($fp, $xml);
    fclose($fp);
    
    $_GET['action'] = 'showAccess';
    showAccess($interface);
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
    return '<a href="users.php?action=showForm&id=' . $record['id'] . '">' . $record['name'] . '</a>';
}

function printLevel($params)
{
    extract($params);

    $html = "<select name=\"level[" . $record['id'] . "]\">\n" . 
            "<option value=\"1\">Administrator</option>\n";
    if ($record['level'] === '0') {
        $html .= "<option value=\"0\" selected>Super User</option>\n";
    } else {
        $html .= "<option value=\"0\">Super User</option>\n";
    }
    if ($record['level'] == '') {
        $html .= "<option value=\"null\" selected>User</option>\n";
    } else {
        $html .= "<option value=\"null\">User</option>\n";
    }
    $html .= '</select>';
    return $html;
}

function printAccess($params)
{
    extract($params);

    // Fetch Menu
    $unserializer = new XML_Unserializer(array('parseAttributes' => true, 'contentName' => 'title'));
    $unserializer->unserialize('menu.xml', true);
    $menuList = $unserializer->getUnserializedData();
    $menuList = $menuList['MenuItem'];
        
    $str = '<table><tr align="center">';
    foreach ($menuList as $menu) {
        if ($record['Title'] == 'Administrator') {
            $str .= '<td>' . $menu['Title'] . '<br><input type="checkbox" name="access[' . $menu['Title'] . '][' . $record['Title'] . ']" value="1" checked disabled></td>';
        } elseif ($menu['AccessLevel'] <= $record['Level']) {
            $str .= '<td>' . $menu['Title'] . '<br><input type="checkbox" name="access[' . $menu['Title'] . '][' . $record['Title'] . ']" value="1" checked></td>';
        } else {
            $str .= '<td>' . $menu['Title'] . '<br><input type="checkbox" name="access[' . $menu['Title'] . '][' . $record['Title'] . ']" value="1"></td>';
        }
    }
    $str .= '</table>';
    
    return $str;
}

?>
