<?php
$interface = new UInterface();

// Process Action
$action = getRequest('action');
if (is_callable($action)) {
    call_user_func_array($action, array(&$interface));
} else {
    showWork($interface);
}

function showWork(&$interface)
{
    // Fetch work specified by query string
    $work = Work::staticGet('id', $_GET['id']);
    $interface->assign('work', $work);    
        
    // Get authors, publisher and work data
    $authorList = $work->getAgents('Author', 'lname');
    $interface->assign('authorList', $authorList);    
    $publisher = $work->getPublisher();
    $interface->assign('publisher', $publisher);    
    $data = $work->getData();
    $interface->assign('data', $data);

    // Build APA Citation
    $i=1;
    foreach ($authorList as $author) {
        if ($i == 1) {
            $citation .= "$author->lname, $author->fname";
        } elseif (($i == count($authorList)) && (count($authorList) > 1)) {
            $citation .= " & $author->fname $author->lname";
        } else {
            $citation .= ", $author->fname $author->lname";
        }
        $i++;
    }
    $citation .= " ($work->publish_year).";
    $citation .= " $work->title.";
    $citation .= " $work->subtitle.";
    $citation .= ' (pp. ' . $work->getAttributeValue('Pages') . ').';
    $citation .= " $publisher->location, $publisher->name";
    $interface->assign('APACitation', $citation);

    // Get tree branch list
    $branchList = $work->getBranchStrings();
    $interface->assign('branchList', $branchList);
    
    $interface->setTemplate('work.tpl');
}

function showAmazonData(&$interface)
{
    // Fetch work specified by query string
    $work = Work::staticGet('id', $_GET['id']);
    $data = $work->getAmazonData();
    $interface->assign('data', $data);
    
    $interface->setTemplate('work-amazon.tpl');    
}

function showEmailForm(&$interface)
{
    // Fetch work specified by query string
    $work = Work::staticGet('id', $_GET['id']);
    $interface->assign('work', $work);    
    
    $interface->setTemplate('work-email.tpl');    
}

function handleEmailForm(&$interface)
{
    $workId = $_POST['work_id'];
    $senderName = $_POST['sender_name'];
    $senderEmail = $_POST['sender_email'];
    $recipName = $_POST['recipient_name'];
    $recipEmail = $_POST['recipient_email'];
    
    $work = Work::staticGet('id', $workId);
    
    // Email Subject
    $subject = '[Panta Rhei] ' . $work->title;
    
    // Email Body
    $url = "http://pantarhei.com/work.php?id=$work->id"; 
    $body = "Hello $recipName, $senderName thought you might find some interest from this citation.\n\n$url";
    
    mail("$recipName <$recipEmail>", $subject, $body, "From: $senderName <$senderEmail>");
    
    $interface->assign('message', 'Email was sent');
    $interface->setTemplate('work.tpl');    
}

function showPDF()
{
    global $translator;
    
    define('FPDF_FONTPATH', 'lib/font/');
    require('lib/fpdf.php');
    
    // Fetch work specified by query string
    $work = Work::staticGet('id', $_GET['id']);
    $filename = 'citation' . $work->id . '.pdf';
    
    // Get authors, publisher and work data
    $authorList = $work->getAgents('Author', 'lname');
    $publisher = $work->getPublisher();
    $data = $work->getData();
    
    // Define PDF File
    $pdf = new FPDF();
    $pdf->AddPage();
    
    // Work Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->MultiCell(0, 10, $work->title);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 5, $work->subtitle);
    
    // Author Data
    $pdf->SetFont('Arial');
    $i=1;
    foreach ($authorList as $author) {
        
        if ($i == 1) {
            $authors .= "$author->fname $author->lname";
        } elseif (($i == count($authorList)) && (count($authorList) > 1)) {
            $authors .= " & $author->fname $author->lname";
        } else {
            $authors .= ", $author->fname $author->lname";
        }
        $i++;
    }
    $pdf->MultiCell(0, 5, $translator->translate('By') . ": " . $authors);

    // Publisher Data
    $pdf->SetFont('Arial');
    $pdf->MultiCell(0, 5, $translator->translate('Publisher') . ": $publisher->name - $publisher->location");
    $pdf->MultiCell(0, 5, $translator->translate('Publish Year') . ": $work->publish_year");
    
    // Work Data
    $pdf->SetFont('Arial');
    foreach ($data as $field=>$value) {
        $pdf->MultiCell(0, 5, $translator->translate($field) . ": $value");
    }
    
    // Print PDF
    $pdf->Output($filename, 'D');

    exit();
}

// Display page
$interface->display('layout.tpl');

?>