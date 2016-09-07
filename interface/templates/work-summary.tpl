<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <th align="right">{$translator->translate('Title')}: </th>
    <td>{$work->title}</td>
  </tr>
  <tr>
    <th align="right">{$translator->translate('SubTitle')}: </th>
    <td>{$work->subtitle}</td>
  </tr>
  <tr>
    <th align="right">{$translator->translate('Parallel Title')}: </th>
    <td>{$work->paralleltitle}</td>
  </tr>
  <tr>
    <th align="right">{$translator->translate('Description')}: </th>
    <td>{$work->description}</textarea></td>
  </tr>
  <tr>
    <th align="right" valign="top">{$translator->translate('Agent')}(s): </th>
    <td>
      <table cellspacing="0" cellpadding="0" border="0" width="600">
        <tr bgcolor="#CCCCCC" align="left">
          <th>Agent Type</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Alternate Name</th>
          <th>Organization Name</th>
        </tr>
        {foreach from=$work->getAgents() item=agent}
        <tr>
          <td width="100" style="border-bottom: solid 1px #CCCCCC;">{$agent->agenttype}&nbsp;</td>
          <td width="110" style="border-bottom: solid 1px #CCCCCC;">{$agent->fname}&nbsp;</td>
          <td width="110" style="border-bottom: solid 1px #CCCCCC;">{$agent->lname}&nbsp;</td>
          <td width="130" style="border-bottom: solid 1px #CCCCCC;">{$agent->alternate_name}&nbsp;</td>
          <td width="150" style="border-bottom: solid 1px #CCCCCC;">{$agent->organization_name}&nbsp;</td>
        </tr>
        {/foreach}
      </table>
    </td>
  </tr>
  <tr>
    <th align="right" valign="top">{$translator->translate('Published')}: </th>
    <td>
      <table cellspacing="0" cellpadding="0" border="0" width="600">
        <tr bgcolor="#CCCCCC" align="left">
          <th width="80">Year From</th>
          <th width="80">Year To</th>
          <th width="220">Publisher</th>
          <th width="220">Location</th>
        </tr>
        {foreach from=$publishList item=publish}
        <tr>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">{$publish->publish_year}&nbsp;</td>
          <td width="80" align="center" style="border-bottom: solid 1px #CCCCCC;">{$publish->publish_year_end}&nbsp;</td>
          <td width="220" style="border-bottom: solid 1px #CCCCCC;">{$publish->name}&nbsp;</td>
          <td width="220" style="border-bottom: solid 1px #CCCCCC;">{$publish->location}&nbsp;</td>
        </tr>
        {/foreach}
      </table>
    </td>
  </tr>
  {if $parent}
  <tr>
    <th align="right">{$translator->translate('Parent Work')}: </th>  
    <td>{$parent->title}</td>
  </tr>
  {/if}
  <tr>
    <th align="right" valign="top">{$translator->translate('Subject Tree')}: </th>
    <td>
    {foreach from=$branchList item=branch}
      <p>{$branch}</p>
    {/foreach}
    </td>
  </tr>
  <tr>
    <th align="right">{$translator->translate('Type')}: </th>
    <td>{$worktype->type}</td>
  </tr>
  {if $worktype}
  {foreach from=$worktype->getAttributes() item=attribute}
  {assign var="option" value=$work->getAttributeValue($attribute->field)}
  <tr valign="top">
    <th align="right">{$attribute->field}: </th>
    {if is_object($option)}
    <td>{$option->title}</td>
    {else}
    <td>{$option}</td>
    {/if}
  </tr>
  {/foreach}
  {/if}
</table>