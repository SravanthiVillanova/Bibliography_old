<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$agent->id}">
<table cellspacing="0" cellpadding="4" border="0" class="form">
  <tr><th>First Name: </th><td><input type="text" name="fname" value="{$agent->fname}"></td></tr>
  <tr><th>Last Name: </td><th><input type="text" name="lname" value="{$agent->lname}"></td></tr>
  <tr><th>Alternate Name: </th><td><input type="text" name="altname" value="{$agent->alternate_name}"></td></tr>
  <tr><th>Organization Name: </th><td><input type="text" name="orgname" value="{$agent->organization_name}"></td></tr>
  <tr><td></td><td><input type="submit" name="submitBtn" value="Save"></td></tr>
</table>
</form>