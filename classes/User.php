<?php
/**
 * Table Definition for user
 */
require_once 'DB/DataObject.php';

class User extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'user';                            // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $name;                            // string(100)  not_null
    var $username;                        // string(20)  not_null
    var $password;                        // string(32)  not_null
    var $language;                        // string(2)  not_null
    var $level;                           // int(11)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('User',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function isAdmin()
    {
        if ($this->level) {
           return true;
        } else {
           return false;
        }
    }
    
    function hasAccess($level)
    {
        if ($level === '') {
            return true;
        } else {
            if ($this->level >= $level) {
                return true;
            } else {
                return false;
            }
        }
    }
}
