<? include ("inc/purchase_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
$Page = "purchase_add_product.php";
$PageTitle = "Add Product";
$PageFor = "Product";
$PageKey = "product_id";
$PageKeyValue = "";
$Message = "";
$mode = "";

$name = '';
$existing_stock = '';
$opening_date='';

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$product_name = $_POST['product_name'];	
	
	$ip_add = $_SERVER['REMOTE_ADDR'];
	if($PageKeyValue == "")
	{
		$tablename="ms_purchase_product_master";
		$tableData=array("''","'$product_name'","now()","$SessionLoginMasterId","'$ip_add'");
		addDataIntoTable($tablename,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{	
			$tablename="ms_purchase_product_master";
			$tableColumns=array("product_id","product_name");
			$tableData=array("'$PageKeyValue'","'$product_name'");
			updateDataIntoTable($tablename,$tableColumns,$tableData);			
			$Message = "$PageFor Updated";
		}
		
	}
	redirect("$Page?Message=$Message");
}
?>
<?
$ReferenceId = "";
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_purchase_product_master where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "$PageFor Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_purchase_product_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["product_name"];	
		$existing_stock = $row["opening_stock"];
		$opening_date  = getDatetime($row["opening_date"]);		
	}
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/purchase_snb.php"); ?>
        </td>        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/>&nbsp; Add Product</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px; padding-left:40px;">
                    	<table width="1000" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" class="border">
                                    <div align="center" style="min-height:470px; padding-top:15px;">
                                        <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;padding:5 0 5 0"><?=$Message?></div>
                                        <form id="purchase_frm" name="purchase_frm" action="" method="post">
                                            <table align="center" cellpadding="1" cellspacing="1" border="0" width="60%" style="border:#CCCCCC solid 1px;">
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0" width="40%" style="padding-left:10px;"><b>Product Name</b></td>
                                                    <td align="left" bgcolor="#F2F7F9" width="60%" style="padding-left:10px;">
                                                    <input type="text" id="product_name" name="product_name" value="<?= $name ?>" /></td>
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
                                            	<td class="h_text"><b>S.No.</b></td>
                                                <td class="h_text"><b>Product Name</b></td>
                                                <td class="h_text"><b>Edit</b></td>
                                                <td class="h_text"><b>Delete</b></td>
                                            </tr>
                                            <?
											$sql = "select * from  ms_purchase_product_master order by product_name";
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
														<td class="Text01"><?=$row["product_name"]?></td>
                                                        <td class="Text01">
                                                          <a href="purchase_add_product.php?product_id=<?=$row['product_id']?>&mode=edit">
                                                          <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                                          </a>
                                                        </td>
                                                        <td class="Text01">
                                                        	<a href="javascript:;" onClick="overlay(<?=$row['product_id']?>);">
                                                        <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                                        </a>
                                                      </td>
													</tr>
												<?												
												}
											 }
											 else
											 {
											 ?>
											 	<tr bgcolor="#f9f8f9">
														<td class="Text01" colspan="7" align="center">No Records Entered Yet.</td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<? include ("inc/hr_footer.php"); ?>	