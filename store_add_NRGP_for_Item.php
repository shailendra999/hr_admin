<? include("inc/store_header.php"); ?>
<style>
.getDataInDiv {
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
.get_H_18_W_60 {
	height:18px;
	width:60px;
}
</style>
<script type="text/javascript">
function overlay(MasterId,RecordId) {
	e1 = document.getElementById("overlay");
	document.getElementById("hidden_overlay_master").value=MasterId;
	document.getElementById("hidden_overlay").value=RecordId;
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
                               
	var myTable="<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable+="<input name='NRGP_trans_id[]' id='NRGP_trans_id[]' type='hidden' value='' />";
  myTable+="<tr class='text_tr' bgcolor='"+tableColor+"'><td align='center'><b>S. No. </b></td><td align='center'><b>Department</b></td><td align='center'><b>Item Name</b></td><td align='center'><b>UOM</b></td></td><td align='center'><b>Remarks</b></td><td align='center'><b>Quantity</b></td><td align='center'><b>Rate</b></td><td align='center'></td></tr>";
  myTable+="<tr class='text_tr' bgcolor='"+tableColor+"'>";
	myTable+="<td align='center'><input name='sno[]' id='sno[]' type='text' value='"+num+"' readonly='readonly' class='get_H_18_W_60'/></td>";
	 myTable+="<td align='center'><select name='department_id[]' id='department_id[]' style='height:18px;width:145px;'><option value='0'></option><? $sql_dept= 'select * from ms_department order by name asc';$res_dept = mysql_query ($sql_dept) or die ('Invalid query : '.$sql_dept.'<br>'.mysql_errno().' : '.mysql_error());if(mysql_num_rows($res_dept)>0){while($row_dept = mysql_fetch_array($res_dept)){?><option value='<?= $row_dept['department_id'];?>'><?=$row_dept['name'];?></option><? }}?></select></td>"; 
  myTable+="<td align='center'><input name='item_name[]' id='item_name[]' style='height:18px;width:200px' /></td>";
 myTable +="<td align='center'><select name='uom_id[]' id='uom_id[]' style='height:18px;width:70px;'><option value='0'></option><? $sql_U= 'select * from ms_uom order by name asc';$res_U = mysql_query ($sql_U) or die ('Invalid query : '.$sql_U.'<br>'.mysql_errno().' : '.mysql_error());if(mysql_num_rows($res_U)>0){while($row_U = mysql_fetch_array($res_U)){?><option value='<?= $row_U['uom_id'];?>'><?=$row_U['name'];?></option><? }}?></select></td>"; 
  myTable+="<td align='center'><input name='remarks[]' id='remarks[]' type='text' style='height:18px;width:200px;'/></td>";
	myTable+="<td align='center'><input name='quantity[]' id='quantity[]' type='text' class='get_H_18_W_60'/></td>";
  myTable+="<td align='center'><input name='rate[]' id='rate[]' type='text' class='get_H_18_W_60'/></td>";
	myTable+="<td class='AddMore' align='center'><a href=\"javascript:;\" title='Delete This Row' onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img alt='Delete' src='images/delete_icon.jpg' border='0'/></a></td>";
	myTable+="</tr></table>";
	newdiv.innerHTML=myTable;
	ni.appendChild(newdiv);
}
function removeElement(divNum,myDiv) {
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<script type="text/javascript">
	function getItemDetailsForIssueEntry(itemnameId, divItemCode, divItemUom){
		var strURL1="store_get_itemcode.php?item_id="+itemnameId;
		var strURL2="store_get_itemuom.php?item_id="+itemnameId;
		
		var req = getXMLHTTP();
		var req1 = getXMLHTTP();

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
	}			
														
</script>
<?
$Page = "store_add_NRGP_for_Item.php";
$PageTitle = "Add NRGP";
$PageFor = "NRGP";
$PageKey = "NRGP_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode'])){
	$mode=$_GET['mode'];
	$sql_idate="select * from ms_NRGP_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator')){
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}
}

//////////////////////////////////////////////////////////
$NRGP_id='';$NRGP_date='';$supplier_id='';$NRGP_type='';$ref_quot_no='';$ref_quot_date='';$NRGP_number='';
$despatch_through='';$special_instr='';
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
$item_id='';$remarks='';$quantity='';$value='';$duedate='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_NRGP_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$NRGP_date=$row['NRGP_date'];
		$supplier_id=$row['supplier_id'];
		$ref_quot_no=$row['ref_quot_no'];	
		$ref_quot_date=$row['ref_quot_date'];
		$despatch_through=$row['despatch_through'];
		$special_instr=stripslashes($row['special_instr']);
	}
}

