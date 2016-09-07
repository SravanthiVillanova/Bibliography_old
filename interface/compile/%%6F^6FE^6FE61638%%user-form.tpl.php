<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:56:16
         compiled from user-form.tpl */ ?>
<?php echo $this->_tpl_vars['message']; ?>

<form method="post">
<input type="hidden" name="action" value="handleForm">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Name: </th><td><input type="text" name="fname"></td></tr>
  <tr>
    <th>Access Level: </th>
    <td>
      <select name="level">
        <option value="1">Administrator</option>
        <option value="0">Super User</option>
        <option value="">User</option>
      </select>
    </td>
  </tr>
  <tr><th>Username: </th><td><input type="text" name="username"></td></tr>
  <tr><th>Password: </th><td><input type="password" name="password"></td></tr>
  <tr><th>Password Again: </th><td><input type="password" name="password2"></td></tr>
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>