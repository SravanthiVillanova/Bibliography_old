<p><a href="admin/">Administration</a></p>

<div align="center">
<table cellpadding="4" cellspacing="0" border="0" width="100%" class="tree">
  <tr valign="top">
{foreach from=$rootList item=root name=root}
    <td width="33%">
      <a href="treeview.php?id={$root->id}" class="root">{$root->number} {$root->$langVar}</a><br>
      {foreach from=$root->getChildren($childrenPerCell) item=child name=child}
      <a href="treeview.php?id={$child->id}">{$child->$langVar}</a>{if !$smarty.foreach.child.last},{else}...{/if}
      {/foreach}
    </td>
  {if $smarty.foreach.root.iteration == $cellPerRow}
  </tr>
  <tr valign="top">
  {/if}
{/foreach}
        
</table>
</div>