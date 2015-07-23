<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$dept_id = "";
if(isset($_GET["id"]))
{
	$date = $_GET["id"];
	$emp_id = $_GET["str4"];
	$old_dept_id = $_GET["str6"];
	$old_main_id=getdeptDetail('reference_id','rec_id',$old_dept_id);
}
?>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
		 <form id="frm_emp_list" name="frm_emp_list">
            <input type="text" name="depart_from_date" id="depart_from_date" style="width:130px; height:20px;" value="<?=$date?>"/>	 <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.depart_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a></form>
        </td>
        <td>
        	<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Department" title="Edit Department" onclick="get_frm('change_department_edit.php',document.getElementById('department').value+'&date=<?=$date?>','div_department_edit','<?=$emp_id?>')" />&nbsp;</td>
 		<td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="get_frm('dept_designation.php','<?=$emp_id?>','div_detail','')">
        </td>
	</tr>
</table>