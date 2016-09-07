<?php

require_once 'XML/Util.php';

require_once 'classes/Agenttype.php';

header('Content-type: application/xml', true);    

$rss = XML_Util::getXMLDeclaration('1.0', 'ISO-8859-1') . "\n";
$rss .= '<!DOCTYPE rdf:RDF PUBLIC "-//DUBLIN CORE//DCMES DTD 2002/07/31//EN" "http://dublincore.org/documents/2002/07/31/dcmes-xml/dcmes-xml-dtd.dtd">' . "\n";
$rss .= '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc ="http://purl.org/dc/elements/1.1/">' . "\n";
$rss .= ' <rdf:Description rdf:about="http://liboffice.villanova.edu/panta_rhei/">' . "\n";

if (isset($_GET['id'])) {
    $work = Work::staticGet('id', $_GET['id']);
    $rss .= '  <dc:title xml:lang="' . $work->language . '">' . $work->title . '</dc:title>' . "\n";
    $publisher = $work->getPublisher();
    $rss .= '  <dc:publisher>' . $publisher->name . '</dc:publisher>' . "\n";
    $rss .= '  <dc:description>' . $work->description . '</dc:description>' . "\n";
    $rss .= '  <dc:date>' . date('r', strtotime($work->publish_date)) . "</dc:date>\n";
    $rss .= '  <dc:language>' . $work->language . '</dc:language>' . "\n";
    $type = Agenttype::staticGet('title', 'Author');
    foreach ($work->getAgents($type->id) as $agent) {
        $rss .= '  <dc:creator>' . $agent->name . '</dc:creator>' . "\n";
    }
    $type = Agenttype::staticGet('title', 'Editor');
    foreach ($work->getAgents($type->id) as $agent) {
        $rss .= '  <dc:contributor>' . $agent->name . '</dc:contributor>' . "\n";
    }
    $type = $work->getWorkType();
    $rss .= '  <dc:type>' . $type->title . '</dc:type>' . "\n";
} else {
    $rss .= '  <dc:title>Project Panta Rhei</dc:title>' . "\n";
    $rss .= '  <dc:description>The van Bavel Bibliography of St. Augustine</dc:description>' . "\n";
    $rss .= '  <dc:date>' . date('r') . "</dc:date>\n";
    $rss .= '  <dc:format>text/html</dc:format>' . "\n";
    $rss .= '  <dc:language>en</dc:language>' . "\n";
    $rss .= '  <dc:creator>The Augustinian Institute</dc:creator>' . "\n";
}

$rss .= ' </rdf:Description>' . "\n";
$rss .= '</rdf:RDF>';

echo $rss;
?>