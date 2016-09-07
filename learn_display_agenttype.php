<?php
   require 'classes/learn_Database.php';
   $database = new Database;
   $database->query('select * from agenttype');
   $rows = $database->resultset();
?>
<head>
<link media='screen' rel='stylesheet' href='learn_style.css'/link>
</head>
<body>
<div class= "page">
<h1>AGENT TYPE</h1>
<table class='gridtable'>
<tr>
<th>Id</th>
<th>Type</th>
</tr>
<?php foreach($rows as $row) : ?>
<tr>
<td><?php echo $row['id'] . "&nbsp" ; ?></td>
<td><?php echo $row['type'] . "&nbsp" ; ?></td>
</tr>
<?php endforeach ; ?>