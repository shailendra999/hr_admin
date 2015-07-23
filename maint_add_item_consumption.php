<?
include("inc/maint_header.php");
?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId,ItemId,Qty) 
{
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
	document.getElementById("hidden_overlay_Item_Id").value=ItemId;
	document.getElementById("hidden_overlay_Qty").value=Qty;	
	e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";	
}
</script>
<script type="text/javascript">

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
	var myTable= "<table align='center' width='100%' cellpadding='0' cellspacing='1' class='border' border='0'>";
	myTable+= "<tr bgcolor="+tableColor+" class='text_tr'>";
	
	
	myTable+= "<td align='center' width='8%'><b>SNo.</b></td>";
  myTable+= "<td align='center' width='51%'><b>Item Desc</b></td>";
  myTable+= "<td align='center' width='12%'><b>Stock</b></td>";
  myTable+= "<td align='center' width='12%'><b>Cons. Qty</b></td>";
  myTable+= "<td align='center' width='12%'><b>New Stock</b></td>";
  myTable+= "<td align='center' width='5%'>&nbsp;</td>";
	
	myTable+= "<input type='hidden' name='IC_transaction_id[]' id='IC_transaction_id[]' value=''/>";
	myTable+= "<tr bgcolor="+tableColor+" class='text_tr'>";
	myTable+= "<td align='center'><input type='text' name='sno[]' id='sno[]' readonly='readonly' value='"+num+"' style='height:20px;width:50px;'/></td>";
	
	myTable+= "<td align='center'><select id='item_id_"+num+"' name='item_id[]' onchange=\"getItemStock(this.value,'maint_stock_"+num+"','maint_get_stock.php');return checkItemForDuplicacy("+num+",this.value,'item_id_"+num+"');\" style='height:20px;width:95%;'><option value=''></option><? $sql_S='select ms_item_master.name as ItemName,ms_item_master.item_id,ms_item_master.drawing_number,ms_item_master.catelog_number,ms_uom.name as UOM from ms_item_master,ms_uom where ms_uom.uom_id=ms_item_master.uom_id order by ms_item_master.name asc';$res_S=mysql_query($sql_S) or die(mysql_error());if(mysql_num_rows($res_S)>0){while($row_S=mysql_fetch_array($res_S)){?><option value='<?=$row_S['item_id']?>'><?=addslashes($row_S['ItemName']).' ;Drg. No. '.$row_S['drawing_number'].' ;Cat. No. '.$row_S['catelog_number'].' ; '.$row_S['UOM'];?></option><? }}?></select></td>";
	
	myTable+= "<td align='center'><input type='text' name='maint_stock[]' id='maint_stock_"+num+"' autocomplete='off' style='height:20px;width:100px' readonly='readonly'/></td>";
	myTable+= "<td align='center'><input type='text' name='cons_qty[]' id='cons_qty_"+num+"' autocomplete='off' onKeyUp=\"return remainingQty(this.id,'maint_stock_"+num+"','new_maint_stock_"+num+"','');\" style='height:20px;width:100px'/></td>";
	myTable+= "<td align='center'><input type='text' name='new_maint_stock[]' id='new_maint_stock_"+num+"' readonly='readonly' style='height:20px;width:100px'/></td>";
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
function getItemStock(value,textBoxId,page)
{
		var strURL1;
		strURL1=page+"?item_id="+value+"&sid="+Math.random();
		//alert(strURL1);
		var req = getXMLHTTP();
		if (req)
		{																					
				req.onreadystatechange = function() {
						if (req.readyState == 4) {
								if (req.status == 200)                         
										document.getElementById(textBoxId).value=Number(req.responseText);
								 else 
										alert("There was a problem while using XMLHTTP:\n" + req.statusText);
						}                
				}            
				req.open("GET", strURL1, true);
				req.send(null);
		}
}
</script>
<script>
	function remainingQty(consId,maintId,newMaintId,oldQty)
	{
		var status=true;
		//alert(consId);
		//alert(maintId);
		var maintValue = document.getElementById(maintId).value;
		var value = document.getElementById(consId).value;
		//var rec = document.getElementById('rec_qty[]');
		if(Number(value)>(Number(maintValue)+Number(oldQty)) || maintValue=='')
		{
			alert('Check Required Quantity');
			//document.getElementById(maintId).value='';
			document.getElementById(consId).value='';
			document.getElementById(newMaintId).value='';
			status=false;
		}
		else
		{
			var pend = Number(maintValue)+Number(oldQty)-Number(value);
			document.getElementById(newMaintId).value = pend;
		}
		return status;
	}
	function checkData()
	{
		var status=true;
		var item_id = document.getElementsByName('item_id[]');
		var req = document.getElementsByName('maint_stock[]');
		var rec = document.getElementsByName('cons_qty[]');
		var pend = document.getElementsByName('new_maint_stock[]');
		var len=pend.length;
		//alert(req[0].value);
		for(var i=0;i<len;i++)
		{	
			if(item_id[i].value!='' && (req[i].value=='' || rec[i].value=='' || pend[i].value==''))
			{
				alert("Check All Entries.");
				status=false;
				break;
			}
		}
		return status;
	}
	function checkItemForDuplicacy(no,value) 
	// Used To Check Item Duplicacy
	{
		var status=true;
		var item_id=document.getElementsByName("item_id[]");
		var maint_stock=document.getElementsByName("maint_stock[]");
		var len=item_id.length;
		for(var i=0;i<len;i++)
		{
			if(value==item_id[i].value && parseInt(no-1)!=parseInt(i))
			{
				status=false;
				break;
			}
			else
				status=true;
		}
		if(status==false)
		{
			alert("Item Already selected.");
			item_id[no-1].selectedIndex = 0;
			maint_stock[no-1].value = '';
		}
			
		return status;
	}
