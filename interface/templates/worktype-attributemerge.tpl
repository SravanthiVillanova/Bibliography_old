{if count($merged) > 0}
  {if $forReal == 1}
    <p>Merge complete.</p>
  {else}
    <b>Duplicates to merge:</b>
    <ul>
    {foreach from=$merged item=title}
      <li>{$title|escape}</li>
    {/foreach}
    </ul>
    <form method="get" action="">
      <input type="hidden" name="action" value="mergeDuplicateOptions"/>
      <input type="hidden" name="id" value="{$attrib_id|escape}"/>
      <input type="hidden" name="forreal" value="1"/>
      <input type="submit" value="Fix Now"/>
    </form>
  {/if}
{else}
  <p>No duplicates.</p>
{/if}