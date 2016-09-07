<a href="index.php">Top</a> &gt;
{foreach from=$parentChain item=parent}
<a href="treeview.php?id={$parent->id}">{$parent->$langVar}</a> &gt;
{/foreach}
<b>{$root->$langVar}</b>

<ul STYLE="list-style: upper-roman outside">
{foreach from=$root->getChildren() item=child}
  <li><a href="treeview.php?id={$child->id}">{$child->$langVar}</a></li>
{/foreach}
</ul>

<hr>
<h3>Works</h3>

<ul>
{foreach from=$root->getWorks() item=work}
  <li><a href="work.php?id={$work->id}">{$work->title}</a></li>
{/foreach}
</ul>
