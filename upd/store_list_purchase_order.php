<? include("inc/store_header.php"); ?>
<script type="text/javascript">
function overlay(RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(value,divId,page,byControl)
{
	if(byControl=="PODate")
		value=document.getElementById("PODate").value;
	var strURL1=page+"?value="+value+"&byControl="+byControl;
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
</script>

<?
$Page = "store_list_purchase_order.php";
$PageTitle = "List Purchase Order";
$PageFor = "Order";
$PageKey = "order_id";
$PageKeyValue = "";
$Message = "";
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$sql="select * from ms_GRN_transaction where order_transaction_id='".$PageKeyValueTrans."'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$Message="Not Deleted";
		echo "<script>alert('Sorry!!!GRN is made for this Order.');location.href='$Page?Message=$Message';</script>";
	}
	else
	{
		$sql_sel="select mrt.required_quantity as indent_qty,mrt.pend_qty as old_pend_qty,mrgt.pend_qty as new_pend_qty,mrgt.po_qty,mrt.indent_transaction_id as indent_transaction_id from ms_order_transaction mrgt,ms_indent_transaction mrt where mrt.indent_transaction_id=mrgt.indent_transaction_id and mrgt.order_transaction_id=$PageKeyValueTrans";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['po_qty'];
		$ind_trans_id=$row_sel['indent_transaction_id'];
		$sql_upd="update ms_indent_transaction set pend_qty=$pend_qty where indent_transaction_id=$ind_trans_id";
		mysql_query ($sql_upd) or die (mysql_error());
		$sql = "delete from ms_order_transaction where order_transaction_id = '".$PageKeyValueTrans."'";
		mysql_query ($sql) or die (mysql_error());
		$Message = "Order Transaction Row Sucessfully Deleted";
		$UrlPage=$Page."?Message=".$Message;
		redirect("$UrlPage");
	}
}

?>
<?
$sql="select * from ms_order_master mrgm,ms_order_transaction mrgt where mrgm.order_id=mrgt.order_id order by mrgm.order_id asc";
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Purchase Order
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <!--<tr>
                <td class="AddMore">
                  <a target="_blank" href="store_printall_purchase_order.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>-->
              <tr>
                <td align="center" class="border" valign="top">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>PO No.</b></td>
                      <td align="left">
                        <input type="text" name="PO_id" id="PO_id" onkeyup="getDataInDiv(this.value,'getItemsInDiv','store_get_list_purchase_order.php','POid')" />
                      </td>
                      <td align="left"><b>PO Date</b></td>
                      <td align="left">
                        <input type="text" name="PODate" id="PODate"/>
                          <a href="javascript:void(0)" HIDEFOCUS
                            onClick="gfPop.fPopCalendar(document.getElementById('PODate'));return false;">
                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a> 
                        <input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('','getItemsInDiv','store_get_list_purchase_order.php','PODate')"/>
                      </td>
                     </tr>
                    <tr>
                      <td align="left"><b>Supplier</b></td>
                      <td align="left">
                        <select name="supplier_id" id="supplier_id" style="width:145px;" onchange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_purchase_order.php','Supplier')">
                          <option value="0"></option>
                          <?
                          $sql_sup= "select * from ms_supplier order by name asc";
                          $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                          if(mysql_num_rows($res_sup)>0)
                          {
                            while($row_sup = mysql_fetch_array($res_sup))
                            {
                            ?>
                              <option value="<?= $row_sup['supplier_id']?>"><?= $row_sup['name']?></option>
                            <?
                            }
                          }	
                          ?>
                        </select>
                      </td>
                      <td align="left"><b>Item Name</b></td>
                      <td align="left">
                      	<select name="item_id" id="item_id" style="width:50px; font-size:10px;" onchange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_purchase_order.php','ItemName')">
                          <option value="0"></option>
                          <?
                          $sql_IT= "select * from ms_item_master order by name asc";
                          $res_IT = mysql_query ($sql_IT) or die (mysql_error());
                          if(mysql_num_rows($res_IT)>0)
                          {
                            while($row_IT = mysql_fetch_array($res_IT))
                            {
                            ?>
        

        <option value="<?= $row_IT['item_id']?>"><?= $row_IT['name'].' | Drg No. '.$row_IT['drawing_number'].'  | Cat. No.'.$row_IT['catelog_number']?></option>
	                            <?
                            }
                          }	
                          ?>
                        </select>
                      </td>
                     </tr>
                  </table>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="5%">S.No.</td>
                        <td class="gredBg" width="5%">PO No.</td>
                        <td class="gredBg" width="8%">PO date</td>
                        <td class="gredBg" width="7%">IndentNo.</td>
                        <td class="gredBg" width="20%">Supplier</td>
                        <td class="gredBg" width="30%">Item Name</td>
                        <td class="gredBg" width="6%">PO.Qty.</td>
                        <td class="gredBg" width="7%">Pend.Qty.</td>
                        <td width="4%" class="gredBg">View</td>
                        <td width="4%" class="gredBg">Edit</td>
                        <td width="4%" class="gredBg">Delete</td>   
                      </tr>
                      <?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;
                        while($row=mysql_fetch_array($result))
                        {
                          $sql_idate="select * from ms_order_master where insert_date='".date('Y-m-d')."' and order_id='".$row['order_id']."'";
                          $res_idate=mysql_query($sql_idate);	
                          $row_idate=mysql_fetch_array($res_idate);
                          $insert_date=$row_idate['insert_date'];	
                        ?>
                        <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                          <td align="center"><?=$sno?></td>
                          <td align="center"><?=$row['order_id']?></td>
                          <td align="center"><?=getDateFormate($row['order_date'])?></td>
                          <td align="center"><?=$row['indent_id']?></td>
                          <td align="left" style="padding-left:5px">
                          <?
                            $sql_sup="select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
                            $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                            $row_sup = mysql_fetch_array($res_sup);
                            echo $row_sup['name'];
                            ?>
                          </td>
                          <td align="left" style="padding-left:5px">
                          <?
                           $sql_I="select * from ms_item_master where item_id='".$row['item_id']."' ";
                            $res_I = mysql_query ($sql_I) or die (mysql_error());
                            $row_I = mysql_fetch_array($res_I);
                            echo $row_I['name'].';Drg No. '.$row_I['drawing_number'].';Cat No. '.$row_I['catelog_number'];
                            ?>
                          </td>
                          <td align="center"><?=$row['po_qty']?></td>
                          <td align="center"><?=$row['pend_qty']?></td>
                          <td align="center">
                            <a href="store_view_purchase_order.php?order_id=<?=$row["order_id"]?>">
                            <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                          </td>
                          <?
													if(1)
													{//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
													?>
														<td align="center">
															<a href="store_add_purchase_order.php?order_id=<?=$row["order_id"]?>&mode=edit">
																<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
															</a>
														</td>
														<td align="center">
															<a href="javascript:;" onClick="overlay(<?=$row['order_transaction_id']?>);">
																<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
															</a>
														</td>
														<?
													}
													else
													{
													?>
													 <td></td>
													 <td></td>   
													<?
													}
													//$count++;
													?>
                          
                        </tr>
                         <?
                          $sno++;
                        }	
                      }
											else
											{
												?>
													<tr><td align="center" colspan="11"><b>No Record Found.</b></td></tr>
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

<? 
include("inc/hr_footer.php");
?>