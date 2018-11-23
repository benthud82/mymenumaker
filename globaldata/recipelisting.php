<?php
include_once '../globalincludes/connection.php';

//$var_sort = $_POST['sort'];
//
//switch ($var_sort) {
//    case 'sort_nameasc':
//        $sql_sort = ' rec_shortname asc';
//        break;
//    default:
//        $sql_sort = ' rec_shortname asc';
//        break;
//}

$result2 = $conn1->prepare("SELECT rec_shortname, rec_description, picture_url, rec_dish FROM mymenumaker.recipe
                             JOIN mymenumaker.recipe_pictures on picture_id = rec_pictureid 
                             ;");  //$orderby pulled from: include 'slopecat_switch_orderby.php';
$result2->execute();
$recipelisting = $result2->fetchAll(pdo::FETCH_ASSOC);

foreach ($recipelisting as $key => $value) {
    ?>
    <div class="col-md-4">
        <div class="card " data-category="<?php echo $recipelisting[$key]['rec_dish'] ?>">
            <div class="card-header">
                <strong class="card-title" style="text-transform: uppercase"><?php echo $recipelisting[$key]['rec_shortname'] . ' - ' . $recipelisting[$key]['rec_dish'] ?> </strong>
            </div>
            <img class="card-img-top" src="images/<?php echo $recipelisting[$key]['picture_url'] ?>" alt="Card image cap" style="width:480px;height:240px;">
            <div class="card-body">
                <p class="card-text"><?php echo $recipelisting[$key]['rec_description'] ?></p>
                <div class="p-0 clearfix" style="cursor: pointer">
                    <i class="fa fa-plus-circle bg-primary p-4 font-2xl mr-3 float-left text-light"></i>
                    <div class="h5 text-primary mb-0 pt-3">Add to Menu</div>
                    <div class="text-muted text-uppercase font-weight-bold font-xs small">Last made: </div>
                </div>
            </div>
        </div>
    </div>


    <?php
}
