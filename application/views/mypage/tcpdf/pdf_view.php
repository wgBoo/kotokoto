<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */


// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES.'book-covers(max)1.png';
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(151, 20, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('KOTOKOTO Mybook');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

//TTF폰트추가해서 사용하기!
$font = new TCPDF_FONTS();
$fontX = $font->addTTFfont('./public/assets/fonts/TAKUMIYFONTMINI.ttf');
$pdf->SetFont($fontX , '', 16,'',false);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);


// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

/*// 문자 글꼴을 TCPDF에 포함된 hysmyeongjostdmedium, 14포인트로 설정합니다.
$pdf->SetFont('hysmyeongjostdmedium', '', 14);*/

// remove default header
$pdf->setPrintHeader(false);



// add a page
$pdf->AddPage();

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'book-covers(max)4.png';
$pdf->Image($img_file, 0, 0, 148.5 , 210, '', '', '', false, 300, '', false, false, 0);
$img_file = K_PATH_IMAGES.'book-covers(max)1.png';
$pdf->Image($img_file, 148.5, 0, 148.5 , 210, '', '', '', false, 300, '', false, false, 0);


// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


$pdf->AddPage();
// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'book-covers(max)2.png';
$pdf->Image($img_file, 0, 0, 148.5 , 210, '', '', '', false, 300, '', false, false, 0);
$img_file = K_PATH_IMAGES.'book-covers(max)7.png';
$pdf->Image($img_file, 148.5, 0, 148.5 , 210, '', '', '', false, 300, '', false, false, 0);


// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


// ---------------------------------------------------------


/* 마진설정 */
$pdf->setPrintHeader(false);

$pdf->SetAutoPageBreak(TRUE, 5);
$pdf->SetMargins(PDF_MARGIN_LEFT, 5, PDF_MARGIN_RIGHT);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->AddPage();

//푸터 페이지표시
$pdf->setPrintFooter(true);

//직선추가
//2mm 폭, 선단(butt), 실선, 색(CMYK : 노랑)
$style1 = array('width'=>0.1, 'cap'=> 'butt','color'=> array(179,180,181));
$pdf->Line(148,10,148,200,$style1);

// get current vertical position
$y = $pdf->getY();

// set color for background
$pdf->SetFillColor(255, 255, 255);

// set color for text
$pdf->SetTextColor(0, 0, 0);

// write the first column
$pdf->writeHTMLCell(134, '', '', $y, $pagehtml[0], 0, 0, 1, true, 'J', false);

if(isset($pagehtml[2])) {
// write the second column
    $pdf->writeHTMLCell(134, '', '', '', $pagehtml[1].$pagehtml[2], 0, 1, 1, true, 'J', false);
}else{
    $pdf->writeHTMLCell(134, '', '', '', $pagehtml[1], 0, 1, 1, true, 'J', false);
}
//여기부터 목차다음페이지----------------------------------------------------

//3페이지가있으면 다음페이지를 만들어준다.
if(isset($pagehtml[3])) {

    $cnt = 0;
    for($i = 3; $i < count($pagehtml); $i++){

        if($i % 2 == 1){ //홀수면
            $newpage[$cnt] = $pagehtml[$i];
        }else{
            $newpage[$cnt] = $newpage[$cnt].$pagehtml[$i]; //두페이지씩 집어넣기

            $cnt++;
        }
    }

    for ($i = 0; $i < count($newpage); $i++) {

        if($i % 2 == 0) { //짝수 일때 새페이지
            $pdf->AddPage();

            //푸터 페이지표시
            $pdf->setPrintFooter(true);

            //직선추가
            //2mm 폭, 선단(butt), 실선, 색(CMYK : 노랑)
            $style1 = array('width' => 0.1, 'cap' => 'butt', 'color' => array(179, 180, 181));
            $pdf->Line(148, 5, 148, 200, $style1);

            // get current vertical position
            $y = $pdf->getY();

            // set color for background
            $pdf->SetFillColor(255, 255, 255);

            // set color for text
            $pdf->SetTextColor(0, 0, 0);

            //왼쪽부분 작성
            $pdf->writeHTMLCell(134, '', '', $y, $newpage[$i] , 0, 0, 1, true, 'J', false);

        }else {

            //오른쪽부분 작성
            $pdf->writeHTMLCell(134, '', '', '', $newpage[$i], 0, 1, 1, true, 'J', false);
        }
    }
}

// ---------------------------------------------------------

// write some JavaScript code
if(isset($videocheck)) {

    $js = <<<EOD
app.alert('비디오파일은 삭제됩니다', 3, 0, 'Welcome');
EOD;

// set javascript
    $pdf->IncludeJS($js);
}

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('Mybook.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
