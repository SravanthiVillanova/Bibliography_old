<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$publisher->id}">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Name: </th><td><input type="text" name="name" value="{$publisher->name}" size="50" maxlength="100"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>