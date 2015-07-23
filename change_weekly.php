<? include ("inc/dbconnection.php");?>
<?
$url = "list_employee.php";
$product_name = "";
$product_id = "";
if(isset($_GET["id"]))
{
	$weekly_off = $_GET["id"];
	$emp_id = $_GET["str"];
}
?>
<div id="change_weekly_off">
<table width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle">
			 <select name="off_days" id="off_days" style="width:150px; height:20px;">
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>
			<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
			<input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
         <td>
			<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Weekly Off" title="Edit Weekly Off" onclick="get_frm('change_weekly_edit.php',document.getElementById('off_days').value,'change_weekly_off','<?=$emp_id?>')">&nbsp;
         </td>
         <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_weekly_off_edit','<?=$weekly_off ?>')">
    	</td>
	</tr>
</table>
</div