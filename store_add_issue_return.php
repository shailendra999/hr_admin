<? include("inc/store_header.php"); ?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
.get_H_18_W_60{
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
                               
	var myTable = "<table align='center' width='100%' cellpadding='1' cellspacing='1' class='border' border='0'>";
	myTable +="<input name='IR_trans_id[]' id='IR_trans_id[]' type='hidden' value='' />";
  myTable +="<tr class='text_tr' bgcolor='"+tableColor+"'>";
	myTable +="<td align='center' width='8%'><b>S. No. </b></td>";                               
	myTable +="<td align='center' width='10%'><b>Item No.</b></td>";
	myTable +="<td align='center' width='45%'><b>Item Name</b></td>";
	myTable +="<td align='center' width='10%'><b>UOM</b></td>";
	myTable +="<td align='center' width='10%'><b>Ret. Qty</b></td>";
	myTable +="<td align='center' width='12%'><b>Ret. Type</b></td>";
	myTable +="<td align='center' width='5%'></td>";
  myTable +="<tr class='text_tr' bgcolor='"+tableColor+"'>";
	myTable += "<td align='center'><input name='sno[]' id='sno[]' type='text' value='"+num+"' readonly='readonly' class='get_H_18_W_60'/></td>";
  myTable += "<td align='center'><div id='div_item_no_"+num+"' style='height:18px;width:60px;' class='getDataInDiv '></div></td>";
  myTable += "<td align='center'><select name='item_name[]' id='item_name[]' style='width:95%' onChange=\"getItemDetailsForIssueEntry(this.value,'div_item_no_"+num+"','div_item_uom_"+num+"');return checkItem("+num+",this.value);\"><option value='0'></option><? $sql_item='select mi.item_id,mi.name as iname,mi.closing_stock,mi.drawing_number,mi.catelog_number,md.name as dname from ms_item_master mi,ms_machinary md where mi.machinary_id=md.machinary_id order by mi.name asc';$res_item=mysql_query($sql_item);while($row_item=mysql_fetch_array($res_item)){$str=$row_item['iname'].' || Dr No.:'.$row_item['drawing_number'].' || Cat.No.: '.$row_item['catelog_number'].' || Mach.: '.$row_item['dname'].' || Stock.: '.$row_item['closing_stock']; ?><option value='<?=$row_item['item_id']?>'><?=addslashes($str)?></option><? }?></select></td>";
	myTable += "<td align='center'><div id='div_item_uom_"+num+"' style='height:18px;width:70px;' class='getDataInDiv'></div></td>";
  myTable += "<td align='center'><input name='return_qty[]' id='return_qty[]' type='text' class='get_H_18_W_60'/></td>";
	myTable += "<td align='center'><select name='return_type[]' id='return_type[]' style='width:120px'><option value='0'></option><? $sql_ret='select * from ms_return_type order by return_type asc';$res_ret=mysql_query($sql_ret);while($row_ret=mysql_fetch_array($res_ret)){ ?><option value='<?=$row_ret['return_type_id']?>'><?=$row_ret['return_type']?></option><? }?></select></td>";
	myTable += "<td class='AddMore' align='center'><a href=\"javascript:;\" title='Delete This Row' onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img alt='Delete' src='images/delete_icon.jpg' border='0'/></a></td>";
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
function checkItem(no,value)
{
	var status=true;
	//alert(no);
	var item_id=document.getElementsByName("item_name[]");
	var len=item_id.length;
	for(var i=0;i<len;i++)
	{
		//alert('new='+item_id[i].value);
		if(value==item_id[i].value && parseInt(no-1)!=parseInt(i))
		{
			status=false;
			break;
		}
		else
			status=true;
	}
	if(status==false)
		alert("Item Already selected.");
	return status;
}
function getItemDetailsForIssueEntry(itemnameId, divItemCode, divItemUom)
{
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
$Page = "store_add_issue_return.php";
$PageTitle = "Add Issue Return";
$PageFor = "Issue Return";
$PageKey = "IR_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
//////////////////////////////////////////////////////////
$IR_id='';$remarks='';$IR_date='';$returned_by='';$IR_number='';
$item_id='';$return_qty='';$return_type='';$department_id='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_IR_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$remarks=stripslashes($row['remarks']);
		$returned_by=$row['returned_by'];
		$IR_date=$row['IR_date'];		
	}
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	echo $sql_I="select mim.closing_stock,mim.item_id,mit.return_qty from ms_item_master mim,ms_IR_transaction mit where mit.IR_transaction_id='".$PageKeyValueTrans."' and mim.item_id=mit.item_id";
	$res_I=mysql_query($sql_I);
	$row_I=mysql_fetch_array($res_I);
	
	$total_qty=$row_I['closing_stock']-$row_I['return_qty'];
	$sql_U="update ms_item_master set closing_stock='".$total_qty."' where item_id='".$row_I['item_id']."'";
	mysql_query($sql_U);
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from ms_IR_transaction where IR_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Issue Return Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"]))
{
		//$PageKeyValue = $_POST[$PageKey];
		if($_POST['IR_date']=='')
			$IR_date=date('Y-m-d');
		else
			$IR_date=getDateFormate($_POST['IR_date']);

		$remarks=addslashes($_POST['remarks']);
		$returned_by=$_POST['returned_by'];
$IR_number=$_POST['IR_number'];		
		if($PageKeyValue == "")
		{
			$tableName="ms_IR_master";
			$tableData=array("''","'$IR_number'","'$IR_date'","'$returned_by'","'$remarks'","now()","'$gFinYear'");
			
			if(addDataIntoTable($tableName,$tableData))
			{
				$IR_id=mysql_insert_id();
				for($i=0;$i<sizeof($_POST["sno"]);$i++)
				{
					if($_POST['item_name'][$i]!='0' && $_POST['return_qty'][$i]!='')
					{
						$item_name=$_POST['item_name'][$i];
						$return_qty=$_POST['return_qty'][$i];
						$return_type=$_POST['return_type'][$i];
						///////////////// Update Item Master /////////////////
						$res=mysql_query("select closing_stock from ms_item_master where item_id='".$item_name."'");
						$row=mysql_fetch_array($res);
						$qty=0;
						$qty=(float)$row["closing_stock"];
						$qty+=(float)$return_qty;
						$sql_U="update ms_item_master set closing_stock='".$qty."' where item_id='".$item_name."'";
						mysql_query($sql_U);
						////////////////////// End ////////////////////////			
						$tableData=array("''","'$IR_id'","'$item_name'","'$return_qty'","'$IR_date'","'$return_type'","now()","'$gFinYear'");
						addDataIntoTable("ms_IR_transaction",$tableData);		
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
			$tableName="ms_IR_master";
			$tableColumns=array("$PageKey","IR_date","returned_by","remarks");
			$tableData=array("'$PageKeyValue'","'$IR_date'","'$returned_by'","'$remarks'");
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
			{
				$tableColumns=array("IR_transaction_id","$PageKey","item_id","return_qty","return_type_id");
				for($i=0;$i<sizeof($_POST["sno"]);$i++)
				{
					if($_POST['item_name'][$i]!='0' && $_POST['return_qty'][$i]!='')
					{
						$IR_trans_id=$_POST['IR_trans_id'][$i];
						$item_name=$_POST['item_name'][$i];
						$return_qty=$_POST['return_qty'][$i];
						$return_type=$_POST['return_type'][$i];
						///////////////// Update Item Master /////////////////
						$res=mysql_query("select * from ms_item_master where item_id='".$item_name."'");
						$row=mysql_fetch_array($res);
						$res1=mysql_query("select * from ms_IR_transaction where IR_transaction_id='".$IR_trans_id."'");
						$row1=mysql_fetch_array($res1);
						$qty=0;
						$qty=(float)$row["closing_stock"]-(float)$row1["return_qty"]+(float)$return_qty;
						$sql_U="update ms_item_master set opening_quantity='".$qty."' where item_id='".$item_name."'";
						mysql_query($sql_U);
						////////////////////// End ////////////////////////
						if($IR_trans_id!="")
						{
							$tableData=array("'$IR_trans_id'","'$PageKeyValue'","'$item_name'","'$return_qty'","'$return_type'");
							updateDataIntoTable("ms_IR_transaction",$tableColumns,$tableData);	
						}
						else
						{
							$tableData=array("''","'$PageKeyValue'","'$item_name'","'$return_qty'","'$return_type'","now()");
							addDataIntoTable("ms_IR_transaction",$tableData);	
						}						
					}
				}
			}
		}	
		$Message = "$PageFor Updated";
		redirect("store_list_issue_return.php?Message=$Message");
	}	
	
}

if(isset($_GET["IR_id"]))
{
	$IR_id = $_GET["IR_id"];
}
else
{
	$sql="select max(IR_id) as IR_id from ms_IR_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$IR_id=($row['IR_id']+1);
	
	$sqlf="select finYear from ms_IR_master where IR_id = '".$row['IR_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$IR_number = 1;
	}else{
		$sqlfy="select max(IR_number) as IR_number from ms_IR_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		$IR_number=($rowfy['IR_number']+1);
	}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px;padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Issue Return
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
                  <form name="frm_add" id="frm_add" action="" method="post" onSubmit="return;">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="33%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>Issue No.</b></td>
                    					<td align="left"><input type="hidden" id="IR_id" name="IR_id" readonly="readonly" value="<?= $IR_id ?>" /><input type="text" id="IR_number" name="IR_number" readonly="readonly" value="<?=$IR_number?>" /></td>
                              <td align="left"><b>Issue Date</b></td>
                              <td align="left">
                                <input type="text" id="IR_date" name="IR_date" value="<? if($IR_date!="") echo date("d-m-Y",strtotime($IR_date)); ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.IR_date);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absmiddle" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a> 
                              </td>
														</tr>
                            <tr>
                            	<td align="left"><b>Returned By</b></td>
                              <td align="left">
                              	<input type="text" id="returned_by" name="returned_by" value="<?=$returned_by?>"/>
                              </td>
                              <td align="left"><b>Remarks</b></td>
                              <td align="left">
                                <textarea name="remarks" rows="3" cols="30" id="remarks" ><?= $remarks?></textarea>
                              </td>
                            </tr>
                          </table>
                    		</td>
                   </tr>
                    <tr>   
                      <td colspan="2">
                      	<div id="myDataBaseDiv">
                        <?
												$sql_IR="SELECT * FROM ms_IR_master mgm,ms_IR_transaction mgt WHERE mgm.IR_id=mgt.IR_id AND mgm.IR_id ='".$PageKeyValue."'";
												$res_IR=mysql_query($sql_IR);
												$countTrans=1;
												$rc_trans=mysql_num_rows($res_IR);
												if($rc_trans>0)
												{
													while($row_IR=mysql_fetch_array($res_IR))
													{
																				
														if($countTrans%2==0)
															$tableColor="#eedfdc";
														else
															$tableColor="#f8f1ef";
													?>
                          <div id="myDiv_<?=$countTrans?>">
                        		<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                        			<input name="IR_trans_id[]" id="IR_trans_id[]" type="hidden" value="<?=$row_IR['IR_transaction_id']?>" />
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center" width="8%"><b>S. No. </b></td>                               
                                <td align="center" width="10%"><b>Item No.</b></td>
                                <td align="center" width="45%"><b>Item Name</b></td>
                                <td align="center" width="10%"><b>UOM</b></td>
                                <td align="center" width="10%"><b>Ret. Qty</b></td>
                                <td align="center" width="12%"><b>Ret. Type</b></td>
                                <td align="center" width="5%"></td>                                 
                              </tr>
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center">
                                  <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans ?>" readonly="readonly" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                  <div id="div_item_no_<?= $countTrans ?>" class="getDataInDiv get_H_18_W_60"><?=$row_IR['item_id']?></div>
                                </td>
                                <td align="left" style="padding-left:5px">                                	
                                  <input name="item_name[]" id="item_name[]" type="hidden" value="<?=$row_IR['item_id']?>">
                                    <?
																		$sql_item="select * from ms_item_master where item_id='".$row_IR['item_id']."'";
																		$res_item=mysql_query($sql_item);
																		$row_item=mysql_fetch_array($res_item);
																		$str=$row_item['name'].' || Dr No.:'.$row_item['drawing_number'].' || Cat.No.: '.$row_item['catelog_number'];
                                    echo $str;
																		?>
                                </td>                               
                                <td align="center">
                                <? 
																	$id = $row_IR['item_id'];
																	$sql = "SELECT * FROM  ms_item_master where item_id = '$id'";
																	$result_item = mysql_query ($sql) or die (mysql_error());
																	$uname='';
																	if(mysql_num_rows($result_item)>0)
																	{
																		$row_item = mysql_fetch_array($result_item);
																		$sql_uom = "SELECT * FROM  ms_uom where uom_id = '".$row_item['uom_id']."'";
																		$result_uom = mysql_query ($sql_uom) or die (mysql_error());
																		if(mysql_num_rows($result_uom)>0)
																		{
																			$row_uom = mysql_fetch_array($result_uom);
																			$uname= $row_uom['name'];
																		}
																	}
																	?>
                                     
																	<div id="div_item_uom_<?= $countTrans ?>" class="getDataInDiv" style="height:18px;width:70px"><?=$uname;?></div>
                                  <!--<input name="uom[]" id="uom[]" type="text" value="" class="get_H_18_W_60"/>-->
                                </td>
                                <td align="center">
                                  <input name="return_qty[]" id="return_qty[]" value="<?= $row_IR['return_qty']?>" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                	 <select name="return_type[]" id="return_type[]" style="width:120px">
                                    <option value="0"></option>
                                    <?
																		$sql_ret="select * from ms_return_type order by return_type asc";
																		$res_ret=mysql_query($sql_ret);
																		while($row_ret=mysql_fetch_array($res_ret))
																		{
																		?>
																			<option value="<?=$row_ret['return_type_id']?>"<? if($row_IR['return_type_id']==$row_ret['return_type_id']){?> selected="selected" <? }?>><?=$row_ret['return_type']?></option>
																		<?
																		}
																	?>
                                  </select>
                                </td>
                                
                                <td class="AddMore" align="center">                                        
                                  <a href="javascript:;" onclick="overlay(<?= $PageKeyValue?>,<?=$row_IR['IR_transaction_id']?>);" title="Delete">
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
                        	<input name="IR_trans_id[]" id="IR_trans_id[]" type="hidden" value="" />
                            <tr class="text_tr" bgcolor="#f0e6e4">
                                <td align="center" width="8%"><b>S. No. </b></td>                               
                                <td align="center" width="10%"><b>Item No.</b></td>
                                <td align="center" width="45%"><b>Item Name</b></td>
                                <td align="center" width="10%"><b>UOM</b></td>
                                <td align="center" width="10%"><b>Ret. Qty</b></td>
                                <td align="center" width="12%"><b>Ret. Type</b></td>
                                <td align="center" width="5%"></td>                                
                              </tr>
                            <tr class="text_tr" bgcolor="#f0e6e4">
                               <td align="center">
                                  <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans?>" readonly="readonly" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                  <div id="div_item_no_<?= $countTrans ?>" class="getDataInDiv get_H_18_W_60"></div>
                                </td>
                                <td align="center">                                	
                                  <select name="item_name[]" id="item_name[]" style="width:95%" onChange="getItemDetailsForIssueEntry(this.value,'div_item_no_<?= $countTrans ?>','div_item_uom_<?= $countTrans ?>');return checkItem(<?= $countTrans?>,this.value);">
                                    <option value="0"></option>
                                    <?
																		$sql_item="select mi.item_id,mi.name as iname,mi.closing_stock,mi.drawing_number,mi.catelog_number,md.name as dname from ms_item_master mi,ms_machinary md where mi.machinary_id=md.machinary_id order by mi.name asc";
                                      $res_item=mysql_query($sql_item);
                                      while($row_item=mysql_fetch_array($res_item))
                                      {
                                        $str=$row_item['iname'].' || Dr No.:'.$row_item['drawing_number'].' || Cat.No.: '.$row_item['catelog_number'].' || Mach.: '.$row_item['dname'].' || Stock.: '.$row_item['closing_stock'];
                                      ?>
                                        <option value="<?=$row_item['item_id']?>"><?=$str?></option>
                                      <?
                                      }
                                    ?>
                                  </select>
                                </td>                               
                                <td align="center">
                                  <div id="div_item_uom_<?= $countTrans ?>" class="getDataInDiv" style="height:18px;width:70px"></div>
                                  <!--<input name="uom[]" id="uom[]" type="text" value="" class="get_H_18_W_60"/>-->
                                </td>
                                <td align="center">
                                  <input name="return_qty[]" id="return_qty[]" type="text" class="get_H_18_W_60"/>
                                </td>
                                <td align="center">
                                   <select name="return_type[]" id="return_type[]" style="width:120px">
                                    <option value="0"></option>
                                    <?
																		$sql_ret="select * from ms_return_type order by return_type asc";
																		$res_ret=mysql_query($sql_ret);
																		while($row_ret=mysql_fetch_array($res_ret))
																		{
																		?>
																			<option value="<?=$row_ret['return_type_id']?>"><?=$row_ret['return_type']?></option>
																		<?
																		}
																	?>
                                  </select>
                                </td>
                                <td class="AddMore" align="center">                                        
                                  <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                  <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                                  <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
                                </td>
                              </tr>
                              <tr>
                                  <td colspan="7">
                                      <div id="myDiv1"></div>
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
<? include("inc/hr_footer.php"); ?>