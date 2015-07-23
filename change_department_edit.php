<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
//if(isset($_GET["id"]))
//{
	echo $dept_id = $_GET["id"];echo "<br>";
	echo $main_dept_id=getdeptDetail('reference_id','rec_id',$dept_id);echo "<br>";
	echo $emp_id = $_GET["str"];
	echo $dept_from_date = getdbDateSepretoe($_GET["date"]);echo "<br>"; 
	
//}
if($emp_id !="")
{    
 $sql_check1 = "update ".$mysql_table_prefix."department_employee set	
																to_date  ='$dept_from_date'
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

//Udate department in employee master table.
$query ="update ".$mysql_table_prefix."employee_master set department ='$main_dept_id' where emp_id = '$emp_id'";
mysql_query($query);

$sql_check = "insert into  ".$mysql_table_prefix."department_employee set	
																			emp_id  ='$emp_id',
																			dept_id ='$dept_id',
																			from_date ='$dept_from_date',
																			to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
}
?>
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
           <?=getdeptDetail('department_name','rec_id',$dept_id)?>
         </td>
    </tr>
    <tr>
        <td class="text_1" width="40%">Effective From</td>
        <td align="left" width="60%">
				<?=$_GET["date"]?>
         </td>
        <td class="text_1">
            <a href="javascript:;" onclick="post_frm('change_department.php','<?=$dept_id?>','div_department_edit','<?=$main_dept_id?>','<?=$emp_id?>','<?=$dept_from_date?>','<?=$id?>')">Change</a>
        </td>
       
    </tr>
</table>