<? include("inc/store_header.php"); ?>
<script type="text/javascript" src="ajax/common_function.js"></script>
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
function getMachinaryData() {
	var deptId = document.getElementById("department_id").value;
	document.getElementById("div_machinary").style.border="none";
	document.getElementById("div_machinary").style.padding="0";	
	get_frm("store_get_machinary.php",deptId,"div_machinary",'');
}
function getSubItemHeadData() {
	var deptId = document.getElementById("item_head_id").value;
	document.getElementById("div_sub_item").style.border="none";
	document.getElementById("div_sub_item").style.padding="0";	
	get_frm("store_get_sub_itemhead.php",deptId,"div_sub_item",'');
}
function addElement() {
	var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  if(num%2!==0)
		tableColor="#FFFFFF";
	else
		tableColor="";
	var myTable = "<table align='center' width='100%' cellpadding='3' cellspacing='2' class='border' border='0'>";
	myTable +="<tr bgcolor="+tableColor+" class='table_head border'><td align='center' style='font-weight:bold;' width='10%'>S.No.</td><td align='center' style='font-weight:bold;' width='20%'>Supplier</td><td align='center' style='font-weight:bold;' width='10%'>Rate</td><td align='center' style='font-weight:bold;' width='20%'>Quot. No.</td><td align='center' style='font-weight:bold;' width='20%'>Quot. Date</td><td align='center' width='5%'>&nbsp;</td></tr>";
	myTable +="<input type='hidden' name='item_transaction_id[]' id='item_transaction_id[]' value=''/>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><input name='sno[]' type='text'  value="+(num)+" readonly='readonly' style='height:20px;width:50px;' /></td>";
	myTable += "<td align='center'><select name='supplier_id[]' id='supplier_id[]' style='width:160px;height:20px;'><option value='0'></option><option value=''></option></select></td>";
	myTable += "<td align='center'><input type='text' name='rate[]' id='rate[]' style='height:20px;'/></td>";
	myTable += "<td align='center'><input type='text' name='quotation_number[]' id='quotation_number[]' style='height:20px;'/></td>";
	myTable += "<td align='center'><input type='text' name='quotation_date[]' id='quotation_date_"+num+"' style='height:20px;' /><a href=\"javascript:;\" onClick=gfPop.fPopCalendar(document.frm_additem.quotation_date_"+num+");return false;' HIDEFOCUS><img name='popcal' align='absbottom' src='./calendar/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>";
	myTable += "<td class='delete' align='center'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></a></td>";                                       
	myTable += "</tr></table>";
	newdiv.innerHTML=myTable;
	ni.appendChild(newdiv);
}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<?
$Page = "store_add_item.php";
$PageTitle = "Add Item";
$PageFor = "Item";
$PageKey = "item_code";
$PageKeyValue = "";
$Message = "";
$item_id = '';$item_code= '';$code='';
$name = '';$sub_title = '';$specification = '';
$item_head_id = '';$sub_item_head_id = '';
$department_id = '';$machinary_id = '';$drawing_number = '';$catelog_number = '';
$uom_id = '';$store_packing = '';
$reorder_application = '';$reorder_level = '';$location = '';$maximum_quantity = '';$minimum_quantity = '';$unit_rate = '';
$opening_quantity = '';$opening_rate = '';$opening_value = '';
$cancel_quantity = '';$rec_qty = '';
$machinary_name = '';$supplier_id = '';$rate = '';$quotation_number = '';$quotation_date = '';


