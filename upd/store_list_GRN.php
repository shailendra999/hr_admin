<? include("inc/store_header.php"); 
#include("inc/store_function.php");
set_time_limit(0); ?>
<script type="text/javascript">
function overlay(id,typeGRN) {
  e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	document.getElementById("type_GRN").value=typeGRN;
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
}
/*function getDataInDiv(value,divId,page,byControl){
//	document.getElementById().value;
//	var strURL1=page+"?value="+value+"&byControl="+byControl;
	if(byControl=="All"){
		var GRN_id = document.getElementById("GRN_id").value;
		var supplier_id = document.getElementById("supplier_id").value;
		var GRNDate = document.getElementById("GRNDate").value;
		var GRNDateTo = document.getElementById("GRNDateTo").value;
		var item_id = document.getElementById("item_id").value;
		var mac_id = document.getElementById("mac_id").value;
		var dep_id = document.getElementById("dep_id").value;
		var strURL1=page+"?GRN_id="+GRN_id+"&supplier_id="+supplier_id+"&GRNDate="+GRNDate+"&GRNDateTo="+GRNDateTo+"&item_id="+item_id+"&mac_id="+mac_id+"&dep_id="+dep_id;
		if(GRN_id!="" || supplier_id!="" || GRNDate!="" || GRNDateTo!="" || item_id!="" || mac_id!="" || dep_id!=""){
		var req = getXMLHTTP();
		if (req){																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200){
									alert(req.responseText);
									document.getElementById(divId).innerHTML=req.responseText;
								}else{
									alert("There was a problem while using XMLHTTP:\n" + req.statusText);
								}
						}
					}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
	}else{	alert('Please Select at Least One Condition !!');	}
	}
}*/
</script>

<?
$Page = "store_list_GRN.php";
$PageTitle = "List GRN";
$PageFor = "GRN";
$PageKey = "GRN_id";
$PageKeyValue = "";
$Message = "";

if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_delete"])){
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	if($_POST['type_GRN']=='O'){
		$sql_sel="select mim.closing_stock,mrgt.item_id,mrt.pend_qty as old_pend_qty,mrgt.rec_qty,mrt.order_transaction_id as order_transaction_id from ms_GRN_transaction mrgt,ms_order_transaction mrt,ms_item_master mim where mrt.order_transaction_id=mrgt.order_transaction_id and mrgt.GRN_transaction_id=$PageKeyValueTrans and mrgt.item_id=mim.item_id";
		//echo "<br/>";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
		$ord_trans_id=$row_sel['order_transaction_id'];
		$sql_upd="update ms_order_transaction set pend_qty=$pend_qty where order_transaction_id=$ord_trans_id";
		//echo "<br/>";
		mysql_query ($sql_upd) or die (mysql_error());
	}			
	if($_POST['type_GRN']=='I'){
		$sql_sel="select mim.closing_stock,mrgt.item_id,mrt.pend_qty as old_pend_qty,mrgt.rec_qty,mrt.indent_transaction_id as indent_transaction_id from ms_GRN_transaction mrgt,ms_indent_transaction mrt,ms_item_master mim where mrt.indent_transaction_id=mrgt.indent_transaction_id and mrgt.GRN_transaction_id=$PageKeyValueTrans and mrgt.item_id=mim.item_id";
		//echo "<br />";
		$res_sel=mysql_query($sql_sel);
		$row_sel=mysql_fetch_array($res_sel);
		$pend_qty=$row_sel['old_pend_qty']+$row_sel['rec_qty'];
		$indent_transaction_id=$row_sel['indent_transaction_id'];
		$sql_upd="update ms_indent_transaction set pend_qty=$pend_qty where indent_transaction_id=$indent_transaction_id";
		//echo "<br/>";
		mysql_query ($sql_upd) or die (mysql_error());
	}
	
	$item_id=$row_sel['item_id'];
	$total_qty=$row_sel['closing_stock']-$row_sel['rec_qty'];
	$sql_item="update ms_item_master set closing_stock=$total_qty where item_id=$item_id";
	//echo "<br/>";
	//mysql_query ($sql_item) or die (mysql_error());
  $sql = "delete from ms_GRN_transaction where GRN_transaction_id = '".$PageKeyValueTrans."'";
	//echo "<br/>";
	mysql_query ($sql) or die (mysql_error());
	$Message = "GRN Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");
}
#$sql = "select * from ms_GRN_master sm, ms_GRN_transaction st where sm.GRN_id = st.GRN_id order by sm.GRN_id asc";

