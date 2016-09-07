<form method="post" name="workForm">
<input type="hidden" name="action" value="showMove">
<input type="hidden" name="new_parent_id" value="{$folder->id}">
{$message|escape}

<table cellspacing="0" cellpadding="2" border="0">
  <tr>
    <td>
      <b>Choose parent element:</b><Br>
      {if !empty($destFolder)}
        <input type="hidden" name="dest_folder" value="{$destFolder->id}">
        {foreach from=$destFolder->getParentChain(true) item=parent}
          <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
            <option value=""></option>
            {foreach from=$parent->getSiblings() item=sibling}
              {if $parent->id == $sibling->id}
                <option value="{$sibling->id}" selected>{$sibling->number} {$sibling->$langVar}</option>
              {else}
                <option value="{$sibling->id}">{$sibling->number} {$sibling->$langVar}</option>
              {/if}
            {/foreach}
          </select>
        {/foreach}

        <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          {foreach from=$destFolder->getSiblings() item=sibling}
            {if $destFolder->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {$sibling->$langVar}</option>
            {else}
              <option value="{$sibling->id}">{$sibling->number} {$sibling->$langVar}</option>
            {/if}
          {/foreach}
        </select>

        {if ($destFolder->hasChildren())}
          <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
            <option value=""></option>
            {foreach from=$destFolder->getChildren() item=child}
              <option value="{$child->id}">{$child->number} {$child->$langVar}</option>
            {/foreach}
          </select>
        {/if}
      {else}
        <input type="hidden" name="dest_folder" value="">
        <select onChange="this.form.elements['dest_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          {foreach from=$topFolderList item=folder}
            <option value="{$folder->id}">{$folder->number} {$folder->$langVar}</option>
          {/foreach}
        </select>
      {/if}
    </td>
  </tr>
</table>
<input type="submit" name="submitBtn" value="Save" onClick="document.workForm.action.value='handleMove';">
</form>