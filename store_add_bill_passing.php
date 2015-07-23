<?
include("inc/store_header.php");
?>
<style>
.getDataInDiv
{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
.get_H_18_W_60
{
	height:18px;
	width:60px;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<?

$Page = "store_add_bill_passing.php";
$PageTitle = "Add Bill Passing";
$PageFor = "Bill Passing";
$PageKey = "bill_pass_id";

$Message = "";
$mode='';
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
	/*$sql_idate="select * from ms_bill_pass_master_new where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}*/
}

/////////////////////////////////////////////////////////////////////////////////////////////
$bill_pass_id='';$bill_pass_date='';$GRN_id='';
/////////////////////////////////////////////////////////////////////////////////////////////

$PageKeyValue = "";

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_bill_pass_master_new where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$GRN_id=$row['GRN_id'];
		$bill_pass_date=getDateFormate($row['bill_pass_date']);	
	}
}
?>
<?

if(isset($_POST["btn_submit"]))
{
		if($_POST['bill_pass_date']=='')
			$bill_pass_date=date('Y-m-d');
		else
			$bill_pass_date=getDateFormate($_POST['bill_pass_date']);
		$GRN_id=$_POST['GRN_id'];
		
		if($PageKeyValue == "")
		{
			$tableName="ms_bill_pass_master_new";
			$tableData=array("''","'$bill_pass_date'","'$GRN_id'","now()");
			//print_r($tableData);
			addDataIntoTable($tableName,$tableData);
			//$res=mysql_query("update ms_GRN_master set pending_status='N' where GRN_id='".$GRN_id."'");
			$Message = "$PageFor Inserted";	
			redirect("$Page?Message=$Message");
	
		}
	else
	{
		if($mode == "edit")
		{	
			$old_GRN_id=$_POST['old_GRN_id'];
			$tableName="ms_bill_pass_master_new";
			$tableColumns=array("bill_pass_id","bill_pass_date","GRN_id");
			$tableData=array("'$PageKeyValue'","'$bill_pass_date'","'$GRN_id'");
			updateDataIntoTable($tableName,$tableColumns,$tableData);				
				
		}	
		$Message = "$PageFor Updated";
		redirect("store_list_bill_passing.php?Message=$Message");
	}	

}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}

if(isset($_GET["bill_pass_id"]))
{
	$bill_pass_id = $_GET["bill_pass_id"];
}
else
{
	$sql="select max(bill_pass_id) as bill_pass_id from ms_bill_pass_master_new";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$bill_pass_id=($row['bill_pass_id']+1);
}
?>

