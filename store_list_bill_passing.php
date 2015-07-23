<? include("inc/store_header.php"); ?>
<script>
function overlay(id) {
  el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";	
}
function checkData() {
  bd = document.getElementById("billDate").value;
	itemid = document.getElementById("item_id").value;
	supplierid = document.getElementById("supplier_id").value;
	//grnNo= document.getElementById("grnNo").value;
	if(bd!=''){
		document.getElementById('byControl').value='billDate';
	}
	if(grnNo!=''){
		document.getElementById('byControl').value='grnNo';
	}
	if(bd=='' && itemid=='' && supplierid=='' && grnNo=='' ){
		alert("Select Date Or Supplier Or Item Or GRN No.");
		return false;
	}
	else
		return true;
}
function blankfields(Control) {
  //var val = document.getElementById(Control).value;
	if(Control=='billDate'){
		document.getElementById('item_id').selectedIndex =0;
		document.getElementById('supplier_id').selectedIndex =0;
		//alert(document.getElementById(Control).value)
		
	}else if(Control=='supplier_id'){
		document.getElementById('item_id').selectedIndex =0;
		document.getElementById('billDate').value='';
		document.getElementById('byControl').value='supplier_id';
	}else if(Control=='item_id'){
		document.getElementById('supplier_id').selectedIndex =0;
		document.getElementById('billDate').value='';
		document.getElementById('byControl').value='item_id';
	}else if(Control=='grnNo'){
		document.getElementById('supplier_id').selectedIndex =0;
		document.getElementById('billDate').value='';
		document.getElementById('byControl').value='grnNo';
	}
	
}
</script>
<? $Page = "store_list_bill_passing.php";
$PageTitle = "List Bill Passing";
$PageFor = "Bill Passing";
$PageKey = "bill_pass_id";
$PageKeyValue = "";
$Message = "";
$billDate="";
$byControl='';
$byControlValue='';
$sql="";
if(isset($_GET["Message"])){
	$Message = $_GET["Message"];
}
if(isset($_POST["btn_del"])){
	$PageKeyValue  = $_POST["hidden_overlay"];
	$sql = "delete from ms_bill_pass_master_new where $PageKey = '".$PageKeyValue."'";
	mysql_query($sql);
}
$whreclosegrnNo = "";
$whreclosegrnNo1 = "";
if(isset($_POST['btn_ok'])){
#echo '<pre>';print_r($_POST);echo '</pre>';
	if ($_POST["grnNo"]!=""){
		$whreclosegrnNo = "and ms_bill_pass_master_new.GRN_id='".$_POST["grnNo"]."'";
		$whreclosegrnNo1 = " GRN_id='".$_POST["grnNo"]."'";
	}
	if($_POST['billDate']!=''){
		$billDate=getDateFormate($_POST['billDate']);
		$sql="select * from ms_bill_pass_master_new where bill_pass_date='".$billDate."' ".$whreclosegrnNo."  order by bill_pass_date asc";
	}
	if($_POST['grnNo']!=''){
		$byControlValue=$_POST['grnNo'];
		$grnNo=$_POST['grnNo'];
		$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master where ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id ".$whreclosegrnNo."   order by ms_bill_pass_master_new.bill_pass_date asc";
	}
	if($_POST['supplier_id']!=''){
		$byControlValue=$_POST['supplier_id'];
		$supplier_id=$_POST['supplier_id'];
		$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master where ms_GRN_master.supplier_id='".$supplier_id."' ".$whreclosegrnNo."  and ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id order by ms_bill_pass_master_new.bill_pass_date asc";
	}
	if($_POST['item_id']!=''){
		$byControlValue=$_POST['item_id'];
		$item_id=$_POST['item_id'];
		$sql="select ms_bill_pass_master_new.* from ms_bill_pass_master_new,ms_GRN_master,ms_GRN_transaction where ms_GRN_transaction.item_id='".$item_id."' ".$whreclosegrnNo."  and ms_bill_pass_master_new.GRN_id=ms_GRN_master.GRN_id and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id order by ms_bill_pass_master_new.bill_pass_date asc";
	}
}
else
$sql="select * from ms_bill_pass_master_new ".$whreclosegrnNo1."  order by bill_pass_date asc";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; List Bill Passing
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
              	<td>
                	<form method="post" action="" onsubmit="return checkData();">
                  	<table width="80%" align="center" border="1" cellspacing="2" cellpadding="2" class="table1 text_1">
                      <tr>
                        <td align="center" colspan="6"><b>Search Items</b></td>
                      </tr>
                      <tr>
                        <td align="left"><b>Bill Date</b></td>
                        <td align="left">
                        	<input type="text" name="billDate" id="billDate" readonly="readonly"/>
                          <a hidefocus="" onclick="blankfields('billDate');gfPop.fPopCalendar(document.getElementById('billDate'));return false;" href="javascript:void(0)">
                          	<img height="22" border="0" align="absbottom" width="34" alt="" src="./calendar/calbtn.gif" name="popcal">
                          </a>
                        </td>
                        <td align="left"><b>Item</b></td>
                        <td align="left">
                      	  <select name="item_id" id="item_id" style="width:50px; font-size:10px;" onchange="blankfields('item_id')">
                          <option value=""></option>
