<form method="post" name="mergeForm" action="tree.php">
<input type="hidden" name="action" value="processMerge">
<input type="hidden" name="confirm" value="no">
{$message|escape}
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>
      <b>Source Classification:</b>
    </td>
    <td>
      {if !empty($sourceFolder)}
        <input type="hidden" name="source_folder" value="{$sourceFolder->id}">
        {foreach from=$sourceFolder->getParentChain(true) item=parent}
          {foreach from=$parent->getSiblings() item=sibling}
            {if $parent->id == $sibling->id}
              <span>{$sibling->number} {$sibling->$langVar}</span>
            {/if}
          {/foreach}
        {/foreach}

        {foreach from=$sourceFolder->getSiblings() item=sibling}
          {if $sourceFolder->id == $sibling->id}
            <span>{$sibling->number} {$sibling->$langVar}</span>
          {/if}
        {/foreach}
      {/if}
    </td>
  </tr>
  <tr><td>ID:</td><td>{$sourceFolder->id|escape}</td></tr>
  <tr><td>Works:</td><td>{$sourceWorks|escape}</td></tr>
  <tr><td>Child Classifications:</td><td>{$sourceChildren|escape}</td></tr>
  <tr>
    <td>
      <b>Destination Classification:</b>
    </td>
    <td>
      {if !empty($destFolder)}
        <input type="hidden" name="dest_folder" value="{$destFolder->id}">
        {foreach from=$destFolder->getParentChain(true) item=parent}
          {foreach from=$parent->getSiblings() item=sibling}
            {if $parent->id == $sibling->id}
              <span>{$sibling->number} {$sibling->$langVar}</span>
            {/if}
          {/foreach}
        {/foreach}

        {foreach from=$destFolder->getSiblings() item=sibling}
          {if $destFolder->id == $sibling->id}
            <span>{$sibling->number} {$sibling->$langVar}</span>
          {/if}
        {/foreach}
      {/if}
    </td>
  </tr>
  <tr><td>ID:</td><td>{$destFolder->id|escape}</td></tr>
  <tr><td>Works:</td><td>{$destWorks|escape}</td></tr>
  <tr><td>Child Classifications:</td><td>{$destChildren|escape}</td></tr>
  <tr>
    <td colspan="2" align="center">
      Are you sure you wish to merge these classifications?<br />
      {if !empty($sourceFolder) && !empty($destFolder)}
      <input type="submit" value="Yes" onClick="document.mergeForm.confirm.value='yes';">
      {/if}
      <input type="submit" value="No" onClick="document.mergeForm.action.value='showMerge';">
    </td>
  </tr>
</table>
</form>