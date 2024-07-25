<?php
// Database connection
require("../../config/mysqli_db.php");
require '../../assets/libraries/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Function to fetch all student data grouped by sections
function getAllStudentData($con, $enrollnos)
{
    // Convert the enrollment number range to a comma-separated string
    $enrollNosStr = implode(",", $enrollnos);

    // Fetch main student data within the enrollment number range
    $query = "SELECT * FROM stud_personal_details spd
                      JOIN stud_address sa ON spd.enroll_no = sa.enroll_no
                      JOIN stud_other_details sod ON spd.enroll_no = sod.enroll_no
                      JOIN stud_parents_details spd2 ON spd.enroll_no = spd2.enroll_no
                      JOIN stud_academic_details sad ON spd.enroll_no = sad.enroll_no
                      WHERE spd.enroll_no IN ($enrollNosStr)";
    $result = $con->query($query);
    $students = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch additional data from other tables
    foreach ($students as &$student) {
        // Fetch results
        $query = "SELECT * FROM stud_result WHERE enroll_no = '{$student['enroll_no']}' and add_request='accepted'";
        $result = $con->query($query);
        $student['results'] = $result->fetch_all(MYSQLI_ASSOC);

        // Fetch achievements
        $query = "SELECT * FROM stud_achieve WHERE enroll_no = '{$student['enroll_no']}'";
        $result = $con->query($query);
        $student['achievements'] = $result->fetch_all(MYSQLI_ASSOC);

        // Fetch counsel details
        $query = "SELECT * FROM stud_counsel WHERE enroll_no = '{$student['enroll_no']}'";
        $result = $con->query($query);
        $student['counsel'] = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $students;
}


// Example usage
$course = $_GET['excel_course'];
$sem = $_GET['excel_sem'];
$div = $_GET['excel_div'];

// Fetch enrollment number range based on course, semester, and division
$dataResult = mysqli_query($conn, "SELECT class_enroll_start, class_enroll_end,other_enrolls FROM course_class WHERE course_name='" . $course . "' AND class_semester='" . $sem . "' AND class_div='" . $div . "'");

$enrollDtl = $dataResult->fetch_assoc();
$start = $enrollDtl['class_enroll_start'];
$end = $enrollDtl['class_enroll_end'];
$other_enrolls = $enrollDtl['other_enrolls'];
$other_enrolls_array = array_map('trim', explode(',', $other_enrolls));

// Merge the range enrollments with the additional enrollments
$all_enrolls = range($start, $end);
$all_enrolls = array_merge($all_enrolls, $other_enrolls_array);
// Remove duplicates in case some enrollments are in both the range and the additional list
$enrollNos = array_unique($all_enrolls);

// Convert the array to a comma-separated string for use in the SQL IN clause
// $enrollNosStr = implode(',', $all_enrolls);
$students = getAllStudentData($conn, $enrollNos);

// Separate arrays for each section of data
$personalDetails = [];
$addressDetails = [];
$otherDetails = [];
$parentsDetails = [];
$academicDetails = [];
$resultDetails = [];
$achievementDetails = [];
$counselDetails = [];

foreach ($students as $student) {
    // Personal Details
    $personalDetails[] = [
        'Enrollment No' => $student['enroll_no'],
        'Admission Status' => $student['adm_status'],
        'Admission Date' => $student['adm_date'],
        'SPID' => $student['spid'],
        'Course' => $student['stud_course'],
        'Roll No' => $student['roll_no'],
        'Name' => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
        'Gender' => $student['gender'],
        'Mobile No' => $student['mob_no'],
        'Email ID' => $student['email_id'],
        'Aadhaar No' => $student['aadhar_no'],
        'ABC ID' => $student['abc_id'],
        'Profile Pic' => '../../assets/images/uploaded_images/' . $student['pro_pic']
    ];

    // Address Details
    $addressDetails[] = [
        'Enrollment No' => $student['enroll_no'],
        'Name' => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
        'Localite/Hostelite' => $student['resident_type'],
        'Present Address Line 1' => $student['present_add'],
        'Present Address Line 2' => $student['present_add2'],
        'Present City' => $student['present_city'],
        'Present Pincode' => $student['present_pincode'],
        'Permanent Address Line 1' => $student['permanent_add'],
        'Permanent Address Line 2' => $student['permanent_add2'],
        'Permanent City' => $student['permanent_city'],
        'Permanent Pincode' => $student['permanent_pincode']
    ];

    // Other Details
    $otherDetails[] = [
        'Enrollment No' => $student['enroll_no'],
        'Name' => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
        'Date of Birth' => $student['dob'],
        'Blood Group' => $student['blood_grp'],
        'Height' => $student['stud_height'],
        'Weight' => $student['stud_weight'],
        'Hobbies' => $student['stud_hobbies'],
        'Category' => $student['stud_category'],
        'Religion' => $student['stud_religion'],
        'English Knowledge' => $student['eng_know'],
        'Hindi Knowledge' => $student['hindi_know'],
        'Gujarati Knowledge' => $student['guj_know'],
        'Other Language' => $student['other_know']
    ];

    // Parents Details
    $parentsDetails[] = [
        'Enrollment No' => $student['enroll_no'],
        'Name' => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
        'Father\'s Name' => $student['fathers_name'],
        'Languages Known By Father' => $student['lang_father'],
        'Father\'s Mobile No' => $student['fathers_mob'],
        'Father\'s Uses Whatsapp?' => $student['father_wp'],
        'Father\'s Email' => $student['fathers_email'],
        'Father\'s Company' => $student['fathers_co'],
        'Father\'s Occupation' => $student['fathers_occup'],
        'Father\'s Annual Income' => $student['fathers_annual_income'],
        'Mother\'s Name' => $student['mothers_name'],
        'Languages Known By Mother' => $student['lang_mother'],
        'Mother\'s Mobile No' => $student['mothers_mob'],
        'Mother\'s Uses Whatsapp?' => $student['mother_wp'],
        'Mother\'s Email' => $student['mothers_email'],
        'Mother\'s Company' => $student['mothers_co'],
        'Mother\'s Occupation' => $student['mothers_occup'],
        'Mother\'s Annual Income' => $student['mothers_annual_income'],
        'Emergency Mobile' => $student['emergency_mob'],
        'Emergency Person Name' => $student['emergency_name'],
        'Relationship With Person' => $student['emergency_relationship'],
        'Person Address' => $student['emergency_add'],
        'Person City' => $student['emergency_city'],
        'Person Pincode' => $student['emergency_pincode']
    ];

    // Academic Details
    $academicDetails[] = [
        'Enrollment No' => $student['enroll_no'],
        'Name' => $student['f_name'] . ' ' . $student['m_name'] . ' ' . $student['l_name'],
        'SSC Board Name' => $student['ssc_board'],
        'SSC Passing Month and Year' => $student['ssc_month_year'],
        'SSC Percentage' => $student['ssc_percentage'],
        'SSC School Name' => $student['ssc_school'],
        'SSC Medium Of Study' => $student['ssc_medium'],
        'HSC Board Name' => $student['hsc_board'],
        'HSC Passing Month and Year' => $student['hsc_month_year'],
        'HSC Percentage' => $student['hsc_percentage'],
        'HSC School Name' => $student['hsc_school'],
        'HSC Medium Of Study' => $student['hsc_medium'],
        'Achievements' => $student['stud_achieve']
    ];

    // Result Details
    foreach ($student['results'] as $result) {
        $resultDetails[] = [
            'Enrollment No' => $result['enroll_no'],
            'Course' => $result['course'],
            'Semester' => $result['semester'],
            'SGPA' => $result['sgpa'],
            'CGPA' => $result['cgpa'],
            'Result Image' => '../../assets/images/result_images/' . $result['result_img']
        ];
    }

    // Achievement Details
    foreach ($student['achievements'] as $achievement) {
        $achievementDetails[] = [
            'Enrollment No' => $achievement['enroll_no'],
            'Semester' => $achievement['semester'],
            'Event Date' => $achievement['event_date'],
            'Event' => $achievement['event'],
            'Description' => $achievement['description']
        ];
    }

    // Counsel Details
    foreach ($student['counsel'] as $counsel) {
        $counselDetails[] = [
            'Enrollment No' => $counsel['enroll_no'],
            'Counsel Date' => $counsel['c_date'],
            'Counseling Of' => $counsel['counselling_of'],
            'Mode of Counsel' => $counsel['mode_counsel'],
            'Counsel Time' => $counsel['c_time'],
            'Counsel Session Info' => $counsel['counsel_session_info']
        ];
    }
}

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('SEMCOM')
    ->setTitle('Student Profiles');

// Add data to separate sheets
if (!empty($personalDetails)) {
    // Create Personal Details sheet
    createSheet($spreadsheet, $personalDetails, 'Personal Details');
}

if (!empty($addressDetails)) {
    // Create Address Details sheet
    createSheet($spreadsheet, $addressDetails, 'Address Details');
}

if (!empty($otherDetails)) {
    // Create Other Details sheet
    createSheet($spreadsheet, $otherDetails, 'Other Details');
}

if (!empty($parentsDetails)) {
    // Create Parents Details sheet
    createSheet($spreadsheet, $parentsDetails, 'Parents Details');
}

if (!empty($academicDetails)) {
    // Create Academic Details sheet
    createSheet($spreadsheet, $academicDetails, 'Academic Details');
}

if (!empty($resultDetails)) {
    // Create Result Details sheet
    createSheet($spreadsheet, $resultDetails, 'Result Details');
}

if (!empty($achievementDetails)) {
    // Create Achievement Details sheet
    createSheet($spreadsheet, $achievementDetails, 'Achievement Details');
}

if (!empty($counselDetails)) {
    // Create Counsel Details sheet
    createSheet($spreadsheet, $counselDetails, 'Counsel Details');
}


// Remove the default sheet created by PhpSpreadsheet
$spreadsheet->removeSheetByIndex(0);

// Function to add data to a sheet
function createSheet($spreadsheet, $data, $sheetName)
{
    $sheet = $spreadsheet->createSheet();
    $sheet->setTitle($sheetName);

    // Add headers
    $headerRow = 1;
    foreach ($data[0] as $key => $value) {
        $sheet->setCellValueByColumnAndRow(array_search($key, array_keys($data[0])) + 1, $headerRow, $key);
    }

    // Add data
    $row = 2;
    foreach ($data as $rowArray) {
        $col = 1;
        foreach ($rowArray as $key => $value) {
            if ($key === 'Profile Pic' || $key === 'Result Image') {
                // Insert image into cell
                $imagePath = $value; // Assuming $value is the file path to the image
                $drawing = new Drawing();
                $drawing->setName('Image');
                $drawing->setDescription('Image');
                $drawing->setPath($imagePath);
                $drawing->setCoordinates($sheet->getCellByColumnAndRow($col, $row)->getCoordinate());
                $drawing->setWorksheet($sheet);
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setHeight(100); // Height of the image
                $drawing->setWidth(100); // Width of the image
                $drawing->setResizeProportional(false); // Resize image proportionally

                // Calculate and set column width based on image dimensions
                $sheet->getColumnDimensionByColumn($col)->setAutoSize(false);
                $sheet->getColumnDimensionByColumn($col)->setWidth($drawing->getWidth() / 7); // Adjust divisor as needed

                // Set row height based on image height
                $sheet->getRowDimension($row)->setRowHeight($drawing->getHeight() + 10); // Add extra for padding

            } else {
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
        }
        $row++;
    }

    // Auto size columns
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Center align all cells
    $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
        ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
}

// Set headers for download
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to IST
$ExcelFileName = 'student_profiles_' . date('Ymd_hia') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $ExcelFileName . '"');
header('Cache-Control: max-age=0');

// Save the Excel file to php://output (browser)
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
