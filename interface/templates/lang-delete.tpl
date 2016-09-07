<form method="post">
<input type="hidden" name="action" value="handleDelete">
  
<p>Are you sure you want to delete this?</p>
<ul>
  <li>{$term}</li>
  <input type="hidden" name="term" value="{$term}">
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>