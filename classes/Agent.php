<?php
/**
 * Table Definition for agent
 */
require_once 'DB/DataObject.php';

require_once('classes/Agenttype.php');

class Agent extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'agent';                           // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $fname;                           // string(200)  not_null multiple_key
    var $lname;                           // string(200)  not_null
    var $alternate_name;                  // string(200)  
    var $organization_name;               // string(200)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Agent',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getWorks()
    {
        $workList = array();
        
        $work = new Work();
        $sql = "SELECT work.* FROM work, work_agent WHERE work.id = work_agent.work_id AND work_agent.agent_id = '$this->id'";
        $work->query($sql);
        if ($work->N) {
            while ($work->fetch()) {
                $workList[] = $work;
            }
        }
        
        return $workList;
    }
    
    function getWorkCount()
    {
        $work = new Work();
        $sql = "SELECT COUNT(work.id) as wcnt FROM work, work_agent WHERE work.id = work_agent.work_id AND work_agent.agent_id = '$this->id'";
        $work->query($sql);
        $work->fetch();
        return $work->wcnt;
    }
    
    /*
    function getTypeId($work)
    {
        $do = new DB_DataObject();
        
        $sql = "SELECT agenttype_id FROM work_agent WHERE work_id = '$work->id' AND agent_id = '$this->id'";
        $do->query($sql);
        if ($do->N) {
            $do->fetch();
            $do->agenttype_id;
            return $do->agenttype_id;
        } else {
            return null;
        }
    }
    */
}
?>
