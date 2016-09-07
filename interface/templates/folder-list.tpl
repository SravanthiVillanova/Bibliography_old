<p>
{if $folder != ''}
<b>Viewing:</b>
<a href="tree.php">Top</a> &gt; 
{foreach from=$folder->getParentChain(true) item=parent}
  <a href="tree.php?id={$parent->id}">{$parent->$langVar}</a> &gt;
{/foreach}
{$folder->$langVar}
{/if}
</p>

<a href="tree.php?action=showForm&parent_id={$folder->id}">Add Branch</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
{$dg}
<input type="submit" name="submit" value="Delete">
</form>
{$paging}