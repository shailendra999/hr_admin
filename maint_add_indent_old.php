<?
include("inc/maint_header.php");
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
<script>
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
		tableColor="#f8f1ef";
	else
		tableColor="#eedfdc";

	var myTable= "<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable +="<input name='indent_transaction_id[]' id='indent_transaction_id[]' type='hidden' value='' />";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><b>S. No. </b></td>"; 
	myTable += "<td align='center'><b>Item No.</b></td>";
	myTable += "<td align='center'><b>Item Name</b></td>";
	myTable += "<td align='center'><b>UOM</b></td>";
	myTable += "<td align='center'><b>Description</b></td>";
	myTable += "<td align='center'></td>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable +="<td align='center'><input name='sno[]' type='text' value="+num+" style='width:60px;height:18px;' readonly='readonly'/></td>";
	
	myTable +="<td align='center'><input type='text' id='item_no_"+num+"' name='item_id[]' style='height:18px;width:80px;' readonly='readonly'></td>";
  myTable +="<td align='center'><input type='text' name='item_name[]' id='item_name"+num+"' onKeyUp=\"ajax_showOptions(this.value,'"+num+"','store_ajax_list_item.php',event,1)\" onFocus=\"ajax_showOptions(this.value,'"+num+"','store_ajax_list_item.php',event,1)\" autocomplete='off'  class='itemText' value='' style='width:250px;'/><div id='ajax_listOfOptions_"+num+"' class='ajax_listOfOptions'></div></td>";
	
	
	myTable += "<td align='center'><div id='div_item_uom_"+num+"' style='height:18px;width:80px;' class='getAjaxDataInDiv'></div></td>";
	myTable +="<td align='center'><div id='div_item_desc_"+num+"' style='height:18px;width:200px;' class='getAjaxDataInDiv'></div></td>";
	
	myTable += "<td align='center'></td>";
	myTable += "</tr>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><b>Stock</b></td>";
  myTable += "<td align='center'><b>Required Qty</b></td>";
	myTable += "<td align='center'><b>Remarks</b></td>";
	myTable += "<td align='center'><b>Due Date</b></td>";
	myTable += "<td align='center'><b>Purpose</b></td>";
	myTable += "<td align='center'></td>";
	myTable += "</tr>";
	myTable += "<tr class='text_tr' bgcolor="+tableColor+">";
	myTable += "<td align='center'><div id='div_item_stock_"+num+"' style='height:18px;width:80px;' class='getAjaxDataInDiv'></div></td>";
	myTable += "<td align='center'><input name='req_qty[]' type='text' value='' style='width:80px;height:18px;' /></td>";
	
	myTable += "<td align='center'><input name='remark[]' type='text' value='' style='width:200px;height:18px;' /></td>";
	myTable += "<td align='center'><input name='due_date[]' id='due_date_"+num+"' type='text' value='' style='width:80px;height:18px;' /><a href=\"javascript:;\" onClick=gfPop.fPopCalendar(document.frm_add.due_date_"+num+");return false;' HIDEFOCUS><img name='popcal' align='absbottom' src='./calendar/calbtn.gif' width='34' height='22' border='0' alt=''></a></td>";
	myTable += "<td align='center'><input name='purpose[]' type='text' value='' style='width:200px;height:18px;' /></td>";
	myTable += "<td class='delete'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></a></td>";
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
<script type="text/javascript">
	function getItemDetailsForReturn(itemnameId, divItemCode, divItemUom, divItemDesc,divStock,sno)
	{
		var strURL1="store_get_itemcode.php?item_id="+itemnameId;
		var strURL2="store_get_itemuom.php?item_id="+itemnameId;
		var strURL3="store_get_item_description.php?item_id="+itemnameId;
		var strURLStock="store_get_item_stock.php?item_id="+itemnameId+"&sno="+sno;
		var req = getXMLHTTP();
		var req1 = getXMLHTTP();
		var req2 = getXMLHTTP();var reqStock = getXMLHTTP();
		if (req)
		{																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200)                         
										document.getElementById(divItemCode).innerHTML=req.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}                
				}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
		if(req1)
		{
				req1.onreadystatechange = function() {
						if (req1.readyState == 4) {
								if (req1.status == 200)                         
										document.getElementById(divItemUom).innerHTML=req1.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req1.statusText);
						}                
				}            
				req1.open("GET", strURL2, true);
				req1.send(null);
		}
	
		if (req2)
		{
				req2.onreadystatechange = function() {
						if (req2.readyState == 4) {
								if (req2.status == 200)   
										document.getElementById(divItemDesc).innerHTML=req2.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req2.statusText);
						}                
				}            
				req2.open("GET", strURL3, true);
				req2.send(null);
		}    
		if (reqStock)
		{
				reqStock.onreadystatechange = function() {
						if (reqStock.readyState == 4) {
								if (reqStock.status == 200)   
										document.getElementById(divStock).innerHTML=reqStock.responseText;
								 else 
										alert("There was a problem while using XMLHTTP:\n" + reqStock.statusText);
						}                
				}            
				reqStock.open("GET", strURLStock, true);
				reqStock.send(null);
		}      
	}																	

