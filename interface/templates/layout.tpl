<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Project Panta Rhei</title>
  <script language="javascript" type="text/javascript" src="TreeMenu.js"></script>
  <link rel="stylesheet" href="/panta_rhei/main.css" media="screen" />
  <link rel="meta" href="pantarhei.dcxml" />  
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
</head>
<body bgcolor="#CCCCCC">

<div align="center">
<div class="page">

<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr valign="top">
    <form method="post" name="lang">
    <td>
      <select name="language" onChange="document.lang.submit();">
        <option value="en">English</option>
        <option value="fr"{if ($language == 'fr')} selected{/if}>Fran&ccedil;ais</option>
        <option value="de"{if ($language == 'de')} selected{/if}>Deutsch</option>
        <option value="nl"{if ($language == 'nl')} selected{/if}>Dutch</option>
        <option value="es"{if ($language == 'es')} selected{/if}>Espa&ntilde;ol</option>
        <option value="it"{if ($language == 'it')} selected{/if}>Italiano</option>
      </select>
    </td>
    </form>
    <td width="100%" align="center"><a href="dcxml.php"><img src="images/rdf.32" alt="RDF" border="0"></a></td>
    <form method="post" action="worklist.php">
    <td width="200" align="right" class="search" nowrap>
      <img src="/panta_rhei/images/search.png" alt="Search" align="center">
      Search: <input type="text" name="lookfor" size="15"><br>
      <select name="worktype_id">
        <option></option>
        {foreach from=$worktypeList item=worktype}
        <option value="{$worktype->id}">{$worktype->type}</option>
        {/foreach}
      </select><br>
      <a href="search.php" style="font-weight: normal;">Advanced Search</a>
    </td>
    <td nowrap>&nbsp;<input type="submit" name="submit" value="Go"></td>
    </form>
  </tr>
</table>
<p class="breadcrumb">{$breadcrumb}</p>
{include file="$pageTemplate"}
</div>
</div>

</body>
</html>