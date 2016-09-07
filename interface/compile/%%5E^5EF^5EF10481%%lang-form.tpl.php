<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 19:56:31
         compiled from lang-form.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>

<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="term" value="<?php echo $this->_tpl_vars['term']; ?>
">
<?php echo $this->_tpl_vars['term']; ?>

<table cellspacing="0" cellpadding="4" border="0" class="form">
  <?php $_from = $this->_tpl_vars['translator']->getLanguages(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lang']):
?>
  <tr><th><?php echo $this->_tpl_vars['lang']; ?>
: </th><td><input type="text" name="translation[<?php echo $this->_tpl_vars['lang']; ?>
]" value="<?php echo $this->_tpl_vars['translator']->translate($this->_tpl_vars['term'],$this->_tpl_vars['lang']); ?>
"></td></tr>
  <?php endforeach; endif; unset($_from); ?>
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>