<form method="post">
<textarea name="test" rows="5" cols="50"></textarea><br>
<input type="submit" name="submitBtn" value="Save">
</form>

<hr>

<ul>
{foreach from=$testList item=item}
  <li>{$item->test}</li>
{/foreach}
</ul>
