<?php
// Require PHP Libraries
require_once('PEAR.php');
require_once('DB.php');
require_once('Smarty/Smarty.class.php');
require_once('Structures/DataGrid.php');
require_once('XML/Unserializer.php');

// Smarty Extension class
class UInterface extends Smarty
{
    function UInterface()
    {
        global $configArray;
        global $user;
        global $translator;
        global $language;
        global $instructions;
        global $menuList;

        $this->template_dir  = $configArray['Interface']['template'];
        $this->compile_dir   = $configArray['Interface']['compile'];
        $this->cache_dir     = $configArray['Interface']['cache'];
        $this->caching       = false;
        $this->debug         = true;
        $this->compile_check = true;
        
        // Assing Global Items
        $this->assign('user', $user);
        $this->assign('translator', $translator);
        $this->assign('language', $language);
        $this->assign('langVar', 'text_' . $language);
        $this->assign('instructions', $instructions);
        $this->assign('menuList', $menuList);
        $this->assign('currentPage', basename($_SERVER['PHP_SELF']));
        
        // Assign Work Types
        $worktype = new Worktype();
        $worktype->find();
        while ($worktype->fetch()) {
            $worktypeList[] = $worktype;
        }
        $this->assign('worktypeList', $worktypeList);
        
        // Register Functions
        $this->register_function('toString', 'toString');
        $this->register_function('html_format', 'html_format');
        $this->register_function('printPre', 'printPre');
        $this->register_function('removeSlashes', 'removeSlashes');
    }

    function setTemplate($tpl)
    {
        $this->assign('pageTemplate', $tpl);
    }
    
    function setTrail($trail)
    {
        $str = '';
        foreach($trail as $crumb => $url) {
            if (is_int($crumb)) {
                $str .= $url;
            } else {            
                $str .= "<a href=\"$url\">$crumb</a> &gt; ";
            }
        }
        
        $this->assign('breadcrumb', $str);
    }
}

// Datagrid Extension Class
class DataGrid extends Structures_DataGrid {
    function __construct($limit = null, $page=null)
    {
        Structures_DataGrid::Structures_DataGrid($limit, $page);

        // Define DataGrid Color Attributes
        $this->renderer->setTableHeaderAttributes(array('bgcolor' => '#DDDDDD'));
        $this->renderer->setTableEvenRowAttributes(array('bgcolor' => '#F9F9F9'));
        $this->renderer->setTableOddRowAttributes(array('bgcolor' => '#EEEEEE'));

        // Define DataGrid Table Attributes
        $this->renderer->setTableAttribute('cellspacing', '1');
        $this->renderer->setTableAttribute('cellpadding', '4');
        $this->renderer->setTableAttribute('width', '100%');
        $this->renderer->setTableAttribute('class', 'datagrid');
        
        $this->renderer->sortIconASC = '&uarr;';
        $this->renderer->sortIconDESC = '&darr;';
        
        //$this->renderer->removeExtraVars(array('action'));
    }
}

// Require Panta Rhei Classes
require_once('lib/translator.php');
require_once('lib/database.php');
require_once('classes/User.php');
require_once('classes/Work.php');
require_once('classes/Worktype.php');
require_once('classes/Folder.php');
require_once('classes/User.php');

// Page Instructions Content
include_once('instructions.inc');

// Start up the session and make sure it only lasts an hour:
session_name('PANTARHEISESSID');
session_set_cookie_params(60 * 60, '/');
session_start();

// Sets global error handler for PEAR errors
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handleError');

// Retrieve values from configuration file
$configArray = parse_ini_file('../config/config.ini', true);
$serverArray = parse_ini_file('../config/server.ini', true);

ini_set('memory_limit', '20M');
ini_set('max_execution_time', 120);

// Configures DB_DataObject library
establishDBConnection($configArray['DB_DataObject'], 'utf8');

// Retrieve Language Setting
if (isset($_POST['language'])) {
    $_COOKIE['language'] = $language = $_POST['language'];
    setcookie('language', $language);
} else {
    if (!isset($_COOKIE['language'])) {
        $_COOKIE['language'] = 'fr';
    }
    $language = $_COOKIE['language'];
}
$translator = new I18N_Translator($language);
$translator->load('../translations');

// Build Menu Array
$unserializer = new XML_Unserializer(array('parseAttributes' => true, 'contentName' => 'title'));
$unserializer->unserialize('menu.xml', true);
$menuList = $unserializer->getUnserializedData();
$menuList = $menuList['MenuItem'];
unset($unserializer);

// Print any variable cleanly
function print_pre($var)
{
    echo '<pre><font color="#990000">';

    if (isset($var)) {
        print_r($var);
    } else {
        echo 'null';
    }

    echo '</font></pre>';
}

function getRequest($var)
{
    if (isset($_POST[$var])) {
        return $_POST[$var];
    } else {
        return $_GET[$var];
    }
}

// Determine authentication
function determineAuth()
{
    global $configArray;

    if (!isset($_SESSION['user_id'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (($username == '') || ($password == '')) {
            showLogin();
        } else {
            $user = new User();
            $user->username = $username;
            $user->password = md5($password);
            if ($user->find(true)) {
                // Set login cookie for 1 hour
                $_SESSION['user_id'] = $user->id;
                return $user;
            } else {
                showLogin('Invalid Login, Please try again.');
            }
        }
    } else {
        // Keep cookie for 1 hour
        $user = User::staticGet('id', $_SESSION['user_id']);
        return $user;
    }
}

// Process Instruction Form
if (isset($_POST['instructions'])) {
    $instructions[basename($_SERVER['PHP_SELF'])][$_POST['action']] = $_POST['instructions'];
    $str = "<?php\n";
    foreach($instructions as $page => $data) {
        foreach ($data as $action => $instruction) {
            $str .= '$instructions[\'' . $page . '\'][\'' . $action . '\'] = "' . addslashes($instruction) . "\";\n";
        }
    }
    $str .= '?>';
    $fp = fopen('instructions.inc', 'w');
    fwrite($fp, $str);
    fclose($fp);
}



// Process any errors that are thrown
function handleError($error, $method = null)
{
    $interface = new UInterface();
    $interface->assign('error', $error);
    $interface->display('error.tpl');
   
    exit();
}

// Display Login Screen
function showLogin($msg = null)
{
    $interface = new UInterface();
    $interface->assign('message', $msg);
    $interface->display('login.tpl');
    exit();
}

function toString($params)
{
    extract($params);
    return urlencode(serialize($array));
}

function html_format($params)
{
    return htmlspecialchars($params['text']);
}

function printPre($params)
{
    return print_pre($params['text']);
}

function removeSlashes($params)
{
    return stripslashes($params['text']);
}


// Check Authentication
$user = determineAuth();

$interface = new UInterface();

?>
