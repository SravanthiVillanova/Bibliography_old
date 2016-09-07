<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 17:33:58
         compiled from work.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'work.tpl', 5, false),array('modifier', 'escape', 'work.tpl', 41, false),)), $this); ?>
<p>
  <a href="work.php?id=<?php echo $this->_tpl_vars['work']->id; ?>
&action=showEmailForm" title="Send In Email"><img src="images/email_button.gif" alt="Send In Email" border="0" align="Center"></a>
  <a href="work.php?id=<?php echo $this->_tpl_vars['work']->id; ?>
&action=showPDF" title="Download As PDF"><img src="images/pdf_button.gif" alt="Download As PDF" border="0" align="Center"></a>
  <?php if ($this->_tpl_vars['work']->getAttributeValue('ISBN') != ""): ?>
  <a href="http://www.amazon.com/exec/obidos/tg/detail/-/<?php echo ((is_array($_tmp=$this->_tpl_vars['work']->getAttributeValue('ISBN'))) ? $this->_run_mod_handler('replace', true, $_tmp, "-", "") : smarty_modifier_replace($_tmp, "-", "")); ?>
" title="Buy From Amazon"><img src="images/amazon_button.gif" alt="Buy From Amazon" border="0" align="Center"></a>
  <?php endif; ?>
</p>


<h1><?php echo $this->_tpl_vars['work']->title; ?>
</h1>
<h2><?php echo $this->_tpl_vars['work']->subtitle; ?>
</h2>
<h2><?php echo $this->_tpl_vars['work']->paralleltitle; ?>
</h2>

<p>
  <?php echo $this->_tpl_vars['translator']->translate('By',$this->_tpl_vars['language']); ?>
: 
  <?php $_from = $this->_tpl_vars['authorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['author']):
?>
    <?php echo $this->_tpl_vars['author']->fname; ?>
 <?php echo $this->_tpl_vars['author']->lname; ?>

  <?php endforeach; endif; unset($_from); ?>
</p>

<table cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="label"><?php echo $this->_tpl_vars['translator']->translate('Publisher'); ?>
: </td>
    <td><?php echo $this->_tpl_vars['publisher']->name; ?>
 - <?php echo $this->_tpl_vars['publisher']->location; ?>
</td>
  </tr>
  <tr>
    <td class="label"><?php echo $this->_tpl_vars['translator']->translate('Publish Year'); ?>
: </td>
    <td><?php echo $this->_tpl_vars['work']->publish_year; ?>
</td>
  </tr>
  
  <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['value']):
?>
  <tr>
    <td class="label"><?php echo $this->_tpl_vars['translator']->translate($this->_tpl_vars['field']); ?>
: </td>
    <td><?php echo $this->_tpl_vars['value']; ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>

<p>
  <b>APA Citation Format:</b><br>
  <pre width="80"><?php echo ((is_array($_tmp=$this->_tpl_vars['APACitation'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</pre>
</p>

<p>
<b>Find Similiar Works:</b>
<?php $_from = $this->_tpl_vars['branchList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['branch']):
?>
  <p><?php echo $this->_tpl_vars['branch']; ?>
</p>
<?php endforeach; endif; unset($_from); ?>
</p>