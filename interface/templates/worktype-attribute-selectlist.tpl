<b>Attributes for: </b>{$type->type}<br>
Used attributes are checked <input type="checkbox" checked disabled>
<form method="post">
<input type="hidden" name="action" value="handleAttrSelect">
<input type="hidden" name="type_id" value="{$type->id}">
{$dg}
<input type="submit" name="submit" value="Add/Remove">
</form>
{$paging}