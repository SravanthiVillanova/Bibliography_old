<table>
  <tr><th>Original</th><th>Converted</th></tr>

<?php
$folder = new Folder();
$folder->find();
while($folder->fetch()) {
    echo "  <tr><td>$folder->text_fr</td><td>" . iconv(mb_detect_encoding($folder->text_fr, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $folder->text_fr) . "</td></tr>";
    $folder->text_fr = iconv(mb_detect_encoding($folder->text_fr, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $folder->text_fr);
    $folder->update();
}
?>

</table>
