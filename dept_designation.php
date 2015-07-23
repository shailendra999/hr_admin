<?
include('inc/dbconnection.php');
include('inc/function.php');
$id="";
$id = $_GET["id"];
$designation_id="";
$dept_id="";
$main_dept_id="";
$dept_from_date="";
$designation_from_date="";
$sql = "SELECT * FROM  mpc_designation_employee where emp_id = '$id' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$designation_id=$row['designation_id'];
		$designation_from_date=getDatetime($row['from_date']);
	} 
}
$sql = "SELECT * FROM  mpc_department_employee where emp_id = '$id' and to_date='0000-00-00'";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		$dept_id=$row['dept_id']; 	
		$main_dept_id=getdeptDetail('reference_id','rec_id',$dept_id);
		$dept_from_date=getDatetime($row['from_date']);
	} 
}
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td colspan="2" class="blackHead">Department / Designation Detail</td>
    </tr>
	<tr>
    	<td align="left">
        	<div id="div_department_edit">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            	<tr>
                	<td class="text_1" width="40%">Department</td>
                    <td align="left" width="60%">
                    	<?=getdeptDetail('department_name','rec_id',$main_dept_id)?>
                     </td>
                </tr>
                <tr>
                	<td class="text_1" width="40%">Sub Department</td>
                    <td align="left" width="60%">
                    	<div id="div_sub_department_edit"><?=getdeptDetail('department_name','rec_id',$dept_id)?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                </tr>
                <tr>
                	<td class="text_1" width="40%">Effective From</td>
                    <td align="left" width="60%">
                    	<div id="div_from_date_edit"><?=$dept_from_date?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                     <!--<td class="text_1">
                        <a href="javascript:;" onclick="get_frm('change_department.php','<?=$dept_id?>','div_department_edit','<?=$id?>'); get_frm2('change_sub_department.php','<?=$main_dept_id?>&old_dept_id=<?=$dept_id?>','div_sub_department_edit','<?=$id?>');get_frm_new('change_department_date.php','<?=$dept_from_date?>','div_from_date_edit','<?=$dept_id?>','<?=$id?>')">Change</a>
                    </td>-->
                    <td class="text_1">
                        <a href="javascript:;" onclick="post_frm('change_department.php','<?=$dept_id?>','div_department_edit','<?=$main_dept_id?>','','<?=$dept_from_date?>','<?=$id?>')">Change</a>
                    </td>
                   
                </tr>
            </table>
            </div>
        </td>
        <td>
            <div id="div_category_edit">
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td class="text_1" width="40%">Employee Type</td>
                    <td align="left" width="60%">
                     <?=$emp_type=getdesignationMaster('emp_category','rec_id', $designation_id)?>
                    </td>
                    <td class="text_1">
                    </td>
                </tr>
                 <tr>
                    <td class="text_1" width="40%">Designation</td>
                    <td align="left" width="60%">
                     <div id="div_designation_edit"><?=getdesignationMaster('designation_name','rec_id',$designation_id)?>
                        </div>
                    </td>
                </tr>
                 <tr>
                	<td class="text_1" width="40%">Effective From</td>
                    <td align="left" width="60%">
                    	<div id="div_from_date_edit_des"><?=$designation_from_date?><div id="div_rotation_type"></div>
                        </div>
                     </td>
                    <td class="text_1">
                    	<a href="javascript:;" onclick="post_frm('change_category.php','<?=$designation_id?>','div_category_edit','<?=$emp_type?>','','<?=$designation_from_date?>','<?=$id?>')">Change</a>
                       <!--<a href="javascript:;" onclick="get_frm('change_category.php','<?=$designation_id?>&emp_type=<?=$emp_type?>','div_category_edit','<?=$id?>'); get_frm2('change_designation.php','<?=$emp_type?>&old_cat=<?=$emp_type?>&old_des_id=<?=$designation_id?>','div_designation_edit','<?=$id?>')">Change</a>-->
                    </td>
                </tr>
            </table>
           </div>
        </td>
    </tr>
</table>