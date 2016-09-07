<?php
require_once 'DB/DataObject.php';
require 'learn_db.php';
class agenttype extends DB_DataObject 
{
	//$ql = new mysqli_query();
	//$result = new mysqli_result();
  // $ql = "select * from agenttype";
  //  $result = mysqli_query($con, $ql);
	//$result = new mysqli_query($con, "select * from agenttype");
	function showList() { 
	$result = mysqli_query($con, "select * from agenttype");
	return $result; }
}
?>