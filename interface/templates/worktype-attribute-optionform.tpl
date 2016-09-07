<form method="post">
<input type="hidden" name="id" value="{$option->id}">
<input type="hidden" name="attribute_id" value="{$attribute->id}">
<input type="hidden" name="action" value="handleOptionForm">
<table cellpadding="4" cellspacing="0" border="0" class="form">
  <tr>
    <th>Option:&nbsp;</th>
    <td><input type="text" name="title" value="{$option->title}" size="40">
  </tr>
  <tr>
    <th>Type:&nbsp;</th>
    <td><input type="text" name="value" value="{$option->value}" size="40">
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>