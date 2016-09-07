<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:38:13
         compiled from folder-move.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'folder-move.tpl', 4, false),)), $this); ?>
<form method="post" name="workForm">
<input type="hidden" name="action" value="showMove">
<input type="hidden" name="new_parent_id" value="<?php echo $this->_tpl_vars['folder']->id; ?>
">
<?php echo ((is_array($_tmp=$this->_tpl_vars['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>


<table cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>
      <b>Choose parent element:</b><Br>
      <?php if (! empty ( $this->_tpl_vars['destFolder'] )): ?>
        <input type="hidden" name="dest_folder" value="<?php echo $this->_tpl_vars['destFolder']->id; ?>
">
        <?php $_from = $this->_tpl_vars['destFolder']->getParentChain(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
          <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
            <option value=""></option>
            <?php $_from = $this->_tpl_vars['parent']->getSiblings(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
              <?php if ($this->_tpl_vars['parent']->id == $this->_tpl_vars['sibling']->id): ?>
                <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
" selected><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
              <?php else: ?>
                <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
"><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
              <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
          </select>
        <?php endforeach; endif; unset($_from); ?>

        <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          <?php $_from = $this->_tpl_vars['destFolder']->getSiblings(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
            <?php if ($this->_tpl_vars['destFolder']->id == $this->_tpl_vars['sibling']->id): ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
" selected><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
            <?php else: ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
"><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
            <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
        </select>

        <?php if (( $this->_tpl_vars['destFolder']->hasChildren() )): ?>
          <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
            <option value=""></option>
            <?php $_from = $this->_tpl_vars['destFolder']->getChildren(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
              <option value="<?php echo $this->_tpl_vars['child']->id; ?>
"><?php echo $this->_tpl_vars['child']->number; ?>
 <?php echo $this->_tpl_vars['child']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
        <?php endif; ?>
      <?php else: ?>
        <input type="hidden" name="dest_folder" value="">
        <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          <?php $_from = $this->_tpl_vars['topFolderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['folder']):
?>
            <option value="<?php echo $this->_tpl_vars['folder']->id; ?>
"><?php echo $this->_tpl_vars['folder']->number; ?>
 <?php echo $this->_tpl_vars['folder']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
</option>
          <?php endforeach; endif; unset($_from); ?>
        </select>
      <?php endif; ?>
    </td>
  </tr>
</table>
<input type="submit" name="submitBtn" value="Save" onClick="document.workForm.action.value='handleMove';">
</form>