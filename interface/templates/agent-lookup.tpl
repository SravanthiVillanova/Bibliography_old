<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Project Panta Rhei - Administration</title>
  <link rel="stylesheet" href="main.css" media="screen" />
  <link rel="stylesheet" href="../main.css" media="screen" />
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<body>

<form method="post">
<input type="hidden" name="action" value="handleAgentLookup">
<table cellpadding="4" cellspacing="0" border="0">
  <tr bgcolor="#CCCCCC"><th>First Name</th><th>Last Name</th><th>Alternate Name</th><th>Organization Name</th></tr>
  <tr>
    <td><input type="text" name="fname" size="30"></td>
    <td><input type="text" name="lname" size="30"></td>
    <td><input type="text" name="altname" size="30"></td>
    <td><input type="text" name="orgname" size="30"></td>
  </tr>
  <tr><td colspan="5"><input type="submit" name="submit" value="Search"></td></tr>
</table>
</form>
{$dghtml}

</body>
</html>