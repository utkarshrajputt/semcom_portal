<?php
    $selectQuery = "select course,semester,division from staff_class_assign where staff_email='$staff_email'";
    $selectResult = $conn->query($selectQuery);
    if ($selectResult->num_rows > 0) {
        $row = $selectResult->fetch_assoc();
        $dataResult = mysqli_query($conn, "select class_enroll_start,class_enroll_end from course_class where course_name='" . $row['course'] . "' and class_semester='" . $row['semester'] . "' and class_div='" . $row['division'] . "'");
        try {
            $data = $dataResult->fetch_assoc();
            $start=$data['class_enroll_start'];
            $end=$data['class_enroll_end'];
            $loginQuery = "select count(*) from stud_login where enroll_no>=$start and enroll_no<=$end";
            $loginRersult = mysqli_query($conn, $loginQuery);
            $loginData = mysqli_fetch_row($loginRersult);

            $completeQuery = "select count(*) from stud_login where enroll_no>=$start and enroll_no<=$end and complete_register='yes'";
            $completeRersult = mysqli_query($conn, $completeQuery);
            $completeData = mysqli_fetch_row($completeRersult);

            $resQuery = "select count(*) from stud_result where enroll_no>=$start and enroll_no<=$end and add_request='pending'";
            $resRersult = mysqli_query($conn, $resQuery);
            $resData = mysqli_fetch_row($resRersult);

            $counselQuery = "select count(*) from stud_counsel where enroll_no>=$start and enroll_no<=$end";
            $counselRersult = mysqli_query($conn, $counselQuery);
            $counselData = mysqli_fetch_row($counselRersult);
        } catch (mysqli_sql_exception $e) {
        }
    }
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3> <?php echo $loginData[0] ?></h3>
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
                    <h3> <?php echo $completeData[0] ?></h3>
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
                    <h3> <?php echo $resData[0] ?></h3>
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
                    <h3>  <?php echo $counselData[0] ?> </h3>
                    <p> Total Counselling Achieved </p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>

            </div>
        </div>
    </div>
</div>