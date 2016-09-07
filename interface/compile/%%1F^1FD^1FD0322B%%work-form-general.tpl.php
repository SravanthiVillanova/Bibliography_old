<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:59:42
         compiled from work-form-general.tpl */ ?>
<?php echo '
<script type="text/javascript">
  // This function allows for inserting certain HTML tags into a textarea box.
  function insertTag (tag)
  {
      var str = document.selection.createRange().text;
      var endtag = tag.split(\' \');

      if (!document.selection) return;

      if (!str) {
          alert (\'Please highlight the text you would like to format\');
          return;
      }

      document.selection.createRange().text = \'<\' + tag + \'>\' + str + \'</\' + endtag[0] + \'>\';
  }
</script>
'; ?>


<?php echo $this->_tpl_vars['message']; ?>


<ul class="tabbar">
  <li class="active">General</li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['work']->id; ?>
">
<input type="hidden" name="view" value="">
<input type="hidden" name="tab" value="general">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>Title: </td>
    <td><input type="text" name="title" value="<?php echo $this->_tpl_vars['work']->title; ?>
" size="80"> <input type="submit" name="searchBtn" value="Lookup" onClick="this.form.action.value='showLookup';"></td>
  </tr>
  <tr>
    <td>Sub Title: </td>
    <td><input type="text" name="subtitle" value="<?php echo $this->_tpl_vars['work']->subtitle; ?>
" size="80"></td>
  </tr>
  <tr>
    <td>Parallel Title: </td>
    <td><input type="text" name="ptitle" value="<?php echo $this->_tpl_vars['work']->paralleltitle; ?>
" size="80"></td>
  </tr>
  <tr>
    <td>Description: </td>
    <td><textarea name="description" rows="4" cols="60"><?php echo $this->_tpl_vars['work']->description; ?>
</textarea></td>
  </tr>
  <?php if ($this->_tpl_vars['isIE']): ?>
  <tr>
    <td></td>
    <td>
      <input type="button" name="buttonBold" value="B"
             onClick="insertTag('b');" style="font-weight: bold;">
      <input type="button" name="buttonItalic" value="i"
             onClick="insertTag('i');" style="font-style: italic;">
      <input type="button" name="buttonUnder" value="U"
             onClick="insertTag('u');" style="text-decoration: underline;">
    </td>
  </tr>
  <?php endif; ?>
  <tr>
    <td>Type: </td>
    <td>
      <select name="type">
        <option value="">Choose Type</option>
      <?php $_from = $this->_tpl_vars['typeList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['type']):
?>
        <?php if ($this->_tpl_vars['type']->id == $this->_tpl_vars['work']->type_id): ?>
        <option value="<?php echo $this->_tpl_vars['type']->id; ?>
" selected><?php echo $this->_tpl_vars['type']->type; ?>
</option>
        <?php else: ?>
        <option value="<?php echo $this->_tpl_vars['type']->id; ?>
"><?php echo $this->_tpl_vars['type']->type; ?>
</option>
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>Parent Work: </td>
    <td>
      <input type="hidden" name="work_id" value="<?php echo $this->_tpl_vars['work']->work_id; ?>
">
      <?php if ($this->_tpl_vars['parent']): ?>
      <?php echo $this->_tpl_vars['parent']->title; ?>

      <input type="button" value="Change" onClick="window.open('work.php?action=showWorkLookup','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      <input type="submit" name="removeParentBtn" value="Remove" onClick="this.form.action.value='showForm';">
      <?php else: ?>
      <input type="button" value="Lookup" onClick="window.open('work.php?action=showWorkLookup','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td>Status: </td>
    <td>
      <input type="radio" name="status" value=""<?php if ($this->_tpl_vars['work']->status === null): ?> checked<?php endif; ?>> In Progress<br>
      <input type="radio" name="status" value="0"<?php if ($this->_tpl_vars['work']->status == '0'): ?> checked<?php endif; ?>> Pending Review<br>
      <input type="radio" name="status" value="2"<?php if ($this->_tpl_vars['work']->status == '2'): ?> checked<?php endif; ?>> Unseen Source Doc<br>
      <?php if ($this->_tpl_vars['user']->hasAccess('0')): ?>
      <input type="radio" name="status" value="1"<?php if ($this->_tpl_vars['work']->status == '1'): ?> checked<?php endif; ?>> Complete
      <?php endif; ?>
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