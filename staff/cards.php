<?php
$selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
$selectResult = $conn->query($selectQuery);
if ($selectResult->num_rows > 0) {
    $row = $selectResult->fetch_assoc();
    $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end,other_enrolls from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");

    try {
        $data = $dataResult->fetch_assoc();
        $start = $data['class_enroll_start'];
        $end = $data['class_enroll_end'];
        $other_enrolls = $data['other_enrolls'];
        $other_enrolls_array = array_map('trim', explode(',', $other_enrolls));

        // Merge the range enrollments with the additional enrollments
        $all_enrolls = range($start, $end);
        $all_enrolls = array_merge($all_enrolls, $other_enrolls_array);
        // Remove duplicates in case some enrollments are in both the range and the additional list
        $all_enrolls = array_unique($all_enrolls);

        // Convert the array to a comma-separated string for use in the SQL IN clause
        $enroll_list = implode(',', $all_enrolls);

        // Queries
        if (!(($start == 'NULL' || $start == '') && ($end == 'NULL' || $end == ''))) {
            $loginQuery = "SELECT COUNT(*) FROM stud_login WHERE enroll_no IN ($enroll_list)";
            $loginResult = mysqli_query($conn, $loginQuery);
            $loginData = mysqli_fetch_row($loginResult);

            $completeQuery = "SELECT COUNT(*) FROM stud_login WHERE enroll_no IN ($enroll_list) AND complete_register='yes'";
            $completeResult = mysqli_query($conn, $completeQuery);
            $completeData = mysqli_fetch_row($completeResult);

            $resQuery = "SELECT COUNT(*) FROM stud_result WHERE enroll_no IN ($enroll_list) AND add_request='pending'";
            $resResult = mysqli_query($conn, $resQuery);
            $resData = mysqli_fetch_row($resResult);

            $counselQuery = "SELECT COUNT(*) FROM stud_counsel WHERE enroll_no IN ($enroll_list)";
            $counselResult = mysqli_query($conn, $counselQuery);
            $counselData = mysqli_fetch_row($counselResult);
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3> <?php if (isset($loginData[0])) {
                                echo $loginData[0];
                            } else {
                                echo "0";
                            } ?></h3>
                    <p> Total Students </p>
                </div>
                <div class="icon">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                </div>

            </div>
        </div>

        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3> <?php if (isset($completeData[0])) {
                                echo $completeData[0];
                            } else {
                                echo "0";
                            } ?></h3>
                    <p> Registration Completed Students </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-user-check" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                    <h3> <?php if (isset($resData[0])) {
                                echo $resData[0];
                            } else {
                                echo "0";
                            } ?></h3>
                    <p> Result Requests </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-square-poll-vertical" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-red">
                <div class="inner">
                    <h3> <?php if (isset($counselData[0])) {
                                echo $counselData[0];
                            } else {
                                echo "0";
                            } ?> </h3>
                    <p> Total Counselling Achieved </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>

            </div>
        </div>
    </div>
</div>