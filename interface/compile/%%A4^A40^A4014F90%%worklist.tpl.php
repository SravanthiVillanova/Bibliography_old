<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:35:46
         compiled from worklist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_format', 'worklist.tpl', 3, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['workList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['work']):
?>
<p class="branch">
  <img src="images/document2.png" alt="Work" align="center"><a href="work.php?id=<?php echo $this->_tpl_vars['work']->id; ?>
" class="node"><?php echo html_format(array('text' => $this->_tpl_vars['work']->title), $this);?>
</a>
</p>
<?php endforeach; endif; unset($_from); ?>