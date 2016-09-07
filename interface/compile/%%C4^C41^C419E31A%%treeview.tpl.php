<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:33:48
         compiled from treeview.tpl */ ?>
<a href="index.php">Top</a> &gt;
<?php $_from = $this->_tpl_vars['parentChain']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
<a href="treeview.php?id=<?php echo $this->_tpl_vars['parent']->id; ?>
"><?php echo $this->_tpl_vars['parent']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</a> &gt;
<?php endforeach; endif; unset($_from); ?>
<b><?php echo $this->_tpl_vars['root']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</b>

<ul STYLE="list-style: upper-roman outside">
<?php $_from = $this->_tpl_vars['root']->getChildren(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
  <li><a href="treeview.php?id=<?php echo $this->_tpl_vars['child']->id; ?>
"><?php echo $this->_tpl_vars['child']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>

<hr>
<h3>Works</h3>

<ul>
<?php $_from = $this->_tpl_vars['root']->getWorks(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['work']):
?>
  <li><a href="work.php?id=<?php echo $this->_tpl_vars['work']->id; ?>
"><?php echo $this->_tpl_vars['work']->title; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>