<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:56:09
         compiled from layout-admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'removeSlashes', 'layout-admin.tpl', 52, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title>Panta Rhei - Administration</title>
  <link rel="stylesheet" href="main.css" media="screen" />
  <link rel="stylesheet" href="../main.css" media="screen" />
  <script type="text/javascript" src="menu.js"></script>  
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<body>
<div class="banner">
  <h1>Administration</h1>
  <div class="breadcrumb">
    <div style="float: left;"><?php echo $this->_tpl_vars['breadcrumb']; ?>
</div>
    <div style="float: right;">
      [<a href="logout.php">Log Out</a>]
    </div>
  </div>
</div>

<div class="tabbar">
  <?php $_from = $this->_tpl_vars['menuList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu']):
?>
  <?php if ($this->_tpl_vars['user']->hasAccess($this->_tpl_vars['menu']['AccessLevel'])): ?>
  <div style="float: left; position: relative;">
    <div class="tab" onMouseOver="hover(this, '<?php echo $this->_tpl_vars['menu']['Title']; ?>
');" onMouseOut="unhover(this);" onClick="expand('<?php echo $this->_tpl_vars['menu']['Title']; ?>
');"><img src="images/right.gif" align="right" style="vertical-align: bottom;" id="<?php echo $this->_tpl_vars['menu']['Title']; ?>
img"><?php echo $this->_tpl_vars['menu']['Title']; ?>
</div>
    <ul id="<?php echo $this->_tpl_vars['menu']['Title']; ?>
">
      <?php if ($this->_tpl_vars['menu']['Link']['url']): ?>
      <li><a href="<?php echo $this->_tpl_vars['menu']['Link']['url']; ?>
"><?php echo $this->_tpl_vars['menu']['Link']['title']; ?>
</a></li>
      <?php else: ?>
        <?php $_from = $this->_tpl_vars['menu']['Link']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
          <?php if ($this->_tpl_vars['user']->hasAccess($this->_tpl_vars['link']['AccessLevel'])): ?>
      <li><a href="<?php echo $this->_tpl_vars['link']['url']; ?>
"><?php echo $this->_tpl_vars['link']['title']; ?>
</a></li>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      <?php endif; ?>
    </ul>
  </div>
  <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
</div>

<div style="float: left; margin: 20px 5px 0px 5px;">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['pageTemplate']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

<?php if ($this->_tpl_vars['instructions'] || $this->_tpl_vars['user']->isAdmin()): ?>
<div style="float: right; width: 240px;">
  <div class="tipbox">
    <div>Instructions</div>
    <?php if ($this->_tpl_vars['user']->isAdmin()): ?>
    <form method="post">
      <input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
">
      <textarea name="instructions" rows="5" cols="22"><?php echo removeSlashes(array('text' => $this->_tpl_vars['instructions'][$this->_tpl_vars['currentPage']][$this->_tpl_vars['action']]), $this);?>
</textarea><br>
      <input type="submit" name="submit" value="Save">
    </form>
    <?php else: ?>
    <p><?php echo removeSlashes(array('text' => $this->_tpl_vars['instructions'][$this->_tpl_vars['currentPage']][$this->_tpl_vars['action']]), $this);?>
</p>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

</body>
</html>