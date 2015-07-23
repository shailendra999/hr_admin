<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_advance_deduction.php";
$txt_deduction = "";
$deduction_by = "";
$deduction_date = "";
$ded_id = "";
if(isset($_GET["id"]))
{
	$ded_id = $_GET["id"];
	
	$sql = "select * from mpc_advance_employee where rec_id = '$ded_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$txt_deduction = $row["deduction"];
	$deduction_date = getDatetime($row["deduction_date"]);	
	$deduction_by = $row["deduction_by"];
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="60%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Advance Deduction</b></td>
                    <td align="left"><input type="text" name="txt_deduction" id="txt_deduction" value="<?=$txt_deduction?>" style="width:150px; height:20px;"/></td>
                    <td align="left" class="text_1"><b>Deduction Date</b></td>
                    <td align="left"><input type="text" name="txt_date" id="txt_date" value="<?=$deduction_date?>" style="width:150px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="left" class="text_1"><b>Deduction By</b></td>
                    <td align="left">
                        <select name="deduction_by" id="deduction_by">
                            <option>-Select-</option>
                            <option value="Cash" <? if($deduction_by=='Cash'){echo 'selected="selected"';}?>>Cash</option>
                            <option value="Cheque"  <? if($deduction_by=='Cheque'){echo 'selected="selected"';}?>>Cheque</option>
                            <option value="Salary"  <? if($deduction_by=='Salary'){echo 'selected="selected"';}?>>Salary</option>
                        </select>
					</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="ded_id" id="ded_id" value="<?=$ded_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Advance Deduction" title="Edit Advance Deduction">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>