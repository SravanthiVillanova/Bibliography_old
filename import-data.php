<?php
include('global.inc');

require_once('classes/Agent.php');
require_once('classes/Publisher.php');
require_once('classes/Workattribute.php');

$file = $_FILES['csvfile'];
$path = '/tmp/' . $file['name'];

if (move_uploaded_file($file['tmp_name'], $path)) {

    // Read Data
    $fileData = array();
    $handle = fopen($path, 'r');
    while (($data = fgetcsv($handle, 10000)) !== FALSE) {           
        $fileData[] = $data;
    }

    if (!count($fileData)) {
        $message = '<p class="error">Error: File not in CSV format or empty</p>';
    }
    
    // Delete CSV file from tmp location
    unlink('/tmp/' . $file['name']);
    
    // Import Data
    foreach ($fileData as $record) {
        $work = new Work();
        
        // Import standard work data from file
        if ($record[15] != '') {
            $work->title = addslashes($record[15]);
        }
        if ($record[16] != '') {
            $work->subtitle = addslashes($record[16]);
        }
        if ($record[28] != '') {
            $work->publish_year = addslashes($record[28]);
        }

        // Import Publisher information from file
        $publisher = new Publisher();
        if ($record[27] != '' || $record[26] != '') {
            $publisher->name = addslashes($record[27]);
            $publisher->location = addslashes($record[26]);
            if ($publisher->find()) {
                $publisher->fetch();
                $work->publisher_id = $publisher->id;
            } else {
                $work->publisher_id = $publisher->insert();
            }
        }
                
        // Create work in database        
        if (!$work->find()) {
            $result = $work->insert();
        } else {
            $work->fetch();
        }
        
        // Import Agent Information from file
        $agentType = Agenttype::staticGet('type', 'Author');
        // Author 1
        if ($record[6] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[7]);
            $agent->lname = addslashes($record[6]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }

        // Author 2
        if ($record[8] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[9]);
            $agent->lname = addslashes($record[8]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }

        // Author 3
        if ($record[10] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[11]);
            $agent->lname = addslashes($record[10]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }

        // Author 4
        if ($record[12] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[13]);
            $agent->lname = addslashes($record[12]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }
        
        $agentType = Agenttype::staticGet('type', 'Editor');
        // Editor 1
        if ($record[21] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[22]);
            $agent->lname = addslashes($record[21]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }

        // Editor 2
        if ($record[23] != '') {
            $agent = new Agent();
            $agent->fname = addslashes($record[24]);
            $agent->lname = addslashes($record[23]);
            if (!$agent->find(true)) {
                $agent->insert();
            }
            if (!$work->hasAgent($agent, $agentType->id)) {
                $work->addAgent($agent, $agentType->id);
            }
        }
        
        // Import Attribute Data from file
        if (isset($work->_query)) { // Only set data for new records
            if ($record['17'] != '') {
                $attribute = Workattribute::staticGet('field', 'Found In');
                $result = $work->addAttributeValue($attribute, $record['17']);
            }
            if ($record['18'] != '') {
                $attribute = Workattribute::staticGet('field', 'Periodical');
                $result = $work->addAttributeValue($attribute, $record['18']);
            }
            if ($record['19'] != '') {
                $attribute = Workattribute::staticGet('field', 'Volume');
                $result = $work->addAttributeValue($attribute, $record['19']);
            }
            if ($record['20'] != '') {
                $attribute = Workattribute::staticGet('field', 'Number');
                $result = $work->addAttributeValue($attribute, $record['20']);
            }
            if ($record['25'] != '') {
                $attribute = Workattribute::staticGet('field', 'Start Page');
                $result = $work->addAttributeValue($attribute, $record['25']);
            }
            if ($record['29'] != '') {
                $attribute = Workattribute::staticGet('field', 'Total Pages');
                $result = $work->addAttributeValue($attribute, $record['29']);
            }
            if ($record['30'] != '') {
                $attribute = Workattribute::staticGet('field', 'Edition');
                $result = $work->addAttributeValue($attribute, $record['30']);
            }
            if ($record['31'] != '') {
                $attribute = Workattribute::staticGet('field', 'Edition Year');
                $result = $work->addAttributeValue($attribute, $record['31']);
            }
            if ($record['32'] != '') {
                $attribute = Workattribute::staticGet('field', 'Series');
                $result = $work->addAttributeValue($attribute, $record['32']);
            }
            if ($record['33'] != '') {
                $attribute = Workattribute::staticGet('field', 'Series Number');
                $result = $work->addAttributeValue($attribute, $record['33']);
            }
            if ($record['34'] != '') {
                $attribute = Workattribute::staticGet('field', 'Illustrated');
                $result = $work->addAttributeValue($attribute, $record['34']);
            }
            if ($record['35'] != '') {
                $attribute = Workattribute::staticGet('field', 'ISBN');
                $result = $work->addAttributeValue($attribute, $record['35']);
            }
        }
        
        // Determine Directory Location
        $tree = fetchTree($record);
        $work->addTree($tree);
        
    }
    $message = '<p class="okay">Data Import was a success</p>';
} else {
    $message = '<p class="error">Error: File was not uploaded.</p>';
}

include ('header.inc');

echo $message;
?>

<form method="post" enctype="multipart/form-data">
<input type="file" name="csvfile"><br>
<input type="submit" name="submit" value="Import">
</form>


<?php
include ('footer.inc');

// Recursive method to crawl down the tree to find the end item
function fetchTree($record, $parent_id = 'null', $level = 1)
{
    $tree = new Folder();
    $tree->parent_id = $parent_id;
    $tree->number = $record[$level];
    if ($tree->find()) {
        $tree->fetch();
        if ($level < 5) {
            $child = fetchTree($record, $tree->id, $level+1);
            if ($child != null) {
                return $child;
            } else {
                return $tree;
            }
        } else {
            return $tree;
        }
    }
    
    return null;
}    
?>