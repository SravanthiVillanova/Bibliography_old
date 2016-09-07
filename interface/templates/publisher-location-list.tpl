<p><b>Publisher: </b> {$publisher->name}</p>

<a href="publisher.php?pub_id={$publisher->id}&action=showLocationForm">Add Location</a>
<form method="post">
<input type="hidden" name="action" value="processLocations">
<input type="hidden" name="pub_id" value="{$publisher->id}">
{$dg}

<table width="100%">
  <tr>
    <td><input type="submit" name="submit" value="Delete"></td>
    <td align="right"><input type="submit" name="submit" value="Merge"></td>
  </tr>
</table>

</form>
{$paging}