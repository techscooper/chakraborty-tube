<?php
include '../config.php';

if ($ckadmin==0)
{
  header('location:../login');
}
else
{
  $cy1 = date('y');
  $cy2 = $cy1 + 1;

  $sl=$Invoice_Series=$Stiching_Series=$Stuffing_Serice=$Refund_Serice='';
  $get_bank_info=mysqli_query($conn,"SELECT * FROM billing_serise_tbl WHERE sl=1 AND stat=1");
  if ($row_bank_info=mysqli_fetch_array($get_bank_info))
  {
    $Invoice_Series = $row_bank_info['invoice_series'];
    $Refund_Serice = $row_bank_info['refund_series'];
  }
?>
<!doctype html>
<html lang="en">
   <head>
      <link rel="icon" href="favicon.ico" type="image/x-icon">
      <title>::Billing Series :: <?php echo $projectName; ?> ::</title>
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
                     <h1>Billing Series</h1>
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item">Business</li>
                        <li class="breadcrumb-item active">Billing Series</li>
                     </ol>
                  </div>
                  <div class="right">
                    <a href="index.php" class="btn btn-primary btn-animated btn-animated-y">
                      <span class="btn-inner--visible">Back</span>
                      <span class="btn-inner--hidden"><i class="fa fa-arrow-left"></i></span>
                    </a>
                  </div>
               </div>
               <div class="row clearfix">
                  <div class="col-lg-12 col-md-12">
                     <div class="card">
                        <div class="header">
                           <h2><i class="fa fa-circle"></i> Billing Series</h2>
                        </div>
                        <form  action="business-code/billing-series2.php" method="post" id="billing_info_frm" enctype="multipart/form-data">
                           <div class="body">
                              <div class="row">
                                 <div class="form-group col-md-3">
                                    <label for="">Invoice <font color="red"><b>*</b></font></label>
                                    <input type="text" class="form-control" placeholder="Invoice Series" name="invoice_series" id="invoice_series" onkeyup="this.value = this.value.toUpperCase();" maxlength="4" value="<?php echo $Invoice_Series;?>">
                                    <small class="text-primary"><?php if($Invoice_Series!=""){ echo "$Invoice_Series/$cy1-$cy2/0001";}?></small>
                                 </div>
                                 <div class="form-group col-md-3" style="display:none;">
                                    <label for="">Refund <font color="red"><b>*</b></font></label>
                                    <input type="text" class="form-control" placeholder="Refund Serice" name="refund_series" id="refund_series" onkeyup="this.value = this.value.toUpperCase();" maxlength="4" value="<?php echo $Refund_Serice;?>">
                                    <small class="text-primary"><?php if($Refund_Serice!=""){ echo "$Refund_Serice/$cy1-$cy2/0001";}?></small>
                                 </div>
                                 <div class="col-lg-3" style="padding-top:30px;">
                                    <button class="btn btn-success" type="submit" id="billing_info_btn" name="bank_info_btn">Confirm</button>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php require_once('../javascripts.php');?>
      <script type="text/javascript" src="business-js/billing-info.js"></script>
   </body>
</html>
<?php
}
?>
