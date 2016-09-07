<form method="post">
<input type="hidden" name="action" value="handleLocationDelete">
<input type="hidden" name="pub_id" value="{$publisher->id}">
  
<p>Are you sure you want to delete these?</p>
<ul>
  {foreach from=$locList item=location}
  <li>{$location->location}</li>
  <input type="hidden" name="id[]" value="{$location->id}">
  {/foreach}
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>