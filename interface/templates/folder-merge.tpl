<form method="post" name="mergeForm" action="tree.php">
<input type="hidden" name="action" value="showMerge">
{$message|escape}
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>
      <b>Source Classification</b><br>
      {if !empty($sourceFolder)}
        <input type="hidden" name="source_folder" value="{$sourceFolder->id}">
        {foreach from=$sourceFolder->getParentChain(true) item=parent}
          <select onChange="this.form.elements['source_folder'].value=this.value; this.form.submit();">
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

        <select onChange="this.form.elements['source_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          {foreach from=$sourceFolder->getSiblings() item=sibling}
            {if $sourceFolder->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {$sibling->$langVar}</option>
            {else}
              <option value="{$sibling->id}">{$sibling->number} {$sibling->$langVar}</option>
            {/if}
          {/foreach}
        </select>

        {if ($sourceFolder->hasChildren())}
          <select onChange="this.form.elements['source_folder'].value=this.value; this.form.submit();">
            <option value=""></option>
            {foreach from=$sourceFolder->getChildren() item=child}
              <option value="{$child->id}">{$child->number} {$child->$langVar}</option>
            {/foreach}
          </select>
        {/if}
      {else}
        <input type="hidden" name="source_folder" value="">
        <select onChange="this.form.elements['source_folder'].value=this.value; this.form.submit();">
          <option value=""></option>
          {foreach from=$topFolderList item=folder}
            <option value="{$folder->id}">{$folder->number} {$folder->$langVar}</option>
          {/foreach}
        </select>
      {/if}
    </td>
  </tr>
  <tr>
    <td>
      <b>Destination Classification</b><Br>
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
  
  <tr>
    <td align="center">
      {if !empty($sourceFolder) && !empty($destFolder)}
      <input type="submit" value="Merge" onClick="document.mergeForm.action.value='processMerge';">
      {/if}
      <input type="button" value="Clear" onClick="document.location.href='tree.php?action=showMerge';">
    </td>
  </tr>
</table>
</form>