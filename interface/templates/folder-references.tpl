<form method="post" name="workForm">
<input type="hidden" name="action" value="handleReferences">
<input type="hidden" name="id" value="{$folder->id}">

Manage References:
      <table cellspacing="0" cellpadding="2" border="0">
{if $selectedFolderList != ''}
  {foreach from=$selectedFolderList item=folder}
        <tr>
          <td><input type="checkbox" name="removeFolder[]" value="{$folder->id}"></td>
          <input type="hidden" name="new_folder_id[{$folder->id}]" value="{$folder->id}">
          {foreach from=$folder->getParentChain(true) item=parent}
          <td>
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$parent->getSiblings() item=sibling}
              {if $parent->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          {/foreach}
          <td>
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getSiblings() item=sibling}
              {if $folder->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          <td>
            {if ($folder->hasChildren())}
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getChildren() item=child}
              <option value="{$child->id}">{$child->number} {html_format text=$child->$langVar}</option>
              {/foreach}
            </select>
            {/if}
          </td>
        </tr>
  {/foreach}
{/if}
        <tr>
          <td></td>
          <td>
            <input type="hidden" name="new_folder_id[new]" value="">
            <select name="folder_id[new]" onChange="this.form.action.value='showReferences'; document.forms[1].elements['new_folder_id[new]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$topFolderList item=folder}
              <option value="{$folder->id}">{$folder->number} {html_format text=$folder->$langVar}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="removeFolderBtn" value="Remove" onClick="this.form.action.value='showForm';">
            <input type="submit" name="submitBtn" value="Save">
          </td>
        </tr>
      </table>
</form>