<?php
require_once 'DB/DataObject.php';

/**
 * Standard function to establish DB_DataObject connection with correct character encoding.
 */
function establishDBConnection($config, $encoding = 'latin1')
{
    // Set constant if not already present:
    if (!defined('DB_DATAOBJECT_NO_OVERLOAD')) {
        define('DB_DATAOBJECT_NO_OVERLOAD', 0);
    }

    // Set DB_DataObject configuration:
    $options =& PEAR::getStaticProperty('DB_DataObject', 'options');
    $options = $config;

    // Properly initialize character encoding:
    $obj = new DB_DataObject();
    $conn = $obj->getDatabaseConnection();
    $conn->query("SET NAMES " . $encoding);
}
?>