<?
include("inc/maint_header.php");
?>
<script>
function overlay(id,ItemId,Qty) {
  	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	document.getElementById("hidden_overlay_ItemId").value=ItemId;
	document.getElementById("hidden_overlay_Qty").value=Qty;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}function getDataInDiv(value,divId,page,byControl)
{
		var strURL1;
		strURL1=page+"?value="+value+"&byControl="+byControl;
		//alert(strURL1);
		if(value!="")
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
$Page = "maint_list_item_consumption.php";
$PageTitle = "List Item Consumption";
$PageFor = "Item Consumption";
$PageKey = "IC_id";
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
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$item_id  = $_POST["hidden_overlay_ItemId"];
	$Qty  = $_POST["hidden_overlay_Qty"];
	$sql_stk = "select * from maint_item_stock where item_id = '".$item_id."' ";
	$result_stk = mysql_query ($sql_stk) or die ("Invalid query : ".$sql_stk."<br>".mysql_errno()." : ".mysql_error());
	
	if(mysql_num_rows($result_stk)>0)
	{
		$row_stk = mysql_fetch_array($result_stk);
		$total_stock = $row_stk['maint_stock'] + $Qty;
		
		$tableName="maint_item_stock";
		$tableColumns=array("item_id","maint_stock","insert_date");
		$tableData=array("'$item_id'","'$total_stock'","now()");
		updateDataIntoTable($tableName,$tableColumns,$tableData);
	}
	$sql = "delete from maint_item_consumption_transaction where IC_transaction_id = '".$PageKeyValueTrans."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	redirect("$Page?Message=$Message");
}

?>
<?
$colspan=0;
?>
<?
$sql="select * from maint_item_consumption_master mim, maint_item_consumption_transaction mit where mim.IC_id = mit.IC_id order by mim.IC_date asc";

$result=mysql_query($sql);
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Item Consumption
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td align="center" class="border" >
                	<div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Consumption No.</b></td>
                      <td><input type="text" name="IC_id" id="IC_id" onKeyup="getDataInDiv(this.value,'getDataInDiv','maint_get_list_item_consumption.php','IC_id')" /></td>
                      <td><b>Consumption Date(Format dd-mm-yyyy)</b></td>
                      <td>
                      <input type="text" name="ICDate" id="ICDate" />
                      	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.getElementById('ICDate'));return false;" HIDEFOCUS>
                        	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                        </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv(document.getElementById('ICDate').value,'getDataInDiv','maint_get_list_item_consumption.php','ICDate')"/>
                       </td>
                    </tr>
                    <tr>
                      <td align="left"><b>Item</b></td>
                      <td align="left" colspan="3">
                      	<select id="item_id" name="item_id" style="width:300px" onchange="getDataInDiv(this.value,'getDataInDiv','maint_get_list_item_consumption.php','Item')">
                        <option value=""></option>
                        <?
												$sql_d="select * from ms_item_master order by name";
                        $res_d=mysql_query($sql_d);
												while($row_d=mysql_fetch_array($res_d))
												{
												?>
                        	<option value="<?= $row_d['item_id']?>"><?= $row_d['name']?></option>
												<?	
                        }
												?>
                        </select>
                      </td>
                    </tr>
                  </table>
                  <div id="getDataInDiv" style="margin:0 auto;width:100%;overflow:auto;height:600px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                      <tr>
                        <td valign="top">
                        	<table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
                            <tr>
                              <td class="gredBg" width="7%">S.No.</td>
                              <td class="gredBg" width="8%">IC No.</td>
                              <td class="gredBg" width="10%">IC Date.</td>
                              <td class="gredBg" width="52%">Item Desc</td>
                              <td class="gredBg" width="8%">Cons. Qty.</td>
                              <td width="5%" class="gredBg">View</td>
                              <td width="5%" class="gredBg">Edit</td>
                              <td width="5%" class="gredBg">Delete</td>
                            </tr>	
														<?  
														if(mysql_num_rows($result)>0)
														{
															$sno =1;
															while($row=mysql_fetch_array($result))
															{	
																$sql_idate="select * from maint_item_consumption_master where insert_date='".date('Y-m-d')."' and IC_id='".$row['IC_id']."'";
																$res_idate=mysql_query($sql_idate);
																$row_idate=mysql_fetch_array($res_idate);
																$insert_date=$row_idate['insert_date'];
															?>
                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                <td align="center"><?=$sno?></td>
                                <td align="center"><?=$row['IC_id']?></td>
                                <td align="center"><?= getDateFormate($row['IC_date'])?></td>
                                <td align="left" style="padding-left:3px">
																<?
                                $sql_S="select * from ms_item_master where ms_item_master.item_id = '".$row['item_id']."'";
                                $res_S=mysql_query($sql_S) or die(mysql_error());
                                if(mysql_num_rows($res_S)>0)
                                {
                                  while($row_S=mysql_fetch_array($res_S))
                                  {
                                   echo $row_S['name']." ;Drg No. ".$row_S['drawing_number']." ;Cat No. ".$row_S['catelog_number'];
                                  }
                                }
                                ?>
                                </td>
                                <td align="center"><?= $row['cons_qty']?></td>
                                <td align="center">
                                  <a href="maint_view_item_consumption.php?IC_id=<?=$row["IC_id"]?>">
                                  <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                                </td>
																 <? 
                                 if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
                                 {
                                	?>
                                  <td align="center">
                                    <a href="maint_add_item_consumption.php?IC_id=<?=$row["IC_id"]?>&mode=edit">
                                      <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                    </a>
                                  </td>
                                  <td align="center">
                                    <a href="javascript:;" onClick="overlay(<?=$row["IC_transaction_id"]?>,<?=$row["item_id"]?>,<?=$row["cons_qty"]?>);">
                                      <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                    </a>
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
                                    <td colspan="8" align="center"><b>No Records Found</b></td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<div id="overlay">
   <div class="form_msg">
      <p>Are you sure to delete this Record</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="hidden" name="hidden_overlay_ItemId" id="hidden_overlay_ItemId" value="" />
        <input type="hidden" name="hidden_overlay_Qty" id="hidden_overlay_Qty" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>

<? 
include("inc/hr_footer.php");
?>