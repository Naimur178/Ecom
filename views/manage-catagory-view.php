<?php
$obj_adminBack= new adminBack();
$ctg_data=$obj_adminBack->display_catagory();

if(isset($_GET['status'])){
    $get_id=$_GET['id'];
    
    if($_GET['status']=='publish'){
        $obj_adminBack->publish_catagory($get_id);
    }elseif($_GET['status']=='unpublish'){
        $obj_adminBack->unpublish_catagory($get_id);
    }elseif($_GET['status']=='delete'){
        $msg=$obj_adminBack->delete_catagory($get_id);
    }
}

?>
<h2 align="center">Manage Catagory</h2>
<?php
if(isset($msg)){
    echo $msg;
}
?>
<table class="table">
    <thead>
        <tr>
            <th>Catagory ID</th>
            <th>Catagory Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Update/Delete</th>

        </tr>
    </thead>
    <tbody>
        <?php
        while($ctg=mysqli_fetch_assoc($ctg_data)){
            ?>
            <tr>
                <td><?php  echo $ctg['ctg_id'] ;?></td>
                <td><?php  echo $ctg['ctg_name'] ;?></td>
                <td><?php  echo $ctg['ctg_des']; ?></td>
                <td>
                    <?php
                    if($ctg['ctg_status']==0){
                        echo "Unpublished";
                        ?>
                        <a class="btn btn-sm btn-success" 
                        href="?status=publish&&id=<?php  echo $ctg['ctg_id'];?>">Make Publish</a>
                        <?php
                    }
                    else{
                        echo "Published";

                        ?>
                        <a class="btn btn-sm btn-danger" 
                        href="?status=unpublish&&id=<?php  echo $ctg['ctg_id'] ?>">Make Unpublished</a>
                        <?php

                    }
                    ?>
                </td>
                <td>
                    <a href="edit_cat.php?status=edit&&id=<?php echo $ctg['ctg_id'] ; ?>">Edit</a>
                    <a href="?status=delete&&id=<?php echo $ctg['ctg_id'] ; ?>">Delete</a>
                </td>
            </tr>



<?php
        }

        ?>
    </tbody>

</table>