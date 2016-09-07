<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:42:16
         compiled from main.tpl */ ?>
<p><a href="admin/">Administration</a></p>

<div align="center">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="tree">
  <tr valign="top">
<?php $_from = $this->_tpl_vars['rootList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['root'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['root']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['root']):
        $this->_foreach['root']['iteration']++;
?>
    <td width="33%">
      <a href="treeview.php?id=<?php echo $this->_tpl_vars['root']->id; ?>
" class="root"><?php echo $this->_tpl_vars['root']->number; ?>
 <?php echo $this->_tpl_vars['root']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</a><br>
      <?php $_from = $this->_tpl_vars['root']->getChildren($this->_tpl_vars['childrenPerCell']); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['child']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['child']):
        $this->_foreach['child']['iteration']++;
?>
      <a href="treeview.php?id=<?php echo $this->_tpl_vars['child']->id; ?>
"><?php echo $this->_tpl_vars['child']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</a><?php if (! ($this->_foreach['child']['iteration'] == $this->_foreach['child']['total'])): ?>,<?php else: ?>...<?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
    </td>
  <?php if ($this->_foreach['root']['iteration'] == $this->_tpl_vars['cellPerRow']): ?>
  </tr>
  <tr valign="top">
  <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
        
</table>
</div>