<form method="post">
<input type="hidden" name="action" value="handleDelete">
  
<p>Are you sure you want to delete these?</p>
<ul>
  {foreach from=$folderList item=folder}
  {if $folder->hasChildren() || $folder->hasWorks()}
  <li class="error"><b>{$folder->$langVar}</b> Cannot be deleted due to dependencies!</li>
  {else}
  <li>{$folder->$langVar}</li>
  <input type="hidden" name="id[]" value="{$folder->id}">
  {/if}
  {/foreach}
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>