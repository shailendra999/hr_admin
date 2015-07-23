<?php
if(isset($_POST['emp_assest']))
{    $id = $_SESSION['emp_id'];
	  $vehicle=$_POST['vehicle'];
	  $registration_no=$_POST['registration_no'];
	  $model_no=$_POST['model_no'];
	  $no_vehicle=$_POST['no_vehicle'];
	  $laptop_detail=$_POST['laptop_detail'];
	  $all_details=$_POST['all_details'];
	  $assists_all=$_POST['assists_all'];
	  $other = $_POST['other'];
	 include("inc/dbconnection.php");
	 
		if($emp_assest_edit=="")
		{
	$que = mysql_query("INSERT INTO `ssofts_mah`.`assets_detail` (`rec_id`, `emp_id`, `Vehicle`, `Registration`, `Model`, `Vehicle_no`, `laptop`, `tv`, `assist_all`, `other`) VALUES ('', '$id', '$vehicle', '$registration_no', '$model_no', '$no_vehicle', '$laptop_detail', '$all_details', '$assists_all', '$other');");
}
else{
	
	//update
	$query = mysql_query("update assets_detail set Vehicle='$vehicle',Registration='$registration_no',
	Model='$model_no',Vehicle_no='$no_vehicle',laptop='$laptop_detail',tv='$all_details',assist_all='$assists_all',other='$other' where emp_id='$id'");
	
	}
}
?>
<div <? if($mode=='salary_details'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
      <form name="assets_details_test.php" id="empolyee_family" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="63%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;margin-left: 282px;margin-top: -173px;">
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" height="344px;" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1" width="35%">Vehicle</td>
                  <td align="left" width="65%"><input type="text" name="vehicle" id="vehicle" style="width:150px; height:20px;" value="<?=$vehicle?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Registration No.</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="text" name="registration_no" id="registration_no" style="width:150px; height:20px;" value="<?=$registration_no?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Model No.</td>
                  <td align="left"><input type="text" name="model_no" id="model_no" style="width:150px; height:20px;" value="<?=$model_no?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">No. of vehicle(Quantity)</td>
                   <td align="left" style="padding-top:5px;"><input type="text" name="no_vehicle" id="no_vehicle" style="width:150px; height:20px;" value="<?=$vehicle_no?>"></td>
                </tr>
               <?php /*?> <tr>
                  <td class="text_1">Spouse Name </td>
                  <td align="left"><input type="text" name="wife_name" id="wife_name" style="width:150px; height:20px;" value="<?=$wife_name?>"/></td>
                </tr><?php */?>
                
                
                <?php //if($_SESSION['marital_sta'] === 'yes'){ ?>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1">Laptop(Mode and comany all Data in brief)</td>
                  <td align="left"><textarea name="laptop_detail" id="laptop_detail" rows="4" cols="32" style="height:105px;"><?=$laptop_detail?>
</textarea></td>
                </tr>
                <tr>
                  <td class="text_1">T.V,Freez(All details in brief)</td>
                  <td align="left"><textarea name="all_details" id="all_details" rows="4" cols="32" style="height:105px;"><?=$all_details?>
                  </textarea></td>
                </tr>
                <tr>
                  <td class="text_1">Assists All(what ever is issued by the company)</td>
                  <td align="left"><textarea name="assists_all" id="assists_all" rows="4" cols="32" style="height:105px;"><?=$assists_all?>
                  </textarea></td>
                </tr>
                
          <tr>
                  <td class="text_1">Other Products</td>
                  <td align="left"><textarea name="other" id="other" rows="4" cols="32" style="height:105px;"><?=$other?>
                  </textarea></td>
                </tr>


              </table></td>
          </tr>
          <?php   //if($_SESSION['marital_sta'] === 'yes'){ ?>
		   <?php //} ?>
              <tr>
                <td style="text-align:center;" colspan="4">
                <input type="submit"  value="Submit" name="emp_assest" id="emp_assest"/>
              <? if(isset($_SESSION['emp_id'])){
								    ?>
              <!--<input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>--></td></tr>
            </table>
            </div>
          
            </td>
          <?php }?>
		  </table>
      </form>
    </div>