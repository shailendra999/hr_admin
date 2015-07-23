<? include("inc/store_header.php"); ?>
<style>
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

$Page = "store_add_purchase_order.php";
$PageTitle = "Add Purchase Order";
$PageFor = "Purchase Order";
$PageKey = "order_id";

$Message = "";
$mode='';
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
	$sql_idate="select * from ms_order_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}/**/
}

$po_type_select='';$order_date='';$supplier_id='';$indent_id='';
$purchase_order_date='';$purchase_order_type='';

$tc_billing_address='';$tc_delivery_address='';$tc_payment_terms='';$tc_delivery='';
$tc_delivery_date='';$tc_errection='';$tc_freight='';
$tc_excise_and_taxes='';$tc_p_and_f='';$tc_remarks='';
$cal_gross_amt='';
$cal_disc_amt='';$cal_duty_amount='';$cal_vat_amt='';$cal_ecess_amt='';
$cal_pack_fowd_amt='';
$cal_round_off='';$cal_total_amt='';$cal_net_amt='';
$PageKeyValue = "";

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_order_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$purchase_order_date=getDateFormate($row['order_date']);
		$po_type_select=$row['po_type_id'];
		$order_date=getDateFormate($row['order_date']);
		$supplier_id=$row['supplier_id'];$indent_id=$row['indent_id'];
	
	
		$tc_billing_address=stripslashes($row['tc_billing_address']);
		$tc_delivery_address=stripslashes($row['tc_delivery_address']);
		$tc_payment_terms=stripslashes($row['tc_payment_terms']);
		$tc_delivery=stripslashes($row['tc_delivery']);
		$tc_delivery_date=getDateFormate($row['tc_delivery_date']);
		$tc_errection=stripslashes($row['tc_errection']);
		$tc_freight=stripslashes($row['tc_freight']);
		$tc_excise_and_taxes=stripslashes($row['tc_excise_and_taxes']);
		$tc_p_and_f=stripslashes($row['tc_p_and_f']);
		$tc_remarks=stripslashes($row['tc_remarks']);
	
	
		$cal_gross_amt=$row['gross_amt_total'];$cal_disc_amt=$row['disc_amt_total'];	
		$cal_duty_amount=$row['duty_amt_total'];$cal_vat_amt=$row['vat_amt_total'];
		$cal_ecess_amt=$row['ecess_amt_total'];
		$cal_pack_fowd_amt=$row['pf_after_before_amount'];
		$cal_round_off=$row['round_off_amount'];
		$cal_total_amt=$row['total_amount'];$cal_net_amt=$row['net_amount'];	
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql_po="select * from ms_po_terms ";
	$res_po=mysql_query($sql_po);
	$row_po=mysql_fetch_array($res_po);
	$tc_billing_address=$row_po['billing_address'];
	$tc_delivery_address=$row_po['delivery_address'];
	$tc_excise_and_taxes=$row_po['excise_and_taxes'];
	$tc_delivery=$row_po['delivery'];
	$tc_payment_terms=$row_po['payment_terms'];
}
?>
<?
if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
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
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");/**/
}

