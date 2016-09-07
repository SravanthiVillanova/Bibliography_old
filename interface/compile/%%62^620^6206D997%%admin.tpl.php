<?php /* Smarty version 2.6.25-dev, created on 2016-08-31 18:56:09
         compiled from admin.tpl */ ?>
<p>Welcome, <?php echo $this->_tpl_vars['user']->name; ?>
</p>

<?php if ($this->_tpl_vars['user']->isAdmin()): ?>
You have <b><?php echo $this->_tpl_vars['reviewCnt']; ?>
</b> works awaiting review.
<?php endif; ?>