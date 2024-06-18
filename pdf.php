<?php
require("config/mysqli_db.php");
require_once('assets/libraries/pdf/tcpdf.php');

// Function to fetch student data
function getStudentData($conn, $enroll_no) {
    // Query to fetch student data from different tables
    $studentData = [];

    // Fetch Personal Details
    $query = "SELECT * FROM stud_personal_details WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    $studentData['personal_details'] = $result->fetch_assoc();

    // Fetch Address Details
    $query = "SELECT * FROM stud_address WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    $studentData['address_details'] = $result->fetch_assoc();

    // Fetch Other Details
    $query = "SELECT * FROM stud_other_details WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    $studentData['other_details'] = $result->fetch_assoc();

    // Fetch Parents Details
    $query = "SELECT * FROM stud_parents_details WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    $studentData['parents_details'] = $result->fetch_assoc();

    // Fetch Academic Details
    $query = "SELECT * FROM stud_academic_details WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    $studentData['academic_details'] = $result->fetch_assoc();

    return $studentData;
}

// Function to create a PDF for a student
function createStudentPDF($studentData, $pdf) {
    // Add a new page for each student
    $pdf->AddPage();

    
    $pdf->Image('assets/images/semcom-logo.jpg', 170, 5, 25); // Path to the college logo
    // $pdf->SetFont('helvetica', 'B', 20);
    // $pdf->Cell(0, 15, 'STUDENT PROFILE', 0, 1, 'C');
    // $pdf->SetFont('helvetica', '', 12);
    // $pdf->Ln(5);
    // $pdf->Cell(0, 0, '', 'T'); // Top border
    // $pdf->Ln(10);

    // Profile Image and Personal Details

    // Header
    $html='<table style="padding-bottom:25px;">';
    $html .= '<tr>
                <td colspan="2" align="center"><h4>STUDENT PROFILE</h4></td>
              </tr>';
    $html .= '</table>';

    $html .= '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td rowspan="6"><img src="assets/images/uploaded_images/' . $studentData['personal_details']['pro_pic'] . '" width="100" height="130" /></td>
                <td><b>Admission Date:</b><br> ' . $studentData['personal_details']['adm_date'] . '</td>
                <td><b>SPID:</b><br> ' . $studentData['personal_details']['spid'] . '</td>
                <td><b>Current Admission Status:</b><br> ' . $studentData['personal_details']['adm_status'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>CVM University Enrollment ID:</b><br> ' . $studentData['personal_details']['enroll_no'] . '</td>
                <td><b>Roll Number:</b><br> ' . $studentData['personal_details']['roll_no'] . '</td>
                <td><b>Student Name:</b><br> ' . $studentData['personal_details']['f_name'] . ' ' . $studentData['personal_details']['m_name'] . ' ' . $studentData['personal_details']['l_name'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Gender:</b><br> ' . $studentData['personal_details']['gender'] . '</td>
                <td><b>Student\'s Mobile Number:</b><br> ' . $studentData['personal_details']['mob_no'] . '</td>
                <td><b>Student\'s Email ID:</b><br> ' . $studentData['personal_details']['email_id'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Aadhar Number:</b><br> ' . $studentData['personal_details']['aadhar_no'] . '</td>
                <td><b>ABC ID:</b><br> ' . $studentData['personal_details']['abc_id'] . '</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Address Section
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(0, 10, 'Address Section', 0, 1, 'L', 1);
    $pdf->Ln(5);
    $html = '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td><b>Localite / Hostelite:</b><br> ' . $studentData['address_details']['resident_type'] . '</td>
                <td><b>Permanent Address:</b><br> ' . $studentData['address_details']['permanent_add'] . ' ' . $studentData['address_details']['permanent_add2'] . '</td>
                <td><b>Permanent City:</b><br> ' . $studentData['address_details']['permanent_city'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Permanent Pincode:</b><br> ' . $studentData['address_details']['permanent_pincode'] . '</td>
                <td><b>Present Address:</b><br> ' . $studentData['address_details']['present_add'] . ' ' . $studentData['address_details']['present_add2'] . '</td>
                <td><b>Present City:</b><br> ' . $studentData['address_details']['present_city'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Present Pincode:</b><br> ' . $studentData['address_details']['present_pincode'] . '</td>
              </tr>';
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Other Details Section
    $pdf->Cell(0, 10, 'Other Details Section', 0, 1, 'L', 1);
    $pdf->Ln(5);
    $html = '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td><b>Birth Date:</b><br> ' . $studentData['other_details']['dob'] . '</td>
                <td><b>Blood Group:</b><br> ' . $studentData['other_details']['blood_grp'] . '</td>
                <td><b>Height:</b><br> ' . $studentData['other_details']['stud_height'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Weight:</b><br> ' . $studentData['other_details']['stud_weight'] . '</td>
                <td><b>Hobbies:</b><br> ' . $studentData['other_details']['stud_hobbies'] . '</td>
                <td><b>Category:</b><br> ' . $studentData['other_details']['stud_category'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Religion:</b><br> ' . $studentData['other_details']['stud_religion'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>English:</b><br> ' . $studentData['other_details']['eng_know'] . '</td>
                <td><b>Hindi:</b><br> ' . $studentData['other_details']['hindi_know'] . '</td>
                <td><b>Gujarati:</b><br> ' . $studentData['other_details']['guj_know'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Other Languages:</b><br> ' . $studentData['other_details']['other_know'] . '</td>
              </tr>';
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Parents Details Section
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Parents Details Section', 0, 1, 'L', 1);
    $pdf->Ln(5);
    $html = '<h3>Father\'s Details</h3>';
    $html .= '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td><b>Father\'s Name:</b><br> ' . $studentData['parents_details']['fathers_name'] . '</td>
                <td><b>Languages known by Father:</b><br> ' . $studentData['parents_details']['lang_father'] . '</td>
                <td><b>Father\'s Mobile Number:</b><br> ' . $studentData['parents_details']['fathers_mob'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Whether Father is using WhatsApp?</b><br> ' . $studentData['parents_details']['father_wp'] . '</td>
                <td><b>Father\'s Email ID:</b><br> ' . $studentData['parents_details']['fathers_email'] . '</td>
                <td><b>Father\'s Occupation:</b><br> ' . $studentData['parents_details']['fathers_occup'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Father\'s Company Name:</b><br> ' . $studentData['parents_details']['fathers_co'] . '</td>
                <td><b>Father\'s Designation:</b><br> ' . $studentData['parents_details']['fathers_desig'] . '</td>
                <td><b>Father\'s Annual Income:</b><br> ' . $studentData['parents_details']['fathers_annual_income'] . '</td>
              </tr>';
    $html .= '</table>';

    $html .= '<h3>Mother\'s Details</h3>';
    $html .= '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td><b>Mother\'s Name:</b><br> ' . $studentData['parents_details']['mothers_name'] . '</td>
                <td><b>Languages known by Mother:</b><br> ' . $studentData['parents_details']['lang_mother'] . '</td>
                <td><b>Mother\'s Mobile Number:</b><br> ' . $studentData['parents_details']['mothers_mob'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Whether Mother is using WhatsApp?</b><br> ' . $studentData['parents_details']['mother_wp'] . '</td>
                <td><b>Mother\'s Email ID:</b><br> ' . $studentData['parents_details']['mothers_email'] . '</td>
                <td><b>Mother\'s Occupation:</b><br> ' . $studentData['parents_details']['mothers_occup'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Mother\'s Company Name:</b><br> ' . $studentData['parents_details']['mothers_co'] . '</td>
                <td><b>Mother\'s Designation:</b><br> ' . $studentData['parents_details']['mothers_desig'] . '</td>
                <td><b>Mother\'s Annual Income:</b><br> ' . $studentData['parents_details']['mothers_annual_income'] . '</td>
              </tr>';
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Emergency Contact Details
    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Emergency Contact Detail', 0, 1, 'L', 1);
    $pdf->Ln(5);
    $html = '<table style="border-spacing:10px;">';
    $html .= '<tr>
                <td><b>Emergency Contact Mobile Number:</b><br> ' . $studentData['parents_details']['emergency_mob'] . '</td>
                <td><b>Person\'s Name (Other than Father and Mother):</b><br> ' . $studentData['parents_details']['emergency_name'] . '</td>
                <td><b>Relationship with Student:</b><br> ' . $studentData['parents_details']['emergency_relationship'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>Address of Person:</b><br> ' . $studentData['parents_details']['emergency_add'] . '</td>
                <td><b>City of Person:</b><br> ' . $studentData['parents_details']['emergency_city'] . '</td>
                <td><b>Pincode of Person:</b><br> ' . $studentData['parents_details']['emergency_pincode'] . '</td>
              </tr>';
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');
    
    $pdf->AddPage();
    // Academic Details Section
    $pdf->Cell(0, 10, 'Academic Details Section', 0, 1, 'L', 1);
    $pdf->Ln(5);
    $html = '<table style="border-spacing:10px;padding-bottom:5px;">';
    $html .= '<tr>
                <td><b>SSC Board Name:</b><br> ' . $studentData['academic_details']['ssc_board'] . '</td>
                <td colspan="2"><b>SSC Passing Month and Year:</b><br> ' . $studentData['academic_details']['ssc_month_year'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>SSC School Name:</b><br> ' . $studentData['academic_details']['ssc_school'] . '</td>
                <td><b>SSC Medium of Study:</b><br> ' . $studentData['academic_details']['ssc_medium'] . '</td>
                <td><b>SSC Percentage:</b><br> ' . $studentData['academic_details']['ssc_percentage'] . '</td>
              </tr>';
    $html .= '</table>';
    $html .= '<table style="border-spacing:10px;padding-bottom:5px;">';
    $html .= '<tr>
                <td><b>HSC Board Name:</b><br> ' . $studentData['academic_details']['hsc_board'] . '</td>
                <td colspan="2"><b>HSC Passing Month and Year:</b><br> ' . $studentData['academic_details']['hsc_month_year'] . '</td>
              </tr>';
    $html .= '<tr>
                <td><b>HSC School Name:</b><br> ' . $studentData['academic_details']['hsc_school'] . '</td>
                <td><b>HSC Percentage:</b><br> ' . $studentData['academic_details']['hsc_percentage'] . '</td>
                <td><b>HSC Medium of Study:</b><br> ' . $studentData['academic_details']['hsc_medium'] . '</td>
              </tr>';
    $html .= '<tr>
                <td colspan="3"><b>Achievements:</b><br> ' . $studentData['academic_details']['stud_achieve'] . '</td>
              </tr>';
    $html .= '</table>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Footer
    $pdf->Ln(10);
    $pdf->Cell(0, 0, '', 'T'); // Bottom border
    $pdf->Ln(5);
}

// Fetch student IDs from the database
$query = "SELECT enroll_no FROM stud_login WHERE complete_register = 'yes'";
$result = $conn->query($query);

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Student Profiles');
$pdf->SetSubject('Student Profile Details');
$pdf->SetKeywords('TCPDF, PDF, student, profile');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont("PDF_FONT_MONOSPACED");

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 15 , PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Loop through each student and create a PDF page for them
while ($row = $result->fetch_assoc()) {
    $studentData = getStudentData($conn, $row['enroll_no']);
    createStudentPDF($studentData, $pdf);
}

// Close and output PDF document
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to IST
$pdfFileName = 'student_profiles_' . date('Ymd_hia') . '.pdf';
$pdf->Output($pdfFileName, 'I');


// Close the database connection
$conn->close();