<?  $sql_I= 'select * from ms_item_master order by name asc';
$res_I = mysql_query ($sql_I) or die (mysql_error());
if(mysql_num_rows($res_I)>0){
	while($row_I = mysql_fetch_array($res_I)){ ?>
<option value="<?= $row_I['item_id']?>"><?= $row_I['name'].' | Drg No. '.$row_I['drawing_number'].'  | Cat. No.'.$row_I['catelog_number']?></option>
<?  }
} ?>
                          </select>
                      	</td>
                        <td align="left"><strong>GRn No.</strong></td><td align="left"><input name="grnNo" type="text" id="grnNo" value="" size="10" maxlength="5" /></td>
                        
                       </tr>
                       <tr>
                       <tr>
                          <td align="left"><b>Supplier</b></td>
                          <td align="left">
                            <select name="supplier_id" id="supplier_id" style="width:250px;" onchange="blankfields('supplier_id')">
                              <option value=""></option>
<? $sql_sup= "select * from ms_supplier order by name asc";
	$res_sup = mysql_query ($sql_sup) or die (mysql_error());
	if(mysql_num_rows($res_sup)>0){
		while($row_sup = mysql_fetch_array($res_sup)){ ?>
			<option value="<?= $row_sup['supplier_id']?>"><?= $row_sup['name']?></option>
<?		}
	}?>
                            </select>
                          </td>
                        	<td colspan="2" align="center">
                          	<input type="hidden" name="byControl" id="byControl"  />
                          	<input type="submit" name="btn_ok" id="btn_ok" value="Ok"/>
                          </td>
						<td colspan="2" align="center">
                        	<a href="#" onclick="test.submit();" ><img src="images/print_25.png"  /></a>
<!--<input type="button" name="btn_reset" id="btn_reset" value="Reset" onclick="location.href='store_list_bill_passing.php';"/>-->
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            	<tr>
                <td align="center" class="border" valign="top">
                  <div id="div_message" style="color:#399;font-size:16px;font-weight:bold;"><?=$Message?></div>
<? if(isset($_POST['btn_ok'])){ ?>
    <div class="AddMore" style="padding-top:10px">
<form action="store_print_bill_passing_By_Date.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="grnNo" value="<?=$_POST["grnNo"]?>" />
    <input type="hidden" name="billDate" value="<?=$_POST['billDate']?>">
    <input type="hidden" name="supplier_id" value="<?=$_POST['supplier_id']?>">
    <input type="hidden" name="item_id" value="<?=$_POST['item_id']?>">
</form>
    </div>
<? } ?>
                  <table align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td class="gredBg" width="5%">S.No.</td>
                      <td class="gredBg" width="5%">Bill No.</td>
                      <td class="gredBg" width="7%">Bill Date</td>
                      <td class="gredBg" width="5%">GRN No.</td>
                      <td class="gredBg" width="7%">GRN Date</td>
                      <td class="gredBg" width="5%">Inv. No.</td>
                      <td class="gredBg" width="7%">Inv. Date</td>
                      <td class="gredBg" width="16%">Supplier</td>
                      <td class="gredBg" width="16%">ItemName</td>
                      <td class="gredBg" width="5%">ItemQty</td>
                      <td class="gredBg" width="5%">NetRate</td>
                      <td class="gredBg" width="5%">Total Amt.</td>
                      <td class="gredBg" width="4%">View</td>
                      <td class="gredBg" width="4%">Edit</td>
                      <td class="gredBg" width="4%">Delete</td>
                    </tr>
