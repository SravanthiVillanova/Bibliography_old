<form method="post">
<input type="hidden" name="id" value="{$attribute->id}">
<input type="hidden" name="action" value="handleAttrForm">
<table cellpadding="0" cellspacing="0" border="0" class="form">
  <tr>
    <th>Attribute:&nbsp;</th>
    <td><input type="text" name="attribute" value="{$attribute->field}">
  </tr>
  <tr>
    <th>Field Type:&nbsp;</th>
    <td>
      <input type="radio" name="type" value="Text"{if (($attribute->type == 'Text') || ($attribute->type == ''))} checked{/if}> Short Text<br>
      <input type="radio" name="type" value="Textarea"{if $attribute->type == 'Textarea'} checked{/if}> Long Text<br>
      <input type="radio" name="type" value="Checkbox"{if $attribute->type == 'Checkbox'} checked{/if}> True/False Box<br>
      <input type="radio" name="type" value="Select"{if $attribute->type == 'Select'} checked{/if}> Options Drop-Down<br>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Save">
  </tr>
</table>
</form>