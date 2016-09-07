<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:21
         compiled from work-form-category.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>


<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li class="active">Classification</li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['work']->id; ?>
">
<input type="hidden" name="view" value="category">
<input type="hidden" name="tab" value="category">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>Subject Tree: </td>
    <td>
      <table cellspacing="0" cellpadding="2" border="0">
<?php if ($this->_tpl_vars['selectedFolderList'] != ''): ?>
  <?php $_from = $this->_tpl_vars['selectedFolderList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['folderLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['folderLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['folder']):
        $this->_foreach['folderLoop']['iteration']++;
?>
        <tr>
          <td><input type="checkbox" name="removeFolder[]" value="<?php echo $this->_tpl_vars['folder']->id; ?>
"></td>
          <input type="hidden" name="new_folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]" value="<?php echo $this->_tpl_vars['folder']->id; ?>
">
          <?php $_from = $this->_tpl_vars['folder']->getParentChain(true); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
          <td>
            <select name="folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]'].value=this.value; this.form.submit();">
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
          </td>
          <?php endforeach; endif; unset($_from); ?>
          <td>
            <select name="folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['folder']->getSiblings(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['sibling']):
?>
              <?php if ($this->_tpl_vars['folder']->id == $this->_tpl_vars['sibling']->id): ?>
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
          </td>
          <td>
            <?php if (( $this->_tpl_vars['folder']->hasChildren() )): ?>
            <select name="folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[<?php echo $this->_foreach['folderLoop']['iteration']; ?>
]'].value=this.value; this.form.submit();">
              <option value=""></option>
              <?php $_from = $this->_tpl_vars['folder']->getChildren(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
              <option value="<?php echo $this->_tpl_vars['child']->id; ?>
"><?php echo $this->_tpl_vars['child']->number; ?>
 <?php echo $this->_tpl_vars['child']->{(($_var=$this->_tpl_vars['langVar']) && substr($_var,0,2)!='__') ? $_var : $this->trigger_error("cannot access property \"$_var\"")}; ?>
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
            <select name="folder_id[new]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[new]'].value=this.value; this.form.submit();">
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
          </td>
        </tr>
        <tr><td colspan="2"><input type="submit" name="removeFolderBtn" value="Remove" onClick="this.form.action.value='showForm';"></td></tr>
      </table>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
</form>