<p><b>{$hits}</b> works found for <b>{$title}</b>. Please select the correct item:</p>
{foreach from=$recordCollection key=title item=recordList}
{$title}
<ul>
  {foreach from=$recordList item=record}
  <li>
    <a href="work.php?action=showForm&record={toString array=$record}">
      {$record[245][0]}{$record[245][1]}{$record[245][2]}
    </a>
  </li>
  {foreachelse}
  No records found
  {/foreach}
</ul>
{/foreach}

<a href="work.php?action=showForm&title={$title}">Return to Form</a>