$GRN_id = '';
$GRN_number = '';
$supplier_id = '';
$GRNDate = '';
$GRNDateTo = '';
$item_id = '';
$mac_id = '';
$dep_id = '';
$department = array();
$machinery = array();
$departments = '';
$machineries = '';
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
if(isset($_POST['btnOk'])){
	$GRN_id = $_POST['GRN_id'];
	$supplier_id = $_POST['supplier_id'];
	$GRNDate = $_POST['GRNDate'];
	$GRNDateTo = $_POST['GRNDateTo'];
	$item_id = $_POST['item_id'];
	$mac_id = $_POST['mac_id'];
	$dep_id = $_POST['dep_id'];
	$where_condition = "where mrgm.GRN_id = mrgt.GRN_id";
	if($GRN_id != ''){
		$where_condition .= " and mrgm.GRN_id = '".$GRN_id."'";
	}
	if($GRNDate != '' || $GRNDateTo != ''){
		$from_date = getDateFormate($GRNDate);
		$to_date = getDateFormate($GRNDateTo);
		if($to_date == ''){
			$to_date = date('Y-m-d');
		}
		$where_condition .= " and mrgm.GRN_date between '".$from_date."' and '".$to_date."'";
	}
	if($supplier_id != ''){
		$where_condition .= " and mrgm.supplier_id = '".$supplier_id."'";
	}
	if($item_id != ''){
		$where_condition .= " and mrgt.item_id = '".$item_id."'";
	}
	if($mac_id != ''){
		$sql_mac = "SELECT `item_id` FROM `ms_item_master` WHERE `machinary_id` = '".$mac_id."'";
		$res_mac = mysql_query ($sql_mac) or die (mysql_error());
		if(mysql_num_rows($res_mac)>0){
			while($row_mac = mysql_fetch_array($res_mac)){
				$machinery[] = $row_mac['item_id'];
			}
			$machineries = implode(',', $machinery) ;
			$where_condition .= " and mrgt.item_id in($machineries)";
		}
	}
	if($dep_id != ''){
		$sql_dep = "SELECT `item_id` FROM `ms_item_master` WHERE `department_id` = '".$dep_id."'";
		$res_dep = mysql_query ($sql_dep) or die (mysql_error());
		if(mysql_num_rows($res_dep)>0){
			while($row_dep = mysql_fetch_array($res_dep)){
				$department[] = $row_dep['item_id'];
			}
			$departments = implode(',', $department);
			$where_condition .= " and mrgt.item_id in($departments)";
		}
	}
	$sql = "select mrgm.GRN_id, mrgm.type_GRN, mrgm.indent_id, mrgm.GRN_date, mrgm.supplier_id, mrgt.item_id, mrgt.GRN_transaction_id, mrgm.order_id from ms_GRN_master mrgm, ms_GRN_transaction mrgt ".$where_condition." order by mrgm.GRN_id asc";
}
$sql = "select sm.GRN_id, sm.GRN_number, sm.GRN_date, sm.order_id, sm.indent_id, sm.supplier_id, st.item_id, sm.finYear from ms_GRN_master sm, ms_GRN_transaction st where sm.GRN_id = st.GRN_id order by sm.GRN_id asc";
$result = mysql_query($sql);
$rn = mysql_num_rows($result); ?>
<form action="store_print_final_GRN.php" name="pint_grn" method="post" target="_blank">
    <input type="hidden" name="GRN_id" value="<?=$GRN_id?>" />
    <input type="hidden" name="supplier_id" value="<?=$supplier_id?>">
    <input type="hidden" name="GRNDate" value="<?=$GRNDate?>">
    <input type="hidden" name="GRNDateTo" value="<?=$GRNDateTo?>">
    <input type="hidden" name="item_id" value="<?=$item_id?>">
    <input type="hidden" name="mac_id" value="<?=$mac_id?>">
    <input type="hidden" name="dep_id" value="<?=$dep_id?>">
</form>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style=" padding-top:5px;"><? include ("inc/store_snb.php"); ?></td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
      	<tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; List GRN</td>
      	</tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <!--<tr>
                <td class="AddMore">
                  <a target="_blank" href="store_printall_GRN.php" title="Print">Print All&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>-->
              <tr>
                <td align="center" class="border">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
<form name="storeSearch" action="" method="post">
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="4"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>GRN No.</b></td>
                      <td align="left">
<!--<input type="text" name="GRN_id" id="GRN_id" onKeyUp="getDataInDiv(this.value,'getItemsInDiv','store_get_list_GRN.php','GRNid')" />-->
<input type="text" name="GRN_id" id="GRN_id" value="<?=$GRN_id?>" />
                      </td>
                      <td align="left"><b>Supplier</b></td>
                      <td align="left">
