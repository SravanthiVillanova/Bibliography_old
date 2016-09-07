{$message}

<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li class="active">Classification</li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="{$work->id}">
<input type="hidden" name="view" value="category">
<input type="hidden" name="tab" value="category">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>Subject Tree: </td>
    <td>
      <table cellspacing="0" cellpadding="2" border="0">
{if $selectedFolderList != ''}
  {foreach from=$selectedFolderList item=folder name="folderLoop"}
        <tr>
          <td><input type="checkbox" name="removeFolder[]" value="{$folder->id}"></td>
          <input type="hidden" name="new_folder_id[{$smarty.foreach.folderLoop.iteration}]" value="{$folder->id}">
          {foreach from=$folder->getParentChain(true) item=parent}
          <td>
            <select name="folder_id[{$smarty.foreach.folderLoop.iteration}]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[{$smarty.foreach.folderLoop.iteration}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$parent->getSiblings() item=sibling}
              {if $parent->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          {/foreach}
          <td>
            <select name="folder_id[{$smarty.foreach.folderLoop.iteration}]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[{$smarty.foreach.folderLoop.iteration}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getSiblings() item=sibling}
              {if $folder->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          <td>
            {if ($folder->hasChildren())}
            <select name="folder_id[{$smarty.foreach.folderLoop.iteration}]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[{$smarty.foreach.folderLoop.iteration}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getChildren() item=child}
              <option value="{$child->id}">{$child->number} {$child->$langVar}</option>
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
            <select name="folder_id[new]" onChange="this.form.action.value='showForm'; this.form.elements['new_folder_id[new]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$topFolderList item=folder}
              <option value="{$folder->id}">{$folder->number} {$folder->$langVar}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr><td colspan="2"><input type="submit" name="removeFolderBtn" value="Remove" onClick="this.form.action.value='showForm';"></td></tr>
      </table>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
</form>