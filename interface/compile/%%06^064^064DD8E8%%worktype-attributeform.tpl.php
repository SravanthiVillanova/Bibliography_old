<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:46:52
         compiled from worktype-attributeform.tpl */ ?>
<form method="post">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['attribute']->id; ?>
">
<input type="hidden" name="action" value="handleAttrForm">
<table cellpadding="0" cellspacing="0" border="0" class="form">
  <tr>
    <th>Attribute:&nbsp;</th>
    <td><input type="text" name="attribute" value="<?php echo $this->_tpl_vars['attribute']->field; ?>
">
  </tr>
  <tr>
    <th>Field Type:&nbsp;</th>
    <td>
      <input type="radio" name="type" value="Text"<?php if (( ( $this->_tpl_vars['attribute']->type == 'Text' ) || ( $this->_tpl_vars['attribute']->type == '' ) )): ?> checked<?php endif; ?>> Short Text<br>
      <input type="radio" name="type" value="Textarea"<?php if ($this->_tpl_vars['attribute']->type == 'Textarea'): ?> checked<?php endif; ?>> Long Text<br>
      <input type="radio" name="type" value="Checkbox"<?php if ($this->_tpl_vars['attribute']->type == 'Checkbox'): ?> checked<?php endif; ?>> True/False Box<br>
      <input type="radio" name="type" value="Select"<?php if ($this->_tpl_vars['attribute']->type == 'Select'): ?> checked<?php endif; ?>> Options Drop-Down<br>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>