<form method="post" name="mergeForm">
<input type="hidden" name="action" value="showMerge">
<input type="hidden" name="source_id" value="{$source->id}">
<input type="hidden" name="end_id" value="{$end->id}">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td width="50%">
      <b>Source Agent</b><br>
      {if $source}
      {$source->fname} {$source->lname}
      {else}
      <table cellspacing="0" cellpadding="4" border="0">
        <tr><th>Find: </th><td><input type="text" name="source" value="{$source->name}" size="50" maxlength="100"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            {if $dgSource}
            {$dgSource}
            <input type="submit" name="submit" value="Select">
            {/if}
          </td>
        </tr>
      </table>
      {/if}
    </td>
    <td width="50%">
      <b>Destination Agent</b><Br>
      {if $end}
      {$end->fname} {$end->lname}
      {else}
      <table cellspacing="0" cellpadding="4" border="0">
        <tr>
          <th>Find: </th>
          <td><input type="text" name="end" value="{$end->name}" size="50" maxlength="100"{if !$source} DISABLED{/if}></td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            {if $dgDestination}
            {$dgDestination}
            <input type="submit" name="submit" value="Select">
            {/if}
          </td>
        </tr>
      </table>
      {/if}
    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center">
      {if $source->id && $end->id}
      <input type="submit" name="submit" value="Merge" onClick="document.mergeForm.action.value='processMerge';">
      {/if}
      <input type="button" name="submit" value="Clear" onClick="document.location.href='agent.php?action=showMerge';">
    </td>
  </tr>
</table>
</form>