{$message}

<a href="users.php?action=showForm">Add User</a>
<form method="post">
<input type="hidden" name="action" value="handleList">
{$dg}
<input type="submit" name="submit" value="Delete" style="float: left;">
<input type="submit" name="submit" value="Save" style="float: right;">
</form>
{$paging}