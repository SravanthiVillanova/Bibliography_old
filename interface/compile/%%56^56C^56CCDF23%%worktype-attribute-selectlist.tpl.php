<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:48
         compiled from worktype-attribute-selectlist.tpl */ ?>
<b>Attributes for: </b><?php echo $this->_tpl_vars['type']->type; ?>
<br>
Used attributes are checked <input type="checkbox" checked disabled>
<form method="post">
<input type="hidden" name="action" value="handleAttrSelect">
<input type="hidden" name="type_id" value="<?php echo $this->_tpl_vars['type']->id; ?>
">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Add/Remove">
</form>
<?php echo $this->_tpl_vars['paging']; ?>