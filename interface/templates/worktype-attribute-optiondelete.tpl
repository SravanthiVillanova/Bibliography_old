<form method="post">
<input type="hidden" name="action" value="handleoptionDelete">
  
<p>Are you sure you want to delete these?</p>
<ul>
  {foreach from=$optionList item=option}
  <li>{$option->title}</li>
  <input type="hidden" name="id[]" value="{$option->id}">
  {/foreach}
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>