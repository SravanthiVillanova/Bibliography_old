<?php
/**
 * Table Definition for agent_agenttype
 */
require_once 'DB/DataObject.php';

class Agent_agenttype extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'agent_agenttype';                 // table name
    var $agent_id;                        // int(11)  not_null primary_key
    var $agenttype_id;                    // int(11)  not_null primary_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Agent_agenttype',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
