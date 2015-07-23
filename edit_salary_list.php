<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#txt_from_date" ).datepicker();
	$("#txt_to_date").datepicker();
  });

<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_salary_employee.php";
$basic ="";
$hra ="";
$leave_travel_allow ="";
$convence="";
$medical ="";
$side_allowance ="";
$professional_tax ="";
$tds ="";
$other_deductions ="";
$from_date ="";
$to_date ="";
if(isset($_GET["id"]))
{
	$salary_id = $_GET["id"];
	
	$sql = "select * from mpc_salary_master where rec_id = '$salary_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	$row = mysql_fetch_array($result);
	
	$emp_id = $row["emp_id"];
	$basic = $row["basic"];
	$hra = $row["hra"];
	$leave_travel_allow = $row["leave_travel_allow"];
	$convence = $row["convence"];
	$medical = $row["medical"];
	$side_allowance = $row["side_allowance"];
	$professional_tax = $row["professional_tax"];
	$tds = $row["tds"];
	$other_deductions = $row["other_deductions"];	
	$from_date = getDatetime($row["from_date"]);
	if($row["to_date"]=='0000-00-00')
		{
			$to_date = date('d/m/Y');
		}
		else
		{
			$to_date = getDatetime($row["to_date"]);
		}
	$salary_id = $row["rec_id"];
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Basic</b></td>
                    <td align="left"><input type="text" name="txt_basic" id="txt_basic" value="<?=$basic?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>HRA</b></td>
                    <td align="left"><input type="text" name="txt_hra" id="txt_hra" value="<?=$hra?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>LTA</b></td>
                    <td align="left"><input type="text" name="txt_lta" id="txt_lta" value="<?=$leave_travel_allow?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Convence</b></td>
                    <td align="left"><input type="text" name="txt_convence" id="txt_convence" value="<?=$convence?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Medical</b></td>
                    <td align="left"><input type="text" name="txt_medical" id="txt_medical" value="<?=$medical?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>S/A</b></td>
                    <td align="left"><input type="text" name="txt_sa" id="txt_sa" value="<?=$side_allowance?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>P/Tax</b></td>
                    <td align="left"><input type="text" name="txt_ptax" id="txt_ptax" value="<?=$professional_tax?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>TDS</b></td>
                    <td align="left"><input type="text" name="txt_tds" id="txt_tds" value="<?=$tds?>" style="width:50px; height:20px;"/></td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>O/D</b></td>
                    <td align="left"><input type="text" name="txt_deduction" id="txt_deduction" value="<?=$other_deductions?>" style="width:50px; height:20px;"/></td>
                    
                    <td align="left" class="text_1"><b>From</b></td>
                    <td align="left"><input type="text" name="txt_from_date" id="txt_from_date" value="<?=$from_date?>" style="width:100px; height:20px;"/>
            		</td>
                    <td align="left" class="text_1"><b>To</b></td>
                    <td align="left"><input type="text" name="txt_to_date" id="txt_to_date" value="<?=$to_date?>" style="width:100px; height:20px;"/>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
                            <input type="hidden" name="salary_id" id="salary_id" value="<?=$salary_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Salary" title="Edit Salary">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>