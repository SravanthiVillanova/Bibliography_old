<p align="center">
{foreach from=$letterList item="letter" name="letterLoop"}
  <a href="publisher.php?letter={$letter|urlEncode}">{$letter}</a>
  {if !$smarty.foreach.letterLoop.last}|{/if}
{/foreach}
</p>

<a href="publisher.php?action=showForm">Add Publisher</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
{$dg}
<input type="submit" name="submit" value="Delete">
</form>
{$paging}