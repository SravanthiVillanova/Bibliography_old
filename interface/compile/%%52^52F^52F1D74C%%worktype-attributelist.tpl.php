<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:53
         compiled from worktype-attributelist.tpl */ ?>
<a href="worktype.php?action=showAttrForm&type_id=<?php echo $this->_tpl_vars['typeId']; ?>
">Add Attribute</a>
<form method="post">
<input type="hidden" name="action" value="showAttrDelete">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>