function checkData()
{
	var status=true;
	//alert(no);
	var req_qty=document.getElementsByName("req_qty[]");
	var item_id=document.getElementsByName("item_id[]");
	var len=req_qty.length;
	for(var i=0;i<len;i++)
	{
		//alert('new='+item_id[i].value);
		if((req_qty[i].value =='' || req_qty[i].value =='0') && item_id[i].value!='')
		{
			alert("check All Entries");
			status=false;
			break;
		}
		else
			status=true;
	}
	return status;
}
</script>

<?

$Page = "maint_add_indent.php";
$PageTitle = "Add Indent";$PageFor = "Indent";$PageKey = "indent_id";
$Message = '';$mode = '';

$indent_date = '';
$department_id = '';$approved_by = '';$indent_transaction_id = '';$item_id = '';
$stock = '';$required_quantity = '';$due_date = '';$remark = '';$purpose = '';$cancel_quantity = '';
$PageKeyValue = "";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
	/*$sql_idate="select * from ms_indent_master where insert_date='".date('Y-m-d')."' and indent_id='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='maint_homepage.php';</script>";
	}*/
	//echo $sql="select * from ms_order_master,ms_GRN_master where indent_id='".$_GET[$PageKey]."'";
	$sql="select ms_order_master.order_id,ms_GRN_master.GRN_id,ms_indent_master.indent_id from ms_order_master,ms_GRN_master,ms_indent_master where ms_indent_master.indent_id='".$_GET[$PageKey]."' and (ms_order_master.indent_id='".$_GET[$PageKey]."' or ms_GRN_master.indent_id='".$_GET[$PageKey]."')";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	mysql_num_rows($result);
	if(mysql_num_rows($result)>0)
	{
		echo "<script>alert('You Cant Edit, Purchase Order Or GRN is Made for this Indent.');location.href='maint_list_indent.php';</script>";
	}
}
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_indent_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$indent_id = $row[$PageKey];
		$indent_date = getDateFormate($row["indent_date"]);
		$department_id = $row["department_id"];
		$approved_by = $row["approved_by"];
	}
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	
	$sql="select ms_order_master.order_id,ms_GRN_master.GRN_id,ms_indent_master.indent_id from ms_order_master,ms_GRN_master,ms_indent_master where ms_indent_master.indent_id='".$PageKeyValue."' and (ms_order_master.indent_id='".$PageKeyValue."' or ms_GRN_master.indent_id='".$PageKeyValue."')";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
	{
		$Message="Not Deleted";
		echo "<script>alert('Sorry!PO or GRN is made for this Indent.');location.href='$Page?Message=$Message';</script>";
	}
	else
	{
		$sql = "delete from ms_indent_transaction where indent_transaction_id = '".$PageKeyValueTrans."'";
		mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$Message = "Indent Transaction Row Sucessfully Deleted";
		$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
		redirect("$UrlPage");//redirect("$Page?Message=$Message");
	}
}

