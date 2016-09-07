<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:42:16
         compiled from layout.tpl */ ?>
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
        <option value="fr"<?php if (( $this->_tpl_vars['language'] == 'fr' )): ?> selected<?php endif; ?>>Fran&ccedil;ais</option>
        <option value="de"<?php if (( $this->_tpl_vars['language'] == 'de' )): ?> selected<?php endif; ?>>Deutsch</option>
        <option value="nl"<?php if (( $this->_tpl_vars['language'] == 'nl' )): ?> selected<?php endif; ?>>Dutch</option>
        <option value="es"<?php if (( $this->_tpl_vars['language'] == 'es' )): ?> selected<?php endif; ?>>Espa&ntilde;ol</option>
        <option value="it"<?php if (( $this->_tpl_vars['language'] == 'it' )): ?> selected<?php endif; ?>>Italiano</option>
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
        <?php $_from = $this->_tpl_vars['worktypeList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['worktype']):
?>
        <option value="<?php echo $this->_tpl_vars['worktype']->id; ?>
"><?php echo $this->_tpl_vars['worktype']->type; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
      </select><br>
      <a href="search.php" style="font-weight: normal;">Advanced Search</a>
    </td>
    <td nowrap>&nbsp;<input type="submit" name="submit" value="Go"></td>
    </form>
  </tr>
</table>
<p class="breadcrumb"><?php echo $this->_tpl_vars['breadcrumb']; ?>
</p>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['pageTemplate']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</div>

</body>
</html>