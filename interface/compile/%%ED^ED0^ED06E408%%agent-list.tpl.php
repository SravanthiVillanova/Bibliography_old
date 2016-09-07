<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:18:53
         compiled from agent-list.tpl */ ?>
<p align="center">
<?php $_from = $this->_tpl_vars['letterList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['letterLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['letterLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['letter']):
        $this->_foreach['letterLoop']['iteration']++;
?>
  <a href="agent.php?letter=<?php echo $this->_tpl_vars['letter']; ?>
"><?php echo $this->_tpl_vars['letter']; ?>
</a>
  <?php if (! ($this->_foreach['letterLoop']['iteration'] == $this->_foreach['letterLoop']['total'])): ?>|<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</p>

<a href="agent.php?action=showForm">Add Agent</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>