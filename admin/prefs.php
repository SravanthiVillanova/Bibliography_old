<?php
// Process Action
$action = getRequest('action');
if (!is_callable($action)) {
    $action = "showForm";
}
$interface->assign('action', $action);
call_user_func_array($action, array(&$interface));

// Display page
$interface->display('layout-admin.tpl');

function showForm(&$interface)
{
    $interface->setTrail(array('Home' => 'index.php', 'My Preferences' => 'prefs.php', 'Change Password'));
        
    $interface->setTemplate('prefs-form.tpl');
}

function handleForm(&$interface)
{
    global $user;

    if ($_POST['password'] == $_POST['password2']) {
        $user->password = md5($_POST['password']);
        $result = $user->update();
    } else {
        $result = new PEAR_Error('Passwords do not match, please try again');
    }
    
    if (PEAR::isError($result)) {
        $interface->assign('message', '<p class="error">Error: ' . $result->getMessage() . '</p>');
    } else {
        $interface->assign('message', '<p class="sucess">Password Changed</p>');
    }    
    
    showForm($interface);
}

?>
