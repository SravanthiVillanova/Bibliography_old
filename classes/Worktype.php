<?php
/**
 * Table Definition for worktype
 */
require_once 'DB/DataObject.php';

class Worktype extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'worktype';                        // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $type;                            // string(200)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Worktype',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getAttributes()
    {
        require_once('Workattribute.php');
        
        $list = array();
        
        $sql = "SELECT workattribute.* FROM workattribute, worktype_workattribute " . 
               "WHERE workattribute.id = worktype_workattribute.workattribute_id AND worktype_workattribute.worktype_id = '$this->id' " . 
               "ORDER BY worktype_workattribute.rank";
        $attribute = new Workattribute();
        $attribute->query($sql);
        if ($attribute->N) {
            while ($attribute->fetch()) {
                $list[] = clone($attribute);
            }
        }
        
        return $list;
    }
}
