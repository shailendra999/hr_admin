<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "salary_deduction_list.php";
$salary_fine = "";
$salary_damage = "";
$salary_canteen = "";
$salary_society_welfare = "";
$salary_electrical = "";
$salarly_security = "";
$salary_house_rent= "";
$salary_deduction_date = "";
if(isset($_GET["id"]))
{
	$salary_ded_id = $_GET["id"];
	
	$sql = "select * from mpc_salary_deduction where rec_id = '$salary_ded_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$salary_fine = $row["salary_fine"];
	$salary_damage = $row["salary_damage"];
	$salary_canteen = $row["salary_canteen"];
	$salary_society_welfare = $row["salary_society_welfare"];
	$salary_electrical = $row["salary_electrical"];
	$salarly_security = $row["salarly_security"];
	$salary_house_rent = $row["salary_house_rent"];
	$salary_deduction_date = getDatetime($row["salary_deduction_date"]);	
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Fine</b></td>
                    <td align="left"><input type="text" name="txt_fine" id="txt_fine" value="<?=$salary_fine?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Damage</b></td>
                    <td align="left"><input type="text" name="txt_damage" id="txt_damage" value="<?=$salary_damage?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Canteen</b></td>
                    <td align="left"><input type="text" name="txt_canteen" id="txt_canteen" value="<?=$salary_canteen?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Society welfare</b></td>
                    <td align="left"><input type="text" name="txt_society_welfare" id="txt_installments" value="<?=$salary_society_welfare?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Electrical</b></td>
                    <td align="left"><input type="text" name="txt_elecrical" id="txt_elecrical" value="<?=$salary_electrical?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Security</b></td>
                    <td align="left"><input type="text" name="txt_security" id="txt_security" value="<?=$salarly_security?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>House Rent</b></td>
                    <td align="left"><input type="text" name="txt_house_rent" id="txt_house_rent" value="<?=$salary_house_rent?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1"><b>Deduction Date</b></td>
                    <td align="left"><input type="text" name="txt_date" id="txt_date" value="<?=$salary_deduction_date?>" style="width:100px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="salary_ded_id" id="salary_ded_id" value="<?=$salary_ded_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Loan Deduction" title="Edit Loan Deduction">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>