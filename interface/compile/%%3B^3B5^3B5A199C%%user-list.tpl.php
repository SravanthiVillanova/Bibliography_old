<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 20:17:56
         compiled from user-list.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>


<a href="users.php?action=showForm">Add User</a>
<form method="post">
<input type="hidden" name="action" value="handleList">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete" style="float: left;">
<input type="submit" name="submit" value="Save" style="float: right;">
</form>
<?php echo $this->_tpl_vars['paging']; ?>