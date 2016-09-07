<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:24
         compiled from work-form-publisher.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>


<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li class="active">Publisher</li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['work']->id; ?>
">
<input type="hidden" name="view" value="publisher">
<input type="hidden" name="tab" value="publisher">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC">
          <th width="60">Lookup</th>
          <th width="80">Year From</th>
          <th width="80">Year To</th>
          <th>Publisher</th>
          <th>Location</th>
          <th width="60">Remove</th>
        </tr>
        <?php $_from = $this->_tpl_vars['publishList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pubLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pubLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['publish']):
        $this->_foreach['pubLoop']['iteration']++;
?>
        <tr>
          <td style="border-bottom: solid 1px #CCCCCC;">&nbsp;</td>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[<?php echo $this->_foreach['pubLoop']['iteration']; ?>
][start]" value="<?php echo $this->_tpl_vars['publish']->publish_year; ?>
" size="4" maxlength="4">
          </td>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[<?php echo $this->_foreach['pubLoop']['iteration']; ?>
][end]" value="<?php echo $this->_tpl_vars['publish']->publish_year_end; ?>
" size="4" maxlength="4">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[<?php echo $this->_foreach['pubLoop']['iteration']; ?>
][name]" value="<?php echo $this->_tpl_vars['publish']->name; ?>
" size="50">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[<?php echo $this->_foreach['pubLoop']['iteration']; ?>
][location]" value="<?php echo $this->_tpl_vars['publish']->location; ?>
" size="50">
          </td>
          <td bgcolor="#CCCCCC" align="center"><input type="checkbox" name="removePub[<?php echo $this->_foreach['pubLoop']['iteration']; ?>
]" value="<?php echo $this->_tpl_vars['publish']->id; ?>
"></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <tr style="background-color: #FFFFCC;">
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="button" value="Lookup" onClick="window.open('work.php?action=showPublisherLookup&row=0', 'lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
          </td>
          <td width="80" align="center" nowrap="true" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][start]" size="4" maxlength="4"><br>
          </td>
          <td width="80" align="center" nowrap="true" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][end]" size="4" maxlength="4">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][name]" size="50">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][location]" size="50">
          </td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        
        <tr>
          <td><input type="submit" name="submitBtn" value="Add" onClick="document.workForm.action.value='showForm';"></td>
          <td colspan="4"></td>
          <td><input type="submit" name="removePubBtn" value="Remove" onClick="document.workForm.action.value='showForm';"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
</form>