<? include ("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<script type="text/javascript">
function toggle_display_decimal_places() 
{
	var dec_req=document.getElementById("dec_req").value;
	if(dec_req=='Y')
		document.getElementById("tr_dec_places").style.display="block";
	else
		document.getElementById("tr_dec_places").style.display="none";
	
}
</script>
<?
$Page = "store_add_return_type.php";
$PageTitle = "Add Return Type";
$PageFor = "Return Type";
$PageKey = "return_type_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$return_type = '';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$return_type = $_POST['return_type'];	
	$tableName="ms_return_type";
	if($PageKeyValue == "")
	{
		$tableData=array("''","'$return_type'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{						
			$tableColumns=array("return_type_id","return_type");
			$tableData=array("'$PageKeyValue'","'$return_type'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?

if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_return_type where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_return_type where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$return_type = $row["return_type"];		
	}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_setting_snb.php"); ?>
        </td>        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Return Type</td>
                </tr>
                <tr>
                	<td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;">
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:10 0 10 0"><?=$Message?></div>
                                        <form id="store_frm_ret_type" name="store_frm_ret_type" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%">Return Type</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="return_type" name="return_type" value="<?= $return_type ?>" /></td>
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
                                        <div id="div_category_list"  style="overflow:auto;height:400px;width:750px;margin-top:20px;">
                                          <table align="center" width="100%" style="border:#CCCCCC solid 1px;" cellpadding="2" cellspacing="1">
                                            <tr style="background:#F4F2F7" height="30px">
                                            	<td class="h_text">S.No.</td>
                                                <td class="h_text">Return Type</td>
                                                <td class="h_text">Edit</td>
                                                <td class="h_text">Delete</td>
                                            </tr>
                                            <?
											$sql = "select * from  ms_return_type order by return_type";
											$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
											if(mysql_num_rows($result)>0)
											{
												
												$num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
												$sno=1;
												while($row = mysql_fetch_array($result)) 
												{ 
													?>
													<tr bgcolor="#F2F7F9">
														<td class="Text01"><?= $sno++;?></td>
														<td class="Text01"><?=$row["return_type"]?></td>
														<td class="Text01">
                                                        	<a href="store_add_return_type.php?return_type_id=<?=$row['return_type_id']?>&mode=edit">Edit</a>
                                                        </td>
														<td class="Text01">
                                                        	<a href="javascript:;" onClick="overlay(<?=$row['return_type_id']?>);">Delete</a>
                                                        </td>
													</tr>
													<?												
												}
											 }
											 else
											 {
											 ?>
											 	<tr bgcolor="#f9f8f9">
														<td class="Text01" colspan="4" align="center">No Records Entered Yet.</td>
												</tr>
                                             <? 
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
            </table>
        </td>
    </tr>
</table>
<div id="overlay">
	<div>
        <p class="form_msg">Are you sure to delete this UOM</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<? include ("inc/hr_footer.php"); ?>	