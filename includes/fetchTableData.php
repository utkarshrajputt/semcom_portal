<?php
    // Function to fetch data from the database
    function fetchData($tbl,$enroll, $conn)
    {
        $sql = "SELECT * FROM $tbl WHERE enroll_no = '$enroll'";
        $stmt = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($stmt);
        return ($data) ? $data : array();
    }
