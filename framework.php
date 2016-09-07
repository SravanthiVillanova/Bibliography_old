<?php
//error_reporting(E_ALL);
//ini_set('display_errors', true);
//DIE("Hello World");
// Require PHP Libraries
require_once('PEAR.php');
require_once('DB.php');
require_once('Smarty/Smarty.class.php');
require_once('Structures/DataGrid.php');

// Smarty Extension class
class UInterface extends Smarty
{
    function UInterface()
    {
        global $configArray;
        global $translator;
        global $language;

        $this->template_dir  = $configArray['Interface']['template'];
        $this->compile_dir   = $configArray['Interface']['compile'];
        $this->cache_dir     = $configArray['Interface']['cache'];
        $this->caching       = false;
        $this->debug         = true;
        $this->compile_check = true;
        
        $this->assign('translator', $translator);
        $this->assign('language', $language);
        $this->assign('langVar', 'text_'. $language);
        
        $worktype = new Worktype();
        $worktype->find();
        while ($worktype->fetch()) {
            $worktypeList[] = clone($worktype);
        }
        $this->assign('worktypeList', $worktypeList);
        
        $this->register_function('html_format', 'html_format');
    }

    function setTemplate($tpl)
    {
        $this->assign('pageTemplate', $tpl);
    }
    
    function setTrail($trail)
    {
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

// Require Panta Rhei Classes
require_once('lib/translator.php');
require_once('lib/database.php');
require_once('classes/Work.php');
require_once('classes/Worktype.php');
require_once('classes/Folder.php');
require_once('classes/User.php');

// Sets global error handler for PEAR errors
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handleError');

// Retrieve values from configuration file
$configArray = parse_ini_file('config/config.ini', true);

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
$translator->load('./translations');

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
    return isset($_POST[$var]) ? $_POST[$var]: $_GET[$var];
}

// Process any errors that are thrown
function handleError($error, $method = null)
{
	VAR_DUMP($error);
	DIE("Hello");
    $interface = new UInterface();
    $interface->assign('error', $error);
    $interface->display('error.tpl');
   
    exit();
}



// Datagrid Extension Class
class DataGrid extends Structures_DataGrid {
    function DataGrid($limit = null, $page = 1, $renderer = DATAGRID_RENDERER_TABLE)
    {
        Structures_DataGrid::Structures_DataGrid($limit, $page, $renderer);

        // Define DataGrid Color Attributes
        $this->renderer->setTableHeaderAttributes(array('bgcolor' => '#DDDDDD'));
        $this->renderer->setTableEvenRowAttributes(array('bgcolor' => '#F9F9F9'));
        $this->renderer->setTableOddRowAttributes(array('bgcolor' => '#EEEEEE'));

        // Define DataGrid Table Attributes
        //$this->renderer->setTableAttribute('width', '100%');
        $this->renderer->setTableAttribute('cellspacing', '1');
        $this->renderer->setTableAttribute('cellpadding', '4');
        $this->renderer->setTableAttribute('class', 'datagrid');
    }
}

function html_format($params)
{
    return htmlspecialchars($params['text']);
}

?>
