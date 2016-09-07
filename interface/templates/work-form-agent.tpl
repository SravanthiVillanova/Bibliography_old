{$message}

<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li class="active">Agents</li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="{$work->id}">
<input type="hidden" name="view" value="agent">
<input type="hidden" name="tab" value="agent">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC">
          <th>Lookup</th><th>Agent Type</th><th>First Name</th><th>Last Name</th><th>Alternate Name</th><th>Organization Name</th><th>Remove</th>
        </tr>
        {if $work->id != ''}
        {foreach from=$work->getAgents() item=agent name="agentLoop"}
        <tr>
          <td bgcolor="#CCCCCC"></td>
          <td><select name="agent[{$smarty.foreach.agentLoop.iteration}][type]"><option value=""></option>{html_options options=$agentTypeList selected=$agent->agenttype_id}</select></td>
          <td><input type="text" name="agent[{$smarty.foreach.agentLoop.iteration}][fname]" value="{$agent->fname}" size="30"></td>
          <td><input type="text" name="agent[{$smarty.foreach.agentLoop.iteration}][lname]" value="{$agent->lname}" size="30"></td>
          <td><input type="text" name="agent[{$smarty.foreach.agentLoop.iteration}][altname]" value="{$agent->alternate_name}" size="30"></td>
          <td><input type="text" name="agent[{$smarty.foreach.agentLoop.iteration}][orgname]" value="{$agent->organization_name}" size="30"></td>
          <td bgcolor="#CCCCCC" align="center"><input type="checkbox" name="removeAgent[]" value="{$agent->id}"></td>
        </tr>
        {/foreach}
        <tr>
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row=0', 'lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');"></td>
          <td><select name="agent[0][type]"><option value=""></option>{html_options options=$agentTypeList}</select></td>
          <td><input type="text" name="agent[0][fname]" size="30"></td>
          <td><input type="text" name="agent[0][lname]" size="30"></td>
          <td><input type="text" name="agent[0][altname]" size="30"></td>
          <td><input type="text" name="agent[0][orgname]" size="30"></td>
          <td bgcolor="#CCCCCC"></td>
        </tr>
        {else}
        {section name=loop loop=5}
        <tr>
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row={$smarty.section.loop.iteration-1}','lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');"></td>
          <td><select name="agent[{$smarty.section.loop.iteration-1}][type]"><option value=""></option>{html_options options=$agentTypeList}</select></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][fname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][lname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][altname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][orgname]" size="30"></td>
          <td bgcolor="#CCCCCC"></td>
        </tr>
        {/section}
        {/if}
        <tr>
          <td><input type="submit" name="submitBtn" value="Add" onClick="this.form.action.value='showForm';"></td>
          <td colspan="5"></td>
          <td bgcolor="#CCCCCC"><input type="submit" name="removeAgentBtn" value="Remove" onClick="this.form.action.value='showForm';"></td>
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