<? include("inc/store_header.php"); ?>
<style>
.getDataInDiv{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
.get_H_18_W_70{
	height:18px;
	width:70px;
}
.ajax_listOfOptions{
	
	left:400px;
	/*width:550px;	 Width of box */
	
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
	myTable +="<input name='IE_trans_id[]' id='IE_trans_id[]' type='hidden' value='' />";
  myTable +="<tr class='text_tr' bgcolor='"+tableColor+"'><td align='center' width='8%'><b>S. No. </b></td><td align='center' width='8%'><b>Item No.</b></td><td align='center' width='52%'><b>Item Name</b></td><td align='center' width='12%'><b>UOM</b></td><td align='center' width='8%'><b>Stk. Qty</b></td><td align='center' width='8%'><b>Iss. Qty</b></td><td align='center' width='4%'></td>  </tr>";
  myTable +="<tr class='text_tr' bgcolor='"+tableColor+"'>";
	myTable += "<td align='center'><input name='sno[]' id='sno[]' type='text' value='"+num+"' readonly='readonly' class='get_H_18_W_70'/></td>";
	myTable += "<td align='center'><input type='text' id='item_no_"+num+"' name='item_id[]' class='get_H_18_W_70'/></td>";
	myTable += "<td align='center'><input type='text' name='item_name[]' id='item_name"+num+"' onKeyUp=\"ajax_showOptions(this.value,'"+num+"','store_ajax_list_item.php',event,2)\" onFocus=\"ajax_showOptions(this.value,'"+num+"','store_ajax_list_item.php',event,2)\" autocomplete='off'  class='itemText' value='' style='width:98%;' /><div id='ajax_listOfOptions_"+num+"' class='ajax_listOfOptions'></div></td>";
	
  
	myTable += "<td align='center'><div id='div_item_uom_"+num+"' style='height:18px;width:70px;' class='getDataInDiv'></div></td>";
  myTable += "<td align='center'><input id='stk_qty_"+num+"' name='stk_qty[]' readonly='readonly' class='get_H_18_W_70' type='text' /></td>";
	//myTable += "<td align='center'><input name='req_qty[]' id='req_qty[]' type='text' class='get_H_18_W_70'/></td>";
  myTable += "<td align='center'><input name='iss_qty[]' id='iss_qty_"+num+"' type='text' class='get_H_18_W_70' onkeyup=\"return validateQuantity(event,this.value,"+num+",'')\" autocomplete='off'/></td>";
  
	
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
function validateQuantity(e,qty,no,oldIssQty)
{
	var status=true;
	//var qty=document.getElementById(thisid).value;
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	var stk_id="stk_qty_"+no;
	var thisid="iss_qty_"+no;
	var stk_qty=document.getElementById(stk_id).value;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		if(Number(qty)>(Number(stk_qty)+Number(oldIssQty)))
		{
			alert("Issue quantity can not more than Stock Quantity.");
			document.getElementById(thisid).value='';
			document.getElementById(thisid).focus();
			status=false;
			document.getElementById('btn_submit').disabled=true;
		}
		else
		{
			document.getElementById('btn_submit').disabled=false;
		}
	}
	return status;
}
</script>
<?
$Page = "store_add_issue_entry.php";
$PageTitle = "Add Issue Entry";
$PageFor = "Issue Entry";
$PageKey = "IE_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
	/*$sql_idate="select * from ms_IE_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
		echo "<script>alert('You Cant Update Here');location.href='store_homepage.php';</script>";
	}*/
}

