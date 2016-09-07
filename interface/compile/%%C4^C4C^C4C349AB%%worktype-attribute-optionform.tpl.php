<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:48:33
         compiled from worktype-attribute-optionform.tpl */ ?>
<form method="post">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['option']->id; ?>
">
<input type="hidden" name="attribute_id" value="<?php echo $this->_tpl_vars['attribute']->id; ?>
">
<input type="hidden" name="action" value="handleOptionForm">
<table cellpadding="4" cellspacing="0" border="0" class="form">
  <tr>
    <th>Option:&nbsp;</th>
    <td><input type="text" name="title" value="<?php echo $this->_tpl_vars['option']->title; ?>
" size="40">
  </tr>
  <tr>
    <th>Type:&nbsp;</th>
    <td><input type="text" name="value" value="<?php echo $this->_tpl_vars['option']->value; ?>
" size="40">
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>