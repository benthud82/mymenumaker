<?php

include_once 'globalincludes/connection.php';
$startdate = '2019-04-01';
$enddate = '2019-06-31';


$result1 = $conn1->prepare("SELECT 
                                ci_date, ci_tier, ci_mean, ci_lower, ci_upper
                            FROM
                                gillingham.fcast_ci
                                    JOIN
                                gillingham.workdayofweek ON ci_date = workday_date
                                    LEFT JOIN
                                gillingham.fcast_dateexcl ON ci_date = exclude_date
                            WHERE
                                ci_tier = 'ALL'
                                    AND (workday_befvac + workday_aftvac + workday_befchrist + workday_aftchrist) = 0
                                    AND ci_date BETWEEN '$startdate' AND '$enddate'
                                    AND exclude_date IS NULL");
$result1->execute();

$result2 = $conn1->prepare("SELECT 
                                    linesgrouped_date, SUM(linesgrouped_lines) AS ACT_Lines
                                FROM
                                    gillingham.fcast_linesgrouped
                                        JOIN
                                    gillingham.workdayofweek ON linesgrouped_date = workday_date
                                        LEFT JOIN
                                    gillingham.fcast_dateexcl ON linesgrouped_date = exclude_date
                                WHERE
                                    linesgrouped_tier LIKE '%'
                                        AND linesgrouped_date BETWEEN '$startdate' AND '$enddate'
                                        AND (workday_befvac + workday_aftvac + workday_befchrist + workday_aftchrist) = 0
                                        AND exclude_date IS NULL
                                GROUP BY linesgrouped_date");
$result2->execute();




//$rows = array();
foreach ($result1 as $row) {
    $epcchdate = strtotime($row['ci_date'] ) * 1000;
//    $epcchdate = ($row['ci_date'] ) ;
    $lower = intval($row['ci_lower']);
    $upper = intval($row['ci_upper']);

    $ranges[] = array($epcchdate, $lower, $upper);
}
foreach ($result2 as $row2) {
    $epcchdate = strtotime($row2['linesgrouped_date'] ) * 1000;
   // $epcchdate = ($row2['linesgrouped_date'] );
    $actual = intval($row2['ACT_Lines']);
    
    $averages[] = array($epcchdate, $actual);
}

$result = array();
$averages = json_encode($averages);
$ranges = json_encode($ranges);


