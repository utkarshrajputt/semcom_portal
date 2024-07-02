<div id="excelDiv" class="container mt-5" style="display:none;">
<h3 class="text-center"><u>EXCEL REPORT</u></h3>
    <form method="get" action="../admin/report/selected_fetch_excel.php" onsubmit="return validateExcelForm()">
        <!-- Radio buttons for entry type -->
        <div class="mb-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="entryExcelType" id="selectTableRadio" value="selectTable" checked onclick="toggleExcelEntry('excel', 'selectTable')">
                <label class="form-check-label" for="selectTableRadio">Select Table</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="entryExcelType" id="selectTableColumnRadio" value="selectTableColumn" onclick="toggleExcelEntry('excel', 'selectTableColumn')">
                <label class="form-check-label" for="selectTableColumnRadio">Select Table and Column</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="entryExcelType" id="allRadio" value="selectAll" onclick="toggleExcelEntry('excel', 'selectAll')">
                <label class="form-check-label" for="allRadio">All</label>
            </div>
        </div>



        <!-- Select Table Section -->
        <div class="form-group col-md-6" id="excelSelectTable">
            <label for="selectTable">Select Table</label>
            <select class="form-select" id="selectTable" name="excelTables[]">
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
            <div class="form-group col-md-6">
                <input type="hidden" class="startEnroll" name="excel_start">
                <input type="hidden" class="endEnroll" name="excel_end">
                <button name="excel_submit" type="submit" class="btn btn-success mt-3">Submit</button>
            </div>
        </div>

        <!-- Select Table and Column Section -->
        <div class="form-group col-md-6" id="excelSelectTableColumn" style="display: none;">
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
                            <select class="form-select" name="tables[]" onchange="populateColumns(this, 0)">
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
                            <select class="form-select" name="columns[]">
                                <option value="">Select Column</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary mx-2" onclick="addRow()">Add</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group col-md-6">
                <input type="hidden" class="startEnroll" name="excel_start">
                <input type="hidden" class="endEnroll" name="excel_end">
                <button name="excel_submit" type="submit" class="btn btn-success mt-3">Submit</button>
            </div>
        </div>
        <div class="form-group col-md-6" id="excelSelectAll" style="display: none;">
            <div class="form-group col-md-6">
                <input type="hidden" id="all_start" class="startEnroll" name="excel_start">
                <input type="hidden" id="all_end" class="endEnroll" name="excel_end">
                <button ID="all_submit" type="button" class="btn btn-success mt-3">Submit</button>
            </div>
        </div>
        <!-- Submit Button -->

    </form>
</div>

<!-- Bootstrap JS and your custom script for toggling visibility -->
<script>
    // Table columns data
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

    // Function to populate columns based on selected table



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

    // Function to add a new row for table and column selection
    function addRow() {
        const table = document.getElementById('dynamicTable');
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);

        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);

        cell1.innerHTML = `<select class="form-select" name="tables[]" onchange="populateColumns(this, ${rowCount})">
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

        cell2.innerHTML = `<select class="form-select" name="columns[]">
                                <option value="">Select Column</option>
                              </select>`;

        cell3.innerHTML = ` <button type="button" class="btn btn-primary mx-2" onclick="addRow()">Add</button><button type="button" class="btn btn-danger" onclick="deleteRow(this)">Delete</button>`;
    }

    // Function to delete a row from the table
    function deleteRow(btn) {
        const row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function toggleExcelEntry(role, entryExcelType) {
        var allEntry = document.getElementById(role + 'SelectAll');
        var singleEntry = document.getElementById(role + 'SelectTable');
        var rangeEntry = document.getElementById(role + 'SelectTableColumn');


        // Check if elements exist before accessing their style property
        if (allEntry) {
            allEntry.style.display = (entryExcelType === 'selectAll') ? 'block' : 'none';
        } else {
            console.warn('Element for All Entry not found.');
        }

        if (singleEntry) {
            singleEntry.style.display = (entryExcelType === 'selectTable') ? 'block' : 'none';
        } else {
            console.warn('Element for Single Entry not found.');
        }

        if (rangeEntry) {
            rangeEntry.style.display = (entryExcelType === 'selectTableColumn') ? 'block' : 'none';
        } else {
            console.warn('Element for Range Entry not found.');
        }
    }

    function validateExcelForm() {
        const entryType = document.querySelector('input[name="entryExcelType"]:checked').value;

        // Check for visible dropdowns and ensure selection
        if (entryType === 'selectTable') {
            const selectTable = document.getElementById('selectTable');
            if (selectTable.style.display !== 'none') {
                if (selectTable.value === '') {
                    alert('Please select a table.');
                    return false;
                }
            }
        }

        if (entryType === 'selectTableColumn') {
            const tablesSelects = document.getElementsByName('tables[]');
            let allValid = true;

            tablesSelects.forEach((select, index) => {
                if (select.parentNode.parentNode.style.display !== 'none') {
                    if (select.value === '') {
                        alert(`Please select a table in row ${index + 1}.`);
                        allValid = false;
                    }
                }
            });

            if (!allValid) {
                return false;
            }

            const columnsSelects = document.getElementsByName('columns[]');
            allValid = true;

            columnsSelects.forEach((select, index) => {
                if (select.parentNode.parentNode.style.display !== 'none') {
                    if (select.value === '') {
                        alert(`Please select a column in row ${index + 1}.`);
                        allValid = false;
                    }
                }
            });

            if (!allValid) {
                return false;
            }
        }


        return true;
    }
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('all_submit').addEventListener('click', function() {
            var start = document.getElementById('all_start').value;
            var end = document.getElementById('all_end').value;
            window.location.href = "../admin/report/all_excel.php?excel_start=" + start + "&excel_end=" + end + "";
        });
    });
</script>

</body>

</html>