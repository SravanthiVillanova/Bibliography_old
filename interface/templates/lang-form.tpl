{$message}
<form method="post">
<input type="hidden" name="action" value="handleForm">
<input type="hidden" name="term" value="{$term}">
{$term}
<table cellspacing="0" cellpadding="4" border="0" class="form">
  {foreach from=$translator->getLanguages() item=lang}
  <tr><th>{$lang}: </th><td><input type="text" name="translation[{$lang}]" value="{$translator->translate($term, $lang)}"></td></tr>
  {/foreach}
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>
