<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'headerincludes.php' ?>
    <?php
    include 'verticalnav.php';
    include 'globaldata/dashboardgraph_replens_actual_range.php';  //returns json with range and date data for highchart
    include 'globaldata/forecast_today.php';  //returns json with range and date data for highchart
    ?>
</head>

<body>


    <div id="right-panel" class="right-panel">
        <?php include 'horizontalnav.php'; ?>
        <div class="content mt-3">

            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="p-0 clearfix">
                            <i class="fa fa-line-chart bg-success p-4 px-5 font-2xl mr-3 float-left text-light"></i>
                            <div class="h5 text-info mb-0 pt-3 "><span class="count"><?php echo ($today_mean); ?></span></div>
                            <div class="text-muted text-uppercase font-weight-bold font-xs small">Today's Forecast</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="p-0 clearfix">
                            <i class="ti-upload bg-info p-4 px-5 font-2xl mr-3 float-left text-light"></i>
                            <div class="h5 text-info mb-0 pt-3 count"><?php echo ($today_upper); ?></div>
                            <div class="text-muted text-uppercase font-weight-bold font-xs small">High Forecast</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="p-0 clearfix">
                            <i class="ti-download bg-info p-4 px-5 font-2xl mr-3 float-left text-light"></i>
                            <div class="h5 text-info mb-0 pt-3 count"><?php echo ($today_lower); ?></div>
                            <div class="text-muted text-uppercase font-weight-bold font-xs small">Low Forecast</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <!--Historical Actual Replens graph-->
                    <section class="panel hidewrapper" id="graph_historicalreplens_actual" style="margin-bottom: 50px; margin-top: 20px;"> 

                        <div id="historicalreplens_actual" class="panel-body" style="background: #efefef">
                            <div id="chartpage_replen_actual"  class="page-break" >
                                <div id="charts padded">
                                    <div id="container_replens_actual" class="dashboardstyle printrotate"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">

                    <div id="table_forecastacc"></div>

                    <div class="col-md-6">
                        TEST TEST TEST
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        $(document).ready(function () {
            var userid = 'BHUD01';
            //ajax for loose replen reduction opportunity
            $.ajax({
                url: 'globaldata/table_forecastaccuracy.php',
                data: {userid: userid},
                type: 'POST',
                dataType: 'html',
                success: function (ajaxresult) {
                    $("#table_forecastacc").html(ajaxresult);
                }
            });
        });

        $('.count').each(function () {
            debugger;
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
        Highcharts.chart('container_replens_actual', {
            chart: {
                zoomType: 'x',
                events: {
                    load: function () {
                        var chart = this,
                                yAxis = chart.yAxis[0],
                                yExtremes = yAxis.getExtremes(),
                                newMin = yExtremes.dataMin - 5,
                                newMax = yExtremes.dataMax + 5;

                        yAxis.setExtremes(newMin, newMax, true, false);
                    }
                }
            },

            title: {
                text: 'Lines Forecast'
            },

            xAxis: {
                type: 'datetime'
            },

            yAxis: {
                title: {
                    text: null
                }
            },

            tooltip: {
                crosshairs: true,
                shared: true

            },

            legend: {
            },

            series: [{
                    name: 'Actual Lines',
                    data: <?php echo $averages; ?>,
                    zIndex: 1,
                    marker: {
                        fillColor: 'white',
                        lineWidth: 2,
                        lineColor: Highcharts.getOptions().colors[0]
                    }
                }, {
                    name: 'Range',
                    data: <?php echo $ranges; ?>,
                    type: 'arearange',
                    lineWidth: 0,
                    linkedTo: ':previous',
                    color: Highcharts.getOptions().colors[1],
                    fillOpacity: 0.2,
                    zIndex: 0,
                    marker: {
                        enabled: false
                    }
                }]
        });
    </script>

</body>
</html>