if(isset($_POST["btn_submit"]))
{
	if($_POST['indent_date']=='')
		$indent_date =date('Y-m-d');
	else
		$indent_date = getDateFormate($_POST['indent_date']);
		$indent_number = $_POST['indent_id'];
	$department_id = $_POST['department_id'];
	$approved_by = $_POST['approved_by'];

	if($PageKeyValue == "")
	{
		$tableName="ms_indent_master";
		$tableData=array("''","'$indent_number'","'$indent_date'","'$department_id'","'$approved_by'","now()");
		if(addDataIntoTable($tableName,$tableData))
		{
			$insert_id = mysql_insert_id();
			for($i=0; $i<sizeof($_POST['sno']); $i++)
			{
				if($_POST['item_id'][$i]!='' && $_POST['req_qty'][$i]!="")
				{
					$item_id=$_POST['item_id'][$i];	
					$required_quantity=$_POST['req_qty'][$i];
					$pend_qty=$_POST['req_qty'][$i];
					$due_date = getDateFormate($_POST['due_date'][$i]);
					$remark=$_POST['remark'][$i];
					$purpose=$_POST['purpose'][$i];
					$tableName="ms_indent_transaction";
					//print_r($tableData);
					$tableData=array("''","'$insert_id'","'$item_id'","'$required_quantity'","'$pend_qty'","'$due_date'","'$remark'","'$purpose'","now()");
					addDataIntoTable($tableName,$tableData);
				}
			}
			$Message = "$PageFor Inserted";
			redirect("$Page?Message=$Message");
		}
	}	
	else
	{ 
		if($mode == "edit")
		{	
			$tableName="ms_indent_master";
			$tableColumns=array("indent_id","indent_date","department_id","approved_by");
			$tableData=array("'$PageKeyValue'","'$indent_number'","'$indent_date'","'$department_id'","'$approved_by'");
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
			{
				$Message1='';$msg='';
				//echo sizeof($_POST['sno']);
				for($i=0; $i<sizeof($_POST['sno']); $i++)
				{	
					if($_POST['item_id'][$i]!='' && $_POST['req_qty'][$i]!="")
					{
						$indent_transaction_id=$_POST['indent_transaction_id'][$i];
						$item_id=$_POST['item_id'][$i];	
						$required_quantity=$_POST['req_qty'][$i];
						$pend_qty=$_POST['req_qty'][$i];
						$due_date = getDateFormate($_POST['due_date'][$i]);
						$remark=$_POST['remark'][$i];
						$purpose=$_POST['purpose'][$i];
						if($indent_transaction_id == "")
						{
								$tableName="ms_indent_transaction";
								$tableData=array("''","'$PageKeyValue'","'$item_id'","'$required_quantity'","'$pend_qty'","'$due_date'","'$remark'","'$purpose'","now()");
								//print_r($tableData);
								addDataIntoTable($tableName,$tableData);
						}
						else
						{
							$sql_pend="select required_quantity,pend_qty from ms_indent_transaction where indent_transaction_id='".$indent_transaction_id."'";
							$res_pend=mysql_query($sql_pend) or die("Error In :".$sql_pend."<br />".mysql_errno());
							if(mysql_num_rows($res_pend)>0)
							{
								$row_pend=mysql_fetch_array($res_pend);
								//echo $row_pend['required_quantity']." : ".$row_pend['pend_qty']." : ".$pend_qty."<br />";
								if($row_pend['required_quantity']!=$row_pend['pend_qty'])
								{
									$pend_qty_new=$required_quantity-$row_pend['required_quantity']+$row_pend['pend_qty'];
									//echo $row_pend['required_quantity']." : ".$row_pend['pend_qty']." : ".$pend_qty."<br />";
									if($pend_qty_new<0)
									{
										$msg .=$item_id.', ';
										$Message1=$msg." Item No. Can't Update";
									}
									else
									{	
										$tableName="ms_indent_transaction";
										$tableColumns=array("indent_transaction_id","item_id","required_quantity","pend_qty","due_date","remark","purpose");
										$tableData=array("'$indent_transaction_id'","'$item_id'","'$required_quantity'","'$pend_qty_new'","'$due_date'","'$remark'","'$purpose'");
										//print_r($tableData);
										//echo "<br />";//
										updateDataIntoTable($tableName,$tableColumns,$tableData);
										$Message =$Message1."$PageFor Updated";//
									}
								}
								else
								{
									$tableName="ms_indent_transaction";
									$tableColumns=array("indent_transaction_id","item_id","required_quantity","pend_qty","due_date","remark","purpose");
									$tableData=array("'$indent_transaction_id'","'$item_id'","'$required_quantity'","'$pend_qty'","'$due_date'","'$remark'","'$purpose'");
									//print_r($tableData);
									//echo "<br />";//
									updateDataIntoTable($tableName,$tableColumns,$tableData);
									$Message =$Message1."$PageFor Updated";//////
								}
							} 							
						}
					}
				}
				//echo $Message;
				redirect("maint_list_indent.php?Message=$Message");
			}
		}
	}
}
?>

