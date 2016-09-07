<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 19:59:11
         compiled from publisher-form.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['publisher']->id; ?>
">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Name: </th><td><input type="text" name="name" value="<?php echo $this->_tpl_vars['publisher']->name; ?>
" size="50" maxlength="100"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>