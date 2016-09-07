{$message}

<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li class="active">Publisher</li>
  <li><a href="" onClick="document.workForm.view.value='agent'; document.workForm.submit(); return false;">Agents</a></li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="{$work->id}">
<input type="hidden" name="view" value="publisher">
<input type="hidden" name="tab" value="publisher">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC">
          <th width="60">Lookup</th>
          <th width="80">Year From</th>
          <th width="80">Year To</th>
          <th>Publisher</th>
          <th>Location</th>
          <th width="60">Remove</th>
        </tr>
        {foreach from=$publishList item=publish name="pubLoop"}
        <tr>
          <td style="border-bottom: solid 1px #CCCCCC;">&nbsp;</td>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[{$smarty.foreach.pubLoop.iteration}][start]" value="{$publish->publish_year}" size="4" maxlength="4">
          </td>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[{$smarty.foreach.pubLoop.iteration}][end]" value="{$publish->publish_year_end}" size="4" maxlength="4">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[{$smarty.foreach.pubLoop.iteration}][name]" value="{$publish->name}" size="50">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[{$smarty.foreach.pubLoop.iteration}][location]" value="{$publish->location}" size="50">
          </td>
          <td bgcolor="#CCCCCC" align="center"><input type="checkbox" name="removePub[{$smarty.foreach.pubLoop.iteration}]" value="{$publish->id}"></td>
        </tr>
        {/foreach}
        <tr style="background-color: #FFFFCC;">
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="button" value="Lookup" onClick="window.open('work.php?action=showPublisherLookup&row=0', 'lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');">
          </td>
          <td width="80" align="center" nowrap="true" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][start]" size="4" maxlength="4"><br>
          </td>
          <td width="80" align="center" nowrap="true" style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][end]" size="4" maxlength="4">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][name]" size="50">
          </td>
          <td style="border-bottom: solid 1px #CCCCCC;">
            <input type="text" name="publish[0][location]" size="50">
          </td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        
        <tr>
          <td><input type="submit" name="submitBtn" value="Add" onClick="document.workForm.action.value='showForm';"></td>
          <td colspan="4"></td>
          <td><input type="submit" name="removePubBtn" value="Remove" onClick="document.workForm.action.value='showForm';"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
</form>