$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_item_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$item_id= $row["item_id"];
		$PageKeyValue = $row[$PageKey];
		$code = $row["code"];
		$name = $row["name"];
		$sub_title = $row["sub_title"];
		$specification = $row["specification"];
		$item_head_id = $row["item_head_id"];
		$sub_item_head_id = $row["sub_item_head_id"];
		$department_id = $row["department_id"];
		$machinary_id = $row["machinary_id"];
		$drawing_number = $row["drawing_number"];
		$catelog_number = $row["catelog_number"];
		$uom_id = $row["uom_id"];
		$store_packing = $row["store_packing"];	
		$reorder_application = $row["reorder_application"];
		$reorder_level = $row["reorder_level"];
		$location = $row["location"];	
		$maximum_quantity = $row["maximum_quantity"];
		$minimum_quantity = $row["minimum_quantity"];
		$unit_rate = $row["unit_rate"];
		$opening_quantity = $row["opening_quantity"];	$opening_rate = $row["opening_rate"];
		$opening_value = $row["opening_value"];
		$cancel_quantity = $row["cancel_quantity"];
		$rec_qty = $row["rec_qty"];	
				
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql="select max(item_code) as item_code from ms_item_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$PageKeyValue=($row['item_code']+1);
	
	$sql="select max(item_id) as item_id from ms_item_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$item_id=($row['item_id']+1);
}
if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from ms_item_transaction where item_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Item Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$code = $_POST["code"];
	$name = $_POST['name'];
	$sub_title = $_POST['sub_title'];
	$specification = $_POST['specification'];
	$item_head_id = $_POST['item_head_id'];$sub_item_head_id = $_POST["sub_item_head_id"];
	$uom_id = $_POST['uom_id'];
	if($_POST['department_id']!=0)
	{
		$department_id = $_POST['department_id'];
		$machinary_id = $_POST['machinary_id'];
	}
	else
	{
		$department_id = '';
		$machinary_id = '' ;
	}
	$drawing_number = $_POST['drawing_number'];
	$catelog_number = $_POST['catelog_number'];
	$store_packing = $_POST['store_packing'];
	$reorder_application = $_POST['reorder_application'];
	$reorder_level = $_POST['reorder_level'];
	$location = $_POST['location'];
	$maximum_quantity = $_POST['maximum_quantity'];
	$minimum_quantity = $_POST['minimum_quantity'];
	$unit_rate = $_POST['unit_rate'];
	$opening_quantity = $_POST["opening_quantity"];	$opening_rate = $_POST["opening_rate"];$opening_value = $_POST['opening_value'];
	$cancel_quantity = $_POST["cancel_quantity"];$rec_qty = $_POST["rec_qty"];	
	
	if($PageKeyValue == "")
	{
		$tableName="ms_item_master";
		
		$tableData=array("''","'$item_code'","'$code'","'$name'","'$sub_title'","'$specification'","'$item_head_id'","'$sub_item_head_id'","'$department_id'","'$machinary_id'","'$drawing_number'","'$catelog_number'","'$uom_id'","'$store_packing'","'$reorder_application'","'$reorder_level'","'$location'","'$maximum_quantity'","'$minimum_quantity'","'$unit_rate'","'$opening_quantity'","'$opening_rate'","'$opening_value'","'$cancel_quantity'","''","'$rec_qty'","''","''","now()");
		addDataIntoTable($tableName,$tableData);
		$insert_id = mysql_insert_id();
				
		if(isset($_POST['supplier_id'])){$count=count($_POST['supplier_id']);}
		
		for($i=0; $i<$count; $i++)
		{
				$supplier_id=$_POST['supplier_id'][$i];	
				$rate=$_POST['rate'][$i];
				$quotation_number=$_POST['quotation_number'][$i];
				$quotation_date=getDateFormate($_POST['quotation_date'][$i]);
				
				$tableName="ms_item_transaction";
				$tableData=array("''","'$insert_id'","'$supplier_id'","'$rate'","'$quotation_number'","'$quotation_date'","now()");
				addDataIntoTable($tableName,$tableData);
				$Message = "$PageFor Inserted";
		}	
		$Message = "$PageFor Inserted";
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="ms_item_master";
			$tableColumns=array("item_code","code","name","sub_title","specification","item_head_id","sub_item_head_id","department_id","machinary_id","drawing_number","catelog_number","uom_id","store_packing","reorder_application","reorder_level","location","maximum_quantity","minimum_quantity","unit_rate","opening_quantity","opening_rate","opening_value","cancel_quantity","rec_qty");
			
			$tableData=array("'$PageKeyValue'","'$code'","'$name'","'$sub_title'","'$specification'","'$item_head_id'","'$sub_item_head_id'","'$department_id'","'$machinary_id'","'$drawing_number'","'$catelog_number'","'$uom_id'","'$store_packing'","'$reorder_application'","'$reorder_level'","'$location'","'$maximum_quantity'","'$minimum_quantity'","'$unit_rate'","'$opening_quantity'","'$opening_rate'","'$opening_value'","'$cancel_quantity'","'$rec_qty'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			//if(isset($_POST['supplier_id'])){$count=count($_POST['supplier_id']);}
		
			for($i=0; $i<sizeof($_POST['supplier_id']); $i++)
			{
					$item_transaction_id=$_POST['item_transaction_id'][$i];	
					$supplier_id=$_POST['supplier_id'][$i];
					$rate=$_POST['rate'][$i];
					$quotation_number=$_POST['quotation_number'][$i];
					$quotation_date=getDateFormate($_POST['quotation_date'][$i]);
					
					if($item_transaction_id=="")
					{
						$tableName="ms_item_transaction";
						$tableData=array("''","'$PageKeyValue'","'$supplier_id'","'$rate'","'$quotation_number'","'$quotation_date'","now()");
						addDataIntoTable($tableName,$tableData);
					}
					else
					{
						$tableName="ms_item_transaction";
						$tableColumns=array("item_transaction_id","item_id","supplier_id","rate","quotation_number","quotation_date");
						$tableData=array("'$item_transaction_id'","'$PageKeyValue'","'$supplier_id'","'$rate'","'$quotation_number'","'$quotation_date'");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
					}
					$Message = "$PageFor Updated";
			}	
			$Message = "$PageFor Updated";
			//redirect("store_list_item.php");
		}
	}
}
?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}



