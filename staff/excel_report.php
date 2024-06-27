<div class="container mt-5">
        <h2 class="mb-4">Generate Excel with Custom Columns</h2>
        <form method="post" action="generate_excel.php">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select Table</th>
                        <th>Select Column</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="dynamicTable">
                    <tr>
                        <td>
                            <select class="form-select" name="tables[]" onchange="populateColumns(this, 0)" required>
                                <option value="">Select Table</option>
                                <option value="stud_login">Student Login</option>
                                <option value="stud_personal_details">Personal Details</option>
                                <option value="stud_address">Address Details</option>
                                <option value="stud_other_details">Other Details</option>
                                <option value="stud_parents_details">Parents Details</option>
                                <option value="stud_academic_details">Academic Details</option>
                                <option value="stud_result">Result Details</option>
                                <option value="stud_achieve">Achievements</option>
                                <option value="stud_counsel">Counseling Details</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="columns[]" required>
                                <option value="">Select Column</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" onclick="addRow()">Add</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success mt-3">Submit</button>
        </form>
    </div>

    <script>
        const tableColumns = {
            "stud_login": {
                "stud_id": "Student ID",
                "enroll_no": "Enrollment Number",
                "password": "Password",
                "complete_register": "Registration Status"
            },
            "stud_personal_details": {
                "stud_id": "Student ID",
                "adm_status": "Admission Status",
                "adm_date": "Admission Date",
                "spid": "SPID",
                "enroll_no": "Enrollment Number",
                "stud_course": "Course",
                "stud_sem": "Semester",
                "stud_div": "Division",
                "roll_no": "Roll Number",
                "f_name": "First Name",
                "m_name": "Middle Name",
                "l_name": "Last Name",
                "gender": "Gender",
                "mob_no": "Mobile Number",
                "email_id": "Email ID",
                "aadhar_no": "Aadhar Number",
                "abc_id": "ABC ID",
                "pro_pic": "Profile Picture"
            },
            "stud_address": {
                "add_id": "Address ID",
                "enroll_no": "Enrollment Number",
                "resident_type": "Resident Type",
                "permanent_add": "Permanent Address",
                "permanent_add2": "Permanent Address Line 2",
                "permanent_city": "Permanent City",
                "permanent_pincode": "Permanent Pincode",
                "present_add": "Present Address",
                "present_add2": "Present Address Line 2",
                "present_city": "Present City",
                "present_pincode": "Present Pincode"
            },
            "stud_other_details": {
                "other_id": "Other ID",
                "enroll_no": "Enrollment Number",
                "dob": "Date of Birth",
                "blood_grp": "Blood Group",
                "stud_height": "Height",
                "stud_weight": "Weight",
                "stud_hobbies": "Hobbies",
                "stud_category": "Category",
                "stud_religion": "Religion",
                "eng_know": "English Knowledge",
                "hindi_know": "Hindi Knowledge",
                "guj_know": "Gujarati Knowledge",
                "other_know": "Other Languages Known"
            },
            "stud_parents_details": {
                "p_id": "Parent ID",
                "enroll_no": "Enrollment Number",
                "fathers_name": "Father's Name",
                "lang_father": "Father's Language",
                "fathers_mob": "Father's Mobile Number",
                "father_wp": "Father's WhatsApp",
                "fathers_email": "Father's Email ID",
                "fathers_occup": "Father's Occupation",
                "fathers_co": "Father's Company",
                "fathers_desig": "Father's Designation",
                "fathers_annual_income": "Father's Annual Income",
                "mothers_name": "Mother's Name",
                "lang_mother": "Mother's Language",
                "mothers_mob": "Mother's Mobile Number",
                "mother_wp": "Mother's WhatsApp",
                "mothers_email": "Mother's Email ID",
                "mothers_occup": "Mother's Occupation",
                "mothers_co": "Mother's Company",
                "mothers_desig": "Mother's Designation",
                "mothers_annual_income": "Mother's Annual Income",
                "emergency_mob": "Emergency Mobile Number",
                "emergency_name": "Emergency Contact Name",
                "emergency_relationship": "Emergency Contact Relationship",
                "emergency_add": "Emergency Contact Address",
                "emergency_city": "Emergency Contact City",
                "emergency_pincode": "Emergency Contact Pincode"
            },
            "stud_academic_details": {
                "academic_id": "Academic ID",
                "enroll_no": "Enrollment Number",
                "ssc_board": "SSC Board",
                "ssc_month_year": "SSC Month & Year",
                "ssc_percentage": "SSC Percentage",
                "ssc_school": "SSC School",
                "ssc_medium": "SSC Medium",
                "hsc_board": "HSC Board",
                "hsc_month_year": "HSC Month & Year",
                "hsc_percentage": "HSC Percentage",
                "hsc_school": "HSC School",
                "hsc_medium": "HSC Medium",
                "stud_achieve": "Achievements"
            },
            "stud_result": {
                "result_id": "Result ID",
                "enroll_no": "Enrollment Number",
                "course": "Course",
                "semester": "Semester",
                "sgpa": "SGPA",
                "cgpa": "CGPA",
                "result_img": "Result Image",
                "add_request": "Add Request"
            },
            "stud_achieve": {
                "ach_id": "Achievement ID",
                "enroll_no": "Enrollment Number",
                "semester": "Semester",
                "event_date": "Event Date",
                "event": "Event",
                "description": "Description"
            },
            "stud_counsel": {
                "c_id": "Counseling ID",
                "enroll_no": "Enrollment Number",
                "c_date": "Counseling Date",
                "counselling_of": "Counseling Of",
                "mode_counsel": "Mode of Counseling",
                "c_time": "Counseling Time",
                "counsel_session_info": "Session Information"
            }
        };

        function populateColumns(selectObj, rowIndex) {
            const selectedTable = selectObj.value;
            const columnSelect = document.getElementsByName('columns[]')[rowIndex];

            columnSelect.innerHTML = '<option value="">Select Column</option>'; // Clear previous options

            if (tableColumns[selectedTable]) {
                for (const [columnValue, columnText] of Object.entries(tableColumns[selectedTable])) {
                    const option = document.createElement('option');
                    option.value = columnValue;
                    option.text = columnText;
                    columnSelect.appendChild(option);
                }
            }
        }

        function addRow() {
            const table = document.getElementById('dynamicTable');
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);

            cell1.innerHTML = `<select class="form-select" name="tables[]" onchange="populateColumns(this, ${rowCount})" required>
                                <option value="">Select Table</option>
                                <option value="stud_login">Student Login</option>
                                <option value="stud_personal_details">Personal Details</option>
                                <option value="stud_address">Address Details</option>
                                <option value="stud_other_details">Other Details</option>
                                <option value="stud_parents_details">Parents Details</option>
                                <option value="stud_academic_details">Academic Details</option>
                                <option value="stud_result">Result Details</option>
                                <option value="stud_achieve">Achievements</option>
                                <option value="stud_counsel">Counseling Details</option>
                              </select>`;

            cell2.innerHTML = `<select class="form-select" name="columns[]" required>
                                <option value="">Select Column</option>
                              </select>`;

            cell3.innerHTML = `<button type="button" class="btn btn-danger" onclick="deleteRow(this)">Delete</button>`;
        }

        function deleteRow(btn) {
            const row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>