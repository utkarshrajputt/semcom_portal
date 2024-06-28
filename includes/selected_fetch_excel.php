<?php
// Database connection
require("../config/mysqli_db.php");
require '../assets/libraries/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Function to fetch selected data from multiple tables
function getSelectedStudentData($con, $tables, $columns = [])
{
    $tableColumnsMap = [
        "stud_login" => [
            "stud_id" => "Student ID",
            "enroll_no" => "Enrollment Number",
            "password" => "Password",
            "complete_register" => "Registration Status"
        ],
        "stud_personal_details" => [
            "stud_id" => "Student ID",
            "adm_status" => "Admission Status",
            "adm_date" => "Admission Date",
            "spid" => "SPID",
            "enroll_no" => "Enrollment Number",
            "stud_course" => "Course",
            "stud_sem" => "Semester",
            "stud_div" => "Division",
            "roll_no" => "Roll Number",
            "f_name" => "First Name",
            "m_name" => "Middle Name",
            "l_name" => "Last Name",
            "gender" => "Gender",
            "mob_no" => "Mobile Number",
            "email_id" => "Email ID",
            "aadhar_no" => "Aadhar Number",
            "abc_id" => "ABC ID",
            "pro_pic" => "Profile Picture"
        ],
        "stud_address" => [
            "add_id" => "Address ID",
            "enroll_no" => "Enrollment Number",
            "resident_type" => "Resident Type",
            "permanent_add" => "Permanent Address",
            "permanent_add2" => "Permanent Address Line 2",
            "permanent_city" => "Permanent City",
            "permanent_pincode" => "Permanent Pincode",
            "present_add" => "Present Address",
            "present_add2" => "Present Address Line 2",
            "present_city" => "Present City",
            "present_pincode" => "Present Pincode"
        ],
        "stud_other_details" => [
            "other_id" => "Other ID",
            "enroll_no" => "Enrollment Number",
            "dob" => "Date of Birth",
            "blood_grp" => "Blood Group",
            "stud_height" => "Height",
            "stud_weight" => "Weight",
            "stud_hobbies" => "Hobbies",
            "stud_category" => "Category",
            "stud_religion" => "Religion",
            "eng_know" => "English Knowledge",
            "hindi_know" => "Hindi Knowledge",
            "guj_know" => "Gujarati Knowledge",
            "other_know" => "Other Languages Known"
        ],
        "stud_parents_details" => [
            "p_id" => "Parent ID",
            "enroll_no" => "Enrollment Number",
            "fathers_name" => "Father's Name",
            "lang_father" => "Father's Language",
            "fathers_mob" => "Father's Mobile Number",
            "father_wp" => "Father's WhatsApp",
            "fathers_email" => "Father's Email ID",
            "fathers_occup" => "Father's Occupation",
            "fathers_co" => "Father's Company",
            "fathers_desig" => "Father's Designation",
            "fathers_annual_income" => "Father's Annual Income",
            "mothers_name" => "Mother's Name",
            "lang_mother" => "Mother's Language",
            "mothers_mob" => "Mother's Mobile Number",
            "mother_wp" => "Mother's WhatsApp",
            "mothers_email" => "Mother's Email ID",
            "mothers_occup" => "Mother's Occupation",
            "mothers_co" => "Mother's Company",
            "mothers_desig" => "Mother's Designation",
            "mothers_annual_income" => "Mother's Annual Income",
            "emergency_mob" => "Emergency Mobile Number",
            "emergency_name" => "Emergency Contact Name",
            "emergency_relationship" => "Emergency Contact Relationship",
            "emergency_add" => "Emergency Contact Address",
            "emergency_city" => "Emergency Contact City",
            "emergency_pincode" => "Emergency Contact Pincode"
        ],
        "stud_academic_details" => [
            "academic_id" => "Academic ID",
            "enroll_no" => "Enrollment Number",
            "ssc_board" => "SSC Board",
            "ssc_month_year" => "SSC Month & Year",
            "ssc_percentage" => "SSC Percentage",
            "ssc_school" => "SSC School",
            "ssc_medium" => "SSC Medium",
            "hsc_board" => "HSC Board",
            "hsc_month_year" => "HSC Month & Year",
            "hsc_percentage" => "HSC Percentage",
            "hsc_school" => "HSC School",
            "hsc_medium" => "HSC Medium",
            "stud_achieve" => "Achievements"
        ],
        "stud_result" => [
            "result_id" => "Result ID",
            "enroll_no" => "Enrollment Number",
            "course" => "Course",
            "semester" => "Semester",
            "sgpa" => "SGPA",
            "cgpa" => "CGPA",
            "result_img" => "Result Image",
            "add_request" => "Add Request"
        ],
        "stud_achieve" => [
            "ach_id" => "Achievement ID",
            "enroll_no" => "Enrollment Number",
            "semester" => "Semester",
            "event_date" => "Event Date",
            "event" => "Event",
            "description" => "Description"
        ],
        "stud_counsel" => [
            "c_id" => "Counseling ID",
            "enroll_no" => "Enrollment Number",
            "c_date" => "Counseling Date",
            "counselling_of" => "Counseling Of",
            "mode_counsel" => "Mode of Counseling",
            "c_time" => "Counseling Time",
            "counsel_session_info" => "Session Information"
        ]
    ];

    $data = [];

    // Fetch staff email from POST data
    $staff_email = $_POST['staff_email'];

    // Fetch class assignment details based on staff email
    $selectQuery = "SELECT course, semester, division FROM staff_class_assign WHERE staff_email='$staff_email'";
    $selectResult = $con->query($selectQuery);

    if ($selectResult->num_rows > 0) {
        $staff = $selectResult->fetch_assoc();

        // Fetch enrollment number range based on course, semester, and division
        $dataResult = mysqli_query($con, "SELECT class_enroll_start, class_enroll_end FROM course_class WHERE course_name='" . $staff['course'] . "' AND class_semester='" . $staff['semester'] . "' AND class_div='" . $staff['division'] . "'");

        if ($dataResult) {
            $enrollDtl = $dataResult->fetch_assoc();
            $enrollNos = range($enrollDtl['class_enroll_start'], $enrollDtl['class_enroll_end']);

            $enrollNosStr = implode("','", $enrollNos);

            foreach ($tables as $table) {
                // Determine columns to select based on specified columns or default to all columns
                if (empty($columns)) {
                    $columnsToSelect = array_keys($tableColumnsMap[$table]);
                } else {
                    $columnsToSelect = array_intersect($columns, array_keys($tableColumnsMap[$table]));
                }

                $query = "SELECT enroll_no, " . implode(', ', $columnsToSelect) . " FROM $table WHERE enroll_no IN ('$enrollNosStr')";
                $result = $con->query($query);

                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                    $enroll_no = $row['enroll_no'];

                    // Create a unique key combining table name and enrollment number
                    $key = $table . '_' . $i;
                    if (!isset($data[$key])) {
                        $data[$key] = [
                            'Enrollment Number' => $enroll_no
                        ];
                    }

                    foreach ($columnsToSelect as $column) {
                        $data[$key][$tableColumnsMap[$table][$column]] = $row[$column];
                    }
                }
            }
        }
    }

    return array_values($data); // Return indexed array
}
// Fetch selected tables and columns from the form submission
if (isset($_POST['entryExcelType'])) {
    $entryType = $_POST['entryExcelType'];

    if ($entryType == 'selectTableColumn') {
        $selectedTables = $_POST['tables'];
        $selectedColumns = $_POST['columns'];

        // Fetch selected student data
        $studentsData = getSelectedStudentData($conn, $selectedTables, $selectedColumns);
    } else if ($entryType == 'selectTable') {
        $selectedTables = $_POST['excelTables'];

        // Fetch selected student data (default to all columns)
        $studentsData = getSelectedStudentData($conn, $selectedTables);
    }

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Selected Data');

    // Add headers
    if (!empty($studentsData)) {
        $headers = array_keys($studentsData[0]);
        foreach ($headers as $index => $header) {
            $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1) . '1';
            $sheet->setCellValue($cellAddress, $header);
        }

        // Add data
        $rowIndex = 2;
        foreach ($studentsData as $studentData) {
            $colIndex = 1;
            foreach ($headers as $header) {
                $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $studentData[$header] ?? '');
                $colIndex++;
            }
            $rowIndex++;
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
    } else {
        // Handle case where $studentsData is empty or doesn't have expected structure
        echo "No data available for selected criteria.";
    }
}
