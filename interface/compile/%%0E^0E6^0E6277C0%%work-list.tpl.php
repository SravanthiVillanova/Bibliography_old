<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 20:16:31
         compiled from work-list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlEncode', 'work-list.tpl', 3, false),)), $this); ?>
<p align="center">
<?php $_from = $this->_tpl_vars['letterList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['letterLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['letterLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['letter']):
        $this->_foreach['letterLoop']['iteration']++;
?>
  <a href="work.php?letter=<?php echo ((is_array($_tmp=$this->_tpl_vars['letter'])) ? $this->_run_mod_handler('urlEncode', true, $_tmp) : urlEncode($_tmp)); ?>
<?php if ($this->_tpl_vars['noFolder']): ?>&amp;noFolder<?php endif; ?>"><?php echo $this->_tpl_vars['letter']; ?>
</a>
  <?php if (! ($this->_foreach['letterLoop']['iteration'] == $this->_foreach['letterLoop']['total'])): ?>|<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</p>

<span style="float: right;">Records <?php echo $this->_tpl_vars['recordStart']; ?>
 - <?php echo $this->_tpl_vars['recordEnd']; ?>
 of <?php echo $this->_tpl_vars['recordCount']; ?>
</span>
<a href="work.php?action=showForm">Add Work</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
<?php echo $this->_tpl_vars['dg']; ?>

<input type="submit" name="submit" value="Delete">
</form>
<?php echo $this->_tpl_vars['paging']; ?>