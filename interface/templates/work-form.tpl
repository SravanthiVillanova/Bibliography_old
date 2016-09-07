<form method="post" name="workForm" action="work.php">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="id" value="{$work->id}">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>{$translator->translate('Title')}: </td>
    <td><input type="text" name="title" value="{html_format text=$work->title}" size="80"> <input type="submit" name="searchBtn" value="Lookup" onClick="this.form.action.value='showLookup';"></td>
  </tr>
  <tr>
    <td>{$translator->translate('SubTitle')}: </td>
    <td><input type="text" name="subtitle" value="{html_format text=$work->subtitle}" size="80"></td>
  </tr>
  <tr>
    <td>{$translator->translate('Parallel Title')}: </td>
    <td><input type="text" name="ptitle" value="{html_format text=$work->paralleltitle}" size="80"></td>
  </tr>
  <tr>
    <td>{$translator->translate('Description')}: </td>
    <td><textarea name="description" rows="3" cols="60">{html_format text=$work->description}</textarea></td>
  </tr>
  <tr>
    <td>{$translator->translate('Agent')}(s): </td>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC">
          <th>Lookup</th><th>Agent Type</th><th>First Name</th><th>Last Name</th><th>Alternate Name</th><th>Organization Name</th><th>Remove</th>
        </tr>
        {if $work->id != ''}
        {foreach from=$work->getAgents() item=agent}
        <tr>
          <td bgcolor="#CCCCCC"></td>
          <td><select name="agent[{$agent->id}][type]"><option value=""></option>{html_options options=$agentTypeList selected=$agent->getTypeId($work)}</select></td>
          <td><input type="text" name="agent[{$agent->id}][fname]" value="{html_format text=$agent->fname}" size="30"></td>
          <td><input type="text" name="agent[{$agent->id}][lname]" value="{html_format text=$agent->lname}" size="30"></td>
          <td><input type="text" name="agent[{$agent->id}][altname]" value="{html_format text=$agent->alternate_name}" size="30"></td>
          <td><input type="text" name="agent[{$agent->id}][orgname]" value="{html_format text=$agent->organization_name}" size="30"></td>
          <td bgcolor="#CCCCCC" align="center"><input type="checkbox" name="removeAgent[]" value="{$agent->id}"></td>
        </tr>
        {/foreach}
        <tr>
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row=0', 'lookup', 'height=300, width=750, location=no, menubar=no, scrollbars=no, status=no, toolbar=no, top=200, left=200');"></td>
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
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row={$smarty.section.loop.iteration-1}','lookup', 'height=300, width=750, location=no, menubar=no, scrollbars=no, status=no, toolbar=no, top=200, left=200');"></td>
          <td><select name="agent[{$smarty.section.loop.iteration-1}][type]"><option value=""></option>{html_options options=$agentTypeList}</select></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][fname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][lname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][altname]" size="30"></td>
          <td><input type="text" name="agent[{$smarty.section.loop.iteration-1}][orgname]" size="30"></td>
          <td bgcolor="#CCCCCC"></td>
        </tr>
        {/section}
        {/if}
        <tr><td colspan="6"></td><td bgcolor="#CCCCCC"><input type="submit" name="removeAgentBtn" value="Remove" onClick="this.form.action.value='showForm';"></td></tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>{$translator->translate('Publish Date')}: </td>
    <td>
      <select name="publish_month">
        <option label="" value=""></option>
        <option label="January" value="01"{if $work->publish_month == 01}checked{/if}>January</option>
        <option label="February" value="02"{if $work->publish_month == 02}checked{/if}>February</option>
        <option label="March" value="03"{if $work->publish_month == 03}checked{/if}>March</option>
        <option label="April" value="04"{if $work->publish_month == 04}checked{/if}>April</option>
        <option label="May" value="05"{if $work->publish_month == 05}checked{/if}>May</option>
        <option label="June" value="06"{if $work->publish_month == 06}checked{/if}>June</option>
        <option label="July" value="07"{if $work->publish_month == 07}checked{/if}>July</option>
        <option label="August" value="08"{if $work->publish_month == 08}checked{/if}>August</option>
        <option label="September" value="09"{if $work->publish_month == 09}checked{/if}>September</option>
        <option label="October" value="10"{if $work->publish_month == 10}checked{/if}>October</option>
        <option label="November" value="11"{if $work->publish_month == 11}checked{/if}>November</option>
        <option label="December" value="12"{if $work->publish_month == 12}checked{/if}>December</option>
      </select>
      <input type="text" name="publish_year" value="{$work->publish_year}" size="4" maxlength="4">
    </td>
  </tr>
  <tr>
    <td>{$translator->translate('Publisher')}: </td>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC"><th>Existing {$translator->translate('Publisher')}</th><th>OR</th><th>Name</th><th>Location</th></tr>
        <tr>
          <td>
            <select name="publisher_id">
              <option value=""></option>
              {html_options options=$publisherList selected=$work->publisher_id}
            </select>
          </td>
          <td></td>
          <td><input type="text" name="publisher_name" size="40"></td>
          <td><input type="text" name="publisher_location" size="30"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>{$translator->translate('Subject Tree')}: </td>
    <td>
      <table cellspacing="0" cellpadding="2" border="0">
{if $selectedFolderList != ''}
  {foreach from=$selectedFolderList item=folder}
        <tr>
          <td><input type="checkbox" name="removeFolder[]" value="{$folder->id}"></td>
          <input type="hidden" name="new_folder_id[{$folder->id}]" value="{$folder->id}">
          {foreach from=$folder->getParentChain(true) item=parent}
          <td>
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showForm'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$parent->getSiblings() item=sibling}
              {if $parent->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          {/foreach}
          <td>
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showForm'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getSiblings() item=sibling}
              {if $folder->id == $sibling->id}
              <option value="{$sibling->id}" selected>{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {else}
              <option value="{$sibling->id}">{$sibling->number} {html_format text=$sibling->$langVar}</option>
              {/if}
              {/foreach}
            </select>
          </td>
          <td>
            {if ($folder->hasChildren())}
            <select name="folder_id[{$folder->id}]" onChange="this.form.action.value='showForm'; document.forms[1].elements['new_folder_id[{$folder->id}]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$folder->getChildren() item=child}
              <option value="{$child->id}">{$child->number} {html_format text=$child->$langVar}</option>
              {/foreach}
            </select>
            {/if}
          </td>
        </tr>
  {/foreach}
{/if}
        <tr>
          <td></td>
          <td>
            <input type="hidden" name="new_folder_id[new]" value="">
            <select name="folder_id[new]" onChange="this.form.action.value='showForm'; document.forms[1].elements['new_folder_id[new]'].value=this.value; this.form.submit();">
              <option value=""></option>
              {foreach from=$topFolderList item=folder}
              <option value="{$folder->id}">{$folder->number} {html_format text=$folder->$langVar}</option>
              {/foreach}
            </select>
          </td>
        </tr>
        <tr><td colspan="2"><input type="submit" name="removeFolderBtn" value="Remove" onClick="this.form.action.value='showForm';"></td></tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>{$translator->translate('Type')}: </td>
    <td>
      <select name="type" onChange="this.form.action.value='showForm'; this.form.submit();">
        <option value="">Choose Type</option>
      {foreach from=$typeList item=type}
        {if $type->id == $work->type_id}
        <option value="{$type->id}" selected>{html_format text=$translator->translate($type->type)}</option>
        {else}
        <option value="{$type->id}">{html_format text=$translator->translate($type->type)}</option>
        {/if}
      {/foreach}
      </select>
    </td>
  </tr>
  {if $worktype != null}
  {foreach from=$worktype->getAttributes() item=attribute}
  <tr>
    <td>{$translator->translate($attribute->field)}: </td>
    <td>
      {if $attribute->type == "Text"}
      <input type="text" name="field[{$attribute->id}]" value="{html_format text=$work->getAttributeValue($attribute->field)}" size="50">
      {elseif $attribute->type == "Textbox"}
      <textarea name="field[{$attribute->id}]">{html_format text=$work->getAttributeValue($attribute->field)}</texarea>
      {elseif $attribute->type == "Checkbox"}
      <input type="checkbox" name="field[{$attribute->id}]" value="{html_format text=$work->getAttributeValue($attribute->field)}">
      {/if}
    </td>
      
  </tr>
  {/foreach}
  {/if}
  <tr>
    <td>{$translator->translate('Status')}: </td>
    <td>
      <input type="radio" name="status" value=""{if $work->status === null} checked{/if}> In Progress<br>
      <input type="radio" name="status" value="0"{if $work->status == '0'} checked{/if}> Pending Review<br>
      <input type="radio" name="status" value="2"{if $work->status == '2'} checked{/if}> Unseen Source Doc<br>
      {if $user->isAdmin()}
      <input type="radio" name="status" value="1"{if $work->status == '1'} checked{/if}> Complete
      {/if}
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="submitBtn" value="Save & Add Another">
      <input type="submit" name="submitBtn" value="Save This Work">
    </td>
  </tr>
</table>
</form>