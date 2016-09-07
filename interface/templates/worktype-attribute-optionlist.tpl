<b>Attribute: </b>{$attribute->field}<br>
<a href="worktype.php?action=showOptionForm&attribute_id={$attribute->id}">Add Option</a>
<form method="post">
<input type="hidden" name="action" value="showOptionDelete">
<input type="hidden" name="workattribute_id" value="{$attribute->id}">
{$dg}
<input type="submit" name="submit" value="Delete">
</form>
{$paging}