if(isset($_POST["btn_submit"]))
{
	//$PageKeyValue = $_POST[$PageKey];
	if(sizeof($_POST['indent_trans_id'])==0)
	{
		$Message='Data Not Inserted';
		echo "<script>alert('No Indent Selected');location.href='$Page?Message=$Message';</script>";
	}
	if($_POST['order_date']=='')
		$order_date=date('Y-m-d');
	else
		$order_date=getDateFormate($_POST['order_date']);
	$po_type_select=$_POST['po_type_select'];
	$supplier_id=$_POST['supplier_id'];$indent_id=$_POST['indent_id'];
	
	$tc_billing_address=addslashes($_POST['tc_billing_address']);
	$tc_delivery_address=addslashes($_POST['tc_delivery_address']);
	$tc_payment_terms=addslashes($_POST['tc_payment_terms']);
	$tc_delivery=addslashes($_POST['tc_delivery']);
	$tc_delivery_date=getDateFormate($_POST['tc_delivery_date']);
	$tc_errection=addslashes($_POST['tc_errection']);
	$tc_freight=addslashes($_POST['tc_freight']);
	$tc_excise_and_taxes=addslashes($_POST['tc_excise_and_taxes']);
	$tc_p_and_f=addslashes($_POST['tc_p_and_f']);
	$tc_remarks=addslashes($_POST['tc_remarks']);
	
	$cal_gross_amt=$_POST['cal_gross_amt'];$cal_disc_amt=$_POST['cal_disc_amt'];	
	$cal_duty_amount=$_POST['cal_duty_amount'];$cal_vat_amt=$_POST['cal_vat_amt'];
	$cal_ecess_amt=$_POST['cal_ecess_amt'];
	
	$cal_pack_fowd_amt=$_POST['cal_pack_fowd_amt'];
	
	$cal_round_off=$_POST['cal_round_off'];
	$cal_total_amt=$_POST['cal_total_amt'];
	$cal_net_amt=$_POST['cal_net_amt'];
	
	if($PageKeyValue == "")
	{
		$tableName="ms_order_master";
		$tableData=array("'$PageKeyValue'","'$order_date'","'$po_type_select'","'$supplier_id'","'$indent_id'","'$tc_billing_address'","'$tc_delivery_address'","'$tc_payment_terms'","'$tc_delivery'","'$tc_delivery_date'","'$tc_errection'","'$tc_freight'","'$tc_excise_and_taxes'","'$tc_p_and_f'","'$tc_remarks'","'$cal_gross_amt'","'$cal_disc_amt'","'$cal_duty_amount'","'$cal_vat_amt'","'$cal_ecess_amt'","'$cal_pack_fowd_amt'","'$cal_round_off'","'$cal_total_amt'","'$cal_net_amt'","now()");
		//print_r($tableData);
		if(addDataIntoTable($tableName,$tableData))
		{
			$order_id=mysql_insert_id();
			for($i=0;$i<sizeof($_POST["indent_trans_id"]);$i++)
			{
				$indent_trans_id=$_POST['indent_trans_id'][$i];
				$item_id=$_POST['item_id'][$i];
				$po_qty=$_POST['po_qty'][$i];
				$pend_qty=$_POST['pend_qty'][$i];
				$rate=$_POST['rate'][$i];
				$disc_perc=$_POST['disc_perc'][$i];
				$duty_perc=$_POST['duty_perc'][$i];
				$ecess_perc=$_POST['ecess_perc'][$i];
				$vat_perc=$_POST['vat_perc'][$i];
				$net_rate=$_POST['net_rate'][$i];
				//////////////Update Quantity ///////////////
				$sql_upd="update ms_indent_transaction set pend_qty=$pend_qty where indent_transaction_id=$indent_trans_id";
				mysql_query($sql_upd);
				////////////////////////////////////////////
				$tableData=array("''","'$order_id'","'$indent_trans_id'","'$item_id'","'$po_qty'","'$po_qty'","'$rate'","'$disc_perc'","'$duty_perc'","'$ecess_perc'","'$vat_perc'","'$net_rate'","now()");
				if(addDataIntoTable("ms_order_transaction",$tableData))
					$Message = "$PageFor Inserted";	
			}
			redirect("$Page?Message=$Message");
		}
	}	
	else
	{
		if($mode == "edit")
		{	
			$tableName="ms_order_master";
			$tableColumns=array("order_id","order_date","po_type_id","supplier_id","indent_id","tc_billing_address","tc_delivery_address","tc_payment_terms","tc_delivery","tc_delivery_date","tc_errection","tc_freight","tc_excise_and_taxes","tc_p_and_f","tc_remarks","gross_amt_total","disc_amt_total","duty_amt_total","vat_amt_total","ecess_amt_total","pf_after_before_amount","round_off_amount","total_amount","net_amount ");
			
			$tableData=array("'$PageKeyValue'","'$order_date'","'$po_type_select'","'$supplier_id'","'$indent_id'","'$tc_billing_address'","'$tc_delivery_address'","'$tc_payment_terms'","'$tc_delivery'","'$tc_delivery_date'","'$tc_errection'","'$tc_freight'","'$tc_excise_and_taxes'","'$tc_p_and_f'","'$tc_remarks'","'$cal_gross_amt'","'$cal_disc_amt'","'$cal_duty_amount'","'$cal_vat_amt'","'$cal_ecess_amt'","'$cal_pack_fowd_amt'","'$cal_round_off'","'$cal_total_amt'","'$cal_net_amt'");
			//print_r($tableData);echo "<br />";
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
			{
				$tableColumns=array("order_transaction_id","order_id","indent_id","item_id","po_qty","pend_qty","rate","disc_perc","duty_perc","ecess_perc","vat_perc","net_rate");
				for($i=0;$i<sizeof($_POST["indent_trans_id"]);$i++)
				{
					$order_trans_id=$_POST['order_trans_id'][$i];
					$indent_trans_id=$_POST['indent_trans_id'][$i];
					$item_id=$_POST['item_id'][$i];				
					$po_qty=$_POST['po_qty'][$i];
					$pend_qty=$_POST['pend_qty'][$i];
					$rate=$_POST['rate'][$i];
					$disc_perc=$_POST['disc_perc'][$i];
					$duty_perc=$_POST['duty_perc'][$i];
					$ecess_perc=$_POST['ecess_perc'][$i];
					$vat_perc=$_POST['vat_perc'][$i];
					$net_rate=$_POST['net_rate'][$i];
					///////////////////////////////// Pending Quantity ///////////////////////
					$sql_upd="update ms_indent_transaction set pend_qty=$pend_qty where indent_transaction_id=$indent_trans_id";
					mysql_query ($sql_upd) or die (mysql_error());
					///////////////////////////////// End ///////////////////////
					$tableColumns=array("order_transaction_id","order_id","indent_transaction_id","item_id","po_qty","pend_qty","rate","disc_perc","duty_perc","ecess_perc","vat_perc","net_rate");
					$tableData=array("'$order_trans_id'","'$PageKeyValue'","'$indent_trans_id'","'$item_id'","'$po_qty'","'$po_qty'","'$rate'","'$disc_perc'","'$duty_perc'","'$ecess_perc'","'$vat_perc'","'$net_rate'");
					if(updateDataIntoTable("ms_order_transaction",$tableColumns,$tableData))
						$Message = "$PageFor Updated";
				}		
			}	
			//redirect("store_list_purchase_order.php?Message=$Message");
		}
	}	
	
}
if(isset($_GET["order_id"]))
{
	$order_id = $_GET["order_id"];
}
else
{
	$sql="select max(order_id) as order_id from ms_order_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$order_id=($row['order_id']+1);
}
?>

