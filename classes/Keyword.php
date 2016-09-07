<?php
/**
 * Table Definition for keyword
 */
require_once 'DB/DataObject.php';

class Keyword extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'keyword';                         // table name
    var $id;                              // int(11)  not_null primary_key
    var $keyword;                         // string(80)  not_null unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Keyword',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
