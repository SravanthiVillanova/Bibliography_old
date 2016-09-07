<ul>
{foreach from=$folderList item=folder}
  <li><a href="treeview.php?id={$folder->id}">{html_format text=$folder->$langVar}</a></li>
{foreachelse}
  <li>No search results found</li>
{/foreach}
</ul>