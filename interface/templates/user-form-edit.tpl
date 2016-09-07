{$message}
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$edituser->id}">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Name: </th><td><input type="text" name="fname" value="{$edituser->name}"></td></tr>
  <tr><th>Username: </th><td><input type="text" name="username" value="{$edituser->username}"></td></tr>
  <tr>
    <th>Access Level: </th>
    <td>
      <select name="level">
        <option value="1"{if $edituser->level == "1"} selected{/if}>Administrator</option>
        <option value="0"{if $edituser->level == "0"} selected{/if}>Super User</option>
        <option value=""{if $edituser->level == ""} selected{/if}>User</option>
      </select>
    </td>
  </tr>
  {if $user->isAdmin()}
  <tr><th>Password: </th><td><input type="password" name="password"></td></tr>
  <tr><th>Password Again: </th><td><input type="password" name="password2"></td></tr>
  {/if}
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>
