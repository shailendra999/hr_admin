<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_designation_employee.php";
$basic ="";
$from_date ="";
$to_date ="";
$emp_id=$_GET["id"];
if(isset($_GET["id"]))
{
	
	$designation=$_GET['designation'];
	$sql = "select * from mpc_employee_master where ticket_no='$emp_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	$emp_designation_id=$row['designation'];
	//$designation_id = $_GET["id"];
	
	
	$sql = "select * from mpc_designation_employee where designation_id = '$emp_designation_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	//$emp_id = $row["emp_id"];
	//$emp_designation_id  = $row["designation_id"];
	$emp_type=getdesignationMaster('emp_category','rec_id',$emp_designation_id);
	$from_date = getDatetime($row["from_date"]);
	if($row["to_date"]=='0000-00-00')
		{
			$to_date = date('d/m/Y');
		}
		else
		{
			$to_date = getDatetime($row["to_date"]);
		}
	//$emp_id = $row["emp_id"];
	$rec_id=$row['rec_id'];
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Category</b></td>
                    <td align="left">
							<select  name="emp_category" id="emp_category" onChange="get_frm('change_designation.php',this.value+'&old_cat=<?=$emp_type?>&old_des_id=<?=$emp_designation_id?>','designation_div','<?=$emp_id?>');">
                          		<option value="">--Select--</option>	
                                <option value="staff" <? if($emp_type=="Staff"){echo 'selected="selected"'; } ?>>Staff</option>
                                <option value="worker" <? if($emp_type=="Worker"){echo 'selected="selected"'; } ?>>Worker</option>
                            </select>   
                    </td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Designation</b></td>
                    <td align="left">
                       <div id="designation_div">
                     <?		
						$sql = "SELECT * FROM  mpc_designation_master where emp_category ='$emp_type'order by designation_name";

						$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
						?>
							<select name="designation" id="designation">
									<option value="">--Select--</option>
						<?
						if(mysql_num_rows($result_city)>0)
						{
							while($row_city = mysql_fetch_array($result_city))
							{
						?> 
									<option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$emp_designation_id){ echo 'selected="selected"';} ?>><?=$row_city['designation_name']?></option>
						<?
							}  	
						}
						?>
							</select>  
                        </div>
                    </td>
                    <td align="left" class="text_1"><b>From</b></td>
                    <td align="left"><input type="text" name="txt_from_date" id="txt_from_date" value="<?=$from_date?>" style="width:100px; height:20px;" data-beatpicker="true" />
            		</td>
                    <td align="left" class="text_1"><b>To</b></td>
                    <td align="left"><input type="text" name="txt_to_date" id="txt_to_date" value="<?=$to_date?>" style="width:100px; height:20px;" data-beatpicker="true" />
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
                            <input type="hidden" name="designation_id" id="designation_id" value="<?=$designation_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Department" title="Edit Department">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<!-- date picker -->
<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<!-- end -->
<script>
/*$(function() {
    $( "#date_joining" ).datepicker();
	$("#date_pf").datepicker();
	$("#wife_dob").datepicker();
  });*/
  $(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
  </script>
