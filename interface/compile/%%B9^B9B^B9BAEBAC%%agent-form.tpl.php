<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:18:23
         compiled from agent-form.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['agent']->id; ?>
">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>First Name: </th><td><input type="text" name="fname" value="<?php echo $this->_tpl_vars['agent']->fname; ?>
"></td></tr>
  <tr><th>Last Name: </td><th><input type="text" name="lname" value="<?php echo $this->_tpl_vars['agent']->lname; ?>
"></td></tr>
  <tr><th>Alternate Name: </th><td><input type="text" name="altname" value="<?php echo $this->_tpl_vars['agent']->alternate_name; ?>
"></td></tr>
  <tr><th>Organization Name: </th><td><input type="text" name="orgname" value="<?php echo $this->_tpl_vars['agent']->organization_name; ?>
"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>