?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/production_snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;"  valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Seller Master</td>
                </tr>
                <tr>
                	<td valign="top" style="border-top:5px solid #FFFFFF;">
                        <table width="95%" cellpadding="0" cellspacing="0" align="center" border="0">
                            <tr>
                                <td align="left" valign="top"><img src="images/white1.gif" /></td>
                                <td class="white2"></td>
                                <td align="right" valign="top"><img src="images/white3.gif" /></td>
                            </tr>
                            <tr>
                                <td class="white4"></td>
                                <td>
                                    <table align="center" width="100%" cellpadding="3" cellspacing="1" border="0">
                                        <tr>
                                            <td valign="top">
                                                <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
                                                    <tr>
                                                        <td class="form_txt border" width="25%" valign="top">Company Name</td>
                                                        <td align="left" class="border" width="25%" valign="top"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border" valign="top" width="25%">Company Address</td>
                                                        <td align="left" class="border" width="25%"><textarea cols="20" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form_txt border">City</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border">State</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="form_txt border">PIN</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border">Country</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                    </tr> 
                                                     <tr>
                                                        <td class="form_txt border">Contact No.</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border">Fax</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form_txt border">Email</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border">Website</td>
                                                        <td align="left" class="border"><input type="text" style="height:20px; width:170px;" /></td>
                                                    </tr> 
                                                    <tr>
                                                    	<td height="10px" colspan="4">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form_txt border">Manufacturer</td>
                                                        <td class="form_txt border" colspan="3" align="left"><div style="text-align:left;">Choose from list&nbsp;
                                                        	<select name='supplier_id' id='supplier_id' style='width:170px; height:20px;'>
                                                                <option value="" selected="selected">1</option>
                                                                <option value='0'>2</option>
                                                            </select>&nbsp;
                                                            Or type here &nbsp;
                                                            <input type="text" style="height:20px; width:170px;" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form_txt border" valign="top">Product Name</td>
                                                        <td class="border" valign="top"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border" valign="top">Product Details</td>
                                                        <td class="border"><textarea cols="20" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="form_txt border" valign="top">Quantity</td>
                                                        <td class="border" valign="top"><input type="text" style="height:20px; width:170px;" /></td>
                                                        <td class="form_txt border" valign="top">Description</td>
                                                        <td class="border"><textarea cols="20" rows="2"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" colspan="4">
                                                            <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn_bg" />
                                                        </td>
                                                    </tr>
                                               </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="white5"></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top"><img src="images/white6.gif" /></td>
                                <td class="white7"></td>
                                <td align="right" valign="top"><img src="images/white8.gif" /></td>
                            </tr>
                        </table>
                    </td>
				</tr>
                <tr>
                	<td valign="top" style="border-top:5px solid #FFFFFF;">
                        <table width="95%" cellpadding="0" cellspacing="0" align="center" border="0">
                            <tr>
                                <td align="left" valign="top"><img src="images/white1.gif" /></td>
                                <td class="white2"></td>
                                <td align="right" valign="top"><img src="images/white3.gif" /></td>
                            </tr>
                            <tr>
                                <td class="white4"></td>
                                <td>
                                    <table align="center" width="100%" cellpadding="3" cellspacing="2" border="0">
                                        <tr>
                                            <td class="table_head border" width="10%" valign="top">S.No.</td>
                                            <td class="table_head border" width="20%" valign="top">Seller</td>
                                            <td class="table_head border" valign="top" width="10%">Rate</td>
                                            <td class="table_head border" valign="top" width="20%">Quote No.</td>
                                            <td class="table_head border" valign="top" width="20%">Quote Date</td>
                                            <td class="table_head border" valign="top" width="5%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="table_row1 border" valign="top" align="center">
                                            	<input type="text" name="" id="" readonly="readonly" value="" style="height:20px; width:50px;"/>
                                            </td>
                                            <td class="table_row1 border" valign="top" align="center">
                                            	<select id="seller" name="seller" style=" height:20px;width:160px" >
                                                    <option value="" selected="selected">Seller 1</option>
                                                    <option value="0">Seller 2</option>
                                                    <option value="0">Seller 2</option>
                                                </select>
                                            </td>
                                            <td class="table_row1 border" valign="top" align="center">
                                            	<input type="text" name="rate" id="rate" value="" style="height:20px;"/>
                                            </td>
                                            <td class="table_row1 border" valign="top" align="center">
                                            	<input type="text" name="quotation_num" id="quotation_num" value="" style="height:20px;" />
                                            </td>
                                            <td class="table_row1 border" valign="top" align="center">
                                            	<input type="text" name="quotation_date" id="quotation_date" value="" style="height:20px;"/>
                                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_additem.quotation_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                </a> 
                                            </td>
                                            <td class="table_row1 border" align="center">
                                              	<input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                              	<a href="javascript:;" onClick="addElement();" title="Add More Rows">
                                              	<img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" align="center">
                                            	<div id="myDiv1"></div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="white5"></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top"><img src="images/white6.gif" /></td>
                                <td class="white7"></td>
                                <td align="right" valign="top"><img src="images/white8.gif" /></td>
                            </tr>
                        </table>
                    </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? include("inc/hr_footer.php"); ?>
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                	
                               