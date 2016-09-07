<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 20:01:30
         compiled from publisher-location-merge.tpl */ ?>
<form method="post">
<input type="hidden" name="action" value="handleLocationMerge">
<input type="hidden" name="pub_id" value="<?php echo $this->_tpl_vars['publisherId']; ?>
">
<input type="hidden" name="master_id" value="<?php echo $this->_tpl_vars['master']->id; ?>
">
  
<p>Are you sure you want to merge these?</p>
<ul>
  <?php $_from = $this->_tpl_vars['locationList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['location']):
?>
  <li><?php echo $this->_tpl_vars['location']->location; ?>
</li>
  <input type="hidden" name="id[]" value="<?php echo $this->_tpl_vars['location']->id; ?>
">
  <?php endforeach; endif; unset($_from); ?>
</ul>
<p>To: <b><?php echo $this->_tpl_vars['master']->location; ?>
</b></p>
<input type="hidden" name="master_id" value="<?php echo $this->_tpl_vars['master']->id; ?>
">

<input type="submit" name="submit" value="Merge"> <input type="submit" name="submit" value="Cancel">
</form>