<? include("inc/store_header.php"); ?>
<style>
.get_H_18_W_60{
	height:18px;
	width:60px;
}
</style>
<?
$Page = "store_add_RGP_GRN.php";
$PageTitle = "Add RGP GRN";
$PageFor = "RGP GRN";
$PageKey = "RGP_GRN_id";
$PageKeyValue = "";
$Message = "";
///
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
///
$RGP_GRN_id='';$RGP_GRN_date='';$department_id='';$supplier_id='';$RGP_GRN_number='';
$dc_no='';$dc_date='';$inv_no='';$inv_date='';$gp_no='';$gp_date='';
$vat_amount='';
$othersamount='';$grossamount='';$netamount='';$purpose='';$vatamount='';

$item_id='';$RGP_id='';$remarks='';$RGP_qty='';$pend_qty='';$rec_qty='';
$rate='';$vat_perc='';$net_rate='';
$mode = "";
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
	$sql_idate="select * from ms_RGP_GRN_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}
}

if(isset($_POST["btn_submit"])){
	$tableName="ms_RGP_GRN_master";
	$PageKeyValue = $_GET[$PageKey];
	if(sizeof($_POST['RGP_trans_id'])==0){
		$Message='Data Not Inserted';
		echo "<script>alert('No RGP Selected');location.href='$Page?Message=$Message';</script>";
	}
	$supplier_id=$_POST['supplier_id'];
	$RGP_GRN_number=$_POST['RGP_GRN_number'];
	$dc_no=$_POST['dc_no'];$dc_date=getDateFormate($_POST['dc_date']);
	$inv_no=$_POST['inv_no'];$inv_date=getDateFormate($_POST['inv_date']);
	$gp_no=$_POST['gp_no'];$gp_date=getDateFormate($_POST['gp_date']);
	$RGP_GRN_date=getDateFormate($_POST['RGP_GRN_date']);
	$RGP_id=$_POST['RGP_id'];
	$othersamount=$_POST['othersamount'];
	$grossamount=$_POST['grossamount'];$vatamount=$_POST['vatamount'];
	$netamount=$_POST['netamount'];$purpose=$_POST['purpose'];
		
	if($PageKeyValue == ""){
		
		$tableData=array("''","'$RGP_GRN_number'","'$RGP_GRN_date'","'$supplier_id'","'$dc_no'","'$dc_date'","'$inv_no'","'$inv_date'","'$gp_no'","'$gp_date'","'$RGP_id'","'$purpose'","'$grossamount'","'$vatamount'","'$othersamount'","'$netamount'","now()","'$gFinYear'");	
		//print_r($tableData);	
		if(addDataIntoTable($tableName,$tableData)){
			$insert_id = mysql_insert_id();				
			//print_r($tableData);
			//echo sizeof($_POST['RGP_trans_id']);
			for($i=0; $i<sizeof($_POST['RGP_trans_id']); $i++){
				$RGP_trans_id=$_POST['RGP_trans_id'][$i];
				$rec_qty=$_POST['rec_qty'][$i];
				$pend_qty=$_POST['pend_qty'][$i];
				$rate=$_POST['rate'][$i];
				$vat_perc=$_POST['vat_perc'][$i];
				$net_rate=$_POST['net_rate'][$i];
				$sql_upd="update ms_RGP_transaction set pend_qty=$pend_qty where RGP_transaction_id=$RGP_trans_id";
				mysql_query($sql_upd);
				$tableName="ms_RGP_GRN_transaction";
				$tableData=array("''","'$insert_id'","'$RGP_trans_id'","'$pend_qty'","'$rec_qty'","'$rate'","'$vat_perc'","'$net_rate'","now()","'$gFinYear'");
				//print_r($tableData);
				addDataIntoTable($tableName,$tableData);
				$Message = "$PageFor Inserted";
			}	
		  redirect("$Page?Message=$Message");
		}
	}else{
		if($mode == "edit"){
			$tableName="ms_RGP_GRN_master";
			$tableColumns=array("RGP_GRN_id","RGP_GRN_date","supplier_id","dc_number","dc_date","inv_number","inv_date","gp_number","gp_date","RGP_id","purpose","gross_amount","vat_amount","others_amount","net_amount");
			$tableData=array("'$PageKeyValue'","'$RGP_GRN_date'","'$supplier_id'","'$dc_no'","'$dc_date'","'$inv_no'","'$inv_date'","'$gp_no'","'$gp_date'","'$RGP_id'","'$purpose'","'$grossamount'","'$vatamount'","'$othersamount'","'$netamount'");
			if(updateDataIntoTable($tableName,$tableColumns,$tableData)){
				for($i=0; $i<sizeof($_POST['RGP_trans_id']); $i++){
					$RGP_GRN_trans_id=$_POST['RGP_GRN_trans_id'][$i];	
					$RGP_trans_id=$_POST['RGP_trans_id'][$i];
					$rec_qty=$_POST['rec_qty'][$i];
					$rate=$_POST['rate'][$i];
					$vat_perc=$_POST['vat_perc'][$i];
					$net_rate=$_POST['net_rate'][$i];
					$pend_qty=$_POST['pend_qty'][$i];
					///////////////////////////////// Pending Quantity ///////////////////////
					$sql_upd="update ms_RGP_transaction set pend_qty=$pend_qty where RGP_transaction_id=$RGP_trans_id";
					mysql_query ($sql_upd) or die (mysql_error());
					///////////////////////////////// End ///////////////////////
					if($RGP_GRN_trans_id!=""){
						$tableName="ms_RGP_GRN_transaction";
						$tableColumns=array("RGP_GRN_transaction_id","RGP_GRN_id","RGP_transaction_id","pend_qty","rec_qty","rate","vat_perc","net_rate");
						$tableData=array("'$RGP_GRN_trans_id'","'$PageKeyValue'","'$RGP_trans_id'","'$pend_qty'","'$rec_qty'","'$rate'","'$vat_perc'","'$net_rate'");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
						$Message = "$PageFor Updated";
					}
				}
				redirect("store_list_RGP_GRN.php");
			}
		}
	}
}
if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"])){
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql_sel="select mrt.quantity as RGP_qty,mrt.pend_qty as old_pend_qty,mrgt.pend_qty as new_pend_qty,mrgt.rec_qty,mrt.RGP_transaction_id as RGP_transaction_id from ms_RGP_GRN_transaction mrgt,ms_RGP_transaction mrt where mrt.RGP_transaction_id=mrgt.RGP_transaction_id and mrgt.RGP_GRN_transaction_id=$PageKeyValueTrans";
	$res_sel=mysql_query($sql_sel);
	$row_sel=mysql_fetch_array($res_sel);
	$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
	$RGP_transaction_id=$row_sel['RGP_transaction_id'];
	$sql_upd="update ms_RGP_transaction set pend_qty=$pend_qty where RGP_transaction_id=$RGP_transaction_id";
	mysql_query ($sql_upd) or die (mysql_error());
	$sql = "delete from ms_RGP_GRN_transaction where RGP_GRN_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die (mysql_error());
	$Message = "RGP GRN Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");/**/

}
if(isset($_GET["RGP_GRN_id"])){
	$RGP_GRN_id = $_GET["RGP_GRN_id"];
}else{
	$sql="select max(RGP_GRN_id) as RGP_GRN_id from ms_RGP_GRN_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$RGP_GRN_id=($row['RGP_GRN_id']+1);

	$sqlf="select finYear from ms_RGP_GRN_master where RGP_GRN_id = '".$row['RGP_GRN_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$RGP_GRN_number =1;
	}else{
		$sqlfy="select max(RGP_GRN_number) as RGP_GRN_number from ms_RGP_GRN_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		$RGP_GRN_number=($rowfy['RGP_GRN_number']+1);
	}

}
if(isset($_GET[$PageKey])){
	$sql = "select * from ms_RGP_GRN_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0){
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['RGP_GRN_id'];$supplier_id=$row['supplier_id'];
		$RGP_id=$row['RGP_id'];
		$RGP_GRN_date=getDateFormate($row['RGP_GRN_date']);
	  $dc_no=$row['dc_number'];$dc_date=getDateFormate($row['dc_date']);
		$inv_no=$row['inv_number'];$inv_date=getDateFormate($row['inv_date']);
		$gp_no=$row['gp_number'];$gp_date=getDateFormate($row['gp_date']);
		$purpose=$row['purpose'];
		$vat_amount=$row['vat_amount'];
		$grossamount=$row['gross_amount'];$vatamount=$row['vat_amount'];
		$othersamount=$row['others_amount'];$netamount=$row['net_amount'];
	}
}
?>
<script type="text/javascript">
function overlay(MasterId,RecordId) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<script type="text/javascript">
function getRGPTransactionData(RGP_id, divID, Page)
{
	var url=Page+"?RGP_id="+RGP_id+"&sid="+Math.random();
	//alert(Page);
	var reqRGP = getXMLHTTP();
	if (reqRGP)
	{																					
		reqRGP.onreadystatechange = function() {
			if (reqRGP.readyState == 4) {
				if (reqRGP.status == 200)                         
					document.getElementById(divID).innerHTML=reqRGP.responseText;
				else 
					alert("There was a problem while using XMLHTTP:\n" + reqRGP.statusText);
			}                
		}            
		reqRGP.open("GET", url, true);
		reqRGP.send(null);
	}
}
function showData(){
	var status=true;
	var rate_arr=document.getElementsByName("rate[]");//alert(rate[0].value);
	var rec_qty_arr=document.getElementsByName("rec_qty[]");//alert(rec_qty[0].value);
	var vat_perc_arr=document.getElementsByName("vat_perc[]");//alert(vat_perc[0].value);
	var net_rate_arr=document.getElementsByName("net_rate[]");
	for(var i=0;i<rate_arr.length;i++){
		if((rate_arr[i].value=='0'||rate_arr[i].value=='')||(rec_qty_arr[i].value=='0'||rec_qty_arr[i].value=='')||vat_perc_arr[i].value==''){
			status=false;		
			alert("Invalid Data");
		}else{
			var gross_amt=0;var vat_amt=0;
			var rate=0;var rec_qty=0;var vat=0;var vat_amt_tot=0;
			for(var i=0;i<rate_arr.length;i++){
				rate=Number(rate_arr[i].value);//alert(rate);
				rec_qty=Number(rec_qty_arr[i].value);//alert(rec_qty);
				vat=Number(vat_perc_arr[i].value);//alert(vat);//alert(vat_amt);
				vat_amt=Number((rate*vat)/100); 
				var net_amt=parseFloat((((rate)+vat_amt)*rec_qty).toFixed(2));
				net_rate_arr[i].value=net_amt;//alert('net='+net_amt);
				gross_amt+=(Number(rate)*Number(rec_qty));//alert('ga='+gross_amt);
				vat_amt_tot+=Number(vat_amt);
			}
			var cal_gross_amt=parseFloat((Math.round(gross_amt*100)/100).toFixed(2));
			var cal_vat_amt=parseFloat((Math.round(vat_amt_tot*100)/100).toFixed(2));
			document.getElementById('grossamount').value=cal_gross_amt;
			document.getElementById('vatamount').value=cal_vat_amt;
			var oa=Number(document.getElementById('othersamount').value);
			document.getElementById('netamount').value=Math.round(cal_gross_amt)+Math.round(cal_vat_amt)+Math.round(oa);
			status=true;
		}
	}
	alert("Check Data");
	return status;
}
function checkQuantity(e,thisid,divPending,rgp_qty1)
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
		if(Number(qty1)>Number(rgp_qty1))
		{
			alert("Received quantity can not more than RGP Quantity.");
			document.getElementById(thisid).value='';
			document.getElementById(thisid).focus();
			document.getElementById(divPending).value='';
			status=false;
			document.getElementById('btn_submit').disabled=true;
		}
		else
		{
			document.getElementById('btn_submit').disabled=false;
			document.getElementById(divPending).value=Number(Number(rgp_qty1)-Number(qty1));
		}
	}
	return status;
}
function checkQuantityedit(e,thisid,divPending,rgp_qty1,old_qty)
{
	var status=true;
	var qty1=document.getElementById(thisid).value;
	qty1=Number(qty1);
	rgp_qty1+=old_qty;
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		if(Number(qty1)>Number(rgp_qty1))
		{
			alert("Received quantity can not more than RGP Quantity.");
			document.getElementById(thisid).value='';
			document.getElementById(thisid).focus();
			document.getElementById(divPending).value=rgp_qty1;
			status=false;
			document.getElementById('btn_submit').disabled=true;
		}
		else
		{
			document.getElementById('btn_submit').disabled=false;
			document.getElementById(divPending).value=Number(Number(rgp_qty1)-Number(qty1));
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
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit RGP GRN
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
                  <form name="frm_add" id="frm_add" action="" method="post" onSubmit="return showData()">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>RGP GRN NO.</b></td>
                    					<td align="left"><input type="hidden" id="RGP_GRN_id" name="RGP_GRN_id" readonly="readonly" value="<?= $RGP_GRN_id ?>" /><input type="text" id="RGP_GRN_number" name="RGP_GRN_number" readonly="readonly" value="<?= $RGP_GRN_number ?>" /></td>
                              <td align="left"><b>RGP GRN Date</b></td>
                              <td align="left"><input type="text" id="RGP_GRN_date" name="RGP_GRN_date" value="<?=$RGP_GRN_date?>" />
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.RGP_GRN_date);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a> 
                              </td>
                    				</tr>
                            <tr>
                              <td align="left"><b>Supplier Name</b></td>
                              <td align="left" colspan="3">
                              	<select name="supplier_id" id="supplier_id" style="height:20px;width:200px;">
                                  <option value="0"></option>
                                  <?
																	$sql_sup= "select * from ms_supplier order by name asc";
                                  $res_sup = mysql_query ($sql_sup) or die ("Invalid query : ".$sql_sup."<br>".mysql_errno()." : ".mysql_error());
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
                                <input type="text" id="dc_date" name="dc_date" value="<?=$dc_date ?>" />
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
                                <input type="text" id="inv_date" name="inv_date" value="<?=$inv_date ?>" />
                                  <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.inv_date);return false;" HIDEFOCUS>
                                    <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                  </a> 
                              </td>
                          	</tr>
                            <tr>
                              <td align="left"><b>GP. No.</b></td>
                              <td align="left">
                                <input type="text" id="gp_no" name="gp_no" value="<?= $gp_no ?>" />
                              </td>
                              <td align="left"><b>GP Date</b></td>
                              <td align="left">
                                <input type="text" id="gp_date" name="gp_date" value="<?=$gp_date ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.gp_date);return false;" HIDEFOCUS>
                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                </a> 
                              </td>
                          	</tr>
                            <tr>
                              <td align="left"><b>RGP No.</b></td>
                              <td align="left" colspan="3">
                              <?
															if($mode=='edit')
															{
																echo '<b>'.$RGP_id.'</b>';
																echo "<input type='hidden' id='RGP_id' name='RGP_id' value='".$RGP_id."' />";
															}
															else
															{
															?>
                                 <select name="RGP_id" id="RGP_id" style="height:20px;width:100px" onchange="getRGPTransactionData(this.value,'myDataBaseDiv','store_get_RGP_transaction.php')">
                                  <option value="0"></option>
                                  <?
																	$sql_RGP="select distinct mrm.RGP_id from ms_RGP_master mrm,ms_RGP_transaction mrt where mrm.RGP_id=mrt.RGP_id and mrt.pend_qty<>0 order by mrm.RGP_id asc";
																	$res_RGP=mysql_query($sql_RGP);
																	while($row_RGP=mysql_fetch_array($res_RGP))
																	{
																	?>
																		<option value="<?=$row_RGP['RGP_id']?>"><?=$row_RGP['RGP_id']?></option>
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
                          $sql_GRN_trans="SELECT * FROM ms_RGP_GRN_master mrgm,ms_RGP_GRN_transaction mrgt WHERE mrgm.RGP_GRN_id=mrgt.RGP_GRN_id AND mrgm.RGP_GRN_id ='".$PageKeyValue."'";
                          $res_GRN_trans=mysql_query($sql_GRN_trans);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_GRN_trans);
                          if($rc_trans>0)
                          {													
                            while($row_t=mysql_fetch_array($res_GRN_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                              $sql_tr="SELECT * FROM ms_RGP_transaction mgt where mgt.RGP_transaction_id='".$row_t['RGP_transaction_id']."'";
                              $res_tr=mysql_query($sql_tr);
                              $row_tr=mysql_fetch_array($res_tr);
                              ?>
                            <div id="myDBDiv_<?=$countTrans?>">
                              <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                              <input name="RGP_trans_id[]" id="RGP_trans_id[]" type="hidden" value="<?=$row_t['RGP_transaction_id']?>" />
                              <input name="RGP_GRN_trans_id[]" id="RGP_GRN_trans_id[]" type="hidden" value="<?=$row_t['RGP_GRN_transaction_id']?>" />
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center" width="5%"><b>S. No. </b></td>                               
                                  <td align="center" width="15%"><b>Department</b></td>
                                  <td align="center" width="30%"><b>Item Name</b></td>
                                  <td align="center" width="10%"><b>UOM</b></td>
                                  <td align="center" width="30%"><b>Purpose</b></td>
                                  <td align="center" width="10%"><b>RGP. Qty</b></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><?=$countTrans ?></td>
                                  <td align="center">
                                   <?
                                    $sql_D="select * from ms_department where department_id=$row_tr[department_id]";
                                    $res_D=mysql_query($sql_D);
                                    $row_D=mysql_fetch_array($res_D);
                                    echo $row_D['name'];
                                    ?>
                                  </td>
                                  <td align="left" style="padding-left:5px"><?=$row_tr['item_name']?></td>                                	<td align="center">
                                    <? 
                                      $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id =$row_tr[uom_id]";
                                      $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                      if(mysql_num_rows($result_uom)>0)
                                      {
                                        $row_uom = mysql_fetch_array($result_uom);
                                        echo $row_uom['uname'];
                                      }
                                    ?>
                                  </td>
                                  <td align="left" style="padding-left:5px"><?= $row_tr['remarks']?></td>
                                  <td align="center"><?= $row_tr['quantity']?></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>Rec. Qty</b></td>
                                  <td align="center"><b>Pend. Qty</b></td>
                                  <td align="center"><b>Rate</b></td>
                                  <td align="center"><b>VAT%</b></td>
                                  <td align="center"><b>Net Rate</b></td>
                                  <td align="center"></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center">
                                    <input name="rec_qty[]" id="rec_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" onkeyUp="return checkQuantityedit(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_tr['pend_qty']?>,<?=$row_t['rec_qty']?>);" onchange="return checkQuantityedit(event,'rec_qty_<?=$countTrans?>','pend_qty_<?=$countTrans?>',<?=$row_tr['pend_qty']?>,<?=$row_t['rec_qty']?>);" value="<?=$row_t['rec_qty']?>" />
                                  </td>
                                  <td align="center">
                                    <input name="pend_qty[]" id="pend_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60" value="<?=$row_tr['pend_qty']?>"/>
                                  </td>
                                  <td align="center">
                                    <input name="rate[]" id="rate[]" value="<?= $row_t['rate']?>" type="text" class="get_H_18_W_60"/>
                                  </td>
                                  <td align="center">
                                    <input name="vat_perc[]" value="<?= $row_t['vat_perc']?>" id="vat_perc[]" type="text" class="get_H_18_W_60"/>
                                  </td>
                                  <td align="center">
                                    <input name="net_rate[]" value="<?= $row_t['net_rate']?>" id="net_rate[]" type="text" class="get_H_18_W_60" readonly="readonly"/>
                                  </td>
                                  <td class="AddMore" align="center">
                                    <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                    <a href="javascript:;" onclick="overlay(<?= $PageKeyValue?>,<?=$row_t['RGP_GRN_transaction_id']?>)" title="Delete">
                                     <img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle"/>
                                    </a>
                                  </td>
                                </tr> 
                              </table>
                            </div>
                            <?
                            $countTrans++;
                            }
                          }?>
                          </div>
                          </td>
                        </tr>
                      <tr>
                        <td align="center" colspan="2" class="border" bgcolor="#EAE3E1">
                          <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                            <tr>
                              <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                  <tr>
                                    <td align="left" valign="top"><b>Purpose</b></td>
                                    <td align="left">
                                    	<textarea rows="3" cols="30" name="purpose" id="purpose"><?= $purpose?></textarea>
                                    </td>   
                                  </tr>
                                </table>
                              </td>
                              <td width="50%" valign="top">
                                <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                   <tr>
                                    <td align="left"><b>Gross Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="grossamount" id="grossamount" value="<?= $grossamount?>"/>
                                    </td>
                                   </tr>
                                   <tr>
                                    <td align="left"><b>Vat Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="vatamount" id="vatamount" value="<?= $vatamount?>"/>
                                    </td>
                                   </tr>
                                   <tr>
                                    <td align="left"><b>Others Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="othersamount" id="othersamount" value="<?= $othersamount?>" />
                                    </td>
                                   </tr>
                                   <tr>
                                    <td align="left"><b>Net Amount</b></td>
                                    <td align="left">
                                    	<input type="text" name="netamount" id="netamount" value="<?= $netamount?>" />
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