</script>
<?
$Page = "maint_add_item_consumption.php";
$PageTitle = "Add Item Consumption";
$PageFor = "Item Consumption";
$PageKey = "IC_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$IC_date='';

$item_id='';$req_qty='';$rec_qty='';$pend_qty='';$maint_stock='';
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
	$sql_idate="select * from maint_item_consumption_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='maint_homepage.php';</script>";
	}
}

if(isset($_POST["btn_delete"]))
{
	
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$item_id  = $_POST["hidden_overlay_Item_Id"];
	$Qty = $_POST["hidden_overlay_Qty"];
	
	$sql_stk = "select * from maint_item_stock where item_id = '".$item_id."' ";
	$result_stk = mysql_query ($sql_stk) or die ("Invalid query : ".$sql_stk."<br>".mysql_errno()." : ".mysql_error());
	
	if(mysql_num_rows($result_stk)>0)
	{
		$row_stk = mysql_fetch_array($result_stk);
		$total_stock = $row_stk['maint_stock'] + $Qty;
		
		$tableName="maint_item_stock";
		$tableColumns=array("item_id","maint_stock","insert_date");
		$tableData=array("'$item_id'","'$total_stock'","now()");
		updateDataIntoTable($tableName,$tableColumns,$tableData);
	}
	$sql = "delete from maint_item_consumption_transaction where IC_transaction_id = '".$PageKeyValueTrans."'";
	if(mysql_query ($sql))
	{
		$Message = "Record Sucessfully Deleted";
	}
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"]))
{
	$PageKeyValue = $_POST[$PageKey];
	$IC_date = getDateFormate($_POST["IC_date"]);

	if($PageKeyValue == "")
	{
		$tableName="maint_item_consumption_master";
		
		$tableData=array("''","'$IC_date'","now()");
		//print_r($tableData);
		addDataIntoTable($tableName,$tableData);
		$insert_id = mysql_insert_id();
		
		if(isset($_POST['item_id'])){$count=count($_POST['item_id']);}
		for($i=0; $i<$count; $i++)
		{
				if($_POST['item_id'][$i]!="0")
				{
					$item_id=$_POST['item_id'][$i];
					$cons_qty=$_POST['cons_qty'][$i];
					$new_maint_stock=$_POST['new_maint_stock'][$i];	
					
						$tableName="maint_item_stock";
						$tableData=array("'$item_id'","'$new_maint_stock'","now()");
						$tableColumns=array("item_id","maint_stock","insert_date");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
						
					$tableName="maint_item_consumption_transaction";
					$tableData=array("''","'$insert_id'","'$item_id'","'$cons_qty'","now()");
					addDataIntoTable($tableName,$tableData);
					$Message = "$PageFor Inserted";
				}
		}	
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{
			$tableName="maint_item_consumption_master";
			$tableColumns=array("IC_id","IC_date");
			
			$tableData=array("'$PageKeyValue'","'$IC_date'");
			//print_r($tableData);
			updateDataIntoTable($tableName,$tableColumns,$tableData);
			
			if(isset($_POST['item_id'])){$count=count($_POST['item_id']);}
		
			for($i=0; $i<$count; $i++)
			{
				if($_POST['item_id'][$i]!="0" and $_POST['item_id'][$i]!="")
				{
					$IC_transaction_id=$_POST['IC_transaction_id'][$i];
					$item_id=$_POST['item_id'][$i];
					$cons_qty=$_POST['cons_qty'][$i];
					echo $new_maint_stock=$_POST['new_maint_stock'][$i];	
						
						$tableName="maint_item_stock";
						$tableData=array("'$item_id'","'$new_maint_stock'","now()");
						$tableColumns=array("item_id","maint_stock","insert_date");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
						
						
					$tableName="maint_item_consumption_transaction";
					if($IC_transaction_id=="")
					{
						$tableData=array("''","'$PageKeyValue'","'$item_id'","'$cons_qty'","now()");
						addDataIntoTable($tableName,$tableData);
					}
					else
					{
						$tableColumns=array("IC_transaction_id","IC_id","item_id","cons_qty");
						$tableData=array("'$IC_transaction_id'","'$PageKeyValue'","'$item_id'","'$cons_qty'");
						updateDataIntoTable($tableName,$tableColumns,$tableData);
					}
					$Message = "$PageFor Updated";
				}
			}	
			redirect("maint_list_item_consumption.php?Message=$Message");
		}
	}
}
?>
<?

if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_item_consumption_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$IC_id = $row[$PageKey];
		$IC_date = getDateFormate($row['IC_date']);
				
	}
}
else if(!isset($_GET[$PageKey]))
{
	$sql="select max(IC_id) as IC_id from maint_item_consumption_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$IC_id=($row['IC_id']+1);
}