//////////////////////////////////////////////////////////
$issue_id='';$purpose='';$issue_date='';$issue_number='';
$item_id='';$stk_qty='';$req_qty='';$iss_qty='';$department_id='';
$issue_number='';
if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_IE_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$purpose=stripslashes($row['purpose']);
		$issue_date=getDateFormate($row['IE_date']);		
	}
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$sql_I="select mim.closing_stock,mim.item_id,mit.iss_qty from ms_item_master mim,ms_IE_transaction mit where mit.IE_transaction_id='".$PageKeyValueTrans."' and mim.item_id=mit.item_id";
	$res_I=mysql_query($sql_I);
	$row_I=mysql_fetch_array($res_I);
	
	$total_qty=(float)$row_I['closing_stock']+(float)$row_I['iss_qty'];
	$sql_U="update ms_item_master set closing_stock='".$total_qty."' where item_id='".$row_I['item_id']."'";
	mysql_query($sql_U);
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql = "delete from ms_IE_transaction where IE_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "Issue Entry Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"])){
		//$PageKeyValue = $_POST[$PageKey];
		if($_POST['issue_date']=="")
			$issue_date=date("Y-m-d");
		else
			$issue_date=getDateFormate($_POST['issue_date']);
		$purpose=addslashes($_POST['purpose']);
		$issue_number=addslashes($_POST['issue_number']);
	
		if($PageKeyValue == ""){
			$tableName="ms_IE_master";
			$tableData=array("''","'$issue_number'","'$issue_date'","'$purpose'","now()","'$gFinYear'");
			addDataIntoTable($tableName,$tableData);
			$issue_id=mysql_insert_id();
			for($i=0;$i<sizeof($_POST["sno"]);$i++)
			{
				if($_POST['item_id'][$i]!='' && $_POST['item_id'][$i]!='0')
				{
					$item_id=$_POST['item_id'][$i];
					$stk_qty=$_POST['stk_qty'][$i];
					$iss_qty=$_POST['iss_qty'][$i];
					if($stk_qty < $iss_qty){
						echo 'stop'; 
					}else{
					///////////////// Update Table Item Master ///////////////
						$total_qty=(float)$stk_qty-(float)$iss_qty;
						mysql_query("update ms_item_master set closing_stock='".$total_qty."' where item_id='".$item_id."'");
					}
				  ////////////////////////// End //////////////////////////
					$tableData=array("''","'$issue_id'","'$item_id'","'$iss_qty'","'$issue_date'","now()","'$gFinYear'");
					//print_r($tableData);
					addDataIntoTable("ms_IE_transaction",$tableData);		
				}
		}
		$Message = "$PageFor Inserted";	
		redirect("$Page?Message=$Message");
	}	
	else
	{
		if($mode == "edit")
		{	
			$tableName="ms_IE_master";
			$tableColumns=array("$PageKey","IE_date","purpose");
			$tableData=array("'$PageKeyValue'","'$issue_date'","'$purpose'");
			
			if(updateDataIntoTable($tableName,$tableColumns,$tableData))
			{
				$tableColumns=array("IE_transaction_id","$PageKey","item_id","iss_qty");
				for($i=0;$i<sizeof($_POST["sno"]);$i++)
				{
					if($_POST['item_id'][$i]!='' && $_POST['item_id'][$i]!='0')
					{
						$IE_trans_id=$_POST['IE_trans_id'][$i];
						$item_id=$_POST['item_id'][$i];
						$stk_qty=$_POST['stk_qty'][$i];
						$iss_qty=$_POST['iss_qty'][$i];
						///////////////// Update Table Item Master ///////////////
						$res1=mysql_query("select * from ms_IE_transaction where IE_transaction_id='".$IE_trans_id."'");
						$row1=mysql_fetch_array($res1);
						$total_qty=0;
						$total_qty=(float)$stk_qty+(float)$row1["iss_qty"]-(float)$iss_qty;//$total_qty=$stk_qty+$old_iss_qty-$iss_qty;
						mysql_query("update ms_item_master set closing_stock='".$total_qty."' where item_id='".$item_id."'");
						//////////////////////////////////////////////////////////
						if($IE_trans_id!="")
						{
							$tableData=array("'$IE_trans_id'","'$PageKeyValue'","'$item_id'","'$iss_qty'");
							updateDataIntoTable("ms_IE_transaction",$tableColumns,$tableData);	
						}
						else
						{
							$tableData=array("''","'$PageKeyValue'","'$item_id'","'$iss_qty'","now()");
							addDataIntoTable("ms_IE_transaction",$tableData);	
						}
					}
				}		
				$Message = "$PageFor Updated";
				redirect("store_list_issue_entry.php?Message=$Message");
			}
		}	
		
	}	
	
}

