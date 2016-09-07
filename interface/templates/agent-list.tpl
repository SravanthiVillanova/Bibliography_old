<p align="center">
{foreach from=$letterList item="letter" name="letterLoop"}
  <a href="agent.php?letter={$letter}">{$letter}</a>
  {if !$smarty.foreach.letterLoop.last}|{/if}
{/foreach}
</p>

<a href="agent.php?action=showForm">Add Agent</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
{$dg}
<input type="submit" name="submit" value="Delete">
</form>
{$paging}