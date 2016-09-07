{foreach from=$workList item=work}
<p class="branch">
  <img src="images/document2.png" alt="Work" align="center"><a href="work.php?id={$work->id}" class="node">{html_format text=$work->title}</a>
</p>
{/foreach}
