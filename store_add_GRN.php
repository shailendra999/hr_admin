<? include("inc/store_header.php"); ?>
<style>
.get_H_18_W_60{
	height:18px;
	width:60px;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId,type_GRN){
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	document.getElementById("type_GRN").value=type_GRN;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<?
$Page = "store_add_GRN.php";
$PageTitle = "Add GRN";
$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";

$type_of_form='';
$cash='';
$supplier_id='';
$GRN_id='';
$dc_no='';
$dc_date='';
$grn_date='';
$inv_no='';
$inv_date='';$type_GRN='I';$indent_id='';
$disc_amount='';$duty_amount='';$vat_amount='';$ecess_amount='';
$othersamount='';$grossamount='';$netamount='';$remarks='';

$po_no='';$ind_no='';$po_qty='';$pend_qty='';$rec_qty='';
$rate='';$disc_perc='';$duty_perc='';$ecess_perc='';$vat_perc='';$net_rate='';$totalamount='';
$mode = "";

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	/*$sql_idate="select * from ms_GRN_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}*/
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_GRN_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['GRN_id'];
		$supplier_id=$row['supplier_id'];$order_id=$row['order_id'];
		$grn_date=getDateFormate($row['GRN_date']);$indent_id=$row['indent_id'];
		$dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
		$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);
		$type_GRN=$row['type_GRN'];$remarks=$row['remarks'];
		$disc_amount=$row['disc_amount'];$duty_amount=$row['duty_amount'];
		$vat_amount=$row['vat_amount'];$ecess_amount=$row['ecess_amount'];
		$grossamount=$row['gross_amount'];$othersamount=$row['others_amount'];
		$netamount=$row['net_amount'];$totalamount=$row['total_amount'];
	}
}
?>

