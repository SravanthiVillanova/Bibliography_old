<?php
/**
 * Table Definition for work
 */
require_once 'DB/DataObject.php';

class Work extends DB_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'work';                            // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $work_id;                         // int(11)  multiple_key
    var $type_id;                         // int(11)  multiple_key
    var $language;                        // string(2)  not_null
    var $title;                           // string(255)  not_null
    var $subtitle;                        // string(255)  
    var $paralleltitle;                   // string(200)  
    var $description;                     // blob(65535)  blob
    var $create_date;                     // datetime(19)  not_null binary
    var $create_user_id;                  // int(11)  multiple_key
    var $modify_date;                     // datetime(19)  not_null binary
    var $modify_user_id;                  // int(11)  multiple_key
    var $status;                          // int(4)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('Work',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function addAttributeValue($attribute, $value)
    {
        require_once 'classes/Workattribute_option.php';
        
        // Process Drop-Down Attributes
        if ($attribute->type == 'Select') {
            $option = new Workattribute_option();
            $option->workattribute_id = $attribute->id;
            $option->whereAdd("upper(title) = '" . $option->escape(mb_strtoupper($value, 'UTF-8')) . "'");
            if ($option->find()) {
                $option->fetch();
                $value = $option->id;
            } else {
                $option = new Workattribute_option();
                $option->workattribute_id = $attribute->id;
                $option->title = $value;
                $option->insert();
                $value = $option->id;
            }
        }
        
        $sql = "INSERT INTO work_workattribute (work_id, workattribute_id, value) VALUES('$this->id', '$attribute->id', '" . addslashes($value) . "')";
        return $this->query($sql);
    }    

    function dropAttributeValue($attribute)
    {
        $sql = "DELETE FROM work_workattribute WHERE work_id = '$this->id' AND workattribute_id = '$attribute->id'";
        return $this->query($sql);
    }    
    
    function deleteAttributeValues()
    {
        $sql = "DELETE FROM work_workattribute WHERE work_id = '$this->id'";
        return $this->query($sql);
    }    
        
    function getAttributeValue($attribute)
    {
        require_once('classes/Workattribute.php');
        require_once('classes/Workattribute_option.php');
        
        if (!is_object($attribute)) {
            $attribute = Workattribute::staticGet('field', $attribute);
        }
       
        $do = new DB_DataObject(); 
        $sql = "SELECT value FROM work_workattribute WHERE work_id = '$this->id' AND workattribute_id = '$attribute->id'";
        $do->query($sql);
        $do->fetch();

        if ($attribute->type == 'Select') {
            if (isset($do->value) && $do->value != '') {
                return Workattribute_option::staticGet('id', $do->value);
            } else {
                return new Workattribute_option();
            }
        } else {
            return $do->value;
        }
    }    
    
    function getFolders()
    {
        $folderList = array();
        
        $sql = "SELECT folder.* FROM folder, work_folder WHERE folder.id = work_folder.folder_id AND work_folder.work_id = '$this->id'";
        $folder = new Folder();
        $folder->query($sql);
        if ($folder->N) {
            while ($folder->fetch()) {
                $folderList[] = clone($folder);
            }
        }
        
        return $folderList;
    }
    
    function dropAllFolders()
    {
        $sql = "DELETE FROM work_folder WHERE work_id = '$this->id'";
        $this->query($sql);
    }
    
    function getAgents($type = null, $orderBy = null)
    {
        require_once('classes/Agent.php');
        
        $agentList = array();
        $agent = new Agent();
        $sql = "SELECT agent.*, work_agent.agenttype_id, agenttype.type as agenttype FROM agent, work_agent, agenttype " . 
               "WHERE agent.id = work_agent.agent_id AND work_agent.agenttype_id = agenttype.id AND work_agent.work_id = '$this->id'";
        if ($type != null) {
            $sql .= " AND agenttype.type = '$type'";
        }
        if ($orderBy != null) {
            $sql .= " ORDER BY $orderBy";
        }
        $agent->query($sql);
        if ($agent->N) {
            while ($agent->fetch()) {
                $agentList[] = clone($agent);
            }
        }
        
        return $agentList;
    }
    
    function hasAgent($agent, $typeId)
    {
        $tmp = new Agent();
        $sql = "SELECT agent_id as id FROM work_agent WHERE agent_id = '$agent->id' AND work_id = '$this->id' AND agenttype_id = '$typeId'";
        $tmp->query($sql);
        if ($tmp->N) {
            return true;
        } else {
            return false;
        }
    }    
    
    function addAgent($agent, $typeId)
    {
        $sql = "INSERT INTO work_agent (work_id, agent_id, agenttype_id) VALUES('$this->id', '$agent->id', '$typeId')";
        return $this->query($sql);
    }
    
    function removeAgent($agentId)
    {
        $sql = "DELETE FROM work_agent WHERE work_id = '$this->id' AND agent_id = '$agentId'";
        return $this->query($sql);
    }

    function dropAgents()
    {
        $sql = "DELETE FROM work_agent WHERE work_id = '$this->id'";
        return $this->query($sql);
    }
    
        
    function getData()
    {
        require_once 'classes/Workattribute.php';
        $data = array();
        
        //$sql = "SELECT workattribute.field, work_workattribute.value, workattribute.type " . 
	$sql = "SELECT workattribute.field, work_workattribute.value, workattribute.type, work_workattribute.workattribute_id " .
               "FROM workattribute LEFT JOIN work_workattribute ON work_workattribute.workattribute_id = workattribute.id " . 
               "WHERE work_workattribute.work_id = '$this->id'";
        $this->query($sql);
        if ($this->N) {
            while ($this->fetch()) {
	      if ($this->type == "Select") {
		$attribute = new Workattribute();
		$attribute->id = $this->workattribute_id;
		$attribute->type = $this->type;

		$option = $this->getAttributeValue($attribute);
		$data[$this->field] = $option->title;
	      } else {
                $data[$this->field] = $this->value;
	      }
            }
        }
        
        return $data;
    }
    
    function setPublisher($publisher, $location, $year, $yearEnd)
    {
        if ($publisher->id == '') {
            $publisher->id = 'null';
        }
        if ($location->id == '') {
            $location->id = 'null';
        }
        
        $year = ($year != null) ? $year : 'null';
        $yearEnd = ($yearEnd != null) ? $yearEnd : 'null';
        
        if (($publisher->id != 'null') || ($location->id != 'null') || ($year != 'null') || ($yearEnd != 'null')) {
            $tmp = new Publisher();
            $sql = "INSERT INTO work_publisher (work_id, publisher_id, location_id, publish_year, publish_year_end) " . 
                   "VALUES($this->id, $publisher->id, $location->id, $year, $yearEnd)";
            $tmp->query($sql);
            return true;
        } else {
            return false;
        }
    }
    
    function getPublishers()
    {
        $publisherList = array();
        
        $publisher = new Publisher();
        $sql = "SELECT work_publisher.publisher_id, work_publisher.location_id, work_publisher.publish_year, work_publisher.publish_year_end, publisher_location.location, publisher.name " . 
               "FROM work_publisher " . 
               "LEFT OUTER JOIN publisher ON work_publisher.publisher_id = publisher.id " . 
               "LEFT OUTER JOIN publisher_location ON work_publisher.location_id = publisher_location.id " . 
               "WHERE work_publisher.work_id = '$this->id'";
        $publisher->query($sql);
        if ($publisher->N) {
            while ($publisher->fetch()) {
                $publisher->id = "$publisher->publisher_id|$publisher->location_id";
                $publisherList[] = clone($publisher);
            }
        }
        
        return $publisherList;
    }
    
    function removePublisher($id)
    {
        $sql = "DELETE FROM work_publisher WHERE work_id = '$this->id' AND publisher_id = '$id'";
        $this->query($sql);
    }
    
    function dropPublishers()
    {
        $sql = "DELETE FROM work_publisher WHERE work_id = '$this->id'";
        $this->query($sql);
    }
    
    function dropParent()
    {
        $this->work_id = 'null';
        $this->update();
        $this->work_id = '';
    }
    
    function getWorkType()
    {
        require_once(__DIR__ . '/Worktype.php');
        if ($this->type_id != '') {
            return Worktype::staticGet('id', $this->type_id);
        } else {
            return null;
        }
    }
    
    function findByAgent($name, $type = null)
    {
        require_once('Agent.php');
        
        $worksList = array();
        
        $name = mb_strtoupper($name, 'UTF-8');
        $sql = "SELECT agent.* FROM agent, work_agent, agenttype WHERE agent.id = work_agent.agent_id AND work_agent.agenttype_id = agenttype.id AND (UPPER(agent.lname) LIKE '%$name%' OR UPPER(agent.fname) LIKE '%$name%' OR UPPER(agent.alternate_name) LIKE '%$name%' OR UPPER(agent.organization_name) LIKE '%$name%')";
        if ($type != null) {
            $sql .= " AND agenttype.type = '$type'";
        }
        $agent = new Agent();
        $agent->query($sql);
        if ($agent->N) {
            while ($agent->fetch()) {
                $worksList = array_merge($worksList, $agent->getWorks());
            }
        }
        
        return $worksList;
    }

    function findByPublisher($name)
    {
        require_once('Publisher.php');

        $workList = array();
        
        $name = mb_strtoupper($name, 'UTF-8');
        $publisher = new Publisher();
        $publisher->whereAdd("UPPER(name) LIKE '%$name%'");
        if ($publisher->find()) {
            while ($publisher->fetch()) {
                $workList = array_merge($workList, $publisher->getWorks());
            }
        }
        
        return $workList;
    }

    function fetchData()
    {
        require_once('lib/marc.php');
        
        global $configArray;

        // Do not proceed if yaz is not installed.
        if (!is_callable('yaz_connect')) {
            $error = new PEAR_Error('Yaz Toolkit is not installed');
            $this->raiseError($error);
        }

        // Develop search phrase
        if ($this->title != null) {
            //$phrase = "@attr 1=4 @attr 2=102 \"$this->title\"";
            $phrase = "@attr 1=4 \"$this->title\"";
            echo $phrase;
        } else {
            return new PEAR_Error('Work must have a title for data searching');
        }
 
        // Connect to Z39.50 Gateway
        $conn = yaz_connect($configArray['Z39.50']['host'], array('persistent' => false));
        if (!$conn) {
            $error = new PEAR_Error('Cannot connect to Z39.50 Server');
            $this->raiseError($error);
        }
        $error = yaz_error($conn);
        if (!empty($error)) {
            yaz_close($conn);
            $this->raiseError($error);
        }

        // Define Results Format
        yaz_syntax($conn, 'MARC');
        
        // Run Z39.50 Search in RPN notation
        yaz_search($conn, 'rpn', $phrase);
        $error = yaz_error($conn);
        if (!empty($error)) {
            yaz_close($conn);
            $this->raiseError($error);
        }

        // Wait for results to be returned
        yaz_wait();

        // Retrieve record
        echo "found " . yaz_hits($conn);
        $record = yaz_record($conn, 1, 'string');
        if ($record != '') {
            // Convert record to array
            $record = Text_Marc::toArray($record);

            // Fill in attributes
            $this->populate($record);
                                            
            yaz_close($conn);
            return true;
        }
        yaz_close($conn);
        
        return false;
    }
    
    function populate($record)
    {
        if (isset($record['245'][0])) { // Title
            $this->title = trim($record['245'][0]);
            $this->title = str_replace(' :', '', $this->title);
            $this->title = str_replace(' /', '', $this->title);
            if (count($record['245']) == 3) {
                $this->subtitle = str_replace(' /', '', trim($record['245'][1]));
            }
        }
        
        if (isset($record['246'][0])) { // Alternate Title
            $this->paralleltitle = trim($record['246'][0]);
        }
        
        if (isset($record['100'][0])) { // Author
            $type = Agenttype::staticGet('type', 'Author');
            $agent = new Agent();
            $name = explode(', ', $record['100'][0]);
            $agent->fname = $name[1];
            $agent->lname = $name[0];
            if ($agent->find(true)) {
                if (isset($record['110'][0])) {
                    $agent->organization_name = $record['110'][0];
                }
                if (isset($record['111'][0])) {
                    $agent->alternate_name = $record['111'][0];
                }
                $agent->update();
            } else {
                if (isset($record['110'][0])) {
                    $agent->organization_name = $record['110'][0];
                }
                if (isset($record['111'][0])) {
                    $agent->alternate_name = $record['111'][0];
                }
                $agent->insert();
            }
            $this->addAgent($agent, $type->id);
        }
        
        if (isset($record['260'][0])) { // Publisher
            $publisher = new Publisher();
            $publisher->name = str_replace(',', '', $record['260'][1]);
            if (!$publisher->find(true)) {
                $publisher->insert();
            }
            $location = new Publisher_location();
            $location->publisher_id = $publisher->id;
            $location->location = str_replace(' :', '', $record['260'][0]);
            if (!$location->find(true)) {
                $location->insert();
            }
            print_r($record['260'][2]);
            $this->setPublisher($publisher, $location, $month, substr($record['260'][2], 0, 4));
        }
        
        if (isset($record['022'][0])) { // ISSN
            $attribute = Workattribute::staticGet('field', 'ISSN');
            $this->addAttributeValue($attribute, trim($record['022'][0]));
        }
        
        if (isset($record['020'][0])) { // ISBN
            $type = Worktype::staticGet('type', 'Book');
            $this->type_id = $type->id;
            $attribute = Workattribute::staticGet('field', 'ISBN');
            $this->addAttributeValue($attribute, trim($record['020'][0]));
        }

        if (isset($record['250'][0])) { // Edition
            $attribute = Workattribute::staticGet('field', 'Edition');
            $this->addAttributeValue($attribute, trim($record['250'][0]));
        }

        if (isset($record['440'][0])) { // Series
            $attribute = Workattribute::staticGet('field', 'Series');
            $this->addAttributeValue($attribute, trim($record['440'][0]));
        }
    }
    
    function getAmazonData($locale = 'us')
    {
        require_once('Services/Amazon.php');
        
        $aws = new Services_Amazon('0AC15T03CCSC1ZHDMG02', 'X', $locale);
        
        return $aws->searchIsbn($this->isbn);
    } 
    
    function getBranchStrings($branch = null, $parentId = null, $useLinks = true)
    {
        $linkList = array();

        $sql = "SELECT folder.* FROM folder, work_folder WHERE folder.id = work_folder.folder_id AND work_folder.work_id = '$this->id'";
        
        $folder = new Folder();
        $folder->query($sql);
        if ($folder->N) {
            while ($folder->fetch()) {
                $linkList[] = $this->_developBranchString(clone($folder), null, $useLinks);
            }
        }

        return $linkList;
    }
    
    function _developBranchString($folder, $branch = null, $useLinks)
    {
        global $folderId;
        
        if (isset($_POST['language'])) {
            $langVar = 'text_' . $_POST['language'];
        } else {
            $langVar = 'text_' . $_COOKIE['language'];
        }
        
        if ($branch == null) {
            $folderId = $folder->id;
        }
        
        if ($folder->parent_id == null) {
            $branch = $folder->$langVar . $branch;
        } else {
            $branch = ' &gt; ' . htmlspecialchars($folder->$langVar) . $branch;
            $branch = $this->_developBranchString($folder->getParent(), $branch, $useLinks);
            return $branch;
        }
        
        if ($useLinks) {
            $link = "<a href=\"treeview.php?id=$folderId\">$branch</a>\n";
        } else {
            $link = $branch;
        }
        
        return $link;
    }
}
?>
