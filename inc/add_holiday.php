<? include ("inc/hr_header.php"); ?>
<?
$Message="";
$dept_id="";
?>
<script>
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
$Page = "add_holiday.php";
$PageTitle = "Add Holiday";
$PageFor = "Holiday";
$PageKey = "rec_id";
$PageKeyValue = "";
$Message = "";
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$holiday_name = $_POST["holiday_name"];
	$holiday_Date = getdbDateSepretoe($_POST["holiday_Date"]);
	
	if($PageKeyValue == "")
	{
		$sql = "insert into mpc_holiday_master set
													holiday_name  = '$holiday_name',
													holiday_date  = '$holiday_Date'
													";
		mysql_query($sql) or die ("Error in ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode != "subcategory")
		{					
			  $sql = "update mpc_holiday_master set
														holiday_name  = '$holiday_name',
													    holiday_date  = '$holiday_Date'
														where $PageKey = '$PageKeyValue'
														";
			mysql_query($sql) or die ("Error in ".$sql."<br>".mysql_errno()." : ".mysql_error());
			$Message = "$PageFor Updated";
		}
		
	}
	//redirect("$Page?Message=$Message");
}
?>
<?
$PageKeyValue = "";
$ReferenceId = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_POST["btn_delete"]))
{

	$PageKeyValue  = $_POST["hidden_overlay"];
		$sql = "delete from mpc_holiday_master where $PageKey = '".$PageKeyValue."'";
		mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$Message = "Holiday Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$employee_type="";
$Name="";
if(isset($_GET[$PageKey]))
{
	$sql = "select * from mpc_holiday_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$Name = $row["designation_name"];
	    $employee_type = $row["emp_category"];
	}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
		   <? include ("inc/setting_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Holiday</td>
                </tr>
                <tr>
                	<td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
              			<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;">
                                        <div id="div_message"><?=$Message?></div>
                                        <form id="frm_category" name="frm_category" action="<?=$Page?>" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                             <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">Holiday Name</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                      <input type="text" name="holiday_name" id="holiday_name" value=""/>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">Holiday Date</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                        <input type="text" name="holiday_Date" id="holiday_Date" value="" readonly="readonly"/>
                                                         <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_category.holiday_Date)"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""  onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}"></a>                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center" bgcolor="#E2EBF0" height="25">
                                                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                                                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                    </td>
                                                </tr>
                               			   </table>
                           				 </form>
                                         <?
										 	if(isset($_POST['holiday']))
											  {
												@$year=$_POST['holiday'];
											  }
											else
											 {
											 	@$year=date('Y');
											 }
										 ?>
                                         <form id="frm_holiday" name="frm_holiday" action="<?=$Page?>" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="30%" style="border:#CCCCCC solid 1px;">
                                             <tr>
                                                    <td width="47%" bgcolor="#E2EBF0" class="paas_text">Year</td>
                                                    <td width="53%" align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                     <?    
													$sql_prd = "select YEAR(mpc_holiday_master.holiday_date) as 'Year' from ".$mysql_table_prefix."holiday_master group by Year";
													$result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
                                                                        ?>
                                                    <select id="holiday" name="holiday" onchange="form.submit();">
                                                      <option value="">Select</option>
                                                      <?
													  	while($row_prd = mysql_fetch_array($result_prd))
															{
													  ?>
                                                      <option value="<?=$row_prd['Year']?>" <? if($year==$row_prd['Year']){echo 'selected="selected"';} ?>><?=$row_prd['Year']?></option>
                                                      		<?
															 }
															?>
                                                    </select>
                                               </td>
                                              </tr>
                               			   </table>
                           				 </form>
                            <div id="div_category_list"  style="overflow:scroll;height:300px;width:650px">
                            	<table align="center" width="80%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="1">
                                    <tr>
                                        <td class="h_text">Holiday</td>
                                        <td class="h_text">Date</td>
                                        <td class="h_text">Edit</td>
                                        <td class="h_text">Delete</td>
                                    </tr>
									<?
								$sql = "select * from mpc_holiday_master where YEAR(mpc_holiday_master.holiday_date)='$year' order by holiday_date";
								$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
								if(mysql_num_rows($result)>0)
								{
									
									$num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
									
									while($row = mysql_fetch_array($result)) 
									{ 
										?>
										<tr bgcolor="#F2F7F9">
											<td class="Text01"><?=$row["holiday_name"]?></td>
                                            <td class="Text01"><?=$row["holiday_date"]?></td>
											<td class="Text01"><a href="add_designation.php?rec_id=<?=$row['rec_id']?>&mode=edit">Edit</a></td>
											<td class="Text01"><a href="javascript:;" onClick="overlay(<?=$row['rec_id']?>);">Delete</a></td>
										</tr>
										<?
							
								}
							}
							?>
                                </table>
                            	
                            </div>
                        </div>
					</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td align="center" style="padding-bottom:5px;"><img src="images/pageBtm.jpg" width="1000" height="10"/></td>
    </tr>
</table>
	
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div id="overlay">
	<div>
        <p class="form_msg">Are you sure to delete this Holiday</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	
