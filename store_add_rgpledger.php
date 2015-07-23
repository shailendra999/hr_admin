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
$Page = "store_add_rgpledger.php";
$PageTitle = "Add RGP Ledger";
$PageFor = "RGP Ledger";
$PageKey = "rgp_ledger_code";
$PageKeyValue = "";
$Message = "";
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$address = addslashes($_POST['address']);	
	if($PageKeyValue == "")
	{
		$tableName="ms_rgp_ledger";
		$tableData=array("''","'$name'","'$address'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			$tableName="ms_rgp_ledger";
			$tableColumns=array("rgp_ledger_code","name","address");
			$tableData=array("'$PageKeyValue'","'$name'","'$address'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);			
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
	$sql = "delete from ms_rgp_ledger where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$name = '';
$address = '';
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_rgp_ledger where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];
		$address = stripslashes($row["address"]);		
	}
}
?>
<?
		$sql_code="select max(rgp_ledger_code) as rgp_ledger_code from ms_rgp_ledger";
		$res_code=mysql_query($sql_code);
		$row_code=mysql_fetch_array($res_code);
		$rgp_ledger_code=($row_code['rgp_ledger_code']+1);
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/store_setting_snb.php"); ?>
    </td>        
    <td style="padding-left:5px; padding-top:5px;">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Welcome to Mahima Purespun</td>
        </tr>
        <tr>
          <td height="400px" valign="top" style="padding-top:5px; padding-left:40px;">
            <table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border">
                  <div align="center" style="min-height:470px;padding-bottom:15px; padding-top:15px;overflow:auto">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                    <form id="store_frm_uom" name="store_frm_uom" action="<?=$Page?>" method="post">
                      <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                        <tr>
                          <td class="paas_text" bgcolor="#E2EBF0" width="40%">RGP Ledger Code</td>
                          <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                          	<input type="text" id="rgp_ledger_code" name="rgp_ledger_code" value="<?= $rgp_ledger_code ?>" />
                          </td>
                        </tr>
                        <tr>
                          <td class="paas_text" bgcolor="#E2EBF0" width="40%">RGP Ledger Name</td>
                          <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                          	<input type="text" id="name" name="name" value="<?= $name ?>" />
                          </td>
                        </tr>
                        <tr>
                          <td class="paas_text" bgcolor="#E2EBF0" width="40%">RGP Ledger Address</td>
                          <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                          	<textarea name="address" id="address"><?=$address?></textarea>
                          </td>
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
                    <div id="div_category_list"  style="overflow:auto;height:400px;width:100%;margin-top:10px;">
                      <table align="center" width="100%" style="border:#CCCCCC solid 1px;" cellpadding="2" cellspacing="1">
                        <tr style="background:#F4F2F7" height="30px">
                          <td class="h_text">S.No.</td>
                          <td class="h_text">RGP Ledger Code</td>
                          <td class="h_text">RGP Ledger Name</td>
                          <td class="h_text">RGP Ledger Address</td>
                          <td class="h_text">Edit</td>
                          <td class="h_text">Delete</td>
                        </tr>
												<?
                        $sql = "select * from  ms_rgp_ledger order by name";
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
                            <td class="Text01"><?=$row["rgp_ledger_code"]?></td>
                            <td class="Text01"><?=$row["name"]?></td>
                            <td class="Text01"><?=$row["address"]?></td>
                            <td class="Text01">
                            	<a href="store_add_rgpledger.php?rgp_ledger_code=<?=$row['rgp_ledger_code']?>&mode=edit">Edit</a>
                            </td>
                            <td class="Text01">
                            	<a href="javascript:;" onClick="overlay(<?=$row['rgp_ledger_code']?>);">Delete</a>
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
        <p class="form_msg">Are you sure to delete this RGP Ledger</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<? include ("inc/hr_footer.php"); ?>	