if(isset($_POST["btn_delete"])){
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from ms_NRGP_Item_transaction where NRGP_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "NRGP Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"])){
	$NRGP_date=getDateFormate($_POST['NRGP_date']);
	$supplier_id=$_POST['supplier_id'];
	$NRGP_type=$_POST['NRGP_type'];
	$ref_quot_no=$_POST['ref_quot_no'];	
	$ref_quot_date=getDateFormate($_POST['ref_quot_date']);
	$despatch_through=$_POST['despatch_through'];
	$special_instr=addslashes($_POST['special_instr']);
	$GRN_id='';
	if($PageKeyValue == ""){
		$tableName="ms_NRGP_master";
		$tableData=array("''","'$NRGP_date'","'$supplier_id'","'$ref_quot_no'","'$ref_quot_date'","'$GRN_id'","'$despatch_through'","'$special_instr'","now()");
			
		if(addDataIntoTable($tableName,$tableData))
		{
			$RM_id=mysql_insert_id();
			for($i=0;$i<sizeof($_POST["sno"]);$i++)
			{
				if($_POST['item_name'][$i]!='')
				{
					$item_name=$_POST['item_name'][$i];
					$department_id=$_POST['department_id'][$i];
					$uom_id=$_POST['uom_id'][$i];
					$remarks=$_POST['remarks'][$i];
					$quantity=$_POST['quantity'][$i];
					$pend_qty=$_POST['quantity'][$i];
					$rate=$_POST['rate'][$i];
					$tableData=array("''","'$RM_id'","'$department_id'","'$item_name'","'$uom_id'","'$remarks'","'$quantity'","'$rate'","now()");
					addDataIntoTable("ms_NRGP_Item_transaction",$tableData);		
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
			$tableName="ms_NRGP_master";
			$tableColumns=array("$PageKey","NRGP_date","supplier_id","ref_quot_no","ref_quot_date","despatch_through","special_instr");
			
			$tableData=array("'$PageKeyValue'","'$NRGP_date'","'$supplier_id'","'$ref_quot_no'","'$ref_quot_date'","'$despatch_through'","'$special_instr'");
			
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
			{
				$tableColumns=array("NRGP_transaction_id","$PageKey","department_id","item_name","uom_id","remarks","quantity","rate");
				for($i=0;$i<sizeof($_POST["sno"]);$i++)
				{
					if($_POST['item_name'][$i]!='')
					{
						$NRGP_trans_id=$_POST['NRGP_trans_id'][$i];
						$item_name=$_POST['item_name'][$i];
						$department_id=$_POST['department_id'][$i];
						$uom_id=$_POST['uom_id'][$i];
						$remarks=$_POST['remarks'][$i];
						$quantity=$_POST['quantity'][$i];
						$rate=$_POST['rate'][$i];
						if($NRGP_trans_id!="")
						{
							$tableData=array("'$NRGP_trans_id'","'$PageKeyValue'","'$department_id'","'$item_name'","'$uom_id'","'$remarks'","'$quantity'","'$rate'");
							//print_r($tableData);echo "<br />";
							updateDataIntoTable("ms_NRGP_Item_transaction",$tableColumns,$tableData);	
						}
						else
						{
							$tableData=array("''","'$PageKeyValue'","'$department_id'","'$item_name'","'$uom_id'","'$remarks'","'$quantity'","'$rate'","now()");
							addDataIntoTable("ms_NRGP_Item_transaction",$tableData);	
						}						
					}
				}	
				$Message = "$PageFor Updated";
				redirect("store_list_NRGP_for_Item.php?Message=$Message");
			}
		}	
		
	}	
}
if(isset($_GET["NRGP_id"])){
	$NRGP_id = $_GET["NRGP_id"];
}else{
	$sql="select max(NRGP_id) as NRGP_id from ms_NRGP_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$NRGP_id=($row['NRGP_id']+1);
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add NRGP</td>
				</tr>
				<tr>
					<td valign="top" style="padding-top:10px;">
						<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="red"><?=$Message?></td>
							</tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                  <form name="frm_add" id="frm_add" action="" method="post" onSubmit="return;">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>NRGP No.</b></td>
                    					<td align="left"><input type="text" id="NRGP_id" name="NRGP_id" readonly="readonly" value="<?= $NRGP_id ?>" /></td>
                              <td align="left"><b>NRGP Date</b></td>
                              <td align="left">
                                <input type="text" id="NRGP_date" name="NRGP_date" value="<?= getDateFormate($NRGP_date); ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.NRGP_date);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absmiddle" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a> 
                              </td>
														</tr>
                            <tr>
                            	<td align="left"><b>Supplier</b></td>
                              <td align="left" colspan="3">
                                <select id="supplier_id" name="supplier_id" style="height:20px;width:250px">
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
                              <td align="left"><b>Ref. Quot. No.</b></td>
                              <td align="left"><input type="text" id="ref_quot_no" name="ref_quot_no" value="<?= $ref_quot_no ?>" /></td>
                              <td align="left"><b>Ref. Quot. Date</b></td>
                              <td align="left">
                                <input type="text" id="ref_quot_date" name="ref_quot_date" value="<?= getDateFormate($ref_quot_date) ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.ref_quot_date);return false;" HIDEFOCUS>
                                 <img name="popcal" align="absmiddle" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a>
                              </td>
                             </tr>   
                          </table>
                    		</td>
                   </tr>
                    <tr>   
                      <td width="100%">
                      	<div id="myDataBaseDiv">
                        <?
												$sql_RM="SELECT * FROM ms_NRGP_master mgm,ms_NRGP_Item_transaction mgt WHERE mgm.NRGP_id=mgt.NRGP_id AND mgm.NRGP_id ='".$PageKeyValue."'";
												$res_RM=mysql_query($sql_RM);
												$countTrans=1;
												$rc_trans=mysql_num_rows($res_RM);
												if($rc_trans>0)
												{
													while($row_RM=mysql_fetch_array($res_RM))
													{
														if($countTrans%2==0)
															$tableColor="#eedfdc";
														else
															$tableColor="#f8f1ef";
													?>
                              
                          <div id="myDiv_<?=$countTrans?>">
                        		<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                        			<input name="NRGP_trans_id[]" id="NRGP_trans_id[]" type="hidden" value="<?=$row_RM['NRGP_transaction_id']?>" />  
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center"><b>S. No. </b></td>                               
                                <td align="center"><b>Department</b></td>
                                <td align="center"><b>Item Name</b></td>
                                <td align="center"><b>UOM</b></td>
                                <td align="center"><b>Remarks</b></td>
                                <td align="center"><b>Quantity</b></td>
                                <td align="center"><b>Rate</b></td>                                  
                                <td align="center"></td>                                
                              </tr>
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center">
                                  <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans ?>" readonly="readonly" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                <select name='department_id[]' id='department_id[]' style='height:18px;width:145px;'>
                                	<option value='0'></option>
																	<? $sql_dept= 'select * from ms_department order by name asc';
                                  $res_dept = mysql_query ($sql_dept) or die ('Invalid query : '.$sql_dept.'<br>'.mysql_errno().' : '.mysql_error());
                                  if(mysql_num_rows($res_dept)>0)
                                  {
                                    while($row_dept = mysql_fetch_array($res_dept))
                                    {
                                      ?>
                                      <option value='<?= $row_dept['department_id'];?>'<? if($row_RM['department_id']==$row_dept['department_id']){?> selected="selected" <? }?>><?=$row_dept['name'];?></option>
                                      <? 
                                    }
                                  }
                                  ?>
                                  </select>
                                </td>
                                <td align="center">                                	
                                   <input name="item_name[]" id="item_name[]" style="height:18px;width:200px" value="<?=$row_RM['item_name']?>" />
                                </td>                               
                                <td align="center">
                                 <select name='uom_id[]' id='uom_id[]' style='height:18px;width:70px;'>
                                    <option value='0'></option>
                                    <? 
                                    $sql_U= 'select * from ms_uom order by name asc';
                                    $res_U = mysql_query ($sql_U) or die ('Invalid query : '.$sql_U.'<br>'.mysql_errno().' : '.mysql_error());
                                    if(mysql_num_rows($res_U)>0)
                                    {
                                      while($row_U = mysql_fetch_array($res_U))
                                      {
                                        ?>
                                        <option value='<?= $row_U['uom_id']?>'<? if($row_U['uom_id']==$row_RM['uom_id']){?> selected="selected"<? }?>><?=$row_U['name'];?></option>
                                        <? 
                                      }
                                    }
                                    ?>
                                  </select>
                                  <!--<input name="uom[]" id="uom[]" type="text" value="" class="get_H_18_W_60"/>-->
                                </td>
                                <td align="center">
                                  <input name="remarks[]" id="remarks[]" value="<?= $row_RM['remarks']?>" type="text" style="width:200px;height:18px"/>
                                </td>
                                <td align="center">
                                  <input name="quantity[]" id="quantity[]" value="<?= $row_RM['quantity']?>" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                  <input name="rate[]" id="rate[]" value="<?= $row_RM['rate']?>" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td class="AddMore" align="center">                                        
                                  <a href="javascript:;" onclick="overlay(<?= $PageKeyValue?>,<?=$row_RM['NRGP_transaction_id']?>);" title="Delete">
                                  <img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle"/></a>
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
                        	<input name="NRGP_trans_id[]" id="NRGP_trans_id[]" type="hidden" value="" />
                            <tr class="text_tr" bgcolor="#f0e6e4">
                              <td align="center"><b>S. No. </b></td>                               
                              <td align="center"><b>Department</b></td>
                              <td align="center"><b>Item Name</b></td>
                              <td align="center"><b>UOM</b></td>
                              <td align="center"><b>Remarks</b></td>
                              <td align="center"><b>Quantity</b></td>
                              <td align="center"><b>Rate</b></td>                                  
                              <td align="center"></td>                              
                            </tr>
                            <tr class="text_tr" bgcolor="#f0e6e4">
                               <td align="center">
                                  <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans?>" readonly="readonly" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                  <select name='department_id[]' id='department_id[]' style='height:18px;width:145px;'>
                                	<option value='0'></option>
																	<? $sql_dept= 'select * from ms_department order by name asc';
                                  $res_dept = mysql_query ($sql_dept) or die ('Invalid query : '.$sql_dept.'<br>'.mysql_errno().' : '.mysql_error());
                                  if(mysql_num_rows($res_dept)>0)
                                  {
                                    while($row_dept = mysql_fetch_array($res_dept))
                                    {
                                      ?>
                                      <option value='<?= $row_dept['department_id'];?>'><?=$row_dept['name'];?></option>
                                      <? 
                                    }
                                  }
                                  ?>
                                  </select>
                                </td>
                                <td align="center">                                	
                                  <input name="item_name[]" id="item_name[]" style="height:18px;width:200px" />
                                </td>                               
                                <td align="center">
                                   <select name='uom_id[]' id='uom_id[]' style='height:18px;width:70px;'>
                                    <option value='0'></option>
                                    <? 
																		$sql_U= 'select * from ms_uom order by name asc';
                                    $res_U = mysql_query ($sql_U) or die ('Invalid query : '.$sql_U.'<br>'.mysql_errno().' : '.mysql_error());
                                    if(mysql_num_rows($res_U)>0)
                                    {
                                      while($row_U = mysql_fetch_array($res_U))

                                      {
                                        ?>
                                        <option value='<?= $row_U['uom_id'];?>'><?=$row_U['name'];?></option>
																				<? 
                                      }
                                    }
                                    ?>
                                  </select>
                                </td>
                                <td align="center">
                                  <input name="remarks[]" id="remarks[]" type="text" style="width:200px;height:18px"/>
                                </td>
                                <td align="center">
                                  <input name="quantity[]" id="quantity[]" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                  <input name="rate[]" id="rate[]" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td class="AddMore" align="center">
                                  <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                  <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                                  <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
                                </td>
                              </tr> 
                              <tr>
                                  <td colspan="9">
                                      <div id="myDiv1"></div>
                                  </td>
                              </tr>                              
                          </table>
                    		</td>
                  		</tr>
                      <tr bgcolor="#eae3e1">
                      	<td align="center">
                          <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>Despatch Through</b></td>
                    					<td align="left"><input type="text" id="despatch_through" name="despatch_through" value="<?= $despatch_through ?>" /></td>
                              <td align="left"><b>Special Instructions</b></td>
                              <td align="left">
                                <textarea name="special_instr" id="special_instr" cols="35" rows="3"><?= $special_instr?></textarea>
                              </td>
														</tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" bgcolor="#EAE3E1">
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