<script type="text/javascript">
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
function showData()
{
	var status=true;
	var indent_id=document.getElementById('indent_id').value;
	if(indent_id==0)
	{
		alert("Indent Number Not Selected.");
		status=false;
	}
	//alert('ok');
	var po_qty_arr=document.getElementsByName("po_qty[]");//alert(po_qty_arr[0].value);
	var rate_arr=document.getElementsByName("rate[]");//alert(rate_arr[0].value);
	var disc_perc_arr=document.getElementsByName("disc_perc[]");//alert(disc_perc[0].value);
	var duty_perc_arr=document.getElementsByName("duty_perc[]");//alert(duty_perc[0].value);
	var ecess_perc_arr=document.getElementsByName("ecess_perc[]");//alert(ecess_perc[0].value);
	var vat_perc_arr=document.getElementsByName("vat_perc[]");//alert(vat_perc[0].value);
	var net_rate_arr=document.getElementsByName("net_rate[]");
	var gross_amt=0;var disc_amt=0;var duty_amt=0;var ecess_amt=0;var st_amt=0;
	var pack_forwd_amt=0;
	//alert(rate_arr.length);
	for(var i=0;i<rate_arr.length;i++)
	{
		if((rate_arr[i].value=='0'||rate_arr[i].value=='')||(po_qty_arr[i].value=='0'||po_qty_arr[i].value==''))
		{
			status=false;		
			alert("Invalid Data");
		}
		else
		{
			pack_forwd_amt=Number(document.getElementById('cal_pack_fowd_amt').value);
			var po_qty=Number(po_qty_arr[i].value);
			var rate=Number(rate_arr[i].value);
			var dis_per=Number(disc_perc_arr[i].value);
			var duty_perc=Number(duty_perc_arr[i].value);
			var ecess_perc=Number(ecess_perc_arr[i].value);
			var vat_perc=Number(vat_perc_arr[i].value);
			var ga_local=Number(po_qty*rate);
			disc_amt+=Number((dis_per*ga_local)/100);
			var dis_local=Number((dis_per*ga_local)/100);
			duty_amt+=Number(((ga_local-dis_local)*duty_perc)/100);
			var duty_local =Number(((ga_local-dis_local)*duty_perc)/100);
			ecess_amt+=Number((duty_local*ecess_perc)/100);
			var ecess_local=Number((duty_local*ecess_perc)/100);
			st_amt+=Number(((ga_local-dis_local+duty_local+ecess_local)*vat_perc)/100);
			var st_local=Number(((ga_local-dis_local+duty_local+ecess_local)*vat_perc)/100);
			var net_amt=parseFloat((ga_local-dis_local+duty_local+ecess_local+st_local).toFixed(2));
			net_rate_arr[i].value=Number(Number(net_amt)/Number(po_qty)).toFixed(2);
			gross_amt+=Number(rate*po_qty);//alert('i='+i+'dis_local='+dis_local+'ga_local='+ga_local+'duty_local='+duty_local+'ecess_local='+ecess_local+'st_local='+st_local);
			var cal_gross_amt=parseFloat((Math.round(gross_amt*100)/100).toFixed(2));
			var cal_disc_amt=parseFloat((Math.round(disc_amt*100)/100).toFixed(2));
			var cal_duty_amt=parseFloat((Math.round(duty_amt*100)/100).toFixed(2));
			var cal_st_amt=parseFloat((Math.round(st_amt*100)/100).toFixed(2));
			var cal_ecess_amt=parseFloat((Math.round(ecess_amt*100)/100).toFixed(2));
			document.getElementById('cal_gross_amt').value=cal_gross_amt;
			document.getElementById('cal_disc_amt').value=cal_disc_amt;
			document.getElementById('cal_duty_amount').value=cal_duty_amt;//new_duty;
			document.getElementById('cal_vat_amt').value=cal_st_amt;
			document.getElementById('cal_ecess_amt').value=cal_ecess_amt;
			var net_amt=(cal_gross_amt+pack_forwd_amt+(cal_duty_amt)+(cal_st_amt)+(cal_ecess_amt))-(cal_disc_amt);
			document.getElementById('cal_total_amt').value=net_amt.toFixed(2);
			document.getElementById('cal_net_amt').value=(Math.round(net_amt)).toFixed(2);
			var round_amt=Math.round(net_amt)-net_amt;
			document.getElementById('cal_round_off').value=(Math.round(round_amt*100)/100).toFixed(2);
		}
	}
	alert("Check Data");
	return status;
}
</script>
<script type="text/javascript">
function getIndentTransactionData(indent_id, divID, Page)
{
	if(indent_id=='0')
		alert("Indent Number Not Selected.");
	else
	{
		var url=Page+"?indent_id="+indent_id+"&sid="+Math.random();
		//alert(Page);
		var reqindent = getXMLHTTP();
		if (reqindent)
		{																					
				reqindent.onreadystatechange = function() {
						if (reqindent.readyState == 4) {
								if (reqindent.status == 200)                         
										document.getElementById(divID).innerHTML=reqindent.responseText;
								else 
										alert("There was a problem while using XMLHTTP:\n" + reqindent.statusText);
						}                
				}            
				reqindent.open("GET", url, true);
				reqindent.send(null);
		}
	}
}	
function checkQuantity(e,thisid,divPending,po_qty1)
{
	var status=true;
	var qty1=document.getElementById(thisid).value;
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		if(Number(qty1)>Number(po_qty1))
		{
			alert("PO quantity can not more than Indent Quantity.");
			document.getElementById(thisid).value='';
			document.getElementById(thisid).focus();
			document.getElementById(divPending).value='';
			status=false;
			document.getElementById('btn_submit').disabled=true;
		}
		else
		{
			document.getElementById('btn_submit').disabled=false;
			document.getElementById(divPending).value=Number(Number(po_qty1)-Number(qty1));
		}
	}
	return status;
}
function checkQuantityedit(e,thisid,divPending,po_qty1,old_qty)
{
	var status=true;
	var qty1=document.getElementById(thisid).value;
	qty1=Number(qty1);
	po_qty1+=old_qty;
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		if(Number(qty1)>Number(po_qty1))
		{
			alert("PO quantity can not more than Indent Quantity.");
			document.getElementById(thisid).value='';
			document.getElementById(thisid).focus();
			document.getElementById(divPending).value=old_qty;
			status=false;
			document.getElementById('btn_submit').disabled=true;
		}
		else
		{
			document.getElementById('btn_submit').disabled=false;
			document.getElementById(divPending).value=Number(Number(po_qty1)-Number(qty1));
		}
	}
	return status;
}
														
