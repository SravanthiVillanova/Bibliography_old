<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 20:01:45
         compiled from publisher-location-delete.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleLocationDelete">
<input type="hidden" name="pub_id" value="<?php echo $this->_tpl_vars['publisher']->id; ?>
">
  
<p>Are you sure you want to delete these?</p>
<ul>
  <?php $_from = $this->_tpl_vars['locList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['location']):
?>
  <li><?php echo $this->_tpl_vars['location']->location; ?>
</li>
  <input type="hidden" name="id[]" value="<?php echo $this->_tpl_vars['location']->id; ?>
">
  <?php endforeach; endif; unset($_from); ?>
</ul>

<input type="submit" name="submit" value="Delete"> <input type="submit" name="submit" value="Cancel">
</form>