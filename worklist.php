<?php
$interface = new UInterface();
$interface->setTemplate('worklist.tpl');

$langVar = 'text_' . $language;

$workList = array();

// Search by Title
if (isset($_POST['lookfor'])) {
    $work = new Work();
    $work->whereAdd("UPPER(title) LIKE '" . strtoupper($_POST['lookfor']) . " %'");
    $work->whereAdd("UPPER(title) LIKE '% " . strtoupper($_POST['lookfor']) . " %'", 'OR');
    $work->whereAdd("UPPER(title) LIKE '% " . strtoupper($_POST['lookfor']) . "'", 'OR');
    if ($work->find()) {
        while ($work->fetch()) {
            $workList[] = $work;
        }
    }
}

// Search based on publish date
if (isset($_POST['startYear'])) {
    $work = new Work();
    $work->whereAdd("publish_year >= '" . $_POST['startYear'] . "'");
    $work->whereAdd("publish_year <= '" . $_POST['endYear'] . "'");
    if ($work->find()) {
        while ($work->fetch()) {
            $workList[] = $work;
        }
    }
}

// Search based on author
if (isset($_POST['author'])) {
    $workList = Work::findByAgent($_POST['author'], 'Author');
}

// Search based on editor
if (isset($_POST['editor'])) {
    $workList = Work::findByAgent($_POST['editor'], 'Editor');
}

// Search based on publisher
if (isset($_POST['publisher'])) {
    $workList = Work::findByPublisher($_POST['publisher']);
}

$interface->assign('workList', $workList);

$interface->display('layout.tpl');
?>