<!--<select name="supplier_id" id="supplier_id" style="width:145px;" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_GRN.php','Supplier')">-->
<select name="supplier_id" id="supplier_id" style="width:145px;">
	<option value=""></option>
    <? $sql_sup= "select * from ms_supplier order by name asc";
		$res_sup = mysql_query ($sql_sup) or die (mysql_error());
		if(mysql_num_rows($res_sup)>0){
			while($row_sup = mysql_fetch_array($res_sup)){ ?>
            	<option value="<?=$row_sup['supplier_id']?>" <? if($row_sup['supplier_id'] == $supplier_id){ ?> selected="selected" <? } ?>   ><?= $row_sup['name']?></option>
			<? }
		}?>
</select></td>
                     </tr>
                    <tr>
                   <td align="left"><b>GRN Date</b></td>
                      <td align="left">  From  <input type="text" name="GRNDate" id="GRNDate" value="<?=$GRNDate?>" />
<a href="javascript:void(0)" HIDEFOCUS onClick="gfPop.fPopCalendar(document.getElementById('GRNDate'));return false;">
	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
</a> 
                      </td>
                      <td align="left" colspan="2"> To  <input type="text" name="GRNDateTo" id="GRNDateTo" value="<?=$GRNDateTo?>" />
<a href="javascript:void(0)" HIDEFOCUS onClick="gfPop.fPopCalendar(document.getElementById('GRNDateTo'));return false;">
	<img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
</a>
		</td>
                          </tr>
                          <tr>
                      <td align="left"><b>Item Name</b></td>
                      <td align="left">
<!--<select name="item_id" id="item_id" style="width:200px;" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_GRN.php','ItemName')">-->
<select name="item_id" id="item_id" style="width:200px;">
	<option value=""></option>
    <? $sql_IT= "select * from ms_item_master order by name asc";
		$res_IT = mysql_query ($sql_IT) or die (mysql_error());
		if(mysql_num_rows($res_IT)>0){
			while($row_IT = mysql_fetch_array($res_IT)){ ?>
            	<option value="<?=$row_IT['item_id']?>" <? if($row_IT['item_id'] == $item_id){ ?> selected="selected" <? } ?> ><?= $row_IT['name'].' | Drg No. '.$row_IT['drawing_number'].'  | Cat. No.'.$row_IT['catelog_number']?></option>
		<? }
      }	 ?>
</select>
                      </td>
                      <td align="left"><b>Machine Name</b></td>
                      <td align="left">
<!--<select name="mac_id" id="mac_id" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_GRN.php','MacName')">-->
<select name="mac_id" id="mac_id">
	<option value=""></option>
    <? $sql_mac= "select * from ms_machinary order by name asc";
		$res_mac = mysql_query ($sql_mac) or die (mysql_error());
		if(mysql_num_rows($res_mac)>0){
			while($row_mac = mysql_fetch_array($res_mac)){ ?>
            	<option value="<?=$row_mac['machinary_id']?>" <? if($row_mac['machinary_id'] == $mac_id){ ?> selected="selected" <? } ?> ><?=$row_mac['name']?></option>
		<? }
        }	 ?>
</select>
                      </td>
                      </tr>
                      <tr>
                      <td align="left"><b>Department Name</b></td>
                      <td align="left">
<!--<select name="dep_id" id="dep_id" onChange="getDataInDiv(this.value,'getItemsInDiv','store_get_list_GRN.php','DepName')">-->
<select name="dep_id" id="dep_id">
	<option value=""></option>
    <? $sql_dep= "select * from ms_department order by name asc";
		$res_dep = mysql_query ($sql_dep) or die (mysql_error());
		if(mysql_num_rows($res_dep)>0){
			while($row_dep = mysql_fetch_array($res_dep)){ ?>
            	<option value="<?=$row_dep['department_id']?>" <? if($row_dep['department_id'] == $dep_id){ ?> selected="selected" <? } ?> ><?=$row_dep['name']?></option>
		<? }
		}	 ?>
</select>
                      </td>
                  <td colspan="2" align="left">
<!--	<input type="button" id="btnOk" name="btnOk" value="Ok" onClick="getDataInDiv('','getItemsInDiv','store_get_list_GRN.php','All')"/>-->
    	<input type="submit" id="btnOk" name="btnOk" value="Ok" />
