<?php
include '../config.php';

if ($ckadmin==0)
{
  header('location:../login');
}
else
{
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>::Supplier List:: <?php echo $projectName; ?> ::</title>
    <?php require_once('../stylesheet.php');?>
  </head>
  <body class="theme-blue">
    <?php require_once('../navbar/index.php');?>
    <div class="main_content">
      <?php require_once('../sidebar/left-sidebar.php'); ?>
      <div class="page">
        <div class="container-fluid">
          <div class="page_header">
            <div class="left">
              <h1>Supplier List</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item">Business Setup</li>
                <li class="breadcrumb-item active">Supplier List</li>
              </ol>
            </div>
            <div class="right">
              <a href="add-supplier.php" class="btn btn-primary btn-animated btn-animated-y">
              	<span class="btn-inner--visible">Create New</span>
              	<span class="btn-inner--hidden"><i class="fa fa-plus"></i></span>
              </a>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="header">
                  <h2><i class="fa fa-plus-circle"></i> Supplier List</h2>
                </div>

                <div class="body">
                  <div class="dt-responsive table-responsive">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">Action</th>
                          <th class="text-center">Supplier Details</th>
                          <th class="text-center">Contact Details</th>
                          <th class="text-center">GST Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $slc=0;
                        $get_supplier_dtls=mysqli_query($conn,"SELECT * FROM supplier_tbl WHERE stat=1 ORDER BY supplier_nm");
                        while($row_supplier_dtls=mysqli_fetch_array($get_supplier_dtls))
                        {
                          $slc++;
                          $supplier_unq_id=$row_supplier_dtls['unq_id'];
                          $supplier_nm=$row_supplier_dtls['supplier_nm'];
                          $email_id=$row_supplier_dtls['email_id'];
                          $mobile_no=$row_supplier_dtls['mobile_no'];
                          $gst_no=$row_supplier_dtls['gst_no'];
                          $supplier_state_id=$row_supplier_dtls['supplier_state_id'];
                          $address_1=$row_supplier_dtls['address_1'];
                          $address_2=$row_supplier_dtls['address_2'];
                          $zip_code=$row_supplier_dtls['zip_code'];

                          $state_nm = get_single_value('states','sl',$supplier_state_id,'state_nm','',$conn);
                          ?>
                          <tr>
                            <td style="text-align:center;"><?php echo $slc;?></td>
                            <td style="text-align:center;">
                              <a href="javascript:void(0);" onclick="supplier_edit('<?php echo base64_encode($supplier_unq_id);?>')">
                                <i class="fa fa-edit fa-lg" title="Click to Update"></i>
                              </a>
                              <a href="javascript:void(0);" onclick="supplier_delete('<?php echo base64_encode($supplier_unq_id);?>')">
                                <i class="fa fa-trash fa-lg" style="color:red;" title="Click to delete"></i>
                              </a>
                            </td>
                            <td> Name : <b><?php echo $supplier_nm;?></b><br>
                                 Email ID : <b><?php echo $email_id;?></b><br>
                                 Mobile No : <b><?php echo $mobile_no;?></b>
                          </td>
                          <td>   Address 1 : <b><?php echo $address_1;?></b> <br>
                                 Address 2 : <b><?php echo $address_2;?></b><br>
                                 State :     <b><?php echo $state_nm;?></b><br>
                                 Zipcode :    <b><?php echo $zip_code;?></b>
                          </td>
                            <td>
                                GST No : <b><?php echo $gst_no;?></b>
                            </td>
                          </tr>
                        <?php
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!--Main Content-->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
<!-- Required Js -->
  <?php require_once('../javascripts.php');?>
<script type="text/javascript">
function supplier_edit(s_uid)
{
  $('#div_lightbox').load("lightbox/supplier-edit.php?s_uid="+s_uid).fadeIn("fast");
  $('#modal-report').modal('show');
}
function supplier_delete(s_uid)
{
  $("#div_lightbox").load("lightbox/supplier-delete.php?s_uid="+s_uid).fadeIn("fast");
  $('#modal-report').modal('show');
}
</script>
</body>
</html>
<?php
}
?>
