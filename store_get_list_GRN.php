<? include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");
set_time_limit(0);
$GRN_id = '';
$supplier_id = '';
$GRNDate = '';
$GRNDateTo = '';
$item_id = '';
$mac_id = '';
$dep_id = '';
if(isset($_GET)){
	$GRN_id = $_GET['GRN_id'];
	$supplier_id = $_GET['supplier_id'];
	$GRNDate = $_GET['GRNDate'];
	$GRNDateTo = $_GET['GRNDateTo'];
	$item_id = $_GET['item_id'];
	$mac_id = $_GET['mac_id'];
	$dep_id = $_GET['dep_id'];
}
/*if(isset($_REQUEST['value'])){
	$val=$_REQUEST['value'];
}else{	$val='';	}
if(isset($_REQUEST['value1'])){
	$val_1=$_REQUEST['value1'];
}else{	$val_1='';	}*/
$where_condition = "where mrgm.GRN_id = mrgt.GRN_id";
if($GRN_id != ''){
	$where_condition .= " and mrgm.GRN_id = '".$GRN_id."'";
	#$sql="select mrgm.GRN_id,mrgm.type_GRN,mrgm.indent_id,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgm.GRN_id=$val order by mrgm.GRN_id asc";
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
	}
	$machineries = implode(',', $machinery) ;
	$where_condition .= " and mrgt.item_id in($machineries)";
}
if($dep_id != ''){
	$sql_dep = "SELECT `item_id` FROM `ms_item_master` WHERE `department_id` = '".$dep_id."'";
	$res_dep = mysql_query ($sql_dep) or die (mysql_error());
	if(mysql_num_rows($res_dep)>0){
		while($row_dep = mysql_fetch_array($res_dep)){
			$department[] = $row_dep['item_id'];
		}
	}
	$departments = implode(',', $department);
	$where_condition .= " and mrgt.item_id in($departments)";
}
/*if(($_REQUEST['byControl'])=='GRNDate'){
	$val = getDateFormate($val);
	$val_1 = getDateFormate($val_1);
	$sql="select mrgm.GRN_id, mrgm.type_GRN, mrgm.indent_id,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id = mrgt.GRN_id and mrgm.GRN_date between '".$val."' and '".$val_1."' order by mrgm.GRN_id asc";
}
else if(($_REQUEST['byControl'])=='Supplier'){
	$sql="select mrgm.GRN_id,mrgm.type_GRN,mrgm.indent_id,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgm.supplier_id=$val order by mrgm.GRN_id asc";
}
else if(($_REQUEST['byControl'])=='ItemName'){
	$sql="select mrgm.GRN_id,mrgm.type_GRN,mrgm.indent_id,mrgm.GRN_date,mrgm.supplier_id,mrgt.item_id,mrgt.GRN_transaction_id,mrgm.order_id from ms_GRN_master mrgm,ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgt.item_id = '".$val."' order by mrgm.GRN_id asc";
}
//Update report by Gaurav Sharma
else if(($_REQUEST['byControl'])=='DepName'){
	$sql_dep = "SELECT `item_id` FROM `ms_item_master` WHERE `department_id` = '".$_REQUEST['value']."'";
	$res_dep = mysql_query ($sql_dep) or die (mysql_error());
	if(mysql_num_rows($res_dep)>0){
		while($row_dep = mysql_fetch_array($res_dep)){
			$department[] = $row_dep['item_id'];
		}
	}
	$departments = implode(',', $department);
	$sql="select mrgm.GRN_id, mrgm.type_GRN, mrgm.indent_id, mrgm.GRN_date, mrgm.supplier_id, mrgt.item_id, mrgt.GRN_transaction_id, mrgm.order_id from ms_GRN_master mrgm, ms_GRN_transaction mrgt ".$where_condition." order by mrgm.GRN_id asc";
}
else if(($_REQUEST['byControl'])=='MacName'){
	$sql_mac = "SELECT `item_id` FROM `ms_item_master` WHERE `machinary_id` = '".$_REQUEST['value']."'";
	$res_mac = mysql_query ($sql_mac) or die (mysql_error());
	if(mysql_num_rows($res_mac)>0){
		while($row_mac = mysql_fetch_array($res_mac)){
			$machinery[] = $row_mac['item_id'];
		}
	}
	$machineries = implode(',', $machinery) ;
	$sql="select mrgm.GRN_id, mrgm.type_GRN, mrgm.indent_id, mrgm.GRN_date, mrgm.supplier_id, mrgt.item_id, mrgt.GRN_transaction_id, mrgm.order_id from ms_GRN_master mrgm, ms_GRN_transaction mrgt where mrgm.GRN_id=mrgt.GRN_id and mrgt.item_id in($machineries) order by mrgm.GRN_id asc";
}
*///Update report by Gaurav Sharma
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$sql = "select mrgm.GRN_id, mrgm.type_GRN, mrgm.indent_id, mrgm.GRN_date, mrgm.supplier_id, mrgt.item_id, mrgt.GRN_transaction_id, mrgm.order_id from ms_GRN_master mrgm, ms_GRN_transaction mrgt ".$where_condition." order by mrgm.GRN_id asc";
$result=mysql_query($sql);
/*if(($_REQUEST['byControl'])=='GRNDate'){
?>
<div style="float:right;padding-right:25px;">
 <a href="store_print_GRN_By_Date.php?GRN_date=<?=$val?>" target="_blank" class="AddMore"><b>Print</b></a>
</div>
<?
}
if(($_REQUEST['byControl']=='Supplier') || ($_REQUEST['byControl']=='ItemName')){
?>
	<div class="AddMore" style="padding-top:10px">
  	<form action="store_print_GRN_By_Supplier_and_Item.php" name="test" id="test" method="post" target="_blank"> 
    	<input type="hidden" name="value" id="value" value="<?=$_REQUEST['value'] ?>" />
    	<input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>"/>
      	<a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
  	</form>
  </div> 
  
<? }*/ ?>
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
    <td width="4%" class="gredBg">View</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
  </tr>	
  <?  if(mysql_num_rows($result)>0){
  	$sno = 1;
    while($row=mysql_fetch_array($result)){	
	#echo '<pre>';	print_r($row);	echo '<pre>';
      $sql_idate="select * from ms_GRN_master where insert_date='".date('Y-m-d')."' and GRN_id='".$row['GRN_id']."'";
      $res_idate=mysql_query($sql_idate);	
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date']; ?>
        <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
          <td align="center"><?=$sno?></td>
          <td align="center"><?=$row['GRN_id']?></td>
          <td align="center"><?=getDateFormate($row['GRN_date'])?></td>
          <td align="center"><?=$row['order_id']?></td>
          <td align="center"><?=$row['indent_id']?></td>
          <td align="left" style="padding-left:3px">
          <? $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
            $res_S = mysql_query($sql_S) or die(mysql_error());
            $row_S = mysql_fetch_array($res_S);
            echo $row_S['name']; ?>
          </td>
          <td align="left" style="padding-left:3px">
           <? $sql_I= "select * from ms_item_master where item_id='".$row['item_id']."' ";
            $res_I = mysql_query($sql_I) or die(mysql_error());
            $row_I = mysql_fetch_array($res_I);
            echo $row_I['name'].';Drg No. '.$row_I['drawing_number'].';Cat No. '.$row_I['catelog_number']; ?>
          </td>
          <td align="left" style="padding-left:3px">
          	<? $sql_dep = "select d.name from ms_department as d, ms_item_master as i where i.department_id = d.department_id and i.item_id = '".$row['item_id']."'";
				$result_dep = mysql_query($sql_dep) or die(mysql_error());
				$row_dep = mysql_fetch_array($result_dep);
				echo $row_dep['name']; ?>
          </td>
          <td align="left" style="padding-left:3px">
          	<? $sql_mac = "select m.name from ms_machinary as m, ms_item_master as i where i.machinary_id = m.machinary_id and i.item_id = '".$row['item_id']."'";
			$result_mac = mysql_query($sql_mac) or die(mysql_error());
			$row_mac = mysql_fetch_array($result_mac);
			echo $row_mac['name']; ?>
          </td>
          <td align="center">
             <a href="store_view_GRN.php?GRN_id=<?=$row["GRN_id"]?>">
              <img src="images/search-icon.gif" alt="View" title="View" border="0" />
             </a>
          </td>
          <? if(1){//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
              <td align="center">
                <a href="store_add_GRN.php?GRN_id=<?=$row["GRN_id"]?>&mode=edit"><img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" /></a>
              </td>
              <td align="center">
                <a href="javascript:;" onClick="overlay(<?=$row['GRN_transaction_id']?>,'<?=$row['type_GRN']?>');"><img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                </a>
              </td>
            <? }else{ ?>
             <td></td>
             <td></td>   
            <? } ?> 
       </tr>
       <? $sno++;
     }	
  }else{ ?>
      <tr><td align="center" colspan="12"><b>No Record Found.</b></td></tr>
    <? } ?>  
</table>