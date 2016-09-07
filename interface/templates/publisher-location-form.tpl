<form method="post">
<input type="hidden" name="action" value="handleLocationForm">
<input type="hidden" name="pub_id" value="{$location->publisher_id}">
<input type="hidden" name="id" value="{$location->id}">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>Publisher: </th><td>{$publisher->name}</td></tr>
  <tr><th>Location: </th><td><input type="text" name="location" value="{$location->location}" size="50" maxlength="100"></td></tr>
  <tr><th></th><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>