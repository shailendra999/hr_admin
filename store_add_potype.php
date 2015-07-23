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
$Page = "store_add_potype.php";
$PageTitle = "Add PO Type";
$PageFor = "PO Type";
$PageKey = "po_type_id";
$PageKeyValue = "";
$Message = "";
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$name = $_POST['name'];
	$type = $_POST['type'];
	
	if($PageKeyValue == "")
	{
		/*$sql = "insert into mpc_plant_master set
													plant_name = '$Name'
													";
		mysql_query($sql) or die ("Error in ".$sql."<br>".mysql_errno()." : ".mysql_error());*/
		$tableName="ms_po_type";
		$tableData=array("''","'$name'","'$type'","now()");
		addDataIntoTable($tableName,$tableData);
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{					
			  /*$sql = "update mpc_plant_master set
														plant_name = '$Name'
														where $PageKey = '$PageKeyValue'
														";
			mysql_query($sql) or die ("Error in ".$sql."<br>".mysql_errno()." : ".mysql_error());*/
			$tableName="ms_po_type";
			$tableColumns=array("po_type_id","name","type");
			$tableData=array("'$PageKeyValue'","'$name'","'$type'");
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
	$sql = "delete from ms_po_type where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "PO Type Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}
$name = '';
$type = '';
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_po_type where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$name = $row["name"];
		$type = $row["type"];		
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo</td>
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
                                                    <td class="paas_text" bgcolor="#E2EBF0">PO Type Name</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                    <input type="text" id="name" name="name" value="<?=$name?>" /></td>
                                                </tr>
                                                <tr>
                                                    <td class="paas_text" bgcolor="#E2EBF0">PO Type Type</td>
                                                    <td align="left" bgcolor="#F2F7F9" style="padding-left:10px;">
                                                    <input type="text" id="type" name="type" value="<?=$type?>" /></td>
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
                                        <div id="div_category_list"  style="overflow:auto;height:400px;width:750px;margin-top:20px;" >
                                          <table align="center" width="80%" style="border:#CCCCCC solid 1px;" cellpadding="1" cellspacing="1">
                                            <tr>
                                                <td class="h_text">PO Type Name</td>
                                                <td class="h_text">PO Type Type</td>
                                                <td class="h_text">Edit</td>
                                                <td class="h_text">Delete</td>
                                            </tr>
                                            <?
                                        $sql = "select * from  ms_po_type order by name ";
                                        $result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                        if(mysql_num_rows($result)>0)
                                        {
                                            
                                            $num = mysql_num_rows($result) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                            
                                            while($row = mysql_fetch_array($result)) 
                                            { 
                                                ?>
                                                <tr bgcolor="#F2F7F9">
                                                    <td class="Text01"><?=$row["name"]?></td>
                                                     <td class="Text01"><?=$row["type"]?></td>
                                                     <td class="Text01"><a href="store_add_potype.php?po_type_id=<?=$row['po_type_id']?>&mode=edit">Edit</a></td>
													 <td class="Text01"><a href="javascript:;" onClick="overlay(<?=$row['po_type_id']?>);">Delete</a></td>
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
            </table>
        </td>
    </tr>
</table>
<div id="overlay">
	<div>
        <p class="form_msg">Are you sure to delete this PO Type</p>
		<form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
            <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>

<? include ("inc/hr_footer.php"); ?>	