if(isset($_GET["IE_id"]))
{
	$issue_id = $_GET["IE_id"];
}
else
{
	$sql="select max(IE_id) as IE_id from ms_IE_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$issue_id=($row['IE_id']+1);

	$sqlf="select finYear from ms_IE_master where IE_id = '".$row['IE_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$issue_number =1;
	}else{
		$sqlfy="select max(IE_number) as IE_number from ms_IE_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		print_r($rowfy);
		$issue_number=($rowfy['IE_number']+1);
	}

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
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Issue Entry
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
                  <form name="frm_add" id="frm_add" action="" method="post">
                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr>
                    					<td align="left"><b>Issue Entry No.</b></td>
                    					<td align="left"><input type="text" id="issue_number" name="issue_number" readonly="readonly" value="<?= $issue_number?>" /><input type="hidden" id="issue_id" name="issue_id" readonly="readonly" value="<?= $issue_id ?>" /></td>
                              <td align="left"><b>Issue Entry Date</b></td>
                              <td align="left">
                                <input type="text" id="issue_date" name="issue_date" value="<?=$issue_date ?>" />
                                <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_add.issue_date);return false;" HIDEFOCUS>
                                      <img name="popcal" align="absmiddle" src="calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                              	</a> 
                              </td>
														</tr>
                            <tr>
                              <td align="left"><b>Purpose</b></td>
                              <td align="left" colspan="3">
                                <textarea name="purpose" rows="3" cols="35" id="purpose" ><?= $purpose?></textarea>
                              </td>
                            </tr>
                          </table>
                    		</td>
                   		</tr>
                    	<tr>   
                        <td>
                          <div id="myDataBaseDiv">
                          <?
                          $sql_IE_trans="SELECT * FROM ms_IE_master mgm,ms_IE_transaction mgt WHERE mgm.IE_id=mgt.IE_id AND mgm.IE_id ='".$PageKeyValue."'";
                          $res_IE_trans=mysql_query($sql_IE_trans);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_IE_trans);
                          if($rc_trans>0)
                          {
                            while($row_IE_t=mysql_fetch_array($res_IE_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                            ?>
                            <div id="myDiv_<?=$countTrans?>">
                              <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                <input name="IE_trans_id[]" id="IE_trans_id[]" type="hidden" value="<?=$row_IE_t['IE_transaction_id']?>" />
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center" width="8%"><b>S. No. </b></td>                               
                                  <td align="center" width="8%"><b>Item No.</b></td>
                                  <td align="center" width="52%"><b>Item Name</b></td>
                                  <td align="center" width="12%"><b>UOM</b></td>
                                  <td align="center" width="8%"><b>Stk. Qty</b></td>
                                  <td align="center" width="8%"><b>Iss. Qty</b></td>                                  
                                  <td align="center" width="4%"></td>  
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center">
                                    <input name="sno[]" id="sno[]" type="text" value="<?=$countTrans ?>" readonly="readonly" class="get_H_18_W_70"/>
                                  </td>
                                  <td align="center">
                                    <input type="text" id="item_no_<?= $countTrans ?>" name="item_id[]" value="<?=$row_IE_t['item_id']?>" class="get_H_18_W_70"/>
                                  </td>
                                  <td align="left" style="padding-left:3px">                                	
                                    <?
																		$sql_item="select * from ms_item_master where item_id='".$row_IE_t['item_id']."'";
																		$res_item=mysql_query($sql_item);
																		$row_item=mysql_fetch_array($res_item);
																		$str=$row_item['name'].' || Dr No.:'.$row_item['drawing_number'].' || Cat.No.: '.$row_item['catelog_number'];
                                    echo $str;
																		?>
                                	</td>
                                  <td align="center">
                                  <? 
                                    $id = $row_IE_t['item_id'];
                                    $sql = "SELECT * FROM  ms_item_master where item_id = '$id'";
                                    $result_item = mysql_query ($sql) or die (mysql_error());
                                    $uname='';
                                    $row_item = mysql_fetch_array($result_item);
                                    $uom_id=$row_item['uom_id'];
                                    $closing_stk=$row_item['closing_stock'];
                                    $sql_uom="SELECT name as uname FROM ms_uom where uom_id='".$uom_id."'";
                                    $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                    if(mysql_num_rows($result_uom)>0)
                                    {
                                      $row_uom = mysql_fetch_array($result_uom);
                                      $uname= $row_uom['uname'];
                                    }
                                    ?>
                                    <div id="div_item_uom_<?= $countTrans ?>" class="getDataInDiv" style="height:18px;width:70px"><?=$uname;?></div>
                                  </td>
                                  <td align="center">
                                    <input name="stk_qty[]" id="stk_qty_<?= $countTrans?>" value="<?= $closing_stk?>" type="text" class='get_H_18_W_70' readonly="readonly"/>
                                  </td>
                                  <td align="center">
                                    <input name="iss_qty[]" id="iss_qty_<?= $countTrans?>" value="<?= $row_IE_t['iss_qty']?>" onKeyUp="return validateQuantity(event,this.value,<?= $countTrans?>,<?= $row_IE_t['iss_qty']?>)" type="text" class="get_H_18_W_70" autocomplete="off"/>
                                  </td>
                                  <td class="AddMore" align="center">                                        
                                    <a href="javascript:;" onClick="overlay(<?= $PageKeyValue?>,<?=$row_IE_t['IE_transaction_id']?>);" title="Delete">
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
                            <input name="IE_trans_id[]" id="IE_trans_id[]" type="hidden" value="" />
                              <tr class="text_tr" bgcolor="#f0e6e4">
                              	<td align="center" width="8%"><b>S. No. </b></td>                               
                                <td align="center" width="8%"><b>Item No.</b></td>
                                <td align="center" width="52%"><b>Item Name</b></td>
                                <td align="center" width="12%"><b>UOM</b></td>
                                <td align="center" width="8%"><b>Stk. Qty</b></td>
                                <td align="center" width="8%"><b>Iss. Qty</b></td>                                  
                                <td align="center" width="4%"></td>                             
                              </tr>
                              <tr class="text_tr" bgcolor="#f0e6e4">
                                 <td align="center"><input name="sno[]" id="sno[]" type="text" value="<?=$countTrans?>" readonly="readonly" class="get_H_18_W_70"/></td>
                                  <td align="center">
                                  	<input type="text" id="item_no_<?= $countTrans ?>" name="item_id[]" class="get_H_18_W_70"/>
                                  </td>
                                  <td align="center">                                	
                                    <input type="text" name="item_name[]" id="item_name<?= $countTrans?>" onKeyUp="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,2)" onFocus="ajax_showOptions(this.value,'<?= $countTrans?>','store_ajax_list_item.php',event,2)" autocomplete="off"  class="itemText" value="" style="width:98%;" />
                                  <div id="ajax_listOfOptions_<?= $countTrans?>" class="ajax_listOfOptions"></div>
                                  </td>                               
                                  <td align="center">
                                   <div id="div_item_uom_<?= $countTrans ?>" class="getDataInDiv" style="height:18px;width:70px"></div>
                                  </td>
                                  <td align="center">
                                    <input type="text" id='stk_qty_<?= $countTrans ?>' name="stk_qty[]" class='get_H_18_W_70' readonly="readonly"/>
                                  </td>
                                  <td align="center">
                                    <input name="iss_qty[]" id="iss_qty_<?= $countTrans ?>" type="text" class="get_H_18_W_70" onKeyUp="return validateQuantity(event,this.value,<?= $countTrans?>,'')" autocomplete="off"/>
                                  </td>
                                  <td class="AddMore" align="center">
                                    <input type="hidden" name="h_hidden" id="h_hidden" value="<?= $countTrans ?>"/> 
                                    <a href="javascript:;" onClick="addElement();" title="Add More Rows">
                                    <img src="images/add_icon.jpg" alt="Add" border="0" align="absmiddle"/></a>
                                  </td>
                                </tr> 
                                <tr>
                                    <td colspan="8">
                                        <div id="myDiv1"></div>
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