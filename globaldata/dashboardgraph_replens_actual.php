<?php

//Need replen data!!


include_once '../globalincludes/connection.php';


$result1 = $conn1->prepare("SELECT 
                                ci_date,
                                ci_tier,
                                ci_mean,
                                ci_lower,
                                ci_upper,
                                (SELECT 
                                        SUM(linesgrouped_lines)
                                    FROM
                                        gillingham.fcast_linesgrouped
                                    WHERE
                                        ci_date = linesgrouped_date and linesgrouped_tier like '%'
                                    GROUP BY linesgrouped_date) AS ACT_Lines
                            FROM
                                gillingham.fcast_ci
                            WHERE
                                ci_tier = 'ALL'
                                and ci_date <= '2019-05-23'");
$result1->execute();

$rows = array();
$rows['name'] = 'Date';
$rows1 = array();
$rows1['name'] = 'Mean Forecast';
$rows2 = array();
$rows2['name'] = 'Lower Bound';
$rows3 = array();
$rows3['name'] = 'Upper Bound';
$rows4 = array();
$rows4['name'] = 'Actual Lines';

foreach ($result1 as $row) {
    $rows['data'][] = $row['ci_date'];
    $rows1['data'][] = intval($row['ci_mean']);
    $rows2['data'][] = intval($row['ci_lower']);
    $rows3['data'][] = intval($row['ci_upper']);
    $rows4['data'][] = intval($row['ACT_Lines']);
}


$result = array();
array_push($result, $rows);
array_push($result, $rows1);
array_push($result, $rows2);
array_push($result, $rows3);
array_push($result, $rows4);


print json_encode($result);

