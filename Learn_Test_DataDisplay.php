<?php
/* $user = 'root';
$pwd = '';
$db = 'panta_rhei';
//$con = new mysqli('VU01339',$user,$pwd,$db);
$con = new mysqli('localhost', $user, $pwd, $db);
if ($con->connect_error) {
    die("unable to connect" . $con->connect_error);
}
$ql = "select * from agenttype";
$result = mysqli_query($con, $ql); */
require_once 'Learn_db_connection_fetch.php';
if (mysqli_num_rows($result) > 0) {
    echo "<head>";
    echo "<link media='screen' rel='stylesheet' href='learn_style.css'/link>";
    echo "</head>";
    //echo "<head><link type='text/css' rel='stylesheet' href='style.css'/link>
    //echo "</head>";
    //echo "<link rel='stylesheet' href='/panta_rhei/main.css' media='screen' />";
    echo "<body>";
    echo '<div class= "page">';
    echo "<h1>AGENT TYPE</h1>";
    echo "<table class='gridtable'>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Type</th>";
    echo "</tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "&nbsp" . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "</body>";
    mysqli_free_result($result);
} else {
    echo "query did not fetch any results";
}
?>