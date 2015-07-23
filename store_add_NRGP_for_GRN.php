<? 
include("inc/store_header.php");
?>
<style>
.getDataInDiv
{
	background:#fff;
	border:1px solid #96A2BC;
	overflow:hidden;
}
.get_H_18_W_60
{
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
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
function getRGPTransactionData(GRN_id, divID, Page)
{
	var url=Page+"?GRN_id="+GRN_id+"&sid="+Math.random();
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
function checkQuantity(e,thisid,divPending,rgp_qty1,old_qty)
{
	var status=true;
	var qty1=document.getElementById(thisid).value;
	
	qty1=Number(qty1);
	rgp_qty1+=Number(old_qty);
  //alert(qty1+','+rgp_qty1+','+old_qty);
	var charCode='';
	if(window.event) // IE
		charCode = e.keyCode;
	else if(e.which) // Netscape/Firefox/Opera
		charCode = e.which;
	if(charCode!=37 && charCode!=38 && charCode!=39 && charCode!=40 && charCode!=13)
	{
		if(Number(qty1)>Number(rgp_qty1))
		{
			alert("NRGP quantity can not more than GRN Quantity.");
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
<script type="text/javascript">
</script>
<?
$Page = "store_add_NRGP_for_GRN.php";
$PageTitle = "Add NRGP";
$PageFor = "NRGP";
$PageKey = "NRGP_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
	$sql_idate="select * from ms_NRGP_master where insert_date='".date('Y-m-d')."' and $PageKey='".$_GET[$PageKey]."'";
	$res_idate=mysql_query($sql_idate);
	if(mysql_num_rows($res_idate)==0 && !($SessionUserType=='Administrator'))
	{
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
		$GRN_id=$row['GRN_id'];
		$supplier_id=$row['supplier_id'];
		$ref_quot_no=$row['ref_quot_no'];	
		$ref_quot_date=$row['ref_quot_date'];
		$despatch_through=$row['despatch_through'];
		$special_instr=stripslashes($row['special_instr']);
	}
}

if(isset($_POST["btn_delete"]))
{
	$PageKeyValueTrans  = $_POST["hidden_overlay"];
	$PageKeyValue = $_POST["hidden_overlay_master"];
	$sql_rgt="select  mim.closing_stock,mim.item_id,mgt.GRN_transaction_id,mgt.NRGP_qty as GRN_NRGP_qty, mngt.NRGP_qty as NRGP_qty from ms_item_master mim,ms_GRN_transaction mgt,ms_NRGP_GRN_transaction mngt where mngt.NRGP_transaction_id= '".$PageKeyValueTrans."' and mim.item_id=mngt.item_id and mngt.GRN_transaction_id=mgt.GRN_transaction_id";
	$res_rgt=mysql_query($sql_rgt);
	$row_rgt=mysql_fetch_array($res_rgt);
	$total_stock=$row_rgt['closing_stock']+$row_rgt['NRGP_qty'];
	$total_GRN=$row_rgt['GRN_NRGP_qty']+$row_rgt['NRGP_qty'];
	$GRN_transaction_id=$row_rgt['GRN_transaction_id'];$item_id=$row_rgt['item_id'];
	$sql="update ms_GRN_transaction set NRGP_qty='".$total_GRN."'where GRN_transaction_id='".$GRN_transaction_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$sql="update ms_item_master set closing_stock='".$total_stock."'where item_id='".$item_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$sql = "delete from ms_NRGP_GRN_transaction where NRGP_transaction_id = '".$PageKeyValueTrans."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$Message = "NRGP Transaction Row Sucessfully Deleted";
	$UrlPage=$Page."?".$PageKey."=".$PageKeyValue."&mode=edit";
	redirect("$UrlPage");//redirect("$Page?Message=$Message");
}

if(isset($_POST["btn_submit"])){
	$NRGP_date=getDateFormate($_POST['NRGP_date']);
	$supplier_id=$_POST['supplier_id'];
	$GRN_id=$_POST['GRN_id'];
$NRGP_number=$_POST['NRGP_number'];
	$NRGP_type=$_POST['NRGP_type'];
	$ref_quot_no=$_POST['ref_quot_no'];	
	$ref_quot_date=getDateFormate($_POST['ref_quot_date']);
	$despatch_through=$_POST['despatch_through'];
	$special_instr=addslashes($_POST['special_instr']);
	if($PageKeyValue == "")
	{
		$tableName="ms_NRGP_master";
		$tableData=array("''","'$NRGP_number'","'$NRGP_date'","'$supplier_id'","'$ref_quot_no'","'$ref_quot_date'","'$GRN_id'","'$despatch_through'","'$special_instr'","now()","'$gFinYear'");
			
		if(addDataIntoTable($tableName,$tableData))
		{
			$insert_id=mysql_insert_id();
			for($i=0;$i<sizeof($_POST["item_id"]);$i++)
			{
				if($_POST['NRGP_qty'][$i]!='')
				{
					$GRN_trans_id=$_POST['GRN_trans_id'][$i];
					$item_id=$_POST['item_id'][$i];
					$remarks=$_POST['remarks'][$i];
					$NRGP_qty=$_POST['NRGP_qty'][$i];
					$remain_qty=$_POST['remain_qty'][$i];
					$rate=$_POST['rate'][$i];
					////////////////Item Update ////////////
					$res_S=mysql_query("select * from ms_item_master where item_id='".$item_id."'");
					$row_S=mysql_fetch_array($res_S);
					$total=0;
					$total=(float)$row_S['closing_stock']-(float)$NRGP_qty;
					$sql_U="update ms_item_master set closing_stock='".$total."' where item_id='".$item_id."'";
					mysql_query($sql_U);
					/////////GRN Update //////
					$sql_U="update ms_GRN_transaction set NRGP_qty='".$remain_qty."' where GRN_transaction_id='".$GRN_trans_id."'";
					mysql_query($sql_U);
					/////////////////////End Updates //////////
					$tableData=array("''","'$insert_id'","'$GRN_trans_id'","'$item_id'","'$remarks'","'$NRGP_qty'","'$rate'","now()");
					addDataIntoTable("ms_NRGP_GRN_transaction",$tableData);		
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
				$tableColumns=array("NRGP_transaction_id","$PageKey","GRN_transaction_id","item_id","remarks","NRGP_qty","rate");
				for($i=0;$i<sizeof($_POST["sno"]);$i++)
				{
					if($_POST['NRGP_qty'][$i]!='')
					{
						$NRGP_trans_id=$_POST['NRGP_trans_id'][$i];
						$GRN_trans_id=$_POST['GRN_trans_id'][$i];
						$item_id=$_POST['item_id'][$i];
						$remarks=$_POST['remarks'][$i];
						$NRGP_qty=$_POST['NRGP_qty'][$i];
						$remain_qty=$_POST['remain_qty'][$i];
						$rate=$_POST['rate'][$i];
						$tableData=array("'$NRGP_trans_id'","'$PageKeyValue'","'$GRN_trans_id'","'$item_id'","'$remarks'","'$NRGP_qty'","'$rate'");
						//print_r($tableData);echo "<br />";
						/// NRGP ///
						$resN=mysql_query("select * from ms_NRGP_transaction where NRGP_transaction_id='".$NRGP_trans_id."'");
						$rowN=mysql_fetch_array($resN);
						$old_NRGP_qty=$rowN['NRGP_qty'];
						///////////
						////////////////Item Update ////////////
						$res_S=mysql_query("select * from ms_item_master where item_id='".$item_id."'");
						$row_S=mysql_fetch_array($res_S);
						$total=0;$total=(float)$row_S['closing_stock']+(float)$old_NRGP_qty-(float)$NRGP_qty;
						$sql_U="update ms_item_master set closing_stock='".$total."' where item_id='".$item_id."'";
						mysql_query($sql_U);
						/////////GRN Update //////
						$sql_U="update ms_GRN_transaction set NRGP_qty='".$remain_qty."' where GRN_transaction_id='".$GRN_trans_id."'";
						mysql_query($sql_U);
						/////////////////////End Updates //////////
						updateDataIntoTable("ms_NRGP_GRN_transaction",$tableColumns,$tableData);	
					}
				}	
				$Message = "$PageFor Updated";
				redirect("store_list_NRGP_for_GRN.php?Message=$Message");
			}
		}	
		
	}	
}
if(isset($_GET["NRGP_id"]))
{
	$NRGP_id = $_GET["NRGP_id"];
}
else
{
	$sql="select max(NRGP_id) as NRGP_id from ms_NRGP_master";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$NRGP_id=($row['NRGP_id']+1);
		
	$sqlf="select finYear from ms_NRGP_master where NRGP_id = '".$row['NRGP_id']."'";
	$resf=mysql_query($sqlf);
	$rowf=mysql_fetch_array($resf);
	if($rowf['finYear'] != $gFinYear){
		$NRGP_number=1;
	}else{
		$sqlfy="select max(NRGP_number) as indent_number from ms_NRGP_master where finYear = '".$gFinYear."'";
		$resfy=mysql_query($sqlfy);
		$rowfy=mysql_fetch_array($resfy);
		$NRGP_number=($rowfy['NRGP_number']+1);
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
                    					<td align="left"><input type="hidden" id="NRGP_id" name="NRGP_id" readonly="readonly" value="<?= $NRGP_id ?>" /><input type="text" id="NRGP_number" name="NRGP_number" readonly="readonly" value="<?=$NRGP_number?>" /></td>
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
                             <tr>
                              <td align="left"><b>GRN. No.</b></td>
                              <td align="left" colspan="3">
                              <?
															if($mode=='edit')
															{
																echo '<b>'.$GRN_id.'</b>';
																echo "<input type='hidden' id='GRN_id' name='GRN_id' value='".$GRN_id."' />";
															}
															else
															{
															?>
                               <select name="GRN_id" id="GRN_id" style="height:20px;width:100px" onchange="getRGPTransactionData(this.value,'myDataBaseDiv','store_get_GRN_transaction.php')">
                                <option value="0"></option>
                                <?
                                $sql_G="select distinct mrm.GRN_id from ms_GRN_master mrm,ms_GRN_transaction mrt where mrm.GRN_id=mrt.GRN_id and mrt.NRGP_qty<>0 order by mrm.GRN_id asc";
                                $res_G=mysql_query($sql_G);
                                while($row_G=mysql_fetch_array($res_G))
                                {
                                ?>
                                  <option value="<?=$row_G['GRN_id']?>"><?=$row_G['GRN_id']?></option>
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
                        <td width="100%">
                          <div id="myDataBaseDiv">
                          <?
                          $sql_RM="SELECT * FROM ms_NRGP_master mgm,ms_NRGP_GRN_transaction mgt WHERE mgm.NRGP_id=mgt.NRGP_id AND mgm.NRGP_id ='".$PageKeyValue."'";
                          $res_RM=mysql_query($sql_RM);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_RM);
                          if($rc_trans>0)
                          {
                            while($row_t=mysql_fetch_array($res_RM))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
														$res_GRN=mysql_query("SELECT * FROM ms_GRN_transaction  WHERE GRN_transaction_id='".$row_t['GRN_transaction_id']."'");
														$row_GRN=mysql_fetch_array($res_GRN);
                            ?>
                          <input name="NRGP_trans_id[]" id="NRGP_trans_id[]" type="hidden" value="<?=$row_t['NRGP_transaction_id']?>" /> 
        									<input name="GRN_trans_id[]" id="GRN_trans_id[]" type="hidden" value="<?=$row_t['GRN_transaction_id']?>" />
													<input name="item_id[]" id="item_id[]" type="hidden" value="<?=$row_t['item_id']?>"/>
                          <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                            <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <td align="center" width="10%"><b>S. No. </b></td> 
                              <td align="center" width="40%"><b>Item Name</b></td>
                              <td align="center" width="10%"><b>Remark</b></td>
                              <td align="center" width="10%"><b>GRN Qty</b></td>
                              <td align="center" width="10%"><b>NRGP Qty</b></td>
                              <td align="center" width="10%"><b>Remaining</b></td>
                              <td align="center" width="10%"><b>Rate</b></td>                                
                            </tr>
                            <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <td align="center"><?=$countTrans?></td>
                              <td align="left" style="padding-left:5px">
                              <?
                                $sql_IT="select * from ms_item_master where item_id='".$row_t['item_id']."'";
                                $res_IT=mysql_query($sql_IT);
                                $row_IT=mysql_fetch_array($res_IT);
                                echo $row_IT['name']."; Drg No.: ".$row_IT['drawing_number'].'; Cat No. '.$row_IT['catelog_number'];
                                $uom_id=$row_IT['uom_id'];
                                ?>
                              </td>
                              <!--<td align="center"></td>-->
                              <? 
                              /*$sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$uom_id."' order by name ";
                              $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                              $row_uom = mysql_fetch_array($result_uom);
                              echo $row_uom['uname'];*/
                              ?>
                              <td align="center">
                                <input name="remarks[]" id="remarks[]" type="text" style="height:18px;width:200px" value="<?=$row_t['remarks']?>"/>
                              </td>
                              <td align="center"><?= $row_GRN['rec_qty']?></td>
                              <td align="center">
                                <input name="NRGP_qty[]" id="NRGP_qty_<?=$countTrans?>" type="text" class="get_H_18_W_60" onchange="return checkQuantity(event,'NRGP_qty_<?=$countTrans?>','remain_qty_<?=$countTrans?>',<?=$row_t['NRGP_qty']?>,<?=$row_GRN['NRGP_qty']?>)" value="<?=$row_t['NRGP_qty']?>"/>
                              </td>
                              <td align="center">
                                <input name="remain_qty[]" id="remain_qty_<?=$countTrans?>" readonly="readonly" type="text" class="get_H_18_W_60" value="<?=$row_GRN['NRGP_qty']?>"/>
                              </td>
                              <td align="center">
                                <input name="rate[]" value="<?= $row_t['rate']?>" id="rate[]" type="text" class="get_H_18_W_60"/>
                              </td>
                              <td class="AddMore" align="center">
                                <input type="hidden" name="h_hidden" id="h_hidden" value="<?=$countTrans?>"/> 
                                <a href="javascript:;" onclick="overlay(<?=$PageKeyValue?>,<?=$row_t['NRGP_transaction_id']?>)">
                                <img src="images/delete_icon.jpg" alt="Delete" border="0" align="absmiddle" title="Delete"/>
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