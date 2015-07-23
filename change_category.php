<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$dept_id = "";
$emp_type='';
if(isset($_POST["str1"]))
{
	$designation_id = $_POST["str1"];
	$emp_type=$_POST["str3"];
	$date = $_POST["str5"];
	$emp_id = $_POST["str6"];
}
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Employee Type</td>
                    <td align="left" width="60%">
  		                  <select  name="emp_category" id="emp_category" onChange="get_frm('change_designation.php',this.value+'&old_cat=<?=$emp_type?>&old_des_id=<?=$dept_id?>','designation_div','<?=$emp_id?>');">
                          		<option value="">--Select--</option>	
                                <option value="staff" <? if($emp_type=="Staff"){echo 'selected="selected"'; } ?>>Staff</option>
                                <option value="worker" <? if($emp_type=="Worker"){echo 'selected="selected"'; } ?>>Worker</option>
                            </select>                    
                      </td>
                    <td class="text_1">
                    </td>
                </tr>
                 <tr>
                    <td class="text_1" width="40%">Designation</td>
                    <td align="left" width="60%">
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
									<option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$designation_id){ echo 'selected="selected"';} ?>><?=$row_city['designation_name']?></option>
						<?
							}  	
						}
						?>
							</select>  
                        </div>
                    </td>
                </tr>
                 <tr>
                    <td class="text_1">Effective From</td>
                    <td align="left">
                        <form id="frm_emp_list" name="frm_emp_list">
                        <input type="text" name="depart_from_date" id="depart_from_date" style="width:130px; height:20px;" value="<?=$date?>"/>	 <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.depart_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a></form>
                     </td>
                     <td>
                    <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Designation" title="Edit Designation" onclick="get_frm('change_designation_edit.php',document.getElementById('designation').value+'&date='+document.getElementById('depart_from_date').value,'div_category_edit','<?=$emp_id?>')" />&nbsp;</td>
                    <td>
                         <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="get_frm('dept_designation.php','<?=$emp_id?>','div_detail','')">
                    </td>    
                </tr>
            </table>