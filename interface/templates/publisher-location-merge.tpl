<form method="post">
<input type="hidden" name="action" value="handleLocationMerge">
<input type="hidden" name="pub_id" value="{$publisherId}">
<input type="hidden" name="master_id" value="{$master->id}">
  
<p>Are you sure you want to merge these?</p>
<ul>
  {foreach from=$locationList item=location}
  <li>{$location->location}</li>
  <input type="hidden" name="id[]" value="{$location->id}">
  {/foreach}
</ul>
<p>To: <b>{$master->location}</b></p>
<input type="hidden" name="master_id" value="{$master->id}">

<input type="submit" name="submit" value="Merge"> <input type="submit" name="submit" value="Cancel">
</form>