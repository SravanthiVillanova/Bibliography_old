<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 19:56:13
         compiled from prefs-form.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>


<form method="post">
<input type="hidden" name="action" value="handleForm">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Password: </th><td><input type="password" name="password"></td></tr>
  <tr><th>Password Again: </td><th><input type="password" name="password2"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>