<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$type->id}">
<table cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>Type:&nbsp;</td>
    <td><input type="text" name="type" value="{$type->type}">
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>