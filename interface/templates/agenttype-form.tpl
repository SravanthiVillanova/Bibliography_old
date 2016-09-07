{$message}
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$type->id}">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Type: </th><td><input type="text" name="type" value="{$type->type}"></td></tr>
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>
