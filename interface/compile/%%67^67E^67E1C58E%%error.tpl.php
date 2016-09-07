<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:56:40
         compiled from error.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Panta Rhei Project: Error</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link href="main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <p align="center">
  <table cellpadding="4" cellspacing="0" border="0" bgcolor="#CCCCCC">
    <tr>
      <td align="Center">
        <h2>An error has occured</h2>
        <p class="errorMsg"><?php echo $this->_tpl_vars['error']->getMessage(); ?>
</p>
        <p class="errorStmt"><?php echo $this->_tpl_vars['error']->getDebugInfo(); ?>
</p>
        <p>Please contact your administrator to report the problem</p>
        <p class="errorDebug">
        <B>DEBUG</b><br>
        <?php $_from = $this->_tpl_vars['error']->backtrace; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['backtrace']):
?>
          In <?php echo $this->_tpl_vars['backtrace']['file']; ?>
 on line <?php echo $this->_tpl_vars['backtrace']['line']; ?>
 in function <?php echo $this->_tpl_vars['backtrace']['function']; ?>
<br>
        <?php endforeach; endif; unset($_from); ?>
      </td>
    </tr>
  </table>
  </p>
</body>
</html>