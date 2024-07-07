<?php
require_once('../../assets/libraries/pdf/tcpdf.php');
// Start output buffering
ob_start();
if (isset($_POST['pdf_submit'])) {
    $choice = $_POST['entryTypeStudent'];


    if ($choice == 'all') {
        $start = $_POST['startPDF'];
        $end = $_POST['endPDF'];
        ob_end_clean();
        header('location:../../includes/all_pdf.php?start=' . $start . '&end=' . $end . '');
        header('Content-Type: application/pdf');
        // Output the PDF
        exit; // Exit script after sending PDF

    } else if ($choice == 'single') {
        // Handle single entry case

        $enrollPDF = $_POST['studentSingle'];
        ob_end_clean();
        header('location:../../includes/pdf.php?enroll=' . $enrollPDF . '');
        header('Content-Type: application/pdf');
        // Output the PDF

        exit; // Exit script after sending PDF

    } else if ($choice == 'range') {
        // Handle range entry case
        $startVal = $_POST['studentRangeStart'];
        $endVal = $_POST['studentRangeEnd'];
        ob_end_clean();
        header('location:../../includes/pdf.php?start=' . $startVal . '&end=' . $endVal . '');
        header('Content-Type: application/pdf');
        // Output the PDF
        exit; // Exit script after sending PDF
    }
} else if (isset($_POST['alumini_sub'])) {
    $enrollPDF = $_POST['alumini_enroll'];
    $type = $_POST['type'];
    ob_end_clean();
    header('location:../../includes/pdf.php?enroll=' . $enrollPDF . '&type=' . $type . '');
    header('Content-Type: application/pdf');
    // Output the PDF

    exit; // Exit script after sending PDF
} else {
    echo "<script>alert('Contact admin!')</script>";
}
ob_end_flush();
