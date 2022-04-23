<?php
$obj_adminBack =new adminBack();
if(isset($_POST['ctg_btn'])){
    $return_mesg=$obj_adminBack->add_catagory(($_POST));
}

?>


<h2>Add Catagory</h2>

<form action="" method="post">
    <div class="form-group">
        <label for="ctg_name"> Catagory Name

        </label>
        <input type="text" name="ctg_name" class="form-control">
    </div>
    <div class="form-group">
        <label for="ctg_des"> Description

        </label>
        <input type="text" name="ctg_des" class="form-control">
    </div>
    <div class="form-group">
        <label for="ctg_status"> Status

        </label>
        <select name="ctg_status" class="form-control">
            <option value="0">Unpublished</option>
            <option value="1">Published</option>
        </select>
    </div>
    <input type="submit" value="Add Catagory" name="ctg_btn" class="btn btn-primary">
    <?php
    if(isset($return_mesg)){
        echo $return_mesg;
    }
    ?>

</form>