if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add/Edit Item Consumption
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
                  <form name="frm_add" id="frm_add" action="" method="post" onSubmit="return checkData();">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td width="19%" align="left"><b>Item Rec. No</b></td>
                            <td width="81%" colspan="3" align="left">
                              <input type="text" readonly="readonly" id="IC_id" name="IC_id" value="<?= $IC_id ?>"  />
                            </td>
                          </tr>
                         
                          <tr>
                            <td align="left"><b>Date Of Item Consumption</b></td>
                            <td align="left">
                            	<input type="text" id="IC_date" name="IC_date" value="<?= $IC_date ?>" />
                              <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.IC_date);return false;" HIDEFOCUS>
                              <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              </a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div id="myDataBaseDiv">
                        <?
                        $sql_item_trans="SELECT * FROM maint_item_consumption_master mim, maint_item_consumption_transaction mit WHERE mim.IC_id = mit.IC_id AND mit.IC_id ='".$PageKeyValue."'";
                        $res_item_trans=mysql_query($sql_item_trans) or die(mysql_error());
                        $countTrans=1;
                        $rc_trans=mysql_num_rows($res_item_trans);
                        if($rc_trans>0)
                        {
                          while($row_i_t=mysql_fetch_array($res_item_trans))
                          {
                            if($countTrans%2==0)
                            $tableColor="#eedfdc";
                            else
                            $tableColor="#f8f1ef";
                            ?>
                            <div id="myDiv_<?=$countTrans?>">
                              <table width="100%" border="0" cellspacing="1" cellpadding="0" class="border">
																<tr bgcolor="#eedfdc" class="text_tr">
                                  <td align="center" width="8%"><b>SNo.</b></td>
                                  <td align="center" width="51%"><b>Item Desc</b></td>
                                  <td align="center" width="12%"><b>Stock</b></td>
                                  <td align="center" width="12%"><b>Cons. Qty</b></td>
                                  <td align="center" width="12%"><b>New Stock</b></td>
                                  <td align="center" width="5%">&nbsp;</td>
                                </tr>
                                <tr bgcolor="<?= $tableColor?>" class="text_tr">
                                  <input type="hidden" name="IC_transaction_id[]" id="IC_transaction_id[]" value="<?= $row_i_t['IC_transaction_id']?>"/>
                                  <td align="center">
                                    <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?= $countTrans?>" style="height:20px;width:50px;"/>
                                  </td>
                                  <td align="left" style="padding-left:2px">
                                    <input type="hidden" id="item_id[]" name="item_id[]" value="<?=$row_i_t['item_id']?>" >
                                    <?
                                    $sql_S="select 
																			ms_item_master.name as ItemName, 
																			ms_item_master.item_id, 
																			ms_item_master.drawing_number, 
																			ms_item_master.catelog_number, 
																			ms_uom.name as UOM
																			from 
																			ms_item_master, ms_uom 	
																			where 
																			ms_uom.uom_id = ms_item_master.uom_id 
																			and ms_item_master.item_id='".$row_i_t['item_id']."'
																			order by ms_item_master.name asc";
																			$res_S=mysql_query($sql_S) or die(mysql_error());
																			if(mysql_num_rows($res_S)>0)
																			{
																				$row_S=mysql_fetch_array($res_S);
																				 echo $row_S['ItemName']." ; ".$row_S['drawing_number']." ; ".$row_S['catelog_number']." ; ".$row_S['UOM'];?>
																				<?
																			}
                                    ?>
                                    </select>
                                  </td>
                                  <?
																			$maint_stock='';
																			$sql_stk = "select * from maint_item_stock where item_id = '".$row_i_t['item_id']."' ";
																			$result_stk = mysql_query ($sql_stk) or die ("Invalid query : ".$sql_stk."<br>".mysql_errno()." : ".mysql_error());
																			if(mysql_num_rows($result_stk)>0)
																			{
																				$row_stk = mysql_fetch_array($result_stk);
																				$maint_stock = $row_stk['maint_stock'];
								  										}
									  								?>
                                  <td align="center">
                                  	<input type="text" name="maint_stock[]" id="maint_stock_<?=$countTrans?>" readonly="readonly" value="<?=$maint_stock?>" style="height:20px;width:100px"/>
                                  </td>
                                  <td align="center">
                                    <input type="text" name="cons_qty[]" autocomplete="off" id="cons_qty_<?=$countTrans?>" value="<?=$row_i_t['cons_qty']?>" style="height:20px;width:100px" onKeyUp="return remainingQty('cons_qty_<?= $countTrans ?>','maint_stock_<?= $countTrans ?>','new_maint_stock_<?= $countTrans ?>','<?=$row_i_t['cons_qty']?>');"/>
                                  </td>
                                 
                                  <td align="center">
                                     <input type="text" name="new_maint_stock[]" id="new_maint_stock_<?=$countTrans?>" value="<?=$maint_stock?>" readonly="readonly"  style="height:20px;width:100px"/>
                                  </td>
                                  
                                  <td class='delete'>
                                    <a href="javascript:;" onClick="overlay(<?=$PageKeyValue?>,<?=$row_i_t['IC_transaction_id'] ?>,<?=$row_i_t["item_id"]?>,<?=$row_i_t["cons_qty"]?>);">
                                    <img src="images/delete_icon.jpg" border="0"/></a>
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
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" class="border">
                          <tr bgcolor="#eedfdc" class="text_tr">
                            <td align="center" width="8%"><b>SNo.</b></td>
                            <td align="center" width="51%"><b>Item Desc</b></td>
                            <td align="center" width="12%"><b>Stock</b></td>
                            <td align="center" width="12%"><b>Cons. Qty</b></td>
                            <td align="center" width="12%"><b>New Stock</b></td>
                            <td align="center" width="5%">&nbsp;</td>
                          </tr>
                          <input type="hidden" name="IC_transaction_id[]" id="IC_transaction_id[]" value=""/>
                          <tr bgcolor="#eedfdc" class="text_tr">
                            <td align="center">
                              <input type="text" name="sno[]" id="sno[]" readonly="readonly" value="<?=$countTrans ?>" style="height:20px; width:50px;" />
                            </td>
                            <td align="center">
                            <?
													$sql_S="select 
																ms_item_master.name as ItemName, ms_item_master.item_id, ms_item_master.drawing_number, ms_item_master.catelog_number, ms_uom.name as UOM
																from 
																ms_item_master, ms_uom 	
																where 
																ms_uom.uom_id = ms_item_master.uom_id order by ms_item_master.name asc";
													$res_S=mysql_query($sql_S) or die(mysql_error());
												?>
                               <select id="item_id[]" name="item_id[]" style="height:20px;width:95%" onChange="getItemStock(this.value,'maint_stock_<?=$countTrans ?>','maint_get_stock.php');checkItemForDuplicacy(<?=$countTrans ?>,this.value)" >
                                    <option value=""></option>
                                   <? 
                                    if(mysql_num_rows($res_S)>0)
                                    {
																			while($row_S=mysql_fetch_array($res_S))
																			{
																			?>
																				<option value="<?=$row_S['item_id']?>"><?=$row_S['ItemName']." ;Drg. No. ".$row_S['drawing_number']." ;Cat. No. ".$row_S['catelog_number']." ; ".$row_S['UOM']?></option>
																			<?
																			}
                                    }
                                    ?>
                                    </select>
                            </td>
                            <td align="center">
                              <input type="text" name="maint_stock[]" id="maint_stock_<?= $countTrans ?>" readonly="readonly" autocomplete="off" style="height:20px;width:100px"/>
                            </td>
                            <td align="center">
                            	<input type="text" name="cons_qty[]" id="cons_qty_<?= $countTrans ?>" autocomplete="off" style="height:20px;width:100px"
                                onKeyUp="return remainingQty('cons_qty_<?= $countTrans ?>','maint_stock_<?= $countTrans ?>','new_maint_stock_<?= $countTrans ?>','');"/>
                            </td>
                            <td align="center">
                              <input type="text" name="new_maint_stock[]" id="new_maint_stock_<?=$countTrans?>" readonly="readonly" style="height:20px;width:100px"/>
                            </td>
                            <td class="AddMore" align="center">
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
                    </tr>
                    <tr>
                      <td align="center">
                        <input type="hidden" id="mode" name="mode" value="<?=$mode?>"/>
                        <input type="hidden" id="<?=$PageKey?>" name="<?=$PageKey?>" value="<?=$PageKeyValue?>" />
                        <input type="submit" id="btn_submit" name="btn_submit" value="Save" class="btn_bg" />
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
        <input type="hidden" name="hidden_overlay_Item_Id" id="hidden_overlay_Item_Id" value="" />
        <input type="hidden" name="hidden_overlay_Qty" id="hidden_overlay_Qty" value="" />
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