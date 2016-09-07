<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 16:45:27
         compiled from work-form-agent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'work-form-agent.tpl', 27, false),)), $this); ?>
<?php echo $this->_tpl_vars['message']; ?>


<ul class="tabbar">
  <li><a href="" onClick="document.workForm.view.value='general'; document.workForm.submit(); return false;">General</a></li>
  <li><a href="" onClick="document.workForm.view.value='category'; document.workForm.submit(); return false;">Classification</a></li>
  <li><a href="" onClick="document.workForm.view.value='publisher'; document.workForm.submit(); return false;">Publisher</a></li>
  <li class="active">Agents</li>
  <li><a href="" onClick="document.workForm.view.value='citation'; document.workForm.submit(); return false;">Citation</a></li>
</ul>

<form method="post" name="workForm" action="work.php" class="tabForm">
<input type="hidden" name="action" value="showForm">
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['work']->id; ?>
">
<input type="hidden" name="view" value="agent">
<input type="hidden" name="tab" value="agent">
<table cellspacing="0" cellpadding="4" border="0">
  <tr>
    <td>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr bgcolor="#CCCCCC">
          <th>Lookup</th><th>Agent Type</th><th>First Name</th><th>Last Name</th><th>Alternate Name</th><th>Organization Name</th><th>Remove</th>
        </tr>
        <?php if ($this->_tpl_vars['work']->id != ''): ?>
        <?php $_from = $this->_tpl_vars['work']->getAgents(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['agentLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['agentLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['agent']):
        $this->_foreach['agentLoop']['iteration']++;
?>
        <tr>
          <td bgcolor="#CCCCCC"></td>
          <td><select name="agent[<?php echo $this->_foreach['agentLoop']['iteration']; ?>
][type]"><option value=""></option><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['agentTypeList'],'selected' => $this->_tpl_vars['agent']->agenttype_id), $this);?>
</select></td>
          <td><input type="text" name="agent[<?php echo $this->_foreach['agentLoop']['iteration']; ?>
][fname]" value="<?php echo $this->_tpl_vars['agent']->fname; ?>
" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_foreach['agentLoop']['iteration']; ?>
][lname]" value="<?php echo $this->_tpl_vars['agent']->lname; ?>
" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_foreach['agentLoop']['iteration']; ?>
][altname]" value="<?php echo $this->_tpl_vars['agent']->alternate_name; ?>
" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_foreach['agentLoop']['iteration']; ?>
][orgname]" value="<?php echo $this->_tpl_vars['agent']->organization_name; ?>
" size="30"></td>
          <td bgcolor="#CCCCCC" align="center"><input type="checkbox" name="removeAgent[]" value="<?php echo $this->_tpl_vars['agent']->id; ?>
"></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row=0', 'lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');"></td>
          <td><select name="agent[0][type]"><option value=""></option><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['agentTypeList']), $this);?>
</select></td>
          <td><input type="text" name="agent[0][fname]" size="30"></td>
          <td><input type="text" name="agent[0][lname]" size="30"></td>
          <td><input type="text" name="agent[0][altname]" size="30"></td>
          <td><input type="text" name="agent[0][orgname]" size="30"></td>
          <td bgcolor="#CCCCCC"></td>
        </tr>
        <?php else: ?>
        <?php unset($this->_sections['loop']);
$this->_sections['loop']['name'] = 'loop';
$this->_sections['loop']['loop'] = is_array($_loop=5) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['loop']['show'] = true;
$this->_sections['loop']['max'] = $this->_sections['loop']['loop'];
$this->_sections['loop']['step'] = 1;
$this->_sections['loop']['start'] = $this->_sections['loop']['step'] > 0 ? 0 : $this->_sections['loop']['loop']-1;
if ($this->_sections['loop']['show']) {
    $this->_sections['loop']['total'] = $this->_sections['loop']['loop'];
    if ($this->_sections['loop']['total'] == 0)
        $this->_sections['loop']['show'] = false;
} else
    $this->_sections['loop']['total'] = 0;
if ($this->_sections['loop']['show']):

            for ($this->_sections['loop']['index'] = $this->_sections['loop']['start'], $this->_sections['loop']['iteration'] = 1;
                 $this->_sections['loop']['iteration'] <= $this->_sections['loop']['total'];
                 $this->_sections['loop']['index'] += $this->_sections['loop']['step'], $this->_sections['loop']['iteration']++):
$this->_sections['loop']['rownum'] = $this->_sections['loop']['iteration'];
$this->_sections['loop']['index_prev'] = $this->_sections['loop']['index'] - $this->_sections['loop']['step'];
$this->_sections['loop']['index_next'] = $this->_sections['loop']['index'] + $this->_sections['loop']['step'];
$this->_sections['loop']['first']      = ($this->_sections['loop']['iteration'] == 1);
$this->_sections['loop']['last']       = ($this->_sections['loop']['iteration'] == $this->_sections['loop']['total']);
?>
        <tr>
          <td bgcolor="#CCCCCC"><input type="button" value="Lookup" onClick="window.open('work.php?action=showAgentLookup&row=<?php echo $this->_sections['loop']['iteration']-1; ?>
','lookup', 'height=300, width=700, location=no, menubar=no, scrollbars=yes, status=no, toolbar=no, top=200, left=50');"></td>
          <td><select name="agent[<?php echo $this->_sections['loop']['iteration']-1; ?>
][type]"><option value=""></option><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['agentTypeList']), $this);?>
</select></td>
          <td><input type="text" name="agent[<?php echo $this->_sections['loop']['iteration']-1; ?>
][fname]" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_sections['loop']['iteration']-1; ?>
][lname]" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_sections['loop']['iteration']-1; ?>
][altname]" size="30"></td>
          <td><input type="text" name="agent[<?php echo $this->_sections['loop']['iteration']-1; ?>
][orgname]" size="30"></td>
          <td bgcolor="#CCCCCC"></td>
        </tr>
        <?php endfor; endif; ?>
        <?php endif; ?>
        <tr>
          <td><input type="submit" name="submitBtn" value="Add" onClick="this.form.action.value='showForm';"></td>
          <td colspan="5"></td>
          <td bgcolor="#CCCCCC"><input type="submit" name="removeAgentBtn" value="Remove" onClick="this.form.action.value='showForm';"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="submitBtn" value="Save" onClick="this.form.action.value='handleForm';">
    </td>
  </tr>
</table>
</form>