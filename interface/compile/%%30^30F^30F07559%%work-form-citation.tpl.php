<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:33
         compiled from work-form-citation.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>


<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li class="active">Citation</li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['work']->id; ?>
">
<input type="hidden" name="view" value="">
<input type="hidden" name="tab" value="citation">
<input type="hidden" name="attribute_id" value="">
<?php if ($this->_tpl_vars['worktype'] != null): ?>
<table cellspacing="0" cellpadding="4" border="0">
  <?php $_from = $this->_tpl_vars['worktype']->getAttributes(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attribute']):
?>
  <tr valign="top">
    <td><?php echo $this->_tpl_vars['attribute']->field; ?>
: </td>
    <td>
      <?php if ($this->_tpl_vars['attribute']->type == 'Text'): ?>
      <input type="text" name="field[<?php echo $this->_tpl_vars['attribute']->id; ?>
]" value="<?php echo $this->_tpl_vars['work']->getAttributeValue($this->_tpl_vars['attribute']->field); ?>
" size="50">
      <?php elseif ($this->_tpl_vars['attribute']->type == 'Textarea'): ?>
      <textarea name="field[<?php echo $this->_tpl_vars['attribute']->id; ?>
]" rows="5" cols="50"><?php echo $this->_tpl_vars['work']->getAttributeValue($this->_tpl_vars['attribute']->field); ?>
</textarea>
      <?php elseif ($this->_tpl_vars['attribute']->type == 'Checkbox'): ?>
      <input type="checkbox" name="field[<?php echo $this->_tpl_vars['attribute']->id; ?>
]" value="<?php echo $this->_tpl_vars['work']->getAttributeValue($this->_tpl_vars['attribute']->field); ?>
">
      <?php elseif ($this->_tpl_vars['attribute']->type == 'Select'): ?>
      <?php $this->assign('option', $this->_tpl_vars['work']->getAttributeValue($this->_tpl_vars['attribute']->field)); ?>
      <input type="hidden" name="option[<?php echo $this->_tpl_vars['attribute']->id; ?>
]" value="<?php echo $this->_tpl_vars['option']->id; ?>
">
      <?php if ($this->_tpl_vars['option']->id != ''): ?>
      <?php echo $this->_tpl_vars['option']->title; ?>

      <input type="button" value="Change" onClick="window.open('worktype.php?action=showOptionLookup&id=<?php echo $this->_tpl_vars['attribute']->id; ?>
','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      <input type="submit" name="removeOptionBtn" value="Remove" onClick="this.form.attribute_id.value='<?php echo $this->_tpl_vars['attribute']->id; ?>
'; this.form.view.value='citation';">
      <?php else: ?>
      <input type="button" value="Lookup" onClick="window.open('worktype.php?action=showOptionLookup&id=<?php echo $this->_tpl_vars['attribute']->id; ?>
','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      <?php endif; ?><br>
      <input type="text" name="field[<?php echo $this->_tpl_vars['attribute']->id; ?>
][0]" size="50">
      <?php endif; ?>
    </td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
<?php else: ?>
  Please choose a type under the General Tab.
<?php endif; ?>
</form>