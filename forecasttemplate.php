<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headerincludes.php' ?>
    <?php
    include 'verticalnav.php';
    ?>
</head>

<body>


    <div id="right-panel" class="right-panel">
        <?php include 'horizontalnav.php'; ?>
        <div class="content mt-3">

            <!--Historical Actual Replens graph-->
            <section class="panel hidewrapper" id="graph_historicalreplens_actual" style="margin-bottom: 50px; margin-top: 20px;"> 

                <div id="historicalreplens_actual" class="panel-body" style="background: #efefef">
                    <div id="chartpage_replen_actual"  class="page-break" style="width: 100%; height: 1200px">
                        <div id="charts padded">

                            <div id="container_replens_actual" class="dashboardstyle printrotate"></div>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </div>

    <script>

        //options for actual replens highchart
        var options3 = {
            chart: {
                marginTop: 50,
                marginBottom: 135,
                 height: 700,
                renderTo: 'container_replens_actual',
                type: 'spline',
                zoomType: 'x'
            }, credits: {
                enabled: false
            },
            plotOptions: {
                spline: {
//                    marker: {
//                        enabled: false
//                    }
                },
                series: {
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {
                                window.open('movesdetail.php?startdate=' + this.category + '&enddate=' + this.category + '&formSubmit=Submit');
                            }
                        }
                    }
                }
            },
            title: {
                text: ' '
            },
            xAxis: {
                categories: [], labels: {
                    rotation: -90,
                    y: 25,
                    align: 'right',
                    step: 1,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                },
                legend: {
                    y: "10",
                    x: "5"
                }

            },
            yAxis: {
                title: {
                    text: 'Completed Replenshments'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }],
                opposite: true
            }, tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + Highcharts.numberFormat(this.y, 0);
                }
            },
            series: []
        };
        $.ajax({
            url: 'globaldata/dashboardgraph_replens_actual.php',
//            data: {"userid": userid},
            type: 'GET',
            dataType: 'json',
            async: 'true',
            success: function (json) {
                options3.xAxis.categories = json[0]['data'];
                options3.series[0] = json[1];
                options3.series[1] = json[2];
                options3.series[2] = json[3];
                options3.series[3] = json[4];

                chart = new Highcharts.Chart(options3);
                series = chart.series;
                $(window).resize();
            }
        });

    </script>

</body>
</html>