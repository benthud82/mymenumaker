<?php

include_once 'globalincludes/connection.php';
//$today = date('Y-m-d');
$today = date('2019-06-03');


$result1 = $conn1->prepare("SELECT 
                                ci_mean, ci_lower, ci_upper
                            FROM
                                gillingham.fcast_ci
                            WHERE
                                ci_tier = 'ALL'
                                    AND ci_date = '$today'");
$result1->execute();

foreach ($result1 as $row) {
    $today_lower = intval($row['ci_lower']);
    $today_upper = intval($row['ci_upper']);
    $today_mean = intval($row['ci_mean']);
}