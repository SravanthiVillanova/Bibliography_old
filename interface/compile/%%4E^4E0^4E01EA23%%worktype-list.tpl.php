<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:38
         compiled from worktype-list.tpl */ ?>
<a href="worktype.php?action=showForm">Add Work Type</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>