<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('course').addEventListener('change', function() {
            var course = this.value;
            if (course) {
                fetchOptions('semesters', {
                    course: course
                });
            } else {
                resetDropdown('semester');
                resetDropdown('division');
            }
        });

        document.getElementById('semester').addEventListener('change', function() {
            var course = document.getElementById('course').value;
            var semester = this.value;
            if (semester) {
                fetchOptions('divisions', {
                    course: course,
                    semester: semester
                });
            } else {
                resetDropdown('division');
            }
        });

        function fetchOptions(type, data) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Change to your backend endpoint
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    if (type == 'semesters') {
                        updateDropdown('semester', this.responseText);
                        resetDropdown('division');
                    } else if (type == 'divisions') {
                        updateDropdown('division', this.responseText);
                    }
                }
            };
            var params = 'fetch=' + type + '&' + new URLSearchParams(data).toString();
            xhr.send(params);
        }

        function updateDropdown(dropdownId, optionsHtml) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.innerHTML = optionsHtml;
            dropdown.disabled = false;
        }

        function resetDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            dropdown.innerHTML = '<option value="">--Select--</option>';
            dropdown.disabled = true;
        }
    });
</script>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fetch']) && $_POST['fetch'] == 'semesters') {
        $course = $_POST['course'];
        $result = $conn->query("SELECT DISTINCT class_semester FROM course_class WHERE course_name = '$course'");
        $options = '<option value="">--Select--</option>';
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row['class_semester'] . '">' . $row['class_semester'] . '</option>';
        }
        echo $options;
        exit();
    }

    if (isset($_POST['fetch']) && $_POST['fetch'] == 'divisions') {
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $result = $conn->query("SELECT DISTINCT class_div FROM course_class WHERE course_name = '$course' AND class_semester = '$semester'");
        $options = '<option value="">--Select--</option>';
        while ($row = $result->fetch_assoc()) {
            $options .= '<option value="' . $row['class_div'] . '">' . $row['class_div'] . '</option>';
        }
        echo $options;
        exit();
    }
}
?>
<div class="row">
    <div class="col-md-4 mb-4">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="course">Course</label>
            <select id="course" class="form-control form-control-md">
                <option value="">--Select--</option>
                <?php
                $result = $conn->query("SELECT DISTINCT course_name FROM course_class");
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['course_name'] . '">' . $row['course_name'] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" for="semester">Semester</label>
            <select id="semester" class="form-control form-control-md" disabled>
                <option value="">--Select--</option>
            </select>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div data-mdb-input-init class="form-outline">
            <label class="form-label" class="form-control form-control-md" for="division">Division</label>
            <select id="division" disabled>
                <option value="">--Select--</option>
            </select>
        </div>
    </div>
</div>