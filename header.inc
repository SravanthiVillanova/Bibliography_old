<html>
<head>
  <title>Project Panta Rhei</title>
  <script language="javascript" type="text/javascript" src="TreeMenu.js"></script>
  <link rel="stylesheet" href="/panta_rhei/main.css" media="screen" />
</head>
<body bgcolor="#CCCCCC">

<div align="center">
<div class="page">

<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr valign="top">
    <form method="post" name="lang">
    <td width="100%">
      <select name="language" onChange="document.lang.submit();">
        <option value="en">English</option>
        <option value="fr"<?php if ($language == 'fr') echo ' selected';?>>Français</option>
        <option value="de"<?php if ($language == 'de') echo ' selected';?>>Deutsch</option>
        <option value="nl"<?php if ($language == 'nl') echo ' selected';?>>Dutch</option>
        <option value="es"<?php if ($language == 'es') echo ' selected';?>>Español</option>
        <option value="it"<?php if ($language == 'it') echo ' selected';?>>Italiano</option>
      </select>
    </td>
    </form>
    <form method="post" action="worklist.php">
    <td width="300" align="right" class="search" nowrap>
      <img src="/panta_rhei/images/search.png" alt="Search" align="center">
      Search: <input type="text" name="lookfor" size="15"><br>
      <select name="worktype_id">
        <option></option>
        <?php
        require_once('classes/Worktype.php');
        $worktype = new Worktype();
        $worktype->find();
        while ($worktype->fetch()) {
            echo "<option value=\"$worktype->id\">$worktype->type</option>\n";
        }
        ?>
      </select><br>
      <a href="search.php" style="font-weight: normal;">Advanced Search</a>
    </td>
    <td nowrap>&nbsp;<input type="submit" name="submit" value="Go"></td>
    </form>
  </tr>
</table>