<?php
include('../global.inc');
require_once('../classes/Publisher.php');

if (isset($_GET['id'])) {
    $work = Work::staticGet('id', $_GET['id']);
} else {
    $work = new Work();
}

if (isset($_POST['submit'])) {
    $work->id = $_POST['id']; 
    $work->title = $_POST['title'];
    $work->subtitle = $_POST['subtitle'];
    $work->paralleltitle = $_POST['paralleltitle'];
    
    if ($work->id != '') {
        $work->update();
    } else {
        $work->insert();
    }
}

include('../header.inc');
?>

<form method="post">
<input type="hidden" name="id" value="<?php echo $work->id;?>">
<table cellpadding="2" cellspacing="0" border="0">
  <tr><td class="label"><?php echo I18N_Translator::translate('Title', $language); ?>:&nbsp;</td><td><input type="text" name="title" value="<?php echo $work->title;?>" size="40"></td></tr>
  <tr><td class="label"><?php echo I18N_Translator::translate('Subtitle', $language); ?>:&nbsp;</td><td><input type="text" name="subtitle" value="<?php echo $work->subtitle;?>" size="40"></td></tr>
  <tr><td class="label"><?php echo I18N_Translator::translate('ParallelTitle', $language); ?>:&nbsp;</td><td><input type="text" name="subtitle" value="<?php echo $work->paralleltitle;?>" size="40"></td></tr>
  <tr>
    <td class="label"><?php echo I18N_Translator::translate('Publisher', $language); ?>:&nbsp;</td>
    <td>
      <select name="publisher_id">
        <option value=""></option>
      <?php
      $publisher = new Publisher();
      if ($publisher->find()) {
          while ($publisher->fetch()) {
              $workPub = $work->getPublisher();
              if ($workPub->id == $publisher->id) {
                  echo "<option value=\"$publisher->id\" selected>" . "$publisher->name - $publisher->location" . "</option>\n";
              } else {
                  echo "<option value=\"$publisher->id\">" . "$publisher->name - $publisher->location" . "</option>\n";
              }
          }
      }
      ?>
      </select>
    </td>
  </tr>
  <tr><td class="label"><?php echo I18N_Translator::translate('Publish Year', $language); ?>:&nbsp;</td><td><input type="text" name="publish_year" value="<?php echo $work->publish_year;?>"></td></tr>
  <?php
  $data = $work->getData();
  foreach ($data as $field => $value) {
      echo "<tr><td class=\"label\">" . I18N_Translator::translate($field, $language) . ":&nbsp;</td><td><input type=\"text\" name=\"$field\" value=\"$value\"></td></tr>\n";
  }
  ?>
  <tr><td></td><td><input type="submit" name="submit" value="Save"></td></tr>
</table>
</form>

<?php include('../footer.inc'); ?>