<?
if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$tableName="ms_GRN_master";
	$supplier_id=$_POST['supplier_id'];
	
	if(sizeof($_POST['order_trans_id'])==0 or sizeof($_POST['indent_trans_id'])==0)
	{
		$Message='Data Not Inserted';
		echo "<script>alert('No Indent Selected');location.href='$Page?Message=$Message';</script>";
	}
	if($_POST['grn_date']=='')
		$grn_date=date('Y-m-d');
	else
		$grn_date=getDateFormate($_POST['grn_date']);
		
	$dc_no=$_POST['dc_no'];$dc_date=getDateFormate($_POST['dc_date']);
	$grn_date=getDateFormate($_POST['grn_date']);
	$GRN_number = $_POST['GRN_number'];
	$type_GRN=$_POST['type_GRN'];
	$inv_no=$_POST['inv_no'];$inv_date=getDateFormate($_POST['inv_date']);
	$disc_amount=$_POST['disc_amount'];$duty_amount=$_POST['duty_amount'];
	$vat_amount=$_POST['vat_amount'];$ecess_amount=$_POST['ecess_amount'];
	$othersamount=$_POST['othersamount'];$grossamount=$_POST['grossamount'];
	$netamount=$_POST['netamount'];$totalamount=$_POST['totalamount'];
	$remarks=$_POST['remarks'];
	
	if($PageKeyValue == "")
	{
		$indent_id='';$order_id='';
		if($type_GRN=="I")
		{
			for($j=0;$j<count($_POST['indent_id']);$j++)
			{
				if($j==0)
					$indent_id=$_POST['indent_id'][$j];
				else
					$indent_id.=','.$_POST['indent_id'][$j];
			}
		}
		else if($type_GRN=="O")
		{
			$order_id=$_POST['order_id'];
		}
	
	
		$tableData=array("''","'$GRN_number'","'$grn_date'","'$supplier_id'","'$type_GRN'","'$indent_id'","'$order_id'","'$dc_no'","'$dc_date'","'$inv_no'","'$inv_date'","'$remarks'","'$disc_amount'","'$duty_amount'","'$ecess_amount'","'$vat_amount'","'$grossamount'","'$othersamount'","'$netamount'","'$totalamount'","now()","'$gFinYear'");	
		//print_r($tableData);	
		if(addDataIntoTable($tableName,$tableData))
		{
			$insert_id = mysql_insert_id();		
			
			for($i=0; $i<sizeof($_POST['item_id']); $i++)
			{
				//if($_POST['item_id'][$i]!="0")
				{
					$item_id=$_POST['item_id'][$i];
					$order_trans_id=$_POST['order_trans_id'][$i];
					$indent_trans_id=$_POST['indent_trans_id'][$i];
					
					$rec_qty=$_POST['rec_qty'][$i];$NRGP_qty=$_POST['rec_qty'][$i];
					$pend_qty=$_POST['pend_qty'][$i];
					if($pend_qty=='')
						$pend_qty=0;
					$rate=$_POST['rate'][$i];$disc_perc=$_POST['disc_perc'][$i];
					$duty_perc=$_POST['duty_perc'][$i];
					$ecess_perc=$_POST['ecess_perc'][$i];
					$vat_perc=$_POST['vat_perc'][$i];
					$net_rate=$_POST['net_rate'][$i];
					///////////////// Update Table Item Master ///////////////
					if($type_GRN=="O")
						$sql_U="update ms_order_transaction set pend_qty='".$pend_qty."' where order_transaction_id='".$order_trans_id."'";
					else if($type_GRN=="I")
						$sql_U="update ms_indent_transaction set pend_qty='".$pend_qty."' where indent_transaction_id='".$indent_trans_id."'";
					mysql_query($sql_U);
					$res=mysql_query("select * from ms_item_master where item_id='".$item_id."'");
					$row_opening=mysql_fetch_array($res);
					$total_qty=0;
					$total_qty=(float)$row_opening["closing_stock"]+(float)$rec_qty;
					$sql_upd="update ms_item_master set closing_stock='".$total_qty."' where item_id='".$item_id."'";
					if(mysql_query($sql_upd))
					{
						$tableName="ms_GRN_transaction";
						$tableData=array("''","'$insert_id'","'$grn_date'","'$order_trans_id'","'$indent_trans_id'","'$item_id'","'$rec_qty'","'$NRGP_qty'","'$rate'","'$disc_perc'","'$duty_perc'","'$ecess_perc'","'$vat_perc'","'$net_rate'","now()","'$gFinYear'");
						if(addDataIntoTable($tableName,$tableData))
							$Message = "$PageFor Inserted";
					}
				}
			}
			redirect("$Page?Message=$Message");
		}
		
	}	
	else
	{
		if($mode == "edit")
		{
			$PageKeyValue = $_POST[$PageKey];
			$grn_date=getDateFormate($_POST['grn_date']);
			
			$supplier_id=$_POST['supplier_id'];
			$dc_no=$_POST['dc_no'];$dc_date=getDateFormate($_POST['dc_date']);
			$inv_no=$_POST['inv_no'];$inv_date=getDateFormate($_POST['inv_date']);
			$othersamount=$_POST['othersamount'];$grossamount=$_POST['grossamount'];
			$netamount=$_POST['netamount'];$remarks=$_POST['remarks'];
			$type_GRN=$_POST['type_GRN'];$indent_id='';$order_id='';
			if($type_GRN=="I")
			{
				for($j=0;$j<count($_POST['indent_id']);$j++)
				{
					if($j==0)
						$indent_id=$_POST['indent_id'][$j];
					else
						$indent_id.=','.$_POST['indent_id'][$j];
				}
			}
			else if($type_GRN=="O")
			{
				$order_id=$_POST['order_id'];
			}
			$tableName="ms_GRN_master";
			$tableColumns=array("GRN_id","GRN_number","GRN_date","supplier_id","type_GRN","indent_id","order_id","dc_number","dc_date","inv_number","inv_date","remarks","disc_amount","duty_amount","ecess_amount","vat_amount","gross_amount","others_amount","net_amount","total_amount");
			
			$tableData=array("'$PageKeyValue'","'$GRN_number'","'$grn_date'","'$supplier_id'","'$type_GRN'","'$indent_id'","'$order_id'","'$dc_no'","'$dc_date'","'$inv_no'","'$inv_date'","'$remarks'","'$disc_amount'","'$duty_amount'","'$ecess_amount'","'$vat_amount'","'$grossamount'","'$othersamount'","'$netamount'","'$totalamount'");
				
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
		
			for($i=0; $i<sizeof($_POST['item_id']); $i++)
			{
				//if($_POST['item_id'][$i]!="0")
				{
					$item_id=$_POST['item_id'][$i];
					$GRN_trans_id=$_POST['GRN_trans_id'][$i];
					$order_trans_id=$_POST['order_trans_id'][$i];
					$indent_trans_id=$_POST['indent_trans_id'][$i];
					$pend_qty=$_POST['pend_qty'][$i];
					$rec_qty=$_POST['rec_qty'][$i];$NRGP_qty=$_POST['rec_qty'][$i];
					$old_rec_qty=$_POST['old_rec_qty'][$i];
					$rate=$_POST['rate'][$i];
					$disc_perc=$_POST['disc_perc'][$i];
					$duty_perc=$_POST['duty_perc'][$i];
					$ecess_perc=$_POST['ecess_perc'][$i];
					$vat_perc=$_POST['vat_perc'][$i];
					$net_rate=$_POST['net_rate'][$i];
					///////////////// Update Table Item Master ///////////////
					if($type_GRN=="O")
						$sql_U="update ms_order_transaction set pend_qty='".$pend_qty."' where order_transaction_id='".$order_trans_id."'";
					else if($type_GRN=="I")
						$sql_U="update ms_indent_transaction set pend_qty='".$pend_qty."' where indent_transaction_id='".$indent_trans_id."'";
					////echo "<br />";
					mysql_query($sql_U);
					$res=mysql_query("select * from ms_item_master where item_id='".$item_id."'");
					$row_opening=mysql_fetch_array($res);
					$total_qty=0;
					$total_qty=(float)$row_opening["closing_stock"]+(float)$rec_qty-(float)$old_rec_qty;
					$sql_upd="update ms_item_master set closing_stock='".$total_qty."' where item_id='".$item_id."'";
					//echo "<br />";
					mysql_query($sql_upd);
					////////////////////////// End //////////////////////////
					$tableName="ms_GRN_transaction";
					$tableColumns=array("GRN_transaction_id","rec_qty","NRGP_qty","rate","disc_perc","duty_perc","ecess_perc","vat_perc","net_rate");
					$tableData=array("'$GRN_trans_id'","'$rec_qty'","'$NRGP_qty'","'$rate'","'$disc_perc'","'$duty_perc'","'$ecess_perc'","'$vat_perc'","'$net_rate'");	
					////print_r($tableData);
					updateDataIntoTable($tableName,$tableColumns,$tableData);
					$Message = "$PageFor Updated";
				}
			}	
			redirect("store_list_GRN.php");
		}
	}
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"]))
{	
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	if($_POST['type_GRN']=='O')
	{
		$sql_sel="select mim.closing_stock,mrgt.item_id,mrt.pend_qty as old_pend_qty,mrgt.rec_qty,mrt.order_transaction_id as order_transaction_id from ms_GRN_transaction mrgt,ms_order_transaction mrt,ms_item_master mim where mrt.order_transaction_id=mrgt.order_transaction_id and mrgt.GRN_transaction_id=$PageKeyValueTrans and mrgt.item_id=mim.item_id";
		//echo "<br/>";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
		$ord_trans_id=$row_sel['order_transaction_id'];
		$sql_upd="update ms_order_transaction set pend_qty=$pend_qty where order_transaction_id=$ord_trans_id";//echo "<br/>";
		mysql_query ($sql_upd) or die (mysql_error());
	}			
	if($_POST['type_GRN']=='I')
	{
		$sql_sel="select mim.closing_stock,mrgt.item_id,mrt.pend_qty as old_pend_qty,mrgt.rec_qty,mrt.indent_transaction_id as indent_transaction_id from ms_GRN_transaction mrgt,ms_indent_transaction mrt,ms_item_master mim where mrt.indent_transaction_id=mrgt.indent_transaction_id and mrgt.GRN_transaction_id=$PageKeyValueTrans and mrgt.item_id=mim.item_id";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
		$indent_transaction_id=$row_sel['indent_transaction_id'];
		$sql_upd="update ms_indent_transaction set pend_qty=$pend_qty where indent_transaction_id=$indent_transaction_id";//echo "<br/>";
		mysql_query ($sql_upd) or die (mysql_error());
	}
	
	$item_id=$row_sel['item_id'];
	$total_qty=$row_sel['closing_stock']-$row_sel['rec_qty'];
	$sql_item="update ms_item_master set closing_stock=$total_qty where item_id=$item_id";//echo "<br/>";
	mysql_query ($sql_item) or die (mysql_error());
  $sql = "delete from ms_GRN_transaction where GRN_transaction_id = '".$PageKeyValueTrans."'";//echo "<br/>";
	mysql_query ($sql) or die (mysql_error());
	$Message = "GRN Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");
}
if(isset($_GET["GRN_id"])){
	$GRN_id = $_GET["GRN_id"];
}else{
	$sql="select max(GRN_id) as GRN_id from ms_GRN_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$GRN_id=($row['GRN_id']+1);

	$sqlf="select finYear from ms_GRN_master where GRN_id = '".$row['GRN_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$GRN_number =1;
	}else{
		$sqlfy="select max(GRN_number) as GRN_number from ms_GRN_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		$GRN_number=($rowfy['GRN_number']+1);
	}
}
?>
<script type="text/javascript">
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<script type="text/javascript">
function showData()
{
	var status=true;
	var order_id=document.getElementById('order_id').value;var sel_indent_id=document.getElementById('sel_indent_id').value;
	if(order_id=="" && sel_indent_id=="")
	{
		alert("Order Number/Indent Number Not Selected.");
		status=false;
	}
	var rate_arr=document.getElementsByName("rate[]");//alert(rate_arr[0].value);
	var disc_perc_arr=document.getElementsByName("disc_perc[]");//alert(disc_perc_arr[0].value);
	var rec_qty_arr=document.getElementsByName("rec_qty[]");//alert(rec_qty_arr[0].value);
	var duty_perc_arr=document.getElementsByName("duty_perc[]");//alert(duty_perc_arr[0].value);
	var ecess_perc_arr=document.getElementsByName("ecess_perc[]");//alert(ecess_perc_arr[0].value);
	var vat_perc_arr=document.getElementsByName("vat_perc[]");//alert(vat_perc_arr[0].value);
	var net_rate_arr=document.getElementsByName("net_rate[]");
	
	var gross_amt=0;var disc_amt=0;var duty_amt=0;var ecess_amt=0;var st_amt=0;
	var disc_amt1=0;var duty_amt1=0;var ecess_amt1=0;var st_amt1=0;
	var net=0;
  var otheramt=document.getElementById('othersamount').value;
	var totalReceivedQty=0;
	for(var l=0;l<rate_arr.length;l++)
	{
		totalReceivedQty+=Number(rec_qty_arr[l].value);
	}
	//alert(totalReceivedQty);
	for(var i=0;i<rate_arr.length;i++)
	{
		if((rate_arr[i].value=='0'||rate_arr[i].value=='')||(rec_qty_arr[i].value=='0'||rec_qty_arr[i].value==''))
		{
			status=false;		
			alert("Invalid Data");
		}
		else
		{
			var rec_qty=Number(rec_qty_arr[i].value);
			var rate=Number(rate_arr[i].value);
			var dis_per=Number(disc_perc_arr[i].value);
			var duty_perc=Number(duty_perc_arr[i].value);
			var ecess_perc=Number(ecess_perc_arr[i].value);
			var vat_perc=Number(vat_perc_arr[i].value);
			var ga_local=Number(rec_qty*rate);//alert("gross_amt = "+gross_amt);//alert(oth_amt);
			var oth_amt=Number(otheramt)/Number(totalReceivedQty); 
			disc_amt=Number((ga_local*dis_per)/100);
			//alert("disc_Amt ="+disc_amt);
			duty_amt=Number(((ga_local-disc_amt)*duty_perc)/100);
			//alert("duty_amt ="+duty_amt);
			ecess_amt=Number((duty_amt*ecess_perc)/100);
			//alert("ecess_amt ="+ecess_amt);
			st_amt=Number(((ga_local-disc_amt+duty_amt+ecess_amt)*vat_perc)/100);
			//alert("st_amt ="+st_amt);
			var net_amt=Number(ga_local-disc_amt+duty_amt+ecess_amt+st_amt).toFixed(3);
			net_rate_arr[i].value=Number(((net_amt)/(rec_qty))+(oth_amt));
			gross_amt+=Number(rate*rec_qty);
			
			disc_amt1+=Number((dis_per*ga_local)/100);
			var dis_local=Number((dis_per*ga_local)/100);
			//alert("disc_amt = "+disc_amt1);
			duty_amt1+=Number(((ga_local-dis_local)*duty_perc)/100);
			var duty_local =Number(((ga_local-dis_local)*duty_perc)/100);
			//alert("duty_amt = "+duty_amt1);
			ecess_amt1+=Number((duty_local*ecess_perc)/100);
			var ecess_local=Number((duty_local*ecess_perc)/100);
			//alert("ecess_amt = "+ecess_amt1);
			st_amt1+=Number(((ga_local-dis_local+duty_local+ecess_local)*vat_perc)/100);
			var st_local=Number(((ga_local-dis_local+duty_local+ecess_local)*vat_perc)/100);
			//alert("st_amt = "+st_amt1);

			var cal_gross_amt=parseFloat(gross_amt).toFixed(2);
			var cal_disc_amt=parseFloat(disc_amt1).toFixed(2);
			var cal_duty_amt=parseFloat(duty_amt1).toFixed(2);
			var cal_st_amt=parseFloat(st_amt1).toFixed(2);
			//var cal_sc_amt=parseFloat((Math.round(sc_amt*100)/100).toFixed(3));
			var cal_ecess_amt=parseFloat(ecess_amt1).toFixed(2);
			document.getElementById('disc_amount').value=cal_disc_amt;
			document.getElementById('duty_amount').value=cal_duty_amt;
			document.getElementById('vat_amount').value=cal_st_amt;
			document.getElementById('ecess_amount').value=cal_ecess_amt;
			var oa=0;
			oa=parseFloat(cal_duty_amt)+parseFloat(cal_st_amt)+parseFloat(cal_ecess_amt)-parseFloat(cal_disc_amt);
			var o_a=0;var g_a=0;var n_a=0;
			g_a=parseFloat(((cal_gross_amt*100)/100).toFixed(3));
			o_a=(Math.round(oa*100)/100).toFixed(3);
			n_a=parseFloat(cal_gross_amt).toFixed(3)+parseFloat(oa);
			document.getElementById('grossamount').value=Math.round(g_a);
			var oth=document.getElementById('othersamount').value;
			document.getElementById('othersamount').value=Number(oth);
			net+=Number(net_rate_arr[i].value)*Number(rec_qty);
			//alert(Number(net_rate_arr[i].value)+','+Number(rec_qty)+','+Number(net_rate_arr[i].value)*Number(rec_qty)+','+net);
			//net=Number(parseFloat(g_a)+parseFloat(cal_duty_amt)+parseFloat(cal_st_amt)+parseFloat(cal_ecess_amt)-parseFloat(cal_disc_amt));
			//net_rate_arr[i].value=(net/rec_qty);
			//alert(net/rec_qty);
			document.getElementById('netamount').value=Number(net).toFixed(2);
			document.getElementById('totalamount').value=Math.round(Number(net));
		}
	}
	
	alert("Check Data");
	return status;
}	
function getTransactionData(type, divID, Page)
{
	var order_id='';var flag=true;
	if(type=="Order")
	{
		order_id=document.getElementById("order_id").value;
		if(order_id=='')
		{
			flag=false;
			alert("Order Number Not Selected.");
		}
		else
		{
			var url=Page+"?order_id="+order_id+"&sid="+Math.random();
		}
	}
	if(type=="Indent")
	{
		var ss= document.getElementById('sel_indent_id');
		var len= ss.options.length;
		var str="";
		var j=0;
		for(var i=0;i<len;i++)
		{		
			if(ss.options[i].selected == true)
			{			
				if(j == 0)
					str= ss.options[i].value;
				else
					str += ',' + ss.options[i].value;
				j++;
			}
		}
		if(str=='')
		{
			flag=false;
			alert("Indent Number Not Selected.");
		}
		else
		{
			var url=Page+"?indent_id="+str+"&sid="+Math.random();
		}
	}
	if(flag==true)
	{
		var reqorder = getXMLHTTP();
		if (reqorder)
		{																					
				reqorder.onreadystatechange = function() {
						if (reqorder.readyState == 4) {
								if (reqorder.status == 200)                         
										document.getElementById(divID).innerHTML=reqorder.responseText;
								else 
										alert("There was a problem while using XMLHTTP:\n" + reqorder.statusText);
						}                
				}            
				reqorder.open("GET", url, true);
				reqorder.send(null);
		}
	}
}			
function checkQuantity(e,thisid,divPending,po_qty1,old_qty)
{
	var status=true;
	var qty1=document.getElementById(thisid).value;
	qty1=Number(qty1);
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		///////////// Code Is Cpommented Due To Some Reason By ROHAN KUMAR on 8-4-2011 16:19 ////////
		if(Number(qty1)>(Number(po_qty1)+Number(old_qty)))
		{	
			alert("GRN Quantity can not more than PO/Indent Quantity.");
			
			document.getElementById(thisid).focus();
			if(old_qty=="")
			{
				document.getElementById(divPending).value='';document.getElementById(thisid).value='';
			}
			else
			{
				document.getElementById(divPending).value=old_qty;document.getElementById(thisid).value=po_qty1;
			}
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
function SetTypeOfGRN(disableId,enableId)
{
	document.getElementById(disableId).disabled=true;
	document.getElementById(enableId).disabled=false;
}												
</script>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add GRN
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
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>GRN NO.</b></td>
                    					<td align="left">
                              	<input type="text" id="GRN_number" name="GRN_number" readonly="readonly" value="<?=$GRN_number?>" />
								<input type="hidden" id="GRN_id" name="GRN_id" readonly="readonly" value="<?=$GRN_id ?>" />
                              </td>
                              <td align="left" valign="top"><b>GRN Date</b></td>
                              <td align="left">
                              	<input type="text" id="grn_date" name="grn_date" value="<?= $grn_date ?>" />
                              	<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.grn_date);return false;" HIDEFOCUS>
                                	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a> 
                              </td>
                    				</tr>
                            <tr>
                              <td align="left"><b>Supplier Name</b></td>
                              <td align="left" colspan="3">
                              	<select name="supplier_id" id="supplier_id" style="width:165px;">
                                  <option value="0"></option>
                                  <?
																	$sql_sup= "select * from ms_supplier order by name asc";
                                  $res_sup = mysql_query ($sql_sup) or die (mysql_error());
                                  if(mysql_num_rows($res_sup)>0)
                                  {
																		while($row_sup = mysql_fetch_array($res_sup))
																		{
																		?>
																			<option value="<?= $row_sup['supplier_id']; ?>" <? if($row_sup['supplier_id']==$supplier_id){ ?> selected="selected"<? }?> ><?= $row_sup['name']; ?></option>
																		<?
																		}
                                  }	
                                  ?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td align="left"><b>DC No.</b></td>
                              <td align="left">
                                <input type="text" id="dc_no" name="dc_no" value="<?= $dc_no ?>" />
                              </td>
                              <td align="left"><b>DC Date</b></td>
                              <td align="left">
                                <input type="text" id="dc_date" name="dc_date" value="<?= $dc_date ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.dc_date);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absbottom" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a> 
                              </td>
                            </tr>
                            <tr>
                              <td align="left"><b>Inv. No</b></td>
                              <td align="left">
                                <input type="text" id="inv_no" name="inv_no" value="<?= $inv_no ?>" />
                              </td>
                              <td align="left"><b>Inv. Date</b></td>
                              <td align="left">
                                <input type="text" id="inv_date" name="inv_date" value="<?= $inv_date ?>" />
                                  <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.inv_date);return false;" HIDEFOCUS>
                                        <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                  </a> 
                              </td>
                          	</tr>
                            <?
														if($mode!="edit")
														{
														?>
                              <tr>
                                <td align="left"><b>Select PO/Indent</b></td>
                                <td align="left" colspan="3">
                                  <input type="radio" id="type_GRN_O" name="type_GRN" value="O" <? if($type_GRN=="O"){ ?> checked="checked" <? } ?> onClick="SetTypeOfGRN('indentSelect','order_id')"/>PO
                                  <input type="radio" id="type_GRN_I" name="type_GRN" value="I" <? if($type_GRN=="I"){ ?> checked="checked" <? } ?>onclick="SetTypeOfGRN('order_id','indentSelect')"/>Indent
                                </td>
                              </tr>
                            <?
														}
														if($mode=="edit")
															echo "<input type='hidden' name='type_GRN' id='type_GRN' value='".$type_GRN."'/>";
														?>
                            <tr>
                                <td align="left"><b>PO No.</b></td>
                                <td align="left">
																	<?
                                  if($mode=='edit')
                                  {
																		echo '<b>'.$order_id.'</b>';
																		echo "<input type='hidden' name='order_id' id='order_id' value='".$order_id."'/>";
                                  }
                                  else
                                  {
																		?>
                                  <select id="order_id" name="order_id" style="width:100px" disabled="disabled" onChange="getTransactionData('Order','myDataBaseDiv','store_get_order_transaction.php')">
                                    <option value="">--Select--</option>
                                    <?
																		$sql_Ord="select distinct sm.order_id from ms_order_master sm,ms_order_transaction st where sm.order_id=st.order_id and st.pend_qty<>0 order by sm.order_id asc";
																		$res_Ord=mysql_query($sql_Ord);
																		while($row_Ord=mysql_fetch_array($res_Ord))
																		{
																		?>
																			<option value="<?=$row_Ord['order_id']?>"><?=$row_Ord['order_id']?></option>
																		<?
																		}
                                    ?>
                                  </select>
                                  <?
																	}
																	?>
                                </td>
                                <td align="left"><b>Indent No.</b></td>
                                <td align="left">
																	<?
                                  if($mode=='edit')
                                  {
																		echo '<b>'.$indent_id.'</b>';
																		echo "<input type='hidden' name='indent_id[]' id='sel_indent_id' value='".$indent_id."'/>";
                                  }
                                  else
                                  {
																		?>
                                  <select id="sel_indent_id" name="indent_id[]" multiple="multiple" style="width:100px" size="4">
                                    <option value="">--Select--</option>
                                    <?
											$sql_Ord="select distinct sm.indent_id from ms_indent_master sm,ms_indent_transaction st where sm.indent_id=st.indent_id and st.pend_qty<>0 order by sm.indent_id asc";
																		$res_Ord=mysql_query($sql_Ord);
																		while($row_Ord=mysql_fetch_array($res_Ord))
																		{
																		?>
																			<option value="<?=$row_Ord['indent_id']?>"><?=$row_Ord['indent_id']?></option>
																		<?
																		}
                                    ?>
                                  </select>
                                  <input type="button" value="Select" id="indentSelect" onClick="getTransactionData('Indent','myDataBaseDiv','store_get_indent_GRN_transaction.php')" />
                                  <?
																	}
																	?>
                                </td>
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
																$rec_qty="";
																$Qty="";
																if($countTrans%2==0)
																	$tableColor="#eedfdc";
																else
																	$tableColor="#f8f1ef";
																if($row_t['type_GRN']=="I")
																{
															  	$sql_PI="SELECT mit.required_quantity,mit.pend_qty FROM ms_indent_transaction mit where mit.indent_transaction_id='".$row_t['indent_transaction_id']."'";
																	$res_PI=mysql_query($sql_PI);
																	$row_PI=mysql_fetch_array($res_PI);
																		$req_qty=$row_PI['required_quantity'];
																		$pend_qty=$row_PI['pend_qty'];
																}
																if($row_t['type_GRN']=="O")
																{
																	$sql_PO="SELECT mit.required_quantity,mot.po_qty,mot.pend_qty FROM ms_order_transaction mot,ms_indent_transaction mit where mot.order_transaction_id='".$row_t['order_transaction_id']."' and mot.indent_transaction_id=mit.indent_transaction_id";
																	$res_PO=mysql_query($sql_PO);
																	$row_PO=mysql_fetch_array($res_PO);
																		$req_qty=$row_PO['required_quantity'];
																		$Qty=$row_PO['po_qty'];
																		$pend_qty=$row_PO['pend_qty'];
																}
																?>
																	<div id="myDBDiv_<?=$countTrans?>">
																	<input name="order_trans_id[]" id="order_trans_id[]" type="hidden" value="<?=$row_t['order_transaction_id']?>" />
                                  <input name="indent_trans_id[]" id="indent_trans_id[]" type="hidden" value="<?=$row_t['indent_transaction_id']?>" />
																	<input name="item_id[]" id="item_id[]" type="hidden" value="<?=$row_t['item_id']?>"/> 
                                  <input name="GRN_trans_id[]" id="GRN_trans_id[]" type="hidden" value="<?=$row_t['GRN_transaction_id']?>"/> 
                                  <input name="old_rec_qty[]" id="old_rec_qty[]" type="hidden" value="<?=$row_t['rec_qty']?>"/>
																	<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
																		<tr class="text_tr" bgcolor="<?=$tableColor?>">
																			<td align="center" width="10%"><b>S. No. </b></td> 
																			<td align="center" width="40%"><b>Item Name</b></td>
																			<td align="center" width="10%"><b>UOM</b></td>
																			<td align="center" width="10%"><b>Indent Qty</b></td>
																			<td align="center" width="10%"><b>PO Qty</b></td>
																			<td align="center" width="10%"><b>Rec. Qty</b></td>
																			<td align="center" width="10%"><b>Pend. Qty</b></td>
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
																			<td align="center"><?=$req_qty ?></td>
																			<td align="center"><?=$Qty?></td>
																			<td align="center">
																				<input name="rec_qty[]" id="rec_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" value="<?=$row_t['rec_qty']?>" onKeyUp="return checkQuantity(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['rec_qty']?>,<?=$pend_qty?>)" onBlur="return checkQuantity(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_t['rec_qty']?>,<?=$pend_qty?>)" autocomplete="off"/>
																			</td>
																			<td align="center">
																			<input name="pend_qty[]" id="pend_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60" value="<?=$pend_qty?>"/>
																			</td>
																		</tr>
																		<tr class="text_tr" bgcolor="<?=$tableColor?>">
																			<td align="center"><b>Rate</b></td>
																			<td align="center"><b>Disc%</b></td>
																			<td align="center"><b>Duty%</b></td>
																			<td align="center"><b>E.Cess%</b></td>
																			<td align="center"><b>VAT%</b></td>
																			<td align="center"><b>Net Rate</b></td>
																			<td align="center"></td>
																		</tr>
																		<tr class="text_tr" bgcolor="<?=$tableColor?>">
																			
																			<td align="center">
																				<input name="rate[]" value="<?= $row_t['rate']?>" id="rate[]" type="text" class="get_H_18_W_60" autocomplete="off"/>
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
																			<input type="hidden" name="h_hidden" id="h_hidden" value="<?=$countTrans?>"/> 
																				 <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?=$row_t['GRN_transaction_id']?>,'<?=$row_t['type_GRN']?>')">
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
                        <td align="center" colspan="2" class="border" bgcolor="#EAE3E1">
                        	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                            <tr>
                              <td width="35%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                  <tr>
                                    <td align="left" valign="top"><b>Remarks</b></td>
                                    <td align="left"><textarea rows="3" cols="30" name="remarks" id="remarks"><?= $remarks?></textarea></td>   
                                  </tr>
                                </table>
                              </td>
                              <td width="65%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                   <tr>
                                    <td align="left" valign="top"><b>Discount Amount</b></td>
                                    <td align="left">
                                    <input type="text" id="disc_amount" name="disc_amount" value="<?=$disc_amount?>" style="width:100px" readonly="readonly"/>
                                    </td>
                                    <td align="left"><b>Gross Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="grossamount" id="grossamount" value="<?= $grossamount?>" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Duty Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="duty_amount" name="duty_amount" value="<?= $duty_amount ?>" style="width:100px" readonly="readonly" />
                                    </td>
                                    <td align="left"><b>Others Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="othersamount" id="othersamount" value="<?= $othersamount?>" />
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Vat Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="vat_amount" name="vat_amount" value="<?= $vat_amount ?>" style="width:100px" readonly="readonly"/>
                                    </td>
                                    <td align="left"><b>Net Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="netamount" id="netamount" value="<?=$netamount?>"/>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="left" valign="top"><b>Ecess Amount</b></td>
                                    <td align="left">
                                      <input type="text" id="ecess_amount" name="ecess_amount" value="<?= $ecess_amount ?>" style="width:100px" readonly="readonly" />
                                    </td>
                                    <td align="left"><b>Total Amount</b></td>
                                    <td align="left">
                                    	<input type="text" readonly="readonly" name="totalamount" id="totalamount" value="<?=$totalamount?>"/>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                          </tr>
                          </table>
                        </td>
                  		</tr>
                  		<tr>
                        <td align="center" colspan="2" bgcolor="#EAE3E1">
                          <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                          <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                          <input type="submit" id="btn_submit" name="btn_submit" value="Save" />
                        </td>
                  		</tr>
                 		</table>
                 	</form>
								</td><!-- End Of Main Content -->
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
          <input type="hidden" name="type_GRN" id="type_GRN" value="" />
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