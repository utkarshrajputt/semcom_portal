<?php
require('../includes/loader.php');
require('../includes/session.php');
require('../config/mysqli_db.php');

$admin_email = $_SESSION['admin_email'];

if (!isset($admin_email)) {
    header('location:admin_login.php');
    exit(); // Ensure script execution stops after redirect
}

function getUniqueSemesters($conn)
{
    $semesters = [];
    $query = "SELECT DISTINCT class_semester FROM course_class";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $semesters[] = $row['class_semester'];
        }
        $result->free();
    } else {
        throw new Exception("Error fetching semesters: " . $conn->error);
    }
    return $semesters;
}

function getStudentCounts($conn, $semester)
{
    $counts = [];
    $query = "SELECT stud_course, stud_sem, stud_div, COUNT(*) as student_count 
              FROM stud_personal_details 
              WHERE stud_sem = '$semester'
              GROUP BY stud_course, stud_sem, stud_div";
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $counts[] = $row;
        }
        $result->free();
    } else {
        throw new Exception("Error fetching student counts: " . $conn->error);
    }
    return $counts;
}

try {
    $semesters = getUniqueSemesters($conn);
    $currentSemester = isset($_GET['semester']) ? $_GET['semester'] : $semesters[0];
    $studentCounts = getStudentCounts($conn, $currentSemester);
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    die("Error: " . $e->getMessage()); // Stop further script execution if an error occurs
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon.ico">
    <title>SEMCOM</title>

    <!-- BOOTSTRAP & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a79beb4099.js" crossorigin="anonymous"></script>

    <!-- BOXICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">


    <!-- MAIN STUDENT CSS -->
    <link rel="stylesheet" href="../assets/css/student.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .dash-btn,
        .dash-btn:hover {

            border: none;
            background-color: transparent;
        }

        .responsive-img {
            max-width: 100%;
            height: 95%;
            margin-top: -35px;
            margin-left: 40px;
        }

        .dash-btn:focus {
            outline: none;
            box-shadow: none;
        }

        .nav_link {
            margin-bottom: 20px;
        }

        .dropdown {
            margin-top: 25px;
            padding-top: 15px;
        }
    </style>
</head>

<body id="body-pd">
    <?php require '../includes/sidebar-admin.php'; ?>
    <br>
    <div class="container mt-3">
        <h2 align="center">Student Data Transfer</h2>
        <p style="color:red;">Note: Once data get transfered successfully you can not undo changes.<br>**Refresh the page after any action</p>
        <div class="mt-4 mb-3">
            <label for="semesterSelect" class="form-label">Select Semester</label>
            <select id="semesterSelect" class="form-select" onchange="updateTable()">
                <?php foreach ($semesters as $semester) : ?>
                    <option value="<?php echo $semester; ?>" <?php if ($semester == $currentSemester) echo 'selected'; ?>>
                        <?php echo $semester; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="table-responsive text-center">
            <table class="table table-bordered table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Division</th>
                        <th>Number of Students</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentCounts as $row) : ?>
                        <tr>
                            <td><?php echo $row['stud_course']; ?></td>
                            <td><?php echo $row['stud_sem']; ?></td>
                            <td><?php echo $row['stud_div']; ?></td>
                            <td><?php echo $row['student_count']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="stud_course" value="<?php echo $row['stud_course']; ?>">
                                    <input type="hidden" name="stud_sem" value="<?php echo $row['stud_sem']; ?>">
                                    <input type="hidden" name="stud_div" value="<?php echo $row['stud_div']; ?>">
                                    <button type="submit" name="transfer" class="btn btn-primary">Transfer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateTable() {
            var semester = document.getElementById('semesterSelect').value;
            window.location.href = 'transfer_data.php?semester=' + semester;
        }
    </script>
    <script src="../assets/js/main.js"></script>
    <?php
    if (isset($_POST['transfer'])) {

        $stud_course = $_POST['stud_course'];
        $stud_sem = $_POST['stud_sem'];
        $stud_div = $_POST['stud_div'];

        try {
            // Get enroll_no list
            $enrollNos = [];
            $sql = "SELECT enroll_no FROM stud_personal_details WHERE stud_course='$stud_course' AND stud_sem='$stud_sem' AND stud_div='$stud_div'";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                throw new Exception("Error fetching enroll_no list: " . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $enrollNos[] = $row['enroll_no'];
            }

            if (empty($enrollNos)) {
                throw new Exception("No records found to transfer");
            }

            // Establish connection to semcom_alumni database
            $alumni_conn = new mysqli('localhost', 'semcom', 'semcom', 'semcom_alumini');

            if ($alumni_conn->connect_error) {
                throw new Exception("Connection failed: " . $alumni_conn->connect_error);
            }
            // Insert stud_login data first
            foreach ($enrollNos as $enroll_no) {
                $sql = "SELECT * FROM stud_login WHERE enroll_no='$enroll_no'";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    throw new Exception("Error fetching data from stud_login: " . mysqli_error($conn));
                }

                while ($row = mysqli_fetch_assoc($result)) {
                    $columns = array_keys($row);
                    $columns_str = implode(", ", $columns);
                    $values = array_map(function ($value) use ($alumni_conn) {
                        return "'" . $alumni_conn->real_escape_string($value) . "'";
                    }, array_values($row));
                    $values_str = implode(", ", $values);

                    $insert_sql = "INSERT INTO stud_login ($columns_str) VALUES ($values_str)";
                    if (!mysqli_query($alumni_conn, $insert_sql)) {
                        throw new Exception("Error transferring data to stud_login: " . mysqli_error($alumni_conn));
                    }
                }
            }

            $tables = [
                'stud_academic_details',
                'stud_achieve',
                'stud_address',
                'stud_counsel',
                'stud_other_details',
                'stud_parents_details',
                'stud_personal_details',
                'stud_result'
            ];

            foreach ($tables as $table) {
                foreach ($enrollNos as $enroll_no) {
                    
                    $sql = "SELECT * FROM $table WHERE enroll_no='$enroll_no'";
                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        throw new Exception("Error fetching data from $table: " . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_assoc($result)) {
                        $columns = array_keys($row);
                        $columns_str = implode(", ", $columns);
                        $values = array_map(function ($value) use ($alumni_conn) {
                            return "'" . $alumni_conn->real_escape_string($value) . "'";
                        }, array_values($row));
                        $values_str = implode(", ", $values);

                        $insert_sql = "INSERT INTO $table ($columns_str) VALUES ($values_str)";
                        if (!mysqli_query($alumni_conn, $insert_sql)) {
                            throw new Exception("Error transferring data to $table: " . mysqli_error($alumni_conn));
                        }
                    }
                }
            }

            // Move images and delete originals
            foreach ($enrollNos as $enroll_no) {
                // Move pro_pic images
                $sql = "SELECT pro_pic FROM stud_personal_details WHERE enroll_no='$enroll_no'";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    throw new Exception("Error fetching pro_pic: " . mysqli_error($conn));
                }
                $row = mysqli_fetch_assoc($result);
                $source = "../assets/images/uploaded_images/" . $row['pro_pic'];
                $destination = "../alumini/uploaded_images/" . $row['pro_pic'];
                if (file_exists($source)) {
                    if (!copy($source, $destination)) {
                        throw new Exception("Error copying image: $source");
                    }
                    if (!unlink($source)) {
                        throw new Exception("Error deleting image: $source");
                    }
                }

                // Move result_img images
                $sql = "SELECT result_img FROM stud_result WHERE enroll_no='$enroll_no'";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    throw new Exception("Error fetching result_img: " . mysqli_error($conn));
                }
                $row = mysqli_fetch_assoc($result);
                $source = "../assets/images/result_images/" . $row['result_img'];
                $destination = "../alumini/result_images/" . $row['result_img'];
                if (file_exists($source)) {
                    if (!copy($source, $destination)) {
                        throw new Exception("Error copying image: $source");
                    }
                    if (!unlink($source)) {
                        throw new Exception("Error deleting image: $source");
                    }
                }
            }
            // Delete records from original database
            foreach ($enrollNos as $enroll_no) {
                foreach ($tables as $table) {
                    $delete_sql = "DELETE FROM $table WHERE enroll_no='$enroll_no'";
                    if (!mysqli_query($conn, $delete_sql)) {
                        throw new Exception("Error deleting data from $table: " . mysqli_error($conn));
                    }
                }
            }

            // Delete stud_login records from original database
            foreach ($enrollNos as $enroll_no) {
                $delete_sql = "DELETE FROM stud_login WHERE enroll_no='$enroll_no'";
                if (!mysqli_query($conn, $delete_sql)) {
                    throw new Exception("Error deleting data from stud_login: " . mysqli_error($conn));
                }
            }
            // Close the alumni database connection
            $alumni_conn->close();

            // Alert success message
            echo "<script>alert('Transfer Successful');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        } finally {
            // Close the main database connection
            mysqli_close($conn);
        }
    }
    ?>

</body>

</html>