<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recipe Listing</title>
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
            <!--Left side filtering-->
            <div class="col-md-3">
                <button id="loaddata" type="button" class="btn btn-primary" onclick="getrecipe();" >Load Data</button>

                This should be on the left side.
            </div>
            <!--Recipe cards-->
            <div class="col-md-9">
                <div id="ctn_viewrecipe"></div>
            </div>
        </div>
    </div>

    <script>
        function getrecipe() {
            debugger;
            $.ajax({
                url: 'globaldata/recipelisting.php',
                dataType: 'html',
                success: function (ajaxresult) {
                    $("#ctn_viewrecipe").html(ajaxresult);
                }
            });
        }

    </script>

</body>
</html>