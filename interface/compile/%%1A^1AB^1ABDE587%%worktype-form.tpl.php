<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:50:46
         compiled from worktype-form.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['type']->id; ?>
">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Type:&nbsp;</td>
    <td><input type="text" name="type" value="<?php echo $this->_tpl_vars['type']->type; ?>
">
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>