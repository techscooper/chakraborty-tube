<?php
include '../../config.php';
$allsrc=mysqli_real_escape_string($conn,rawurldecode($_REQUEST['allsrc']));
$af="%".$allsrc."%";
if($allsrc!=''){$a2=" AND (`customer_nm` LIKE '$af' OR `mobile_no` LIKE '$af' OR `address_1` LIKE '$af')";}else{$a2='';}
$slc=0;
$get_customer_dtls=mysqli_query($conn,"SELECT * FROM `customer_tbl` WHERE `stat`=1 $a2 ORDER BY `customer_nm`");
$rcnt_customer_dtls=mysqli_num_rows($get_customer_dtls);
if($rcnt_customer_dtls>0){
?>
<div class="table-responsive">
  <table class="table table-bordered mb-0">
    <thead>
      <tr>
        <th class="text-center" style="width:5%;">#</th>
        <th class="text-center" style="width:10%;">Action</th>
        <th class="text-center" style="width:30%;">Customer  Details</th>
        <th class="text-center" style="width:30%;">Contact Details</th>
        <th class="text-center" style="width:25%;">Others Details</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($row_customer_dtls=mysqli_fetch_array($get_customer_dtls)){
        $slc++;
        $customer_unq_id=$row_customer_dtls['unq_id'];
        $customer_nm=$row_customer_dtls['customer_nm'];
        $email_id=$row_customer_dtls['email_id'];
        $mobile_no=$row_customer_dtls['mobile_no'];
        $date_of_birth=$row_customer_dtls['date_of_birth'];
        $gst_no=$row_customer_dtls['gst_no'];
        $pan_no=$row_customer_dtls['pan_no'];
        $customer_state_id=$row_customer_dtls['customer_state_id'];
        $address_1=$row_customer_dtls['address_1'];
        $address_2=$row_customer_dtls['address_2'];
        $zip_code=$row_customer_dtls['zip_code'];

        if($date_of_birth!=''){$date_of_birth = date('d-m-Y',strtotime($date_of_birth));}
        $state_nm = get_single_value('states','sl',$customer_state_id,'state_nm','');

        if($mobile_no==""){ $mobile_no="NA"; }
        if($customer_nm==""){ $customer_nm="NA"; }
        if($date_of_birth==""){ $date_of_birth="NA"; }
        if($email_id==""){ $email_id="NA"; }
        if($state_nm==""){ $state_nm="NA"; }
        if($address_1==""){ $address_1="NA"; }
        if($address_2==""){ $address_2="NA"; }
        if($zip_code==""){ $zip_code="NA"; }
        if($gst_no==""){ $gst_no="NA"; }
        if($pan_no==""){ $pan_no="NA"; }
        ?>
        <tr>
          <td class="text-center"><?php echo $slc;?></td>
          <td class="text-center">
            <a href="javascript:void(0);" onclick="customer_edit('<?php echo base64_encode($customer_unq_id);?>')" class="btn btn-info btn-sm">Update</a><br>
            <a href="javascript:void(0);" onclick="customer_delete('<?php echo base64_encode($customer_unq_id);?>')" class="btn btn-warning btn-sm" style="margin-top:4px;">Delete</a>
          </td>
          <td>
            Mobile No :<b><?php echo $mobile_no;?></b><br>
            Name :<b><?php echo $customer_nm;?></b> <br>
            Date Of Birth : <b><?php echo $date_of_birth;?></b> <br>
            Email ID :<b><?php echo $email_id;?></b>
          </td>
          <td>
            State :<b><?php echo $state_nm;?></b> <br>
            Address 1 :<b><?php echo $address_1;?></b> <br>
            Address 2 :<b><?php echo $address_2;?></b> <br>
            Zipcode :<b><?php echo $zip_code;?></b>
          </td>
          <td>
            GST No. : <b><?php echo $gst_no;?></b> <br>
            PAN No. : <b><?php echo $pan_no;?></b>
          </td>
        </tr>
      <?php
        }
        ?>
      </tbody>
    </table>
  </div>
<?php
}
else
{
  ?><div><?php echo "No Data Available"; ?></div><?php
}
?>