<form method="post">
<input type="hidden" name="action" value="handleDelete">
  
<p>Are you sure you want to delete these?</p>
<ul>
  {foreach from=$workList item=work}
  <li>{$work->title}</li>
  <input type="hidden" name="id[]" value="{$work->id}">
  {/foreach}
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>