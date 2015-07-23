<? include("inc/store_header.php"); ?>
<script>
function overlay(id,transId) 
{
  	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	document.getElementById("hidden_trans").value=transId;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function getDataInDiv(divId,page){
	var strURL=page;
	var params = "RGP_id="+document.getElementById("RGP_id").value;
	
	params +=  "&supplier_id="+document.getElementById("supplier_id").value;
	params +=  "&RGPGRNDate="+document.getElementById("RGPGRNDate").value;
	params +=  "&RGPGRN_end_Date="+document.getElementById("RGPGRN_end_Date").value;
	params +=  "&item_id="+document.getElementById("item_id").value;
	
	var req = getXMLHTTP();
	if (req){																					
		req.onreadystatechange = function(){
			if (req.readyState == 4) {
				if (req.status == 200){
					document.getElementById(divId).innerHTML=req.responseText;
				}else{
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}                
		}       
		req.open("POST", strURL, true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		req.setRequestHeader("Content-length", params.length);
		req.setRequestHeader("Connection", "close");
		req.send(params);
	}
}
</script>

<?
$Page = "store_list_RGP_GRN.php";
$PageTitle = "List RGP GRN";
$PageFor = "RGP GRN";
$PageKey = "RGP_GRN_id";
$PageKeyValue = "";
$Message = "";

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"])){
	$PageKeyValue  = $_POST["hidden_overlay"];
	$PageKeyValueTrans  = $_POST["hidden_trans"];
	$sql = "delete from ms_RGP_GRN_master where $PageKey = '".$PageKeyValue."'";
	
	//if(mysql_query ($sql))
	{
		$sql_sel="select mrt.quantity as RGP_qty,mrt.pend_qty as old_pend_qty,mrgt.pend_qty as new_pend_qty,mrgt.rec_qty,mrt.RGP_transaction_id as RGP_transaction_id from ms_RGP_GRN_transaction mrgt,ms_RGP_transaction mrt where mrt.RGP_transaction_id=mrgt.RGP_transaction_id and mrgt.RGP_GRN_transaction_id=$PageKeyValueTrans";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
		$RGP_transaction_id=$row_sel['RGP_transaction_id'];
		$sql_upd="update ms_RGP_transaction set pend_qty=$pend_qty where RGP_transaction_id=$RGP_transaction_id";
		mysql_query ($sql_upd) or die (mysql_error());
		
	 	$sqltrans = "delete from ms_RGP_GRN_transaction where  $PageKey = '".$PageKeyValue."'";
	 	if(mysql_query($sqltrans))
			$Message = "Record Sucessfully Deleted";
	}
	//$Message = "Order Sucessfully Deleted";
	redirect("$Page?Message=$Message");
}

$sql="select * from ms_RGP_GRN_master mrgm, ms_RGP_GRN_transaction mrgt where mrgm.RGP_GRN_id=mrgt.RGP_GRN_id order by mrgm.RGP_GRN_id asc";
#$sql="select * from ms_RGP_GRN_master mrgm, ms_RGP_GRN_transaction mrgt where mrgm.RGP_GRN_id=mrgt.RGP_GRN_id and mrgm.finYear = '".$gFinYear."' order by mrgm.RGP_GRN_id asc";
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
          	<td align="center" class="gray_bg">
            	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List RGP-GRN
            </td>
          </tr>
          <tr>
          	<td valign="top">
              <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              	<!--<tr>
                  <td class="AddMore">
                    <a target="_blank" href="store_printall_RGP_GRN.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>
                  </td>
                </tr>-->
              	<tr>
                  <td align="center" class="border">
                    <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
                    <table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td align="center" colspan="4"><b>Search Items</b></td>
                      </tr>
                      <tr>
                        <td align="left"><b>RGP-GRN No.</b></td>
                        <td align="left">
                          <input type="text" name="RGP_id" id="RGP_id" onkeyup="getDataInDiv('getItemsInDiv','store_get_list_RGP_GRN.php')" />
                        </td>
                        <td align="left"><b>Supplier</b></td>
                        <td align="left">
                        <select name="supplier_id" id="supplier_id" style="width:145px;" onchange="getDataInDiv('getItemsInDiv','store_get_list_RGP_GRN.php')">
                            <option value="">-Select-</option>
                            <? $sql_sup= "select * from ms_supplier order by name asc";
                            $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                            if(mysql_num_rows($res_sup)>0){
                              while($row_sup = mysql_fetch_array($res_sup)){ ?>
                                <option value="<?= $row_sup['supplier_id']?>"><?= $row_sup['name']?></option>
                              <? }
                            } ?>
                          </select>
                        </td>
                       </tr>
                       <tr>
                        <td align="left"><b>RGP-GRN Starting Date</b></td>
                        <td align="left">
                          <input type="text" name="RGPGRNDate" id="RGPGRNDate"/>
                            <a href="javascript:void(0)" HIDEFOCUS
                              onClick="gfPop.fPopCalendar(document.getElementById('RGPGRNDate'));return false;">
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                            </a> 
                          
                        </td>
                        <td align="left"><b>RGP-GRN Ending Date</b></td>
                        <td align="left">
                          <input type="text" name="RGPGRN_end_Date" id="RGPGRN_end_Date"/>
                            <a href="javascript:void(0)" HIDEFOCUS
                              onClick="gfPop.fPopCalendar(document.getElementById('RGPGRN_end_Date'));return false;">
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                            </a> 
                          
                        </td>
                        </tr>
                        <tr>
                        <td align="left"><b>Item Name</b></td>
                        <td align="left"><input name="item_id" id="item_id" type="text" style="width:200px;" onkeyup="getDataInDiv('getItemsInDiv','store_get_list_RGP_GRN.php')"/></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                      	<td colspan="4" align="center">
                        
                      	<input type="button" id="btnOk" name="btnOk" value="Ok" onclick="getDataInDiv('getItemsInDiv','store_get_list_RGP_GRN.php')"/>
                        </td>
                      </tr>
                    </table>
                    <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:800px">
                      <table align="center" width="100%" border="1" class="table1 text_1">
                        <tr>
                          <td class="gredBg">S.No.</td>
                          <td class="gredBg">RGP GRN No.</td>
                          <td class="gredBg">RGP GRN Date</td>
                          <td class="gredBg">RGP No.</td>
                          <td class="gredBg">Supplier</td>
                          <td class="gredBg">Item Name</td>
                          <td class="gredBg">Finacial Year</td>
                          <td width="4%" class="gredBg">View</td>
                          <td width="4%" class="gredBg">Edit</td>
                          <td width="4%" class="gredBg">Delete</td> 
                       </tr>	
                      <?  
                        if(mysql_num_rows($result)>0)
                        {
                          $sno = 1;$oldid = "";$count =1;
                          while($row=mysql_fetch_array($result))
                          {	
                          $sql_idate="select * from ms_RGP_GRN_master where insert_date='".date('Y-m-d')."' and RGP_GRN_id='".$row['RGP_GRN_id']."'";
                          $res_idate=mysql_query($sql_idate);	
                          $row_idate=mysql_fetch_array($res_idate);
                          $insert_date=$row_idate['insert_date'];
                          ?>
                          <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                            <td align="center"><?=$sno?></td>
                            <td align="center"><?= $row['RGP_GRN_id']?></td>
                            <td align="center"><?= getDateFormate($row['RGP_GRN_date'])?></td>
                            <td align="center"><?= $row['RGP_id']?></td>
                            <td align="left" style="padding-left:5px">
                            <?
                              $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
                              $res_S = mysql_query ($sql_S) or die (mysql_error());
                              $row_S = mysql_fetch_array($res_S);
                              echo $row_S['name'];
                            ?>
                            </td>
                            <td align="left" style="padding-left:5px">
                            <?
                            $sql_IN= "select mrt.item_name from ms_RGP_transaction mrt,ms_RGP_GRN_transaction mrgt where mrt.RGP_transaction_id='".$row['RGP_transaction_id']."' and mrt.RGP_transaction_id=mrgt.RGP_transaction_id";
                            $res_IN = mysql_query ($sql_IN) or die (mysql_error());
                            $row_IN = mysql_fetch_array($res_IN);
                            echo $row_IN['item_name'];
                            ?>
                            </td>
							<td align="center"><?= $row['finYear']?></td>
                            <td align="center">
                              <a href="store_view_RGP_GRN.php?RGP_GRN_id=<?=$row["RGP_GRN_id"]?>">
                              <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                              </a>
                            </td>
															<?
															if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
															{
															?>
                                <td align="center">
                                  <a href="store_add_RGP_GRN.php?RGP_GRN_id=<?=$row["RGP_GRN_id"]?>&mode=edit">
                                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                  </a>
                                </td>
                                <td align="center">
                                  <a href="javascript:;" onClick="overlay(<?=$row["RGP_GRN_id"]?>,<?=$row["RGP_GRN_transaction_id"]?>);">
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
                            ?> 
                          </tr>
                          <?
                           $sno++;
                          }
                        }
                        else
                        {
                          ?>
                            <tr><td align="center" colspan="9"><b>No Record Found.</b></td></tr>
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
 <iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<div id="overlay">
   <div class="form_msg">
      <p>Are you sure to delete this Record</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="hidden" name="hidden_trans" id="hidden_trans" value="" />
        <input type="submit" name="btn_del" value="Yes" />
        <input type="button" onClick="overlay();" name="btn_close" value="No" />
      </form>
   </div>
</div>

<? 
include("inc/hr_footer.php");
?>