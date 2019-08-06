<?php
$startdate = date('Y-m-d', strtotime('-25 days'));
include_once '../globalincludes/connection.php';
$sql_acc = $conn1->prepare("SELECT 
                                ci_date,
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
                                and ci_date >= '$startdate'
                              ORDER BY ci_date desc");
$sql_acc->execute();
$array_acc = $sql_acc->fetchAll(pdo::FETCH_ASSOC);
?>
<div class="card">
    <div class="card-header">
        <strong class="card-title">25-Day Historical Accuracy</strong>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Actual Lines</th>
                    <th scope="col">Pred. Lines</th>
                    <th scope="col">MAPE</th>
                    <th scope="col">Forecast High</th>
                    <th scope="col">Forecast Low</th>
                </tr>
            </thead>
            <tbody class="">

                <?php
                foreach ($array_acc as $key => $value) {
                    $actlines = $array_acc[$key]['ACT_Lines'];
                    $predlines = $array_acc[$key]['ci_mean'];
                    if ($actlines > 0) {
                        $MAPE = number_format(abs(($actlines - $predlines) / $actlines)* 100,2).'%';
                    } else {
                        $MAPE = ' ';
                    }

                    echo '<tr class="hovercoloer">';
                    echo '<th scope="row">' . $array_acc[$key]['ci_date'] . '</th>';
                    echo '<td>' . $actlines . '</td>';
                    echo '<td>' . $array_acc[$key]['ci_mean'] . '</td>';
                    echo '<td>' . $MAPE . '</td>';
                    echo '<td>' . $array_acc[$key]['ci_upper'] . '</td>';
                    echo '<td>' . $array_acc[$key]['ci_lower'] . '</td>';

                    echo '</tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
