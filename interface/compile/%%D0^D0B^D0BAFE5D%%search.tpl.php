<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:36:46
         compiled from search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select_date', 'search.tpl', 23, false),)), $this); ?>
<h1>Advanced Search</h1>

<h2>Search the subject tree:</h2>
<form method="post" action="search.php">
<input type="text" name="lookfor" size="50"> <input type="submit" name="submit" value="Go"><bR>
Note: You may use a '*' character as a wildcard
</form>

<h2>Search for a record:</h2>
<table cellspacing="0" cellpadding="3" border="0">
  <form method="post" action="worklist.php">
  <tr>
    <td class="label">Title:&nbsp;</td>
    <td><input type="text" name="lookfor" size="30"></td>
    <td><input type="submit" name="submit" value="Go"></td>
  </tr>
  </form>

  <form method="post" action="worklist.php">
  <tr valign="top">
    <td class="label">Publish Date:&nbsp;</td>
    <td>
      <?php echo smarty_function_html_select_date(array('display_days' => false,'prefix' => 'start','month_empty' => "",'year_empty' => "",'start_year' => -100), $this);?>
<br>
      <?php echo smarty_function_html_select_date(array('display_days' => false,'prefix' => 'end','month_empty' => "",'year_empty' => "",'start_year' => -100), $this);?>

    </td>
    <td><input type="submit" name="submit" value="Go"></td>
  </tr>
  </form>

  <form method="post" action="worklist.php">
  <tr>
    <td class="label">Author Last Name:&nbsp;</td>
    <td><input type="text" name="author" size="30"></td>
    <td><input type="submit" name="submit" value="Go"></td>
  </tr>
  </form>

  <form method="post" action="worklist.php">
  <tr>
    <td class="label">Publisher Name:&nbsp;</td>
    <td><input type="text" name="publisher" size="30"></td>
    <td><input type="submit" name="submit" value="Go"></td>
  </tr>
  </form>

  <form method="post" action="worklist.php">
  <tr>
    <td class="label">Editor Last Name:&nbsp;</td>
    <td><input type="text" name="editor" size="30"></td>
    <td><input type="submit" name="submit" value="Go"></td>
  </tr>
  </form>
</table>