<a href="#" onclick="pint_grn.submit();" ><img src="images/print_25.png"  /></a>
                  </td>
                     </tr>
                  </table>
</form>
                  <div id="getItemsInDiv" style="margin:0 auto;width:100%;overflow:auto;height:500px;">
                    <table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="5%">S.No.</td>
                        <td class="gredBg" width="5%">GRN No</td>
                        <td class="gredBg" width="10%">GRN Date</td>
                        <td class="gredBg" width="5%">PO No</td>
                        <td class="gredBg" width="10%">Ind. No</td>
                        <td class="gredBg" width="20%">Supplier Name</td>
                        <td class="gredBg" width="33%">Item Name</td>
                        <td class="gredBg" width="33%">Department Name</td>
                        <td class="gredBg" width="33%">Machine Name</td>
						<td class="gredBg">Finacial Year</td>
                        <td width="4%" class="gredBg">View</td>
                        <td width="4%" class="gredBg">Edit</td>
                        <td width="4%" class="gredBg">Delete</td>
                      </tr>
					  <? if(mysql_num_rows($result)>0){
							$sno = 1;
							while($row=mysql_fetch_array($result)){
								$sql_idate="select * from ms_GRN_master where insert_date='".date('Y-m-d')."' and GRN_id='".$row['GRN_id']."'";
								$res_idate=mysql_query($sql_idate);	
								$row_idate=mysql_fetch_array($res_idate);
								$insert_date=$row_idate['insert_date']; ?>
                            <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                              <td align="center"><?=$sno?></td>
                              <td align="center"><?=$row['GRN_number']?></td>
                              <td align="center"><?=getDateFormate($row['GRN_date'])?></td>
                              <td align="center"><?=$row['order_id']?></td>
                              <td align="center"><?=$row['indent_id']?></td>
                              <td align="left" style="padding-left:5px">
                              <? $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
                                $res_S = mysql_query($sql_S) or die(mysql_error());
                                $row_S = mysql_fetch_array($res_S);
                                echo $row_S['name']; ?>
                               </td>
                               <td align="left" style="padding-left:5px">
                              <? $sql_I= "select * from ms_item_master where item_id='".$row['item_id']."' ";
                                $res_I = mysql_query($sql_I) or die(mysql_error());
                                $row_I = mysql_fetch_array($res_I);
                                echo $row_I['name'].';Drg No. '.$row_I['drawing_number'].';Cat No. '.$row_I['catelog_number']; ?>
                               </td>
                               <td align="left" style="padding-left:5px">
							   <? $sql_dep = "select d.name from ms_department as d, ms_item_master as i where i.department_id = d.department_id and i.item_id = '".$row['item_id']."'";
							   $result_dep = mysql_query($sql_dep) or die(mysql_error());
							   $row_dep = mysql_fetch_array($result_dep);
							   echo $row_dep['name']; ?>
                               </td>
                               <td align="left" style="padding-left:5px">
                               <? $sql_mac = "select m.name from ms_machinary as m, ms_item_master as i where i.machinary_id = m.machinary_id and i.item_id = '".$row['item_id']."'";
							   $result_mac = mysql_query($sql_mac) or die(mysql_error());
							   $row_mac = mysql_fetch_array($result_mac);
							   echo $row_mac['name']; ?>
							   </td>
							   <td align="center"><?= $row['finYear']?></td>
                               <td align="center">
                                 <a href="store_view_GRN.php?GRN_id=<?=$row["GRN_id"]?>">
                                  <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                                 </a>
                               </td>
							 <? if(1){//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
                                  <td align="center">
                                    <a href="store_add_GRN.php?GRN_id=<?=$row["GRN_id"]?>&mode=edit">
                                      <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" /></a>
                                  </td>
                                  <td align="center">
                                    <a href="javascript:;" onClick="overlay(<?=$row['GRN_transaction_id']?>,'<?=$row['type_GRN']?>')">
                                      <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                                    </a>
                                  </td>
						  <? }else{ ?>
                                 <td></td>
                                 <td></td>   
						<? } //$count++; ?> 
                           </tr>
					   <? $sno++;
                     }	
                  }else{ ?>
                          <tr><td align="center" colspan="12"><b>No Record Found.</b></td></tr>
					<? } ?>  
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
      <input type="hidden" name="type_GRN" id="type_GRN" value="" />
      <input type="submit" class="submit" name="btn_delete" id="btn_delete" value="Yes" />
      <input type="button" class="submit" onClick="overlay();" name="btn_close" id="btn_close" value="No" />
		</form>
	</div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>     
<? include("inc/hr_footer.php"); ?>