<script type="text/javascript">
function getGRNData(id,divItemCode)
{
	if(id=='')
	{
		alert('Select GRN Number.');
	}
	else
	{
		var strURL1="store_add_bill_passing_ajax.php?GRN_id="+id;
		var reqGRN = getXMLHTTP();
		if (reqGRN)
		{																					
			reqGRN.onreadystatechange = function() {
				if (reqGRN.readyState == 4) {
					if (reqGRN.status == 200) {                        
							document.getElementById(divItemCode).innerHTML=reqGRN.responseText;
					} else {
							alert("There was a problem while using XMLHTTP:\n" + reqGRN.statusText);
					}
				}                
			}            
			reqGRN.open("GET", strURL1, true);
			reqGRN.send(null);
		}
		document.getElementById('btn_submit').disabled=false;
	}
}		
function checkEntry()
{
	var status=true;
	var GRN_id=document.getElementById('GRN_id').value;
	if(GRN_id=='')
	{
		alert('Select GRN Number.');
		status=false;
	}
	return status;
}														
</script>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;"  valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Bill Passing Entry
          </td>
        </tr>
        <tr>
        	<td valign="top" style="padding-top:10px;">
           	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
             	<tr>
               	<td class="red"><?=$Message?></td>
               </tr>
               <tr>
                	<td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" method="post" onsubmit="return checkEntry();">
                  	<table width="100%" cellpadding="1" cellspacing="1" align="center" border="0" class="border text_12">
                  		<tr>
                      	<td align="left"><b>GRN ID</b></td>
                        <td align="left" colspan="3">
                        	<select id="GRN_id" name="GRN_id" style="width:160px" onchange="getGRNData(this.value,'getGRNDataDiv')">
                            <option value="">-Select-</option>
                            <?
														$sqlG="";
														if($mode=="edit")
														{
															$sqlG="select GRN_id from ms_GRN_master order by GRN_id asc";
														}
                            else
														{
															$sqlG="select GRN_id from ms_GRN_master where GRN_id NOT IN(Select GRN_id from ms_bill_pass_master_new)";
														}
                              $resG=mysql_query($sqlG);
                              while($rowG=mysql_fetch_array($resG))
                              {
                              ?>
                                <option value="<?=$rowG['GRN_id']?>" <? if($rowG['GRN_id']==$GRN_id){?> selected="selected"<? } ?>><?=$rowG['GRN_id']?></option>
                              <?
                              }
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td align="left"><b>Bill Pass No.</b></td>
                        <td align="left">
                          <input type="text" id="bill_pass_id" name="bill_pass_id" readonly="readonly" value="<?= $bill_pass_id ?>" />
                        </td>
                        <td align="left"><b>Bill Pass Date</b></td>
                        <td align="left">
                        <input type="text" id="bill_pass_date" name="bill_pass_date" value="<?= $bill_pass_date?>" />
                          <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.bill_pass_date);return false;" HIDEFOCUS>
                            <img name="popcal" align="absbottom" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                          </a>    
                        </td>
                      </tr>
                      <tr>
                      	<td colspan="4" align="center">
                        	<input type="hidden" value="<?=$GRN_id?>" name="old_GRN_id" id="old_GRN_id" />
                        	<div id="getGRNDataDiv">
                          	<?
														$supplier_id='';$dc_no='';$dc_date='';
														$grn_date='';$inv_no='';$inv_date='';
														$disc_amount='';$duty_amount='';$vat_amount='';$ecess_amount='';
														$othersamount='';$grossamount='';$netamount='';$remarks='';
														$po_no='';$ind_no='';$po_qty='';$pend_qty='';
														$rec_qty='';$ecess_qty='';$short_qty='';$acc_qty='';
														$rate='';$disc_perc='';$p_and_f='';$duty_perc='';
														$ecess_perc='';$vat_perc='';$sc_perc='';$add_amt='';$net_rate='';
														if(isset($_GET[$PageKey]) && $mode=='edit')
														{
															$sql = "select * from ms_GRN_master where GRN_id = '".$GRN_id."'";
															$result = mysql_query ($sql) or die (mysql_error());
															if(mysql_num_rows($result)>0)
															{
																$row=mysql_fetch_array($result);
																$PageKeyValue=$row['GRN_id'];$GRN_id=$row['GRN_id'];
																$supplier_id=$row['supplier_id'];$order_id=$row['order_id'];
																$grn_date=getDateFormate($row['GRN_date']);
																$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
																$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);
																$remarks=$row['remarks'];$disc_amount=$row['disc_amount'];
																$duty_amount=$row['duty_amount'];
																$vat_amount=$row['vat_amount'];$ecess_amount=$row['ecess_amount'];
																$grossamount=$row['gross_amount'];$othersamount=$row['others_amount'];
																$netamount=$row['net_amount'];$totalamount=$row['total_amount'];
															}
														?>
                            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                              <tr>
                                <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                                    <tr style="line-height:22px;background:#EAE3E1;">
                                      <td align="left"><b>GRN NO.</b></td>
                                      <td align="left"><?=$GRN_id ?></td>
                                      <td align="left" valign="top"><b>GRN Date</b></td>
                                      <td align="left"><?= $grn_date ?></td>
                                    </tr>
                                    <tr style="line-height:22px;background:#FFFFFF;">
                                      <td align="left"><b>Supplier Name</b></td>
                                      <td align="left" colspan="3">
                                          <?
                                          $sql_sup= "select * from ms_supplier where supplier_id='".$supplier_id."'";
                                          $res_sup = mysql_query ($sql_sup) or die (mysql_error());                                	$row_sup = mysql_fetch_array($res_sup);
                                          echo $row_sup['name']; 
                                          ?>
                                      </td>
                                    </tr>
                                    <tr style="line-height:22px;background:#EAE3E1;">
                                      <td align="left"><b>DC No.</b></td>
                                      <td align="left"><?= $dc_no ?></td>
                                      <td align="left"><b>DC Date</b></td>
                                      <td align="left"><?= $dc_date ?></td>
                                    </tr>
                                    <tr style="line-height:22px;background:#FFFFFF;">
                                      <td align="left"><b>Inv. No</b></td>
                                      <td align="left"><?= $inv_no ?></td>
                                      <td align="left"><b>Inv. Date</b></td>
                                      <td align="left"><?= $inv_date ?></td>
                                    </tr>
                                    <tr style="line-height:22px;background:#EAE3E1;">
                                        <td align="left"><b>PO No.</b></td>
                                        <td align="left" colspan="3"><?='<b>'.$order_id.'</b>'?></td>
                                     </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>   
                                <td align="center">
                                  <div id="myDataBaseDiv">
                                  <?
                                    $sql_trans="SELECT * FROM ms_GRN_master sm,ms_GRN_transaction st WHERE sm.GRN_id=st.GRN_id AND sm.GRN_id ='".$PageKeyValue."'";
                                    $res_trans=mysql_query($sql_trans);
                                    $countTrans=1;
                                    $rc_trans=mysql_num_rows($res_trans);
                                    if($rc_trans>0)
                                    {
                                      ?>
                                      <div id="divTransaction">
                                      <?
                                        while($row_t=mysql_fetch_array($res_trans))
                                        {
                                          if($countTrans%2==0)
                                            $tableColor="#eedfdc";
                                          else
                                            $tableColor="#f8f1ef";
                                          $sql_order="SELECT * FROM ms_order_transaction mgt where mgt.order_transaction_id='".$row_t['order_transaction_id']."'";
                                          $res_order=mysql_query($sql_order);
                                          $row_order=mysql_fetch_array($res_order);	
                                          $sql_indent="SELECT * FROM ms_indent_transaction mgt where mgt.indent_transaction_id='".$row_t['indent_transaction_id']."'";
                                          $res_indent=mysql_query($sql_indent);
                                          $row_indent=mysql_fetch_array($res_indent);
                                          ?>
                                            <div id="myDBDiv_<?=$countTrans?>">
                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                                <td align="center" width="10%"><b>S. No. </b></td> 
                                                <td align="center" width="40%"><b>Item Name</b></td>
                                                <td align="center" width="10%"><b>UOM</b></td>
                                                <td align="center" width="10%"><b>Indent Qty</b></td>
                                                <td align="center" width="10%"><b>PO Qty</b></td>
                                                <td align="center" width="10%"><b>Rec. Qty</b></td>
                                              </tr>
                                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                                <td align="center"><?=$countTrans?></td>
                                                <td align="left" style="padding-left:5px">
                                                <?
                                                  $sql_IT="select * from ms_item_master where item_id='".$row_t['item_id']."'";
                                                  $res_IT=mysql_query($sql_IT);
                                                  $row_IT=mysql_fetch_array($res_IT);
                                                  echo $row_IT['name']."; Drg No.: ".$row_IT['drawing_number'].'; Cat No. '.$row_IT['catelog_number'];
                                                  $uom_id=$row_IT['uom_id'];
                                                  ?>
                                                </td>
                                                <td align="center">
                                                <? 
                                                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$uom_id."' order by name ";
                                                $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                                $row_uom = mysql_fetch_array($result_uom);
                                                echo $row_uom['uname'];
                                                ?>
                                                </td>
                                                <td align="center"><?= $row_indent['required_quantity']?></td>
                                                <td align="center"><?=$row_order['po_qty']?></td>
                                                <td align="center"><?=$row_t['rec_qty']?></td>
                                              </tr>
                                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                                <td align="center"><b>Rate</b></td>
                                                <td align="center"><b>Disc%</b></td>
                                                <td align="center"><b>Duty%</b></td>
                                                <td align="center"><b>E.Cess%</b></td>
                                                <td align="center"><b>ST%</b></td>
                                                <td align="center"><b>Net Rate</b></td>
                                              </tr>
                                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                                <td align="center"><?= $row_t['rate']?></td>
                                                <td align="center"><?= $row_t['disc_perc']?></td>
                                                <td align="center"><?= $row_t['duty_perc']?></td>
                                                <td align="center"><?= $row_t['ecess_perc']?></td>
                                                <td align="center"><?= $row_t['vat_perc']?></td>
                                                <td align="center"><?= $row_t['net_rate']?></td>
                                              </tr> 
                                            </table>
                                            </div>
                                          <?			
                                          $countTrans++; 													 
                                        } // end of while
                                         ?>
                                      </div> 
                                    <?
                                    }// end if	
                                    ?>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td align="center" class="border" bgcolor="#EAE3E1">
                                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                                    <tr>
                                      <td width="35%" valign="top">
                                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                                          <tr style="line-height:22px;background:#EAE3E1;">
                                            <td align="left" valign="top"><b>Remarks</b></td>
                                            <td align="left"><?= $remarks?></td>   
                                          </tr>
                                        </table>
                                      </td>
                                      <td width="65%" valign="top">
                                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                                           <tr style="line-height:22px;background:#EAE3E1;">
                                            <td align="left" valign="top"><b>Discount Amount</b></td>
                                            <td align="left"><?=$disc_amount?></td>
                                            <td align="left"><b>Gross Amount</b></td>
                                            <td align="left"><?= $grossamount?></td>
                                          </tr>
                                          <tr style="line-height:22px;background:#FFFFFF;">
                                            <td align="left" valign="top"><b>Duty Amount</b></td>
                                            <td align="left"><?= $duty_amount ?></td>
                                            <td align="left"><b>Others Amount</b></td>
                                            <td align="left"><?= $othersamount?></td>
                                          </tr>
                                          <tr style="line-height:22px;background:#EAE3E1;">
                                            <td align="left" valign="top"><b>Vat Amount</b></td>
                                            <td align="left"><?= $vat_amount ?></td>
                                            <td align="left"><b>Net Amount</b></td>
                                            <td align="left"><?=$netamount?></td>
                                          </tr>
                                          <tr style="line-height:22px;background:#FFFFFF;">
                                            <td align="left" valign="top"><b>Ecess Amount</b></td>
                                            <td align="left"><?= $ecess_amount ?></td>
                                            <td align="left"><b>Total Amount</b></td>
                                            <td align="left"><?=$totalamount?></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              
                            </table>
                            <?
														}
														?>
                          </div>
                        </td>
                      </tr>
                      <tr class="text_tr" bgcolor="#EAE3E1">
                        <td align="center" colspan="4">
                          <input type="submit" name="btn_submit" id="btn_submit" value="Save" <? if($mode!='edit'){?> disabled="disabled" <? }?>/>                        
                        </td>
                      </tr>
                    </table>
                   </form> 
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

<? 
include("inc/footer.php");
?>                           