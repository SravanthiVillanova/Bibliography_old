<form method="post">
<input type="hidden" name="action" value="handleAttrDelete">
  
<p>Are you sure you want to delete these?</p>
<ul>
  {foreach from=$attrList item=attr}
  <li>{$attr->field}</li>
  <input type="hidden" name="id[]" value="{$attr->id}">
  {/foreach}
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>