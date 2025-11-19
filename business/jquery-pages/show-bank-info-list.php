<?php
include '../../config.php';
if($ckadmin==1){
?>
<div class="table-responsive">
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th style="text-align:center;">#</th>
                          <th style="text-align:center;">Action</th>
                          <th style="text-align:center;">Bank Holder Name</th>
                          <th style="text-align:center;">Bank Name</th>
                          <th style="text-align:center;">Bank A/C Number</th>
                          <th style="text-align:center;">Branch Name</th>
                          <th style="text-align:center;">IFSC Code</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $slc=0;
										      $getBankInfo=mysqli_query($conn,"SELECT * FROM `bank_information_tbl` WHERE `stat`=1");
                          while($rowBankInfo=mysqli_fetch_array($getBankInfo)){
                            $slc++;
                            $bank_info_unq_id=$rowBankInfo['unq_id'];
											      $bank_holder_name=$rowBankInfo['bank_holder_nm'];
											      $bank_name=$rowBankInfo['bank_nm'];
											      $bank_account_number=$rowBankInfo['bank_ac_number'];
											      $branch_name=$rowBankInfo['branch_nm'];
											      $ifsc_code=$rowBankInfo['ifsc_code'];
                            $bank_primary_stat=$rowBankInfo['primary_stat'];
                            ?>
                            <tr>
                              <td style="text-align:center;"><?php echo $slc;?></td>
                              <td style="text-align:center;">
                                <a href="javascript:void(0);" onclick="bank_info_edit('<?php echo base64_encode($bank_info_unq_id);?>')">
                                  <i class="fa fa-edit fa-lg" title="Click to Update"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="bank_info_delete('<?php echo base64_encode($bank_info_unq_id);?>')">
                                  <i class="fa fa-trash fa-lg" style="color:red;" title="Click to delete"></i>
                                </a>
                                <?php
                                if($bank_primary_stat==1){
                                  ?><a class="badge badge-success" href="javascript:void(0);">Primary</a><?php
                                }
                                else{
                                  ?><a class="badge badge-warning" href="javascript:void(0);" onclick="bank_set_primary('<?php echo base64_encode($bank_info_unq_id);?>','1');">Make Primary</a><?php
                                }
                                ?>
                              </td>
                              <td style="text-align:center;"><b><?php echo $bank_holder_name;?></b></td>
                              <td style="text-align:center;"><?php echo $bank_name;?></td>
                              <td style="text-align:center;"><?php echo $bank_account_number;?></td>
                              <td style="text-align:center;"><?php echo $branch_name;?></td>
                              <td style="text-align:center;"><?php echo $ifsc_code;?></td>
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