<? if(mysql_num_rows($result)>0){
		$sno = 1;$totalQty=0;$totalNetRate=0;$totalValue=0;
		while($row=mysql_fetch_array($result)){
			$sql_idate="select * from ms_bill_pass_master_new where insert_date='".date('Y-m-d')."' and bill_pass_id='".$row['bill_pass_id']."'";
			$res_idate=mysql_query($sql_idate);	
			$row_idate=mysql_fetch_array($res_idate);
			$insert_date=$row_idate['insert_date']; ?>
                      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                        <td align="center"><?=$sno?></td>
                        <td align="center"><?=$row['bill_pass_id']?></td>
                        <td align="center"><?=getDateFormate($row['bill_pass_date'])?></td>
                        <td align="center"><?=$row['GRN_id']?></td>
                        <td align="center">
<? $sql_gd="select GRN_date from ms_GRN_master where GRN_id = '".$row['GRN_id']."' ";
$result_gd = mysql_query($sql_gd) or die (mysql_error());
$row_gd = mysql_fetch_array($result_gd);
echo getDateFormate($row_gd['GRN_date']); ?>
                        </td>
                        <td align="center">
<? $sql_Inv="select inv_number,inv_date from ms_GRN_master where ms_GRN_master.GRN_id='".$row['GRN_id']."'";
$result_Inv = mysql_query($sql_Inv) or die (mysql_error());;
$row_Inv = mysql_fetch_array($result_Inv);
echo $row_Inv['inv_number']; ?>
                        </td>
                        <td align="center"><?=getDateFormate($row_Inv['inv_date']);?>
                        </td>
                        <td align="left" style="padding-left:2px">
<? $sql_S="select name from ms_supplier,ms_GRN_master where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_supplier.supplier_id=ms_GRN_master.supplier_id";
$result_S = mysql_query($sql_S) or die (mysql_error());;
$row_S = mysql_fetch_array($result_S);
echo $row_S['name']; ?>
                        </td>
                        <td align="left" style="padding-left:2px">
<? $sql_I="select name,CONCAT(name,';Drg No. ',drawing_number,';Cat No. ',catelog_number) as ItemDescription from ms_item_master,ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id";
$result_I = mysql_query($sql_I) or die (mysql_error());;
$row_I = mysql_fetch_array($result_I);
echo $row_I['ItemDescription']; ?>
                        </td>
                        <td align="right" style="padding-right:2px">
<? $sql_G="select rec_qty,net_rate from ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id='".$row['GRN_id']."' and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id";
$result_G = mysql_query($sql_G) or die (mysql_error());
$row_G = mysql_fetch_array($result_G);
echo number_format($row_G['rec_qty'],2,'.','');
$totalQty+=number_format($row_G['rec_qty'],2,'.','');
$totalNetRate+=number_format($row_G['net_rate'],2,'.',''); ?>
                        </td>
                        <td align="right" style="padding-right:2px"><?=number_format($row_G['net_rate'],2,'.','');?></td>
                        <td align="right" style="padding-right:2px">
<? $sql_na="select total_amount from ms_GRN_master where GRN_id='".$row['GRN_id']."'";
$result_na = mysql_query($sql_na) or die (mysql_error());;
$row_na = mysql_fetch_array($result_na);
echo number_format($row_na['total_amount'],2,'.','');
$totalValue+=number_format($row_na['total_amount'],2,'.',''); ?>
                        </td>
                        <td align="center">
                          <a href="store_view_bill_passing.php?bill_pass_id=<?=$row["bill_pass_id"]?>">
                          <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
                        </td>
                        <? if(1){ //$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date) ?>
                        <td align="center">
                          <a href="store_add_bill_passing.php?bill_pass_id=<?=$row["bill_pass_id"]?>&mode=edit">
                          <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" /></a>
                        </td>
                        <td align="center">
                          <a href="javascript:;" onClick="overlay(<?=$row["bill_pass_id"]?>);">
                          <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0"></a>
                        </td>
                        <? }else{ ?>
                        	<td></td>
													<td></td>   
                        <? } ?>
                      </tr>
                      <? $sno++;
                      }	?>
                      	<tr>
                        	<td align="right" colspan="9" style="padding-right:10px"><b>Total : </b></td>
                          <td align="right" style="padding-right:2px"><?=number_format($totalQty,2,'.','')?></td>
                          <td align="right" style="padding-right:2px"><?=number_format($totalNetRate,2,'.','')?></td>
                          <td align="right" style="padding-right:2px"><?=number_format($totalValue,2,'.','')?></td>
                          <td align="center" colspan="3">&nbsp;</td>
                        </tr>
                      <? }else{ ?>
                      <tr><td align="center" colspan="15"><b>No Record Found.</b></td></tr>
                      <? } ?>  
                 	</table>      
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
<iframe scrolling="no" height="172" frameborder="0" width="168" style="border: 2px ridge; visibility: hidden; z-index: 999; position: absolute; left: 502px; top: 216px;" src="calendar/ipopeng.htm" id="gToday:normal:agenda.js" name="gToday:normal:agenda.js">
</iframe>
<? include("inc/hr_footer.php"); ?>