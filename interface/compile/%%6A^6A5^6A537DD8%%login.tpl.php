<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:55:46
         compiled from login.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Administation: Login</title>
  <meta http-equiv="Content-Type" content="text/html">
</head>
<body>
  <p align="center">
  <?php echo $this->_tpl_vars['message']; ?>

  <table cellpadding="4" cellspacing="1" border="0" bgcolor="#CCCCCC">
    <form method="post">
    <tr>
      <td>Username: </td>
      <td><input type="text" name="username" value="<?php echo $this->_tpl_vars['username']; ?>
" size="15"></td>
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