<?php
require 'GoogleMapAPI.class.php';

$map = new GoogleMapAPI();
$map->setAPIKey('ABQIAAAAK9Moo1FYIA19RFj0jqC-sxS_VrHpu_6-lSFLx-OrUHdOGftV3xQ4AWN4HLwG-Z4HTAgHb5WbrAx2NQ');

$sql = "SELECT COUNT(work_publisher.work_id), publisher_location.location FROM publisher_location, publisher, work_publisher " . 
       "WHERE publisher_location.publisher_id = publisher.id AND publisher.id = work_publisher.publisher_id GROUP BY publisher_location.location";
$do = new DB_DataObject();
$do->query($sql);
if ($do->N) {
    while ($do->fetch()) {
        $map->addMarkerByAddress($do->location, $do->location, $do->count);
    }
}

$map->setZoomLevel(15);
$map->setWidth(600);
$map->setHeight(500);

$script = '';
$script .= $map->getHeaderJS();
$script .= $map->getMapJS();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Augustine around the World</title>
  <?php echo $script; ?>
</head>
<body onLoad="onLoad();">
<?php
$map->printMap();
//$map->printSidebar();
?>
</body>
</html>
