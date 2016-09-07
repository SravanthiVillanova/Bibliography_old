<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:38:04
         compiled from folder-form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'folder-form.tpl', 4, false),)), $this); ?>
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['folder']->id; ?>
">
<?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Sort Order: </th><td><input type="text" name="number" value="<?php echo $this->_tpl_vars['folder']->sort_order; ?>
" size="5"></td></tr>
  <tr>
    <th>Parent: </th>
    <td>
      <select name="parent_id">
        <option value=""></option>
        <?php $_from = $this->_tpl_vars['folderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
          <?php if ($this->_tpl_vars['folder']->parent_id == $this->_tpl_vars['parent']->id): ?>
          <option value="<?php echo $this->_tpl_vars['parent']->id; ?>
" selected><?php echo $this->_tpl_vars['parent']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
          <?php else: ?>
          <option value="<?php echo $this->_tpl_vars['parent']->id; ?>
"><?php echo $this->_tpl_vars['parent']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </select>
    </td>
  </tr>
  <tr><th>English Title: </th><td><input type="text" name="title_en" value="<?php echo $this->_tpl_vars['folder']->text_en; ?>
" size="50" maxlength="200"></td></tr>
  <tr><th>French Title: </th><td><input type="text" name="title_fr" value="<?php echo $this->_tpl_vars['folder']->text_fr; ?>
" size="50" maxlength="200"></td></tr>
  <tr><th>German Title: </th><td><input type="text" name="title_de" value="<?php echo $this->_tpl_vars['folder']->text_de; ?>
" size="50" maxlength="200"></td></tr>
  <tr><th>Dutch Title: </th><td><input type="text" name="title_nl" value="<?php echo $this->_tpl_vars['folder']->text_nl; ?>
" size="50" maxlength="200"></td></tr>
  <tr><th>Spanish Title: </th><td><input type="text" name="title_es" value="<?php echo $this->_tpl_vars['folder']->text_es; ?>
" size="50" maxlength="200"></td></tr>
  <tr><th>Italian Title: </th><td><input type="text" name="title_it" value="<?php echo $this->_tpl_vars['folder']->text_it; ?>
" size="50" maxlength="200"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>