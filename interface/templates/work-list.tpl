<p align="center">
{foreach from=$letterList item="letter" name="letterLoop"}
  <a href="work.php?letter={$letter|urlEncode}{if $noFolder}&amp;noFolder{/if}">{$letter}</a>
  {if !$smarty.foreach.letterLoop.last}|{/if}
{/foreach}
</p>

<span style="float: right;">Records {$recordStart} - {$recordEnd} of {$recordCount}</span>
<a href="work.php?action=showForm">Add Work</a>
<form method="post">
<input type="hidden" name="action" value="showDelete">
{$dg}
<input type="submit" name="submit" value="Delete">
</form>
{$paging}