<?
if(isset($_GET["indent_id"]))
{
	$indent_id = $_GET["indent_id"];
}
else
{
	$sql="select max(indent_id) as indent_id from ms_indent_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$indent_id=($row['indent_id']+1);
}
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/maint_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Purchase Indent
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
                  <form name="frm_add" id="frm_add" method="post" onSubmit="return checkData();">
                    <table width="100%" cellpadding="1" cellspacing="1" align="center" border="0" class="border">
                      <tr>
                        <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                          <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                            <tr>
                            	<td align="left"><b>Indent No.</b></td>
                            	<td align="left">
                              	<input type="text" name="indent_id" id="indent_id" readonly="readonly" value="<?=$indent_id?>" />
                              </td>
                              <td align="left"><b>Indent Date</b></td>
                              <td align="left">
                                <input type="text" name="indent_date" id="indent_date"  style="width:150px; height:22px;" value="<?=$indent_date?>"/>
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.indent_date);return false;" HIDEFOCUS>
                                  <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                </a>                                  
                              </td>
                            </tr>
                            <tr>
                              <td align="left"><b>Department</b></td>
                              <td align="left">
                                <select name="department_id" id="department_id" style="width:150px">
                                <option value="0"></option>
                                <? $sql_dept= 'select * from ms_department order by name asc';
                                  $res_dept = mysql_query ($sql_dept) or die (mysql_error());
                                  if(mysql_num_rows($res_dept)>0)
                                  {
                                    while($row_dept = mysql_fetch_array($res_dept))
                                    {
                                      ?>
                                      <option value='<?= $row_dept['department_id'];?>'<? if($department_id==$row_dept['department_id']){?> selected="selected" <? }?>><?=$row_dept['name'];?></option>
                                      <? 
                                    }
                                  }
                                  ?>
                                </select>
                              </td>
                              <td align="left"><b>Approved By</b></td>
                              <td align="left">
                                <input type="text" name="approved_by" id="approved_by" value="<?=$approved_by?>" />
                              </td>
                            </tr>          
                            </table>
                        	</td>
                      	</tr>
                        <tr>
                          <td>
                            <div id="myDataBaseDiv">
                            <?
                            $sql_order_trans="SELECT * FROM ms_indent_master mom, ms_indent_transaction mot WHERE mom.indent_id = mot.indent_id AND mom.indent_id ='".$PageKeyValue."'";
                            $res_order_trans=mysql_query($sql_order_trans);
                            $countTrans=1;
                            $rc_trans=mysql_num_rows($res_order_trans);
                            if($rc_trans>0)
                            {
                            while($row_o_t=mysql_fetch_array($res_order_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                              $item_desc_trans='';$uname='';$stock='';
                              $item_id = $row_o_t['item_id'];
                            $sql = "SELECT * FROM  ms_item_master where item_id = '$item_id'" ;
                              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                              if(mysql_num_rows($result_item)>0)
                              {
                                $row_item = mysql_fetch_array($result_item);
                                ////Description////
                                $item_desc_trans= "Drg No.: ".$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
                                //////UOM /////////
                                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
                                $result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                                if(mysql_num_rows($result_uom)>0)
                                {
                                  $row_uom = mysql_fetch_array($result_uom);
                                  $uname= $row_uom['uname'];
                                }
                                //////// Stock /////////
                                $stock= $row_item['opening_quantity'];
                              }
                            ?>
                            <div id="myDiv_<?=$countTrans?>">
                              <input name="indent_transaction_id[]" id="indent_transaction_id[]" type="hidden" value="<?=$row_o_t['indent_transaction_id']?>" /> 
                              <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>S. No. </b></td> 
                                  <td align="center"><b>Item No.</b></td>
                                  <td align="center"><b>Item Name</b></td>
                                  <td align="center"><b>UOM</b></td>
                                  <td align="center"><b>Description</b></td>
                                  <td align="center"></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center">
                                    <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans?>" readonly="readonly" style="height:18px;width:80px"/>
                                  </td>
                                  <td align="center">
                                  	<input type="text" id="item_no_<?= $countTrans ?>" name="item_id[]" style="height:18px;width:80px;" readonly="readonly" value="<?=$item_id?>">
                                	</td>
                                  <td align="center"> 
                                  <?
																	$sql_I="select name from ms_item_master where item_id=$item_id";
																	$res_I=mysql_query($sql_I) or die ("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
																	$row_I=mysql_fetch_array($res_I);
																	$ItemName=$row_I['name'];
																	?>
                                    <input type="text" name="item_name[]" id="item_name<?= $countTrans?>" onKeyUp="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,1)" onFocus="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,1)" autocomplete="off"  class="itemText" value="<?=$ItemName?>" style="width:250px;"/>
                                    <div id="ajax_listOfOptions_<?= $countTrans?>" class="ajax_listOfOptions"></div>
                                  </td>
                                  <td align="center">
                                    <div id="div_item_uom_<?= $countTrans?>" class="getAjaxDataInDiv" style="height:18px;width:80px;"><?=$uname?></div>
                                  </td>
                                  <td align="center">
                                    <div id="div_item_desc_<?=$countTrans?>" style="height:18px;width:200px;" class="getAjaxDataInDiv"><?=$item_desc_trans?></div>
                                  </td>
                                  <td align="center"></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>Stock</b></td>  
                                  <td align="center"><b>Required Qty</b></td>        
                                  <td align="center"><b>Remarks</b></td>
                                  <td align="center"><b>Due Date</b></td>
                                  <td align="center"><b>Purpose</b></td>
                                  <td align="center"></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center">
                                    <div id="div_item_stock_<?=$countTrans?>" style='height:18px;width:80px;' class="getAjaxDataInDiv"><?=$stock?></div>
                                  </td>
                                  <td align="center">
                                    <input name="req_qty[]" id="req_qty[]" type="text" value="<?=$row_o_t['required_quantity']?>" style="height:18px;width:60px"/>
                                  </td>
                                  <td align="center">
                                    <input name="remark[]" id="remark[]" type="text" value="<?=$row_o_t['remark']?>" style="height:18px; width:200px;"/>
                                  </td>
                                  <td align="center">
                                    <input name="due_date[]" id="due_date_<?=$countTrans?>" type="text" value="<?=getDateFormate($row_o_t['due_date'])?>" style="height:18px; width:80px;"/>
                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.due_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                    </a>
                                  </td>
                                  <td align="center">
                                    <input name="purpose[]" id="purpose[]" type="text" value="<?=$row_o_t['purpose']?>" style="height:18px; width:200px;"/>
                                  </td>
                                  <td class='delete'>
                                    <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?=$row_o_t['indent_transaction_id']?>);" title="Delete">
                                      <img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle"/>
                                    </a>
                                  </td>
                                </tr>
                              </table>
                            </div>
                            <?			
                            $countTrans++; 													 
                            } // end of while
                            }// end if	
                            ?>
                            </div>
                            <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                              <input name="indent_transaction_id[]" id="indent_transaction_id[]" type="hidden" value="" />
                              <tr class="text_tr" bgcolor="#f0e6e4" >
                                <td align="center"><b>S. No. </b></td> 
                                <td align="center"><b>Item No.</b></td>
                                <td align="center"><b>Item Name</b></td>
                                <td align="center"><b>UOM</b></td>                            
                                <td align="center"><b>Description</b></td>
                                <td align="center"></td>
                              </tr>
                              <tr class="text_tr" bgcolor="#f0e6e4">
                                <td align="center">
                                  <input name="sno[]" id="sno[]" type="text" value="<?= $countTrans ?>" readonly="readonly" style="height:18px;width:60px"/>
                                </td>
                                <td align="center">
                                  <input type="text" id="item_no_<?= $countTrans ?>" name="item_id[]" style="height:18px;width:80px;" readonly="readonly">
                                </td>
                                <td align="center"> 
                                  <input type="text" name="item_name[]" id="item_name<?= $countTrans?>" onKeyUp="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,1)" onFocus="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,1)" autocomplete="off"  class="itemText" value="" style="width:250px;" />
                                  <div id="ajax_listOfOptions_<?= $countTrans?>" class="ajax_listOfOptions"></div>
                                </td>
                                <td align="center">
                                  <div id="div_item_uom_<?= $countTrans?>" style="height:18px;width:80px;" class="getAjaxDataInDiv"></div>
                                </td>
                                <td align="center">
                                  <div id="div_item_desc_<?=$countTrans?>" style='height:18px;width:200px;' class="getAjaxDataInDiv"></div>
                                </td>
                                <td align="center"></td>
                              </tr>
                              <tr class="text_tr" bgcolor="#f0e6e4"> 
                                <td align="center"><b>Stock</b></td>  
                                <td align="center"><b>Required Qty</b></td>       
                                <td align="center"><b>Remarks</b></td>
                                <td align="center"><b>Due Date</b></td>
                                <td align="center"><b>Purpose</b></td>
                                <td align="center"></td>
                              </tr>
                              <tr class="text_tr" bgcolor="#f0e6e4">
                                <td align="center">
                                  <div id="div_item_stock_<?=$countTrans?>" style='height:18px;width:80px;' class="getAjaxDataInDiv"></div>
                                </td>
                                <td align="center">
                                  <input name="req_qty[]" id="req_qty[]" type="text" style="height:18px;width:80px"/>
                                </td>
                                <td align="center">
                                  <input name="remark[]" id="remark[]" type="text"  style="height:18px; width:200px;"/>
                                </td>
                                <td align="center">
                                  <input name="due_date[]" id="due_date_<?=$countTrans?>" type="text"  style="height:18px; width:80px;"/>
                                  <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.due_date_<?=$countTrans?>);return false;" HIDEFOCUS>
                                    <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                  </a>
                                </td>
                                <td align="center">
                                  <input name="purpose[]" id="purpose[]" type="text" style="height:18px;width:200px;"/>
                                </td>
                                <td align="center" class="AddMore" >
                                  <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                  <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                                    <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/>
                                  </a>
                                </td>
                              </tr>  
                              <tr>
                                <td colspan="6">
                                  <div id="myDiv1"></div>
                                </td>
                              </tr>                              
                            </table>
                          </td>
                        </tr>
                        <tr class="text_tr" bgcolor="#EAE3E1">
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