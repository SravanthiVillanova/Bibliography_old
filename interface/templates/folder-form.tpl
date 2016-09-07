<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$folder->id}">
{$message|escape}
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Sort Order: </th><td><input type="text" name="number" value="{$folder->sort_order}" size="5"></td></tr>
  <tr>
    <th>Parent: </th>
    <td>
      <select name="parent_id">
        <option value=""></option>
        {foreach from=$folderList item=parent}
          {if $folder->parent_id == $parent->id}
          <option value="{$parent->id}" selected>{$parent->$langVar}</option>
          {else}
          <option value="{$parent->id}">{$parent->$langVar}</option>
          {/if}
        {/foreach}
      </select>
    </td>
  </tr>
  <tr><th>English Title: </th><td><input type="text" name="title_en" value="{$folder->text_en}" size="50" maxlength="200"></td></tr>
  <tr><th>French Title: </th><td><input type="text" name="title_fr" value="{$folder->text_fr}" size="50" maxlength="200"></td></tr>
  <tr><th>German Title: </th><td><input type="text" name="title_de" value="{$folder->text_de}" size="50" maxlength="200"></td></tr>
  <tr><th>Dutch Title: </th><td><input type="text" name="title_nl" value="{$folder->text_nl}" size="50" maxlength="200"></td></tr>
  <tr><th>Spanish Title: </th><td><input type="text" name="title_es" value="{$folder->text_es}" size="50" maxlength="200"></td></tr>
  <tr><th>Italian Title: </th><td><input type="text" name="title_it" value="{$folder->text_it}" size="50" maxlength="200"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>