<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:37:59
         compiled from folder-list.tpl */ ?>
<p>
<?php if ($this->_tpl_vars['folder'] != ''): ?>
<b>Viewing:</b>
<a href="tree.php">Top</a> &gt; 
<?php $_from = $this->_tpl_vars['folder']->getParentChain(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
  <a href="tree.php?id=<?php echo $this->_tpl_vars['parent']->id; ?>
"><?php echo $this->_tpl_vars['parent']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</a> &gt;
<?php endforeach; endif; unset($_from); ?>
<?php echo $this->_tpl_vars['folder']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>

<?php endif; ?>
</p>

<a href="tree.php?action=showForm&parent_id=<?php echo $this->_tpl_vars['folder']->id; ?>
">Add Branch</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>