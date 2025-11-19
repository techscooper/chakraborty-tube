<?php
include '../../config.php';
$slc=0;
$getList=mysqli_query($conn,"SELECT * FROM `expense_group` WHERE `stat`!='-1' ORDER BY `group_name`");
if(mysqli_num_rows($getList)>0){
?>
<div class="table-responsive">
  <table class="table table-sm table-bordered mt-3">
    <thead class="bg-dark text-white">
      <tr>
        <th class="text-center" style="width:10%;">#</th>
        <th class="text-center" style="width:20%;">Action</th>
        <th class="text-center" style="width:70%;">Group Name</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($rowList=mysqli_fetch_array($getList)){
        $slc++;
        $unq_id=$rowList['unq_id'];
        $group_name=$rowList['group_name'];
        $stat=$rowList['stat'];

        $tbl_nm = 'expense_group';
        $act_field = 'stat';
        $act_value = $stat;
        $unq_field = 'unq_id';
        $unq_value = $unq_id;

        if($act_value==1){
           $actlogo="../assets/allpic/active.png";
           $ttl="Click to De-active";
        }
        else{
           $actlogo="../assets/allpic/deactive.png";
           $ttl="Click to Active";
        }
        ?>
        <tr>
          <td class="text-center"><?php echo $slc;?></td>
          <td class="text-center">
            <a href="javascript:void(0);" onclick="updateExpense('<?php echo base64_encode($unq_id);?>')"><i class="fa fa-edit fa-lg"></i></a>
            <span class="p-1" id="div<?php echo $unq_value;?>">
              <a href="javascript:void(0);" onclick="act_dact_level('<?php echo $tbl_nm;?>','<?php echo $act_field;?>','<?php echo $act_value;?>','<?php echo $unq_field;?>','<?php echo $unq_value;?>')">
                <img src="<?php echo $actlogo;?>" style="width:20px; height:20px;" title="<?php echo $ttl;?>">
              </a>
            </span>
          </td>
          <td><b><?php echo $group_name;?></b></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
<?php
}
?>
