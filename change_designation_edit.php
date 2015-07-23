<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
if(isset($_GET["id"]))
{
	 $dept_id = $_GET["id"];
	 $emp_id = $_GET["str"];
	 $dept_from_date = getdbDateSepretoe($_GET["date"]);
}
if($emp_id!="")
{
 $sql_check1 = "update ".$mysql_table_prefix."designation_employee set	
																to_date  = '$dept_from_date'
																where emp_id='$emp_id' and to_date ='0000-00-00'";
																
$result_check1=mysql_query($sql_check1) or die ("Query Failed ".mysql_error());

$sql_check = "insert into  ".$mysql_table_prefix."designation_employee set	
																emp_id  ='$emp_id',
																designation_id ='$dept_id',
																from_date ='$dept_from_date',
																to_date ='0000-00-00'";
																
$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());

$emp_type=getdesignationMaster('emp_category','rec_id',$dept_id);

$sql_update = "update ".$mysql_table_prefix."official_detail set 
																emp_category ='$emp_type'
																where emp_id = '$emp_id'";

$result_check=mysql_query($sql_update) or die ("Query Failed ".mysql_error());}
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
    <tr>
        <td class="text_1" width="40%">Employee Type</td>
        <td align="left" width="60%">
         <?=$emp_type=getdesignationMaster('emp_category','rec_id', $dept_id)?>
        </td>
        <td class="text_1">
        </td>
    </tr>
     <tr>
        <td class="text_1" width="40%">Designation</td>
        <td align="left" width="60%">
         <div id="div_designation_edit"><?=getdesignationMaster('designation_name','rec_id',$dept_id)?>
            </div>
        </td>
    </tr>
     <tr>
        <td class="text_1" width="40%">Effective From</td>
        <td align="left" width="60%">
           <?=$_GET["date"]?>
         </td>
        <td class="text_1">
            <a href="javascript:;" onclick="post_frm('change_category.php','<?=$dept_id?>','div_category_edit','<?=$emp_type?>','','<?=$dept_from_date?>','<?=$emp_id?>')">Change</a>
        </td>
    </tr>
</table>