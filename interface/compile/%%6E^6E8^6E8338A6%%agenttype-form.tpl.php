<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:18:44
         compiled from agenttype-form.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>

<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['type']->id; ?>
">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Type: </th><td><input type="text" name="type" value="<?php echo $this->_tpl_vars['type']->type; ?>
"></td></tr>
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>