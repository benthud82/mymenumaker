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
            <h3>Add New Recipe</h3>


            <form id="form_recipe" action="">

                <div class="row">
                    <div class="col-lg-6"style="padding-top: 25px;">
                        <input type="text" name="main_desc" class="form-control" maxlength="65" placeholder="Enter Short Main Description" style="margin-bottom: 25px;"/>
                        <textarea  name="long_desc" class="form-control" placeholder="Enter Detailed Description"></textarea>
                    </div>
                    <div class="col-lg-6" style="padding-top: 25px;">
                        <input name="img_url" type='file' onchange="readURL(this);"  style="margin-bottom: 20px;" accept="image/*"/>
                        <img id="blah" src="http://placehold.it/180" alt="your image" />
                    </div>
                </div>



                <div class="row">
                    <table id="myTable" class=" table order-list">
                        <thead>
                            <tr>
                                <td class="col-sm-6">Ingredient</td>
                                <td class="col-sm-2">Quantity</td>
                                <td class="col-sm-3">Measurement</td>
                                <td class="col-sm-1"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="col-sm-6">
                                    <input type="text" name="ing" class="form-control" />
                                </td>
                                <td class="col-sm-2">
                                    <input type="mail" name="qty"  class="form-control"/>
                                </td>
                                <td class="col-sm-3">
                                    <input type="text" name="meas"  class="form-control"/>
                                </td>
                                <td class="col-sm-1"><a class="deleteRow"></a>

                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: left;">
                                    <input type="button" class="btn btn-lg btn-block " id="addrow" value="Add  More Ingredients" />
                                </td>
                            </tr>
                            <tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>




                <div class="row">
                    <table id="rec_steps" class=" table order-list">
                        <tbody>
                            <tr>
                                <td class="col-sm-12">
                                    <input type="text" name="step" class="form-control" />
                                </td>

                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: left;">
                                    <input type="button" class="btn btn-lg btn-block " id="addsteps" value="Add  More Steps" />
                                </td>
                            </tr>
                            <tr>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </form>
            <input value="Submit" type="submit" onclick="submitform()">

        </div>
    </div>
    <script>
        $(document).ready(function () {
            var counter = 0;
            var counter_steps = 0;
            //add row to the ingredients on click
            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="ing' + counter + '"/></td>';
                cols += '<td><input type="text" class="form-control" name="qty' + counter + '"/></td>';
                cols += '<td><input type="text" class="form-control" name="meas' + counter + '"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("#myTable").append(newRow);
                counter++;
            });

            //add row to the steps on click
            $("#addsteps").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="step' + counter_steps + '"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("#rec_steps").append(newRow);
                counter_steps++;
            });

            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter_steps -= 1;
            });


        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                            .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function submitform() {
            debugger;
            var formData = JSON.stringify($("#form_recipe").serializeArray());
            $.ajax({
                type: "POST",
                url: "postdata/post_addrecipe.php",
                data: formData,
                success: function () {},
                dataType: "json",
                contentType: "application/json"
            });

        }

    </script>
</body>
</html>