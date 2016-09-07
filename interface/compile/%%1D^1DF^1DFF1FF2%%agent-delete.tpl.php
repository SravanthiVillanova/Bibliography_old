<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:21:42
         compiled from agent-delete.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleDelete">
  
<p>Are you sure you want to delete these?</p>
<ul>
  <?php $_from = $this->_tpl_vars['agentList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['agent']):
?>
  <li><?php echo $this->_tpl_vars['agent']->fname; ?>
 <?php echo $this->_tpl_vars['agent']->lname; ?>
</li>
  <input type="hidden" name="id[]" value="<?php echo $this->_tpl_vars['agent']->id; ?>
">
  <?php endforeach; endif; unset($_from); ?>
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>