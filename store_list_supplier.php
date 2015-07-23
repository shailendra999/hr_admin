<?
include("inc/store_header.php");
?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	//alert(id);
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getData(value,divId,page)
{
		var strURL1=page+"?id="+value+"&sid="+Math.random();
		//alert(strURL1);
		if(value=="0")
			alert("Select Supplier From List");
		else
		{
			var req = getXMLHTTP();
			if (req)
			{																					
					req.onreadystatechange = function() {
							if (req.readyState == 4) {
									if (req.status == 200)                         
											document.getElementById(divId).innerHTML=req.responseText;
									 else 
											alert("There was a problem while using XMLHTTP:\n" + req.statusText);
							}                
					}            
					req.open("GET", strURL1, true);
					req.send(null);
			}
		}
}
</script>

<?
$Page = "store_list_supplier.php";
$PageTitle = "List Supplier";
$PageFor = "Supplier";
$PageKey = "supplier_id";
$PageKeyValue = "";
$Message = "";

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"]))
{
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_supplier where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Supplier Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from ms_supplier order by name asc";
$result=mysql_query($sql);
$rn=mysql_num_rows($result);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Supplier</td>
        </tr>
        <tr>
        	<td valign="top">
        		<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        			<tr>
        				<td valign="top" align="center" class="border">
        					<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                            <form action="store_print_supplier.php" name="test" id="test" method="post" target="_blank">
                  	<table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td colspan="2" align="center"><b>Search</b></td>
                      </tr>
                      <tr>
                      	<td align="left"><b>Supplier Name</b></td>
                        <td align="left">
                        	<?
													$sqlM="select * from ms_supplier order by name asc";
													$resM=mysql_query($sql);
													?>
                          <select id="supplier_id" name="supplier_id" style="width:200px" onchange="getData(this.value,'getDataInDiv','store_get_list_supplier.php')">
                          	<option value="0"></option>
														<?
														while($rowM=mysql_fetch_array($resM))
														{
														?>
                            	<option value="<?=$rowM['supplier_id']?>"><?=$rowM['name']?></option>
                            <?
														}
														?>
                          </select>
                        </td>
                      </tr>
                    </table>
                    <div class="AddMore" style="padding-top:10px">
                    	 
                          <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
                     
                    </div> 
                    </form>
                  	<div style="margin:0 auto;width:100%;height:850px;overflow:auto" id="getDataInDiv">
                      <table align="center" width="100%" border="1" class="table1 text_1">
                        <tr>
                          <td class="gredBg" width="5%">S.No.</td>
                          <td class="gredBg" width="25%">Supplier Name</td>
                          <td class="gredBg" width="15%">Phone No.</td>
                          <td class="gredBg" width="25%">Address</td>
                          <td class="gredBg" width="15%">TIN</td>
                          <td class="gredBg" width="5%">View</td>
                          <td class="gredBg" width="5%">Edit</td>
                          <td class="gredBg" width="5%">Delete</td>
                        </tr>
                        <?  
                        if(mysql_num_rows($result)>0)
                        {
                        $sno = 1;
													while($row=mysql_fetch_array($result))
													{
														$sql_idate="select * from ms_supplier where insert_date='".date('Y-m-d')."' and supplier_id='".$row['supplier_id']."'";
														$res_idate=mysql_query($sql_idate);	
														$row_idate=mysql_fetch_array($res_idate);
														$insert_date=$row_idate['insert_date'];
														?>
														<tr <? if ($sno%2==1) { ?> bgcolor="#F2F2F2" <? } ?>>
                              <td align="center"><?=$sno?></td>
                              <td align="left" style="padding-left:5px;"><?=$row['name']?></td>
                              <td align="center"><?=$row['phone_number']?></td>
                              <td align="left" style="padding-left:5px;"><?=stripslashes($row['address'])?></td>
                              <td align="center"><?=$row['tin']?></td>
                              <td align="center">
                                <a href="store_view_supplier.php?supplier_id=<?=$row["supplier_id"]?>">
                                <img src="images/search-icon.gif" alt="View" title="View" border="0"></a>
                              </td> 
                              <?
															if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
															{
															?>
                                <td align="center">
                                  <a href="store_add_supplier.php?supplier_id=<?=$row["supplier_id"]?>&mode=edit">
                                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0"></a>
                                </td>
                                <td align="center">
                                  <a href="javascript:;" onClick="overlay(<?=$row["supplier_id"]?>);">
                                  <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0"></a>
                                </td>
															<?
															}
															else
															{
															?>
																<td align="center"></td>
																<td align="center"></td>
															<?
															}
															?>
													 </tr>
													<?
													$sno++;
                      	}	
                      ?> 
											<?
                    	} // End Of If
											else
											{
											?>
                      <tr>
                      	<td align="center" colspan="10"><b>No Records Found</b></td>
                      </tr>
                      <?
											}
                    	?>
                     </table>       
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
   <div class="form_msg">
      <p>Are you sure to delete this Record</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>

<? 
include("inc/hr_footer.php");
?>