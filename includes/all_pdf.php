<?php
require("../config/mysqli_db.php");
require_once('../assets/libraries/pdf/tcpdf.php');

// Function to fetch student data
function getStudentData($conn, $enroll_no)
{
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

    $query = "SELECT * FROM stud_result WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $studentData['result'][] = $row;
    }
    // $studentData['result'] = $result->fetch_assoc();

    $query = "SELECT * FROM stud_achieve WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $studentData['achieve'][] = $row;
    }

    $query = "SELECT * FROM stud_counsel WHERE enroll_no = $enroll_no";
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $studentData['counsel'][] = $row;
    }

    return $studentData;
}

// Function to create a PDF for a student
function createStudentPDF($studentData, $pdf)
{
    // Add a page
    $pdf->AddPage();

    // Set some content to print
    $pdf->Image('assets/images/semcom-logo.jpg', 170, 5, 25); // Path to the college logo
    $html = '

        <h3 align="Center">STUDENT PROFILE</h3>
        <!-- Personal Information -->
        <div class="section" style="width:90%;">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px;  color: #003366;">Personal Information</h2>
            <table width="90%" style="border-spacing:5px;">
                <tr>
                    <td width="25%">
                    <br><br>
                        <img src="../assets/images/uploaded_images/' . $studentData['personal_details']['pro_pic'] . '" alt="profile pic"  width="150" height="130" />
                    </td>
                    <td>
                        <table class="per-info" style="width: 100%; border-collapse: collapse;border-spacing:5px;">
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Admission Date</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['adm_date'] . '</td>
                            </tr>
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">SPID</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['spid'] . '</td>
                            </tr>
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Current Admission Status</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['adm_status'] . '</td>
                            </tr>
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Enrollment ID</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['enroll_no'] . '</td>
                            </tr>
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Roll No</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['roll_no'] . '</td>
                            </tr>
                            <tr>
                                <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Student Name</th>
                                <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['f_name'] . ' ' . $studentData['personal_details']['m_name'] . ' ' . $studentData['personal_details']['l_name'] . '</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <br>
            <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Gender</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['gender'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Student Mobile No</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['mob_no'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Student Email</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['email_id'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Aadhar No</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">1234 ' . $studentData['personal_details']['aadhar_no'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">ABC ID</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['personal_details']['abc_id'] . '</td>
                </tr>
            </table>
        </div>

        <!-- Address Information -->
        <div class="section" style="">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px; margin-bottom: 10px; color: #003366;">Address Information</h2>
            <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Localite or Hostel</th>
                    <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['address_details']['resident_type'] . '</td>
                </tr>
                <tr>
                    <th rowspan="2" style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Permanent Address</th>
                    <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                        ' . $studentData['address_details']['permanent_add'] . ' ' . $studentData['address_details']['permanent_add2'] . '
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                        City :  ' . $studentData['address_details']['permanent_city'] . '
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                        Pincode: ' . $studentData['address_details']['permanent_pincode'] . '
                    </td>
                </tr>
                <tr>
                    <th rowspan="2" style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Present Address</th>
                    <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                       ' . $studentData['address_details']['present_add'] . ' ' . $studentData['address_details']['present_add2'] . '
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                        City : ' . $studentData['address_details']['present_city'] . '
                    </td>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                        Pincode: ' . $studentData['address_details']['present_pincode'] . '
                    </td>
                </tr>
            </table>
        </div>

        <!-- Other Details -->
        <div class="section" style="">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px; margin-bottom: 10px; color: #003366;">Other Details</h2>
            <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Date of Birth</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;"> ' . $studentData['other_details']['dob'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Blood Group</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['blood_grp'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Height</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['stud_height'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Weight</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['stud_weight'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Hobbies</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['stud_hobbies'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Category</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['stud_category'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Religion</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['other_details']['stud_religion'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Languages</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">&nbsp;English:' . $studentData['other_details']['eng_know'] . ',<br> Hindi:' . $studentData['other_details']['hindi_know'] . ',<br> Gujarati:' . $studentData['other_details']['guj_know'] . ',<br> Other Language:' . $studentData['other_details']['other_know'] . '</td>
                </tr>
            </table>
        </div>

        <!-- Parents\' Details -->
        <div class="section" style="">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px; margin-bottom: 10px; color: #003366;">Parents\' Details</h2>
            <div class="father-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">Father\'s Details</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father\'s Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_name'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Language Known by Father</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['lang_father'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father\'s Mobile No</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_mob'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Using WhatsApp?</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['father_wp'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Email</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_email'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Occupation</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_occup'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Company Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;"> ' . $studentData['parents_details']['fathers_co'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Designation</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_desig'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Father Annual Income</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['fathers_annual_income'] . '</td>
                    </tr>
                </table>
            </div>
            <div class="mother-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">Mother\'s Details</h3>
                 <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother\'s Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_name'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Language Known by Mother</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['lang_mother'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother\'s Mobile No</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_mob'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Using WhatsApp?</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mother_wp'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Email</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_email'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Occupation</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_occup'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Company Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;"> ' . $studentData['parents_details']['mothers_co'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Designation</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_desig'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mother Annual Income</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['mothers_annual_income'] . '</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Emergency Contact Information -->
        <div class="section" style="">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px; margin-bottom: 10px; color: #003366;">Emergency Contact Information</h2>
            <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Emergency Mobile No</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_mob'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Person Name</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_name'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Relation</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_relationship'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Address</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_add'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">City</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_city'] . '</td>
                </tr>
                <tr>
                    <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Pincode</th>
                    <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['parents_details']['emergency_pincode'] . '</td>
                </tr>
            </table>
        </div>

        <!-- Academic Details Information -->
        <div class="section" style="">
            <h2 style="font-size: 18px; border-bottom: 2px solid #003366; padding-bottom: 5px; margin-bottom: 10px; color: #003366;">Academic Details Information</h2>
            <div class="ssc-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">SSC Details</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">SSC Board Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['ssc_board'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Passing Month and Year</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['ssc_month_year'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">School Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['ssc_school'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Medium of Study</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['ssc_medium'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Percentage</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['ssc_percentage'] . '</td>
                    </tr>
                </table>
            </div>
            <div class="hsc-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">HSC Details</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">HSC Board Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['hsc_board'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Passing Month and Year</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['hsc_month_year'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">School Name</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['hsc_school'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Medium of Study</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['hsc_medium'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Percentage</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['hsc_percentage'] . '</td>
                    </tr>
                    <tr>
                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Achievements</th>
                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $studentData['academic_details']['stud_achieve'] . '</td>
                    </tr>
                </table>
            </div>
            
        </div>
        <div class="result-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">Result</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">';

    if (!empty($studentData['result'])) {
        foreach ($studentData['result'] as $resultDtl) {
            $html .= '<tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Semester ' . htmlspecialchars($resultDtl['semester']) . '</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">
                                        <table>
                                            <tr>
                                                <td>SGPA: ' . htmlspecialchars($resultDtl['sgpa']) . '</td>
                                                <td>CGPA: ' . htmlspecialchars($resultDtl['cgpa']) . '</td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>';
        }
    } else {
        $html .= '<tr>
                                        <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">NO RECORDS FOUND</td>
                                </tr>';
    }

    $html .= '</table>            
        </div>
        <div class="achieve-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">Achievements</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">';

    if (!empty($studentData['achieve'])) {
        $i = 0;
        foreach ($studentData['achieve'] as $resultDtl) {
            $i++;
            $html .= '<tr>
                                        <td style="text-align: left;">Sr No:' . $i . '</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Semester :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['semester'] . '</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Event Date :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['event_date'] . '</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Event name :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['event'] . '</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Description :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['description'] . '</td>
                                    </tr>';
        }
    } else {
        $html .= '<tr>
                                        <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">NO RECORDS FOUND</td>
                                </tr>';
    }

    $html .= '</table>            
        </div>
        <div class="counsel-details" style="">
                <h3 style="font-size: 16px; margin-bottom: 10px; color: #003366;">Counselling Details</h3>
                <table style="width: 90%; border-collapse: collapse;border-spacing:5px;">';

    if (!empty($studentData['counsel'])) {
        $i = 0;
        foreach ($studentData['counsel'] as $resultDtl) {
            $i++;
            $html .= '<tr>
                                        <td style="text-align: left;">Session:' . $i . '</td>
                                 </tr>
                                <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Date and Time(24hr format) :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['c_date'] . ' ' . $resultDtl['c_time'] . '</td>
                                 </tr>
                                 <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Counselling OF :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['counselling_of'] . '</td>
                                 </tr>
                                 <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Mode :</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['mode_counsel'] . '</td>
                                 </tr>
                                 <tr>
                                        <th style="width: 260px; border: 1px solid #ddd; padding: 10px; text-align: left; background-color: #f2f2f2;">Description</th>
                                        <td style="border: 1px solid #ddd; padding: 10px; text-align: left;">' . $resultDtl['counsel_session_info'] . '</td>
                                 </tr>';
        }
    } else {
        $html .= '<tr>
                                        <td colspan="2" style="border: 1px solid #ddd; padding: 10px; text-align: left;">NO RECORDS FOUND</td>
                                </tr>';
    }

    $html .= '</table>            
        </div>
</body>
</html>

    ';

    // Write HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');
}

// Create new TCPDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Student Profiles');
$pdf->SetSubject('Student Profile Details');
$pdf->SetKeywords('TCPDF, PDF, student, profile');

// Set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Loop through each student and create a PDF page for them
if ((isset($_GET['start'])) && (isset($_GET['end']))) {
    $start = $_GET['start'];
    $end = $_GET['end'];
    $query = "SELECT enroll_no FROM stud_login WHERE enroll_no >= '$start' AND enroll_no <= '$end' AND complete_register = 'yes'";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $studentData = getStudentData($conn, $row['enroll_no']);
        createStudentPDF($studentData, $pdf);
    }
}

// Close and output PDF document
date_default_timezone_set('Asia/Kolkata'); // Set the timezone to IST
$pdfFileName = 'student_profiles_' . date('Ymd_hia') . '.pdf';
$pdf->Output($pdfFileName, 'I');

// Close the database connection
$conn->close();
