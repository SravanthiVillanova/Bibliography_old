<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 20:01:55
         compiled from publisher-merge.tpl */ ?>
<form method="post" name="mergeForm">
<input type="hidden" name="action" value="showMerge">
<input type="hidden" name="source_publisher_id" value="<?php echo $this->_tpl_vars['source_publisher']->id; ?>
">
<input type="hidden" name="end_publisher_id" value="<?php echo $this->_tpl_vars['end_publisher']->id; ?>
">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>
      Source Publisher
      <table cellspacing="0" cellpadding="4" border="0">
        <tr><th>Find: </th><td><input type="text" name="source_publisher" value="<?php echo $this->_tpl_vars['source_publisher']->name; ?>
" size="50" maxlength="100"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            <?php if ($this->_tpl_vars['dgSource']): ?>
            <?php echo $this->_tpl_vars['dgSource']; ?>

            <input type="submit" name="submit" value="Select">
            <?php endif; ?>
            
            <?php if ($this->_tpl_vars['dgSourceLocations']): ?>
            <?php echo $this->_tpl_vars['dgSourceLocations']; ?>

            <?php endif; ?>
          </td>
        </tr>
      </table>
    </td>
    <td>
      Destination Publisher
      <table cellspacing="0" cellpadding="4" border="0">
        <tr>
          <th>Find: </th>
          <td><input type="text" name="end_publisher" value="<?php echo $this->_tpl_vars['end_publisher']->name; ?>
" size="50" maxlength="100"<?php if (! $this->_tpl_vars['source_publisher']): ?> DISABLED<?php endif; ?>></td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            <?php if ($this->_tpl_vars['dgDestination']): ?>
            <?php echo $this->_tpl_vars['dgDestination']; ?>

            <input type="submit" name="submit" value="Select">
            <?php endif; ?>
            
            <?php if ($this->_tpl_vars['dgDestinationLocations']): ?>
            <?php echo $this->_tpl_vars['dgDestinationLocations']; ?>

            <?php endif; ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center">
      <?php if ($this->_tpl_vars['source_publisher']->id && $this->_tpl_vars['end_publisher']->id): ?>
      <input type="submit" name="submit" value="Merge" onClick="document.mergeForm.action.value='processMerge';">
      <?php endif; ?>
      <input type="button" name="submit" value="Clear" onClick="document.location.href='publisher.php?action=showMerge';">
    </td>
  </tr>
</table>
</form>