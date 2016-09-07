<?php /* Smarty version 2.6.25-dev, created on 2016-09-01 20:00:08
         compiled from publisher-location-list.tpl */ ?>
<p><b>Publisher: </b> <?php echo $this->_tpl_vars['publisher']->name; ?>
</p>

<a href="publisher.php?pub_id=<?php echo $this->_tpl_vars['publisher']->id; ?>
&action=showLocationForm">Add Location</a>
<form method="post">
<input type="hidden" name="action" value="processLocations">
<input type="hidden" name="pub_id" value="<?php echo $this->_tpl_vars['publisher']->id; ?>
">
<?php echo $this->_tpl_vars['dg']; ?>


<table width="100%">
  <tr>
    <td><input type="submit" name="submit" value="Delete"></td>
    <td align="right"><input type="submit" name="submit" value="Merge"></td>
  </tr>
</table>

</form>
<?php echo $this->_tpl_vars['paging']; ?>