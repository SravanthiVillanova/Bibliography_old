<?php
$user = 'root';
$pwd = '';
$db = 'panta_rhei';
//$con = new mysqli('VU01339',$user,$pwd,$db);
$con = new mysqli('localhost', $user, $pwd, $db);
if ($con->connect_error) {
    die("unable to connect" . $con->connect_error);
}
//$ql = "select * from agenttype";
//$result = mysqli_query($con, $ql); 
?>