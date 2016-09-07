<form method="post" name="mergeForm">
<input type="hidden" name="action" value="showMerge">
<input type="hidden" name="source_publisher_id" value="{$source_publisher->id}">
<input type="hidden" name="end_publisher_id" value="{$end_publisher->id}">
<table cellspacing="0" cellpadding="4" border="0">
  <tr valign="top">
    <td>
      Source Publisher
      <table cellspacing="0" cellpadding="4" border="0">
        <tr><th>Find: </th><td><input type="text" name="source_publisher" value="{$source_publisher->name}" size="50" maxlength="100"></td></tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            {if $dgSource}
            {$dgSource}
            <input type="submit" name="submit" value="Select">
            {/if}
            
            {if $dgSourceLocations}
            {$dgSourceLocations}
            {/if}
          </td>
        </tr>
      </table>
    </td>
    <td>
      Destination Publisher
      <table cellspacing="0" cellpadding="4" border="0">
        <tr>
          <th>Find: </th>
          <td><input type="text" name="end_publisher" value="{$end_publisher->name}" size="50" maxlength="100"{if !$source_publisher} DISABLED{/if}></td>
        </tr>
        <tr><td></td><td><input type="submit" name="submit" value="Find"></td></tr>
        <tr>
          <td colspan="2">
            {if $dgDestination}
            {$dgDestination}
            <input type="submit" name="submit" value="Select">
            {/if}
            
            {if $dgDestinationLocations}
            {$dgDestinationLocations}
            {/if}
          </td>
        </tr>
      </table>
    </td>
  </tr>
  
  <tr>
    <td colspan="2" align="center">
      {if $source_publisher->id && $end_publisher->id}
      <input type="submit" name="submit" value="Merge" onClick="document.mergeForm.action.value='processMerge';">
      {/if}
      <input type="button" name="submit" value="Clear" onClick="document.location.href='publisher.php?action=showMerge';">
    </td>
  </tr>
</table>
</form>