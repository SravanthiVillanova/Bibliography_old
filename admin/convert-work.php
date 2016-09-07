<?php
$work = new Work();
$work->find();
while($work->fetch()) {
    $work->description = iconv(mb_detect_encoding($work->description, 'ASCII, UTF-8, ISO-8859-1'), 'UTF-8', $work->description);
    $work->update();
}
?>
