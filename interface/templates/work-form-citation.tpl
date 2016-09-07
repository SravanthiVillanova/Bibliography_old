{$message}

<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li class="active">Citation</li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="{$work->id}">
<input type="hidden" name="view" value="">
<input type="hidden" name="tab" value="citation">
<input type="hidden" name="attribute_id" value="">
{if $worktype != null}
<table cellspacing="0" cellpadding="4" border="0">
  {foreach from=$worktype->getAttributes() item=attribute}
  <tr valign="top">
    <td>{$attribute->field}: </td>
    <td>
      {if $attribute->type == "Text"}
      <input type="text" name="field[{$attribute->id}]" value="{$work->getAttributeValue($attribute->field)}" size="50">
      {elseif $attribute->type == "Textarea"}
      <textarea name="field[{$attribute->id}]" rows="5" cols="50">{$work->getAttributeValue($attribute->field)}</textarea>
      {elseif $attribute->type == "Checkbox"}
      <input type="checkbox" name="field[{$attribute->id}]" value="{$work->getAttributeValue($attribute->field)}">
      {elseif $attribute->type == "Select"}
      {assign var="option" value=$work->getAttributeValue($attribute->field)}
      <input type="hidden" name="option[{$attribute->id}]" value="{$option->id}">
      {if $option->id != ''}
      {$option->title}
      <input type="button" value="Change" onClick="window.open('worktype.php?action=showOptionLookup&id={$attribute->id}','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      <input type="submit" name="removeOptionBtn" value="Remove" onClick="this.form.attribute_id.value='{$attribute->id}'; this.form.view.value='citation';">
      {else}
      <input type="button" value="Lookup" onClick="window.open('worktype.php?action=showOptionLookup&id={$attribute->id}','lookup', 'height=400, width=600, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
      {/if}<br>
      <input type="text" name="field[{$attribute->id}][0]" size="50">
      {/if}
    </td>
  </tr>
  {/foreach}
  <tr>
    <td></td>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
{else}
  Please choose a type under the General Tab.
{/if}
</form>