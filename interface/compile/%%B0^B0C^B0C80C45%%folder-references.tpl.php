<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:38:22
         compiled from folder-references.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_format', 'folder-references.tpl', 18, false),)), $this); ?>
<form method="post" name="workForm">
<input type="hidden" name="action" value="handleReferences">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['folder']->id; ?>
">

Manage References:
      <table cellspacing="0" cellpadding="2" border="0">
<?php if ($this->_tpl_vars['selectedFolderList'] != ''): ?>
  <?php $_from = $this->_tpl_vars['selectedFolderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['folder']):
?>
        <tr>
          <td><input type="checkbox" name="removeFolder[]" value="<?php echo $this->_tpl_vars['folder']->id; ?>
"></td>
          <input type="hidden" name="new_folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]" value="<?php echo $this->_tpl_vars['folder']->id; ?>
">
          <?php $_from = $this->_tpl_vars['folder']->getParentChain(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
          <td>
            <select name="folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['parent']->getSiblings(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
              <?php if ($this->_tpl_vars['parent']->id == $this->_tpl_vars['sibling']->id): ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
" selected><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php else: ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
"><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>
            </select>
          </td>
          <?php endforeach; endif; unset($_from); ?>
          <td>
            <select name="folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['folder']->getSiblings(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
              <?php if ($this->_tpl_vars['folder']->id == $this->_tpl_vars['sibling']->id): ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
" selected><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php else: ?>
              <option value="<?php echo $this->_tpl_vars['sibling']->id; ?>
"><?php echo $this->_tpl_vars['sibling']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['sibling']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>
            </select>
          </td>
          <td>
            <?php if (( $this->_tpl_vars['folder']->hasChildren() )): ?>
            <select name="folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[<?php echo $this->_tpl_vars['folder']->id; ?>
]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['folder']->getChildren(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
              <option value="<?php echo $this->_tpl_vars['child']->id; ?>
"><?php echo $this->_tpl_vars['child']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['child']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
            <?php endif; ?>
          </td>
        </tr>
  <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
        <tr>
          <td></td>
          <td>
            <input type="hidden" name="new_folder_id[new]" value="">
            <select name="folder_id[new]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[new]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['topFolderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['folder']):
?>
              <option value="<?php echo $this->_tpl_vars['folder']->id; ?>
"><?php echo $this->_tpl_vars['folder']->number; ?>
 <?php echo html_format(array('text' => $this->_tpl_vars['folder']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}), $this);?>
</option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="removeFolderBtn" value="Remove" onClick="this.form.action.value='showForm';">
            <input type="submit" name="submitBtn" value="Save">
          </td>
        </tr>
      </table>
</form>