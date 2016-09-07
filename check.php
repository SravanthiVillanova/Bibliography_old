<?php

$handle = fopen('results.csv', 'r');

$dump = [];
while ($line = fgetcsv($handle)) {
  $new = utf8_decode($line[2]);
  $old = utf8_decode($line[1]);
  $dump[$new][] = $old;
}

$handle2 = fopen('results2.csv', 'w');
foreach ($dump as $key => $raw) {
  $vals = array_unique($raw);
  sort($vals);
  fputcsv($handle2, [$key, implode('|', $vals)]);
}

fclose($handle);
fclose($handle2);
echo 'done';
