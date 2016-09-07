<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:46:30
         compiled from worktype-attribute-optionlist.tpl */ ?>
<b>Attribute: </b><?php echo $this->_tpl_vars['attribute']->field; ?>
<br>
<a href="worktype.php?action=showOptionForm&attribute_id=<?php echo $this->_tpl_vars['attribute']->id; ?>
">Add Option</a>
<form method="post">
<input type="hidden" name="action" value="showOptionDelete">
<input type="hidden" name="workattribute_id" value="<?php echo $this->_tpl_vars['attribute']->id; ?>
">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>