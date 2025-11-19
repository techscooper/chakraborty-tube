<?php
include '../../config.php';
if($ckadmin==1){
  ?>
  <div class="table-responsive">
    <table class="table table-sm table-bordered mb-0">
      <thead>
        <tr>
          <th class="text-center" style="width:10%;">#</th>
          <th class="text-center" style="width:10%;">Action</th>
          <th class="text-center" style="width:80%;">Category</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $categoryCnt=0;
        $getCategory=mysqli_query($conn,"SELECT * FROM `inventory_category` WHERE `stat`=1");
        while($rowCategory=mysqli_fetch_array($getCategory)){
          $categoryCnt++;
          $categoryUnqID=$rowCategory['unq_id'];
          $categoryName=$rowCategory['category_name'];
          ?>
          <tr>
            <td class="text-center"><?php echo $categoryCnt;?></td>
            <td class="text-center">
              <a href="javascript:void(0);" onclick="category_edit('<?php echo base64_encode($categoryUnqID);?>')">
              <i class="fa fa-edit fa-lg" title="Click to Update"></i>
            </a>
          </td>
          <td><b><?php echo $categoryName;?></b></td>
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