<?php
error_reporting(E_ALL);

ini_set('display_errors', true);
ini_set('memory_limit', '50M');
set_time_limit('120');

if (isset($_FILES['csvfile'])) {
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
        foreach ($fileData as $line) {
            $indent = 0;
            
            // Get Tree Elements and Determin Indentation
            $record = array();
            for ($i=0; $i<count($line); $i++) {
                if (($line[$i] != '') || ($line[$i+1] != '')) {
                    $record[0] = $line[$i];
                    $record[1] = $line[$i+1];
                    
                    // End after second element
                    break;
                } else {
                    $indent++;
                }
                $i++;
            }
            
            // Create Record
            if ($indent > $parentIndent) {
                // If current record is the first child, set the parent
                $parent[$indent] = $folder;
                $parentIndent = $indent;
                $folder = new Folder();
                $folder->parent_id = $parent[$indent]->id;
            } elseif ($indent <= $parentIndent) {
                // If the current record is another child, use previous parent
                $parentIndent = $indent;
                $folder = new Folder();
                $folder->parent_id = $parent[$indent]->id;
            } else {
                // If the current record is not a child, it is a root element
                $folder = new Folder();
                $folder->parent_id = 'null';
            }
            $folder->number = $record[0];
            if (substr($record[1], 0, 1) == "'") {
                $folder->text_fr = substr($record[1], 1);
            } else {
                $folder->text_fr = $record[1];
            }
            $folder->insert();
        }
        
        $message = '<p class="okay">Data Import was a success</p>';
    } else {
        $message = '<p class="error">Error: File was not uploaded.</p>';
    }
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
?>