<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Administation: Login</title>
  <meta http-equiv="Content-Type" content="text/html">
</head>
<body>
  <p align="center">
  {$message}
  <table cellpadding="4" cellspacing="1" border="0" bgcolor="#CCCCCC">
    <form method="post">
    <tr>
      <td>Username: </td>
      <td><input type="text" name="username" value="{$username}" size="15"></td>
    </tr>

    <tr>
      <td>Password: </td>
      <td><input type="password" name="password" size="15"></td>
    </tr>

    <tr>
      <td></td>
      <td><input type="submit" name="submit" value="Login"></td>
    </tr>
    </form>
  </table>
  </p>
</body>
</html>