</script>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/store_snb.php"); ?>
    </td>
    <td style="padding-left:5px;padding-top:5px;" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Purchase Order
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
                  	<form name="frm_add" id="frm_add" method="post" onSubmit="return showData();">
                    	<table width="100%" cellpadding="1" cellspacing="1" align="center" border="0" class="border">
                      	<tr>
                        	<td bgcolor="#EAE3E1">
                            <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_12">
                            	<tr>
                                <td align="left"><b>PO No.</b></td>
                                 <td align="left">
                                  <input type="text" id="order_id" name="order_id" readonly="readonly" value="<?= $order_id ?>" />
                                 </td>
                               	 <td align="left"><b>PO Date</b></td>
                                 <td align="left"><input type="text" id="order_date" name="order_date" value="<?= $order_date ?>" />
                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.order_date);return false;" HIDEFOCUS>
                                          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                    </a>    
                                 </td>
                              </tr>
                              <tr>
                              	<td align="left"><b>PO Type</b></td>
                              	<td align="left">
                                  <select id="po_type_select" name="po_type_select" style="width:160px" >
                                    <option value="0"></option>
                                    <?
                                    $sql_po="select * from ms_po_type";
                                    $res_po=mysql_query($sql_po);
                                    while($row_po=mysql_fetch_array($res_po))
                                    {
                                    ?>
                                    <option value="<?=$row_po['po_type_id']?>"<? if($po_type_select==$row_po['po_type_id']){?> selected="selected" <? }?>><?=$row_po['name']?></option>
                                    <?
                                    }
                                    ?>
                                  </select>
                                </td>
                              
                               	<td align="left"><b>Supplier</b></td>
                                <td align="left">
                                  <select id="supplier_id" name="supplier_id" style="width:160px" >
                                    <option value="0"></option>
                                    <?
                                      $sql_sup="select * from ms_supplier order by name asc";
                                      $res_sup=mysql_query($sql_sup);
                                      while($row_sup=mysql_fetch_array($res_sup))
                                      {
                                      ?>
                                        <option value="<?=$row_sup['supplier_id']?>"<? if($supplier_id==$row_sup['supplier_id']){?> selected="selected" <? }?>><?=$row_sup['name']?></option>
                                      <?
                                      }
                                    ?>
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td align="left"><b>Indent No.</b></td>
                                <td align="left" colspan="3">
																	<?
                                  if($mode=='edit')
                                  {
                                   echo '<b>'.$indent_id.'</b>';
                                   echo "<input type='hidden' name='indent_id' id='indent_id' value='".$indent_id."' />";
                                  }
                                  else
                                  {
																		?>
                                  <select id="indent_id" name="indent_id" style="width:100px" onchange="getIndentTransactionData(this.value,'myDataBaseDiv','store_get_indent_transaction.php')">
                                    <option value="0"></option>
                                    <?
																		$sql_Ind="select distinct sm.indent_id from ms_indent_master sm,ms_indent_transaction st where sm.indent_id=st.indent_id and st.pend_qty<>0 order by sm.indent_id asc";
																		$res_Ind=mysql_query($sql_Ind);
																		while($row_Ind=mysql_fetch_array($res_Ind))
																		{
																		?>
																		<option value="<?=$row_Ind['indent_id']?>"><?=$row_Ind['indent_id']?></option>
																		<?
																		}
                                    ?>
                                  </select>
                                  <?
																	}
																	?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div id="myDataBaseDiv">
                            	<?
															$sql_trans="SELECT * FROM ms_order_master sm,ms_order_transaction st WHERE sm.order_id=st.order_id AND sm.order_id ='".$PageKeyValue."'";
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
																			
																		$sql_indent="SELECT * FROM ms_indent_transaction mgt where mgt.indent_transaction_id='".$row_t['indent_transaction_id']."'";
																		$res_indent=mysql_query($sql_indent);
																		$row_indent=mysql_fetch_array($res_indent);
																		?>
																			<div id="myDBDiv_<?=$countTrans?>">
																			<input name="indent_trans_id[]" id="indent_trans_id[]" type="hidden" value="<?=$row_t['indent_transaction_id']?>" />
                                      <input name="order_trans_id[]" id="order_trans_id[]" type="hidden" value="<?=$row_t['order_transaction_id']?>" />
																			<input name="item_id[]" id="item_id[]" type="hidden" value="<?=$row_t['item_id']?>"/> 
																			<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
																				<tr class="text_tr" bgcolor="<?=$tableColor?>">
																					<td align="center" width="11%"><b>S. No. </b></td> 
																					<td align="center" width="40%"><b>Item Name</b></td>
																					<td align="center" width="11%"><b>UOM</b></td>
																					<td align="center" width="11%"><b>Indent Qty</b></td>
																					<td align="center" width="11%"><b>PO Qty</b></td>
																					<td align="center" width="11%"><b>Pend Qty</b></td>
																					<td align="center" width="5%"></td>                                  
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
																					<td align="center">
																						<input name="po_qty[]" id="po_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" onchange="return checkQuantityedit(event,'po_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>,<?=$row_t['po_qty']?>)" value="<?=$row_t['po_qty']?>" onblur="return checkQuantityedit(event,'po_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['pend_qty']?>,<?=$row_t['po_qty']?>)"/>
																					</td>
																					<td align="center">
																						<input name="pend_qty[]" id="pend_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60" value="<?=$row_indent['pend_qty']?>"/>
																					</td>
																					<td align="center"></td> 
																				</tr>
																				<tr class="text_tr" bgcolor="<?=$tableColor?>">
																					<td align="center"><b>Rate</b></td>
																					<td align="center"><b>Disc%</b></td>
																					<td align="center"><b>Duty%</b></td>
																					<td align="center"><b>E.Cess%</b></td>
																					<td align="center"><b>ST%</b></td>
																					<td align="center"><b>Net Rate</b></td>
																					<td align="center"></td>
																				</tr>
																				<tr class="text_tr" bgcolor="<?=$tableColor?>">
																					<td align="center">
																						<input name="rate[]" value="<?= $row_t['rate']?>" id="rate[]" type="text" class="get_H_18_W_60"/>
																					</td>
																					<td align="center">
																						<input name="disc_perc[]" value="<?= $row_t['disc_perc']?>" id="disc_perc[]" type="text" class="get_H_18_W_60"/>
																					</td>
																					<td align="center">
																						<input name="duty_perc[]" value="<?= $row_t['duty_perc']?>" id="duty_perc[]" type="text" class="get_H_18_W_60"/>
																					</td>
																					<td align="center">
																						<input name="ecess_perc[]" value="<?= $row_t['ecess_perc']?>" id="ecess_perc[]" type="text" class="get_H_18_W_60"/>
																					</td>
																					<td align="center">
																						<input name="vat_perc[]" value="<?= $row_t['vat_perc']?>" id="vat_perc[]" type="text" class="get_H_18_W_60"/>
																					</td>
																					<td align="center">
																						<input name="net_rate[]" value="<?= $row_t['net_rate']?>" id="net_rate[]" type="text" class="get_H_18_W_60"  readonly="readonly"/>
																					</td>
																					<td class="AddMore" align="center">
																						<input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
																						 <a href="javascript:;" onclick="overlay(<?= $PageKeyValue?>,<?=$row_t['order_transaction_id']?>)">
																							<img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle" title="Delete"/>
																						 </a>
																					</td>
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
                         <td>
                          <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" class="border">
                            <tr>
                              <td align="center" valign="top" class="border" width="38%" bgcolor="#EAE3E1">
                              <fieldset>
                              <legend align="left" style="color:#0066FF;font-size:16px">Terms & Conditions:</legend>
                              <table align="left" width="100%" cellpadding="1" cellspacing="1" border="0" class="text_12">
                                <tr>
                                  <td align="left" valign="top"><b>Billing Address</b></td>
                                  <td align="left">
                                    <textarea id="tc_billing_address" name="tc_billing_address" rows="2" cols="20"><?= $tc_billing_address ?></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top"><b>Delivery Address</b></td>
                                  <td align="left">
                                    <textarea id="tc_delivery_address" name="tc_delivery_address" rows="2" cols="20"><?= $tc_delivery_address ?></textarea>
                                  </td>
                                </tr>	
                                <tr>
                                  <td align="left"><b>Payment Terms</b></td>
                                  <td align="left">
                                  	<textarea id="tc_payment_terms" name="tc_payment_terms" rows="2" cols="20"><?= $tc_payment_terms ?></textarea>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top"><b>Delivery</b></td>
                                  <td align="left">
                                    <input type="text" id="tc_delivery" name="tc_delivery" value="<?= $tc_delivery ?>" style="width:150px" />
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top"><b>Date Of Delivery</b></td>
                                  <td align="left">
                                    <input type="text" id="tc_delivery_date" name="tc_delivery_date" value="<?= $tc_delivery_date ?>" style="width:100px" />
                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.tc_delivery_date);return false;" HIDEFOCUS>
                                            <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                      </a>   
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left"><b>Errection</b></td>
                                  <td align="left">
                                    <input type="text" id="tc_errection" name="tc_errection" value="<?= $tc_errection?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left"><b>Freight</b></td>
                                  <td align="left">
                                    <input id="tc_freight" name="tc_freight" value="<?= $tc_freight?>" style="width:150px" type="text"/>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left"><b>P & F.</b></td>
                                  <td align="left">
                                    <input id="tc_p_and_f" name="tc_p_and_f" value="<?= $tc_p_and_f?>" style="width:150px" type="text"/>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left"><b>Ex. & Taxes.</b></td>
                                  <td align="left">
                                    <input id="tc_excise_and_taxes" name="tc_excise_and_taxes" value="<?= $tc_excise_and_taxes?>" style="width:150px" type="text"/>
                                  </td>
                                </tr>
                                <tr>
                                  <td align="left" valign="top"><b>Remarks</b></td>
                                  <td align="left">
                                    <textarea  id="tc_remarks" name="tc_remarks" rows="2" cols="20"><?= $tc_remarks?></textarea>
                                  </td>
                                </tr> 
                              </table>
                            </fieldset>
                            </td>                                
                            <td align="left" valign="top" class="border" width="62%" bgcolor="#EAE3E1">
                              <fieldset>
                               <legend align="left" style="color:#0066FF;font-size:16px">Calculations:</legend>
                               <table align="left" width="100%" cellpadding="1" cellspacing="1" border="0" class="text_12">
                                  <tr>
                                    <td align="left" valign="top"><b>Gross Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_gross_amt" name="cal_gross_amt" value="<?= $cal_gross_amt ?>" style="width:100px" readonly="readonly" />
                                    </td>
                                    <td align="left" valign="top"><b>Pack & Forwd Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_pack_fowd_amt" name="cal_pack_fowd_amt" value="<?=$cal_pack_fowd_amt?>" style="width:100px" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Discount Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_disc_amt" name="cal_disc_amt" value="<?=$cal_disc_amt?>" style="width:100px" readonly="readonly"/>
                                    </td>
                                    <td align="left"><b>Round Off</b></td>
                                    <td align="left">
                                      <input type="text" readonly="readonly" id="cal_round_off" name="cal_round_off" value="<?= $cal_round_off ?>" style="width:100px" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Duty</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_duty_amount" name="cal_duty_amount" value="<?= $cal_duty_amount ?>" style="width:100px" readonly="readonly" />
                                    </td>
                                    <td align="left" valign="top"><b>Total Amount</b></td>
                                    <td align="left">
                                      <input type="text" readonly="readonly" id="cal_total_amt" name="cal_total_amt" value="<?= $cal_total_amt ?>" style="width:130px" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>VAT</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_vat_amt" name="cal_vat_amt" value="<?= $cal_vat_amt ?>" style="width:100px" readonly="readonly"/>
                                    </td>
                                    <td align="left" valign="top"><b>Net Amount</b></td>
                                    <td align="left">
                                      <input type="text" readonly="readonly" id="cal_net_amt" name="cal_net_amt" value="<?= $cal_net_amt ?>" style="width:130px" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Ecess Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="cal_ecess_amt" name="cal_ecess_amt" value="<?= $cal_ecess_amt ?>" style="width:100px" readonly="readonly" />
                                    </td>
                                  </tr>
                                 </table>
                              	</fieldset>
                            	</td>
                            </tr>
                          </table>
                         </td>
                        </tr>
                        <tr class="text_tr" bgcolor="#f0e6e4">
                        	<td align="center">
                          	<input type="submit" name="btn_submit" id="btn_submit" value="Save" />
                            <input type="hidden" name="edit_id" id="edit_id" value="<?=$editid?>" />
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
                                        

<div id="overlay">
	<div>
    <p class="form_msg">Are you sure to delete this Record</p>
      <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="hidden_overlay_master" id="hidden_overlay_master" value="" />
        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
        <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
        <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
      </form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        

<? 
include("inc/footer.php");
?>                           