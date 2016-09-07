<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 20:03:20
         compiled from agent-merge.tpl */ ?>
<form method="post" name="mergeForm">
<input type="hidden" name="action" value="showMerge">
<input type="hidden" name="source_id" value="<?php echo $this->_tpl_vars['source']->id; ?>
">
<input type="hidden" name="end_id" value="<?php echo $this->_tpl_vars['end']->id; ?>
">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td width="50%">
      <b>Source Agent</b><br>
      <?php if ($this->_tpl_vars['source']): ?>
      <?php echo $this->_tpl_vars['source']->fname; ?>
 <?php echo $this->_tpl_vars['source']->lname; ?>

      <?php else: ?>
      <table cellspacing="0" cellpadding="4" border="0">
        <tr><th>Find: </th><td><input type="text" name="source" value="<?php echo $this->_tpl_vars['source']->name; ?>
" size="50" maxlength="100"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            <?php if ($this->_tpl_vars['dgSource']): ?>
            <?php echo $this->_tpl_vars['dgSource']; ?>

            <input type="submit" name="submit" value="Select">
            <?php endif; ?>
          </td>
        </tr>
      </table>
      <?php endif; ?>
    </td>
    <td width="50%">
      <b>Destination Agent</b><Br>
      <?php if ($this->_tpl_vars['end']): ?>
      <?php echo $this->_tpl_vars['end']->fname; ?>
 <?php echo $this->_tpl_vars['end']->lname; ?>

      <?php else: ?>
      <table cellspacing="0" cellpadding="4" border="0">
        <tr>
          <th>Find: </th>
          <td><input type="text" name="end" value="<?php echo $this->_tpl_vars['end']->name; ?>
" size="50" maxlength="100"<?php if (! $this->_tpl_vars['source']): ?> DISABLED<?php endif; ?>></td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            <?php if ($this->_tpl_vars['dgDestination']): ?>
            <?php echo $this->_tpl_vars['dgDestination']; ?>

            <input type="submit" name="submit" value="Select">
            <?php endif; ?>
          </td>
        </tr>
      </table>
      <?php endif; ?>
    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center">
      <?php if ($this->_tpl_vars['source']->id && $this->_tpl_vars['end']->id): ?>
      <input type="submit" name="submit" value="Merge" onClick="document.mergeForm.action.value='processMerge';">
      <?php endif; ?>
      <input type="button" name="submit" value="Clear" onClick="document.location.href='agent.php?action=showMerge';">
    </td>
  </tr>
</table>
</form>