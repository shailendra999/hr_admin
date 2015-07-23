<? include ("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
$Page = "store_add_taxes.php";
$PageTitle = "Add tax";
$PageFor = "Tax";
$PageKey = "tax_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$number = '';
$tax_for_page = '';
$discount = '';
$duty = '';
$ecess = '';
$st = '';
$sc = '';
$cenVat = '';
$pf = '';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$tax_for_page = $_POST['tax_for_page'];
	$discount = $_POST['discount'];
	$duty = $_POST['duty'];
	$ecess = $_POST['ecess'];
	$st = $_POST['st'];
	$sc = $_POST['sc'];
	$cenVat = $_POST['cenVat'];
	$pf = $_POST['pf'];

	if($PageKeyValue == "")
	{
		$tableName="ms_taxes_master";
		$tableData=array("''","'$tax_for_page'","'$discount'","'$duty'","'$ecess'","'$st'","'$sc'","'$cenVat'","'$pf'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="ms_taxes_master";
			$tableColumns=array("tax_id","tax_for_page","discount","duty","ecess","st","sc","cenVat","pf");
			$tableData=array("'$PageKeyValue'","'$tax_for_page'","'$discount'","'$duty'","'$ecess'","'$st'","'$sc'","'$cenVat'","'$pf'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?
$PageKeyValue = "";
$ReferenceId = "";

if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_taxes_master where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_taxes_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$tax_for_page  	 = $row["tax_for_page"];
		$discount = $row["discount"];
		$duty = $row["duty"];
		$ecess = $row["ecess"];
		$st = $row["st"];
		$sc = $row["sc"];		
		$cenVat = $row["cenVat"];
		$pf = $row["pf"];
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Laxyo</td>
                </tr>
                <tr>
                	<td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="height:470px; padding-top:30px;">
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:10 0 10 0"><?=$Message?></div>
                                        <form id="store_frm_taxes" name="store_frm_taxes" action="" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="20%">Tax for Page</td>
                                                  <td align="left" bgcolor="#F2F7F9" width="28%" style="padding-left:10px;">
                                              <select name="tax_for_page" id="tax_for_page" style="width:145px;">
                                                  		<option value="0">--Select Page--</option>
                                                        <option value="1" <? if($tax_for_page=='1'){ ?> selected= "selected" <? } ?>>Purchase Order</option>
                                                        <option value="2" <? if($tax_for_page=='2'){ ?> selected= "selected" <? } ?>>GRN</option>
                                                        <option value="3" <? if($tax_for_page=='3'){ ?> selected= "selected" <? } ?>>Bill Pass</option>
                                                        <option value="4" <? if($tax_for_page=='4'){ ?> selected= "selected" <? } ?>>Purchase Return</option>
                                                        <option value="5" <? if($tax_for_page=='5'){ ?> selected= "selected" <? } ?>>GRN(RGP)</option>
                                                  </select>
                                                  </td>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="22%">Discount</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="30%" style="padding-left:10px;">
                                                  <input type="text" id="discount" name="discount" value="<?= $discount ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="20%">Duty</td>
                                                  <td align="left" bgcolor="#F2F7F9" width="28%" style="padding-left:10px;">
                                                    <input type="text" id="duty" name="duty" value="<?= $duty ?>" />
                                                  </td>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="22%">E.cess</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="30%" style="padding-left:10px;">
                                                  <input type="text" id="ecess" name="ecess" value="<?= $ecess ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="20%">ST</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="28%" style="padding-left:10px;">
                                                    <input type="text" id="st" name="st" value="<?= $st ?>" />
                                                  </td>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="22%">SC</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="30%" style="padding-left:10px;">
                                                  <input type="text" id="sc" name="sc" value="<?= $sc ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="20%">CenVat</td>
                                                  <td align="left" bgcolor="#F2F7F9" width="28%" style="padding-left:10px;">
                                                    <input type="text" id="cenVat" name="cenVat" value="<?= $cenVat ?>" />
                                                  </td>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="22%">PF</td>
                                                    <td align="left" bgcolor="#F2F7F9" width="30%" style="padding-left:10px;">
                                                  <input type="text" id="pf" name="pf" value="<?= $pf ?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" align="center" bgcolor="#E2EBF0" height="25">
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
                                                <td class="h_text">Tax for Page</td>
                                                <td class="h_text">Discount</td>
                                                <td class="h_text">Duty</td>
                                                <td class="h_text">E.Cess</td>
                                                <td class="h_text">ST</td>
                                                <td class="h_text">SC</td>
                                                <td class="h_text">CenVat</td>
                                                <td class="h_text">PF</td>
                                                <td class="h_text">Edit</td>
                                                <td class="h_text">Delete</td>
                                            </tr>
                                            <?
											$sql = "select * from  ms_taxes_master ";
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
														<td class="Text01">
														<select name="tax_for_page" id="tax_for_page">
                                                            <option value="0">Select Page</option>
                                                            <option value="<?=$row["tax_for_page"]?>" <? if($row["tax_for_page"]=='1'){ ?> selected= "selected" <? } ?>>Purchase Order</option>
                                                            <option value="<?=$row["tax_for_page"]?>" <? if($row["tax_for_page"]=='2'){ ?> selected= "selected" <? } ?>>GRN</option>
                                                            <option value="<?=$row["tax_for_page"]?>" <? if($row["tax_for_page"]=='3'){ ?> selected= "selected" <? } ?>>Bill Pass</option>
                                                            <option value="<?=$row["tax_for_page"]?>" <? if($row["tax_for_page"]=='4'){ ?> selected= "selected" <? } ?>>Purchase Return</option>
                                                            <option value="<?=$row["tax_for_page"]?>" <? if($row["tax_for_page"]=='5'){ ?> selected= "selected" <? } ?>>GRN(RGP)</option>
                                                  		</select>
                                                        </td>
                                                        <td class="Text01"><?=$row["discount"]?></td>
                                                        <td class="Text01"><?=$row["duty"]?></td>
                                                        <td class="Text01"><?=$row["ecess"]?></td>
                                                        <td class="Text01"><?=$row["st"]?></td>
                                                        <td class="Text01"><?=$row["sc"]?></td>
                                                        <td class="Text01"><?=$row["cenVat"]?></td>
                                                        <td class="Text01"><?=$row["pf"]?></td>
														<td class="Text01">
                                                        	<a href="store_add_taxes.php?tax_id=<?=$row['tax_id']?>&mode=edit">Edit</a>
                                                        </td>
														<td class="Text01">
                                                        	<a href="javascript:;" onClick="overlay(<?=$row['tax_id']?>);">Delete</a>
                                                        </td>
													</tr>
													<?												
												}
											 }
											 else
											 {
											 ?>
											 	<tr bgcolor="#f9f8f9">
														<td class="Text01" colspan="6" align="center">No Records Entered Yet.</td>
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
        <p class="form_msg">Are you sure to delete this Record</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<? include ("inc/hr_footer.php"); ?>	