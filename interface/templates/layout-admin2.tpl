<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Project Panta Rhei - Administration</title>
  <link rel="stylesheet" href="main.css" media="screen" />
  <link rel="stylesheet" href="../main.css" media="screen" />
  <script type="text/javascript" src="menu.js"></script>  
  <meta http-equiv="Content-Type" content="text/html">
<body>
<div class="banner">
  <h1>Administration</h1>
  <div class="breadcrumb">
    <div style="float: left;">{$breadcrumb}</div>
    <div style="float: right;">
      [<a href="logout.php">Log Out</a>]
    </div>
  </div>
</div>

<div class="tabbar">
  {foreach from=$menuList item=menu}
  {if $user->hasAccess($menu.AccessLevel)}
  <div style="float: left; position: relative;">
    <div class="tab" onMouseOver="hover(this, '{$menu.Title}');" onMouseOut="unhover(this);" onClick="expand('{$menu.Title}');"><img src="images/right.gif" align="right" style="vertical-align: bottom;" id="{$menu.Title}img">{$menu.Title}</div>
    <ul id="{$menu.Title}">
      {if $menu.Link.url}
      <li><a href="{$menu.Link.url}">{$menu.Link.title}</a></li>
      {else}
        {foreach from=$menu.Link item=link}
      <li><a href="{$link.url}">{$link.title}</a></li>
        {/foreach}
      {/if}
    </ul>
  </div>
  {/if}
  {/foreach}
</div>

<div style="float: left; margin: 20px 5px 0px 5px;">
{include file="$pageTemplate"}
</div>

{if $instructions || $user->isAdmin()}
<div style="float: right; width: 240px;">
  <div class="tipbox">
    <div>Instructions</div>
    {if $user->isAdmin()}
    <form method="post">
      <input type="hidden" name="action" value="{$action}">
      <textarea name="instructions" rows="5" cols="22">{removeSlashes text=$instructions.$currentPage.$action}</textarea><br>
      <input type="submit" name="submit" value="Save">
    </form>
    {else}
    <p>{removeSlashes text=$instructions.$currentPage.$action}</p>
    {/if}
  </div>
</div>
{/if}

</body>
</html>
