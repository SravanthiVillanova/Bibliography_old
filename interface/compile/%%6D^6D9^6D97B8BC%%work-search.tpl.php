<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:51:48
         compiled from work-search.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Project Panta Rhei - Administration</title>
  <link rel="stylesheet" href="main.css" media="screen" />
  <link rel="stylesheet" href="../main.css" media="screen" />
  <script type="text/javascript" src="menu.js"></script>  
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body>

<form method="get">
<input type="hidden" name="action" value="handleWorkLookup">
<table cellpadding="4" cellspacing="0" border="0">
  <tr>
    <th>Title: </th>
    <td><input type="text" name="title" size="40"></td>
  </tr>
  <tr><td></td><td><input type="submit" name="submit" value="Search"></td></tr>
</table>
</form>
<?php echo $this->_tpl_vars['dghtml']; ?>


</body>
</html>