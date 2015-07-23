<?
include("inc/maint_header.php");
?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getItemsByName(value,divId,page,byControl)
{
	var strURL1=page+"?value="+value+"&byControl="+byControl;
	var req = getXMLHTTP();
	if (req)
	{																					
			req.onreadystatechange = function() {
					if (req.readyState == 4) {
							if (req.status == 200) {                        
									document.getElementById(divId).innerHTML=req.responseText;
							} else {
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
							}
					}                
			}            
			req.open("GET", strURL1, true);
			req.send(null);
	}
}
</script>

<?
$Page = "maint_list_item.php";
$PageTitle = "List Item";
$PageFor = "Item";
$PageKey = "item_id";
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
	$sql = "delete from ms_item_master where $PageKey = '".$PageKeyValue."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Item Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

?>
<?
$sql="select * from ms_item_master order by name asc";
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);
$rn=mysql_num_rows($result);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    	<? include ("inc/maint_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
    		<tr>
        	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Item
          </td>
        </tr>
        <tr>
        	<td valign="top">
       			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        			<tr>
                <td align="center" class="border" valign="top">
                 <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                 <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td><b>Item Name</b></td>
                      <td colspan="3" align="left">
                      	<select id="item_name" name="item_name" style="width:200px" onchange="getItemsByName(this.value,'getItemsInDiv','maint_get_list_item.php','ItemId')">
                        	<option value="0"></option>
                        <?
												$sql_item="select * from ms_item_master order by name";
                        $res_item=mysql_query($sql_item);
												while($row_item=mysql_fetch_array($res_item))
												{
												?>
                        	<option value="<?= $row_item['item_id']?>"><?= $row_item['name'].'Drg No. '.$row_item['drawing_number'].' Cat. No.'.$row_item['catelog_number']?></option>
												<?	
                        }
												?>
                        </select>
                      </td>
                     </tr>
                     <tr>
                      <td><b>Department</b></td>
                      <td>
                      	<select id="department_id" name="department_id" style="width:150px" onchange="getItemsByName(this.value,'getItemsInDiv','maint_get_list_item.php','Department')">
                        	<option value="0"></option>
													<?
                          $sqlD="select * from ms_department order by name";
                          $resD=mysql_query($sqlD);
                          while($rowD=mysql_fetch_array($resD))
                          {
                          ?>
                            <option value="<?= $rowD['department_id']?>"><?= $rowD['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                      </td>
                      <td><b>Machinary</b></td>
                      <td>
                      	<select id="machinary_id" name="machinary_id" style="width:150px" onchange="getItemsByName(this.value,'getItemsInDiv','maint_get_list_item.php','Machinary')">
                          <option value="0"></option>
                          <?
                          $sqlM="select * from ms_machinary order by name";
                          $resM=mysql_query($sqlM);
                          while($rowM=mysql_fetch_array($resM))
                          {
                          ?>
                            <option value="<?= $rowM['machinary_id']?>"><?= $rowM['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                    	<td><b>Drawing Number</b></td>
                      <td>
                    		<input type="text" id="drawingNo" name="drawingNo" style="width:150px" onkeyup="getItemsByName(this.value,'getItemsInDiv','maint_get_list_item.php','DrawingNumber')"/>
                      </td>
                      <td><b>Catelog Number</b></td>
                      <td>
                    		<input type="text" id="catelogNo" name="catelogNo" style="width:150px" onkeyup="getItemsByName(this.value,'getItemsInDiv','maint_get_list_item.php','CatelogNumber')"/>
                      </td>
                    </tr>
                  </table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">
                        	<table id="tableItems" align="center" width="100%" border="1" class="table1 text_1">
                            <tr>
                              <td class="gredBg" width="5%">S.No.</td>
                              <td class="gredBg" width="25%">Name</td>
                              <td class="gredBg" width="15%">Department</td>
                              <td class="gredBg" width="15%">Machinary</td>
                              <td class="gredBg" width="10%">Dr. No.</td>
                              <td class="gredBg" width="10%">Cat.No.</td>
                              <td class="gredBg" width="8%">Location</td>
                              <td width="4%" class="gredBg">View</td>
                              <td width="4%" class="gredBg">Delete</td>
                              <td width="4%" class="gredBg">Edit</td>
                            </tr>
														<?  
                            if(mysql_num_rows($result)>0)
                            {
															$sno = 1;
															while($row=mysql_fetch_array($result))
                              {	
															$sql_idate="select * from ms_item_master where insert_date='".date('Y-m-d')."' and item_id='".$row['item_id']."'";
															$res_idate=mysql_query($sql_idate);	
															$row_idate=mysql_fetch_array($res_idate);
															$insert_date=$row_idate['insert_date'];
                              ?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="left" style="padding-left:5px"><?=$row['name']?></td>
                                <td align="left" style="padding-left:5px">
                                  <?
                                  $sql_D= "select * from ms_department where department_id='".$row['department_id']."'";
                                  $res_D = mysql_query ($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
                                  $row_D = mysql_fetch_array($res_D);
                                  echo $row_D['name'];
                                  ?>
                                </td>
                                <td align="left" style="padding-left:5px">
                                  <?
                                  $sql_M= "select * from ms_machinary where machinary_id='".$row['machinary_id']."' ";
                                  $res_M = mysql_query ($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
                                  $row_machinary = mysql_fetch_array($res_M);
                                  echo $row_machinary['name'];
                                  ?>
                               </td>
                               <td align="left" style="padding-left:5px"><?=$row['drawing_number']?></td>
                               <td align="left" style="padding-left:5px"><?=$row['catelog_number']?></td>
                               <td align="left" style="padding-left:5px"><?=$row['location']?></td>
                               <td align="center">
                                  <a href="maint_view_item.php?item_id=<?=$row["item_id"]?>">
                                  <img src="images/search-icon.gif" alt="View" title="View" border="0"></a>
                                </td>
                                <?
																if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
																{
																?>
																	<td align="center">
																		<a href="maint_add_item.php?item_id=<?=$row["item_id"]?>&mode=edit">
																		<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0"></a>
																	</td>
																	<td align="center">
																		<a href="javascript:;" onClick="overlay(<?=$row["item_id"]?>);">
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
                            }
														else
														{
															?>
                              <tr>
                                <td colspan="10" align="center" style="font-weight:bold">No Records Found</td>
                              </tr>
                              <?
														}
                          	?>    
                            </table>    
                        </td>
                      </tr>
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