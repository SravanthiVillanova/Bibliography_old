<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:46:38
         compiled from worktype-attributemerge.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'worktype-attributemerge.tpl', 8, false),)), $this); ?>
<?php if (count ( $this->_tpl_vars['merged'] ) > 0): ?>
  <?php if ($this->_tpl_vars['forReal'] == 1): ?>
    <p>Merge complete.</p>
  <?php else: ?>
    <b>Duplicates to merge:</b>
    <ul>
    <?php $_from = $this->_tpl_vars['merged']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['title']):
?>
      <li><?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</li>
    <?php endforeach; endif; unset($_from); ?>
    </ul>
    <form method="get" action="">
      <input type="hidden" name="action" value="mergeDuplicateOptions"/>
      <input type="hidden" name="id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['attrib_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
      <input type="hidden" name="forreal" value="1"/>
      <input type="submit" value="Fix Now"/>
    </form>
  <?php endif; ?>
<?php else: ?>
  <p>No duplicates.</p>
<?php endif; ?>