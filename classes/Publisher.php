<?php
/**
 * Table Definition for publisher
 */
require_once 'DB/DataObject.php';

class Publisher extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'publisher';                       // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $name;                            // string(100)  not_null unique_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Publisher',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function getWorkCount()
    {
        $sql = "SELECT COUNT(*) AS cnt FROM work_publisher WHERE publisher_id = '$this->id'";
        
        $do = new DB_DataObject();
        $do->query($sql);
        $do->fetch();
        return $do->cnt;
    }
        
    function getAllOptions()
    {
        $publisherList = array();
        
        $pub = new Publisher();
        $sql = "SELECT publisher.*, publisher_location.location, publisher_location.id as location_id " . 
               "FROM publisher LEFT JOIN publisher_location ON publisher.id = publisher_location.publisher_id " . 
               "ORDER BY publisher.name";
        $pub->query($sql);
        if ($pub->N) {
            while ($pub->fetch()) {
                $publisherList["$pub->id|$pub->location_id"] = "$pub->name: $pub->location";
            }
        }
        
        return $publisherList;
    }
}