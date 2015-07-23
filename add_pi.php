<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				 checkString(form.elements["txt_pidate"],"PI Date",false) &&
				 checkString(form.elements["txt_buyer"],"Buyer",false)
		   );
}
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript" src="ajax/ajax-dynamic-list.js"></script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<script>
function show_reporttype(div,buyertype)
{
	var id;
	id = document.getElementById(buyertype).value;
	if(id=='Export')
	{	
		document.getElementById(div).style.display='none';
	}
	else if(id=='Domestic')	
	{
		document.getElementById(div).style.display='block';
	}	
}
</script>
<style type="text/css">
/* Big box with list of options */
	#ajax_listOfOptions{
		position:absolute;	/* Never change this one */
		width:175px;	/* Width of box */
		height:250px;	/* Height of box */
		overflow:auto;	/* Scrolling features */
		border:1px solid #333333;	/* Dark green border */
		background-color:#FFF;	/* White background color */
		text-align:left;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
		z-index:100;
	}
	#ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
		margin:1px;		
		padding:1px;
		cursor:pointer;
		font-size:0.9em;
	}
	#ajax_listOfOptions .optionDiv{	/* Div for each item in list */
		
	}
	#ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
		background-color:#EAE3E1;
		color:#333333;
		font-weight:bold;
		font-family:Verdana, Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	#ajax_listOfOptions_iframe{
		background-color:#F00;
		position:absolute;
		z-index:5;
	}
</style>
<?
if(isset($_POST["btn_del"]))
{
	$id  = $_POST["hidden_overlay"];
	
	$sql_del = "delete from ".$mysql_adm_table_prefix."pi_detail where rec_id = '$id'";
	mysql_query($sql_del) or die("Error in : ".$sql_del." : ".mysql_errno()." : ".mysql_error());
}	
?>	
<?
$msg ='';
$pi_id = '';
$pi_number = '';
$pi_date = '';
$buyer = '';
$buyer_type = '';
$confirm_flag = '';
$freesample_flag = '';
$TermsAndCondition = "";
$ReportType = "";
////////////////// ***************************** INSERT AND UPDATE PURCHASE INVOICE ************************ ///////////////////////

if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit_x']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{	
		 $pi_id = $_POST['pi_id'];
		// $pino = $_POST['txt_pino'];
		 $pidate = getDateFormate($_POST['txt_pidate'],1);
		 $buyerid = $_POST['txt_buyer_hidden'];
		 $ip = $_SERVER['REMOTE_ADDR'];
		 $confrm = isset($_POST['chk_cnfrm']) ? $_POST['chk_cnfrm'] : 0;
		 $freesample = isset($_POST['chk_freesample']) ? $_POST['chk_freesample'] : 0;
		$TermsAndCondition = $_POST['TermsAndCondition'];	
		$report_type = isset($_POST['report_type']) ? $_POST['report_type']	: 0;
		if($pi_id=="")
		{
			 $sql_ins = "insert into ".$mysql_adm_table_prefix."pi_master set 
																			 BuyerId = '$buyerid',
																			 PiDate = '$pidate',
																			 ConfirmFlag = '$confrm',
																			 FreeSampleFlag = '$freesample',
																			 TermsAndCondition = '$TermsAndCondition',
																			 ReportType = '$report_type',
																			 InsertBy = '$SessionUserType',
																			 InsertDate = now(),
																			 IpAddress = '$ip'";
		   $result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
		   $pi_id = mysql_insert_id();
		   
			$sql_a = "select * from ".$mysql_adm_table_prefix."serial_counter where CounterName = 'PurchaseInvoice'";
			$result_a = mysql_query($sql_a) or die("Error in query:".$sql_a."<br>".mysql_error().":".mysql_errno());
			$row_a = mysql_fetch_array($result_a);
			
			$counter_month = $row_a['CounterMonth'];
			$counter_yr = $row_a['CounterYear'];
			$counter_value = $row_a['CounrtValue'];
			
			$counter_yr1 = substr($counter_yr,2,2);
			$counter_yr2 = $counter_yr-1;
			$counter_prv_yr = substr($counter_yr2,2,2);
			$prifix1 = 'MP/';
			$prifix2 = 'PI/';
			$prifix3 = $counter_prv_yr."-".$counter_yr1."/";
			$prifix4 = '1000';
			$prifix5 = $prifix4+$counter_value;
			$purchinvoiceno = $prifix1.$prifix2.$prifix3.$prifix5;
			if($counter_month!=date('n'))
			{
				$counter_month = date('n');
			}
			if($counter_month=='4' and $counter_yr == date('Y'))
			{
				$counter_year = date('Y')+1;
				$counter_value = 1;
			
				$sql_b = "update ".$mysql_adm_table_prefix."serial_counter set CounrtValue = '$counter_value' , CounterYear = '$counter_year'  where CounterName = 'PurchaseInvoice'";
				$result_b = mysql_query($sql_b) or die("Error in query:".$sql_b."<br>".mysql_error().":".mysql_errno());
				
				
				$counter_yr1 = substr($counter_year,2,2);
				$counter_yr2 = $counter_year-1;
				$counter_prv_yr = substr($counter_yr2,2,2);
				$prifix1 = 'MP/';
				$prifix2 = 'PI/';
				$prifix3 = $counter_prv_yr."-".$counter_yr1."/";
				$prifix5 = $prifix4 + $counter_value;
				$purchinvoiceno = $prifix1.$prifix2.$prifix3.$prifix5;
			}
					
			$sql_1 = "update ".$mysql_adm_table_prefix."pi_master set PiNumber = '$purchinvoiceno' where rec_id = '$pi_id'";
			$result_1 = mysql_query($sql_1) or die("Error in query:".$sql_1."<br>".mysql_error().":".mysql_errno());
			
			$counter_value = $counter_value+1;
			
			$sql_b = "update ".$mysql_adm_table_prefix."serial_counter set CounrtValue = '$counter_value' , CounterMonth = '$counter_month' where CounterName = 'PurchaseInvoice'";
			$result_b = mysql_query($sql_b) or die("Error in query:".$sql_b."<br>".mysql_error().":".mysql_errno());
		   
		   
		   $flag = 1;
		
		}
		else
		{
			$sql_up = "update ".$mysql_adm_table_prefix."pi_master set 
																			 BuyerId = '$buyerid',
																			 PiDate = '$pidate',
																			 ConfirmFlag = '$confrm',
																			 TermsAndCondition = '$TermsAndCondition',
																			 ReportType = '$report_type',
																			 FreeSampleFlag = '$freesample' where rec_id = '$pi_id'";
		   $result_up = mysql_query($sql_up) or die("Error in query:".$sql_up."<br>".mysql_error().":".mysql_errno());
			
		    $flag = 1;
		}
		
		$_SESSION['no_refresh'] = $_POST['no_refresh'];	
		if($flag != 0)
		{
			echo "<script language='javascript'>";
			echo "document.location='add_pi.php?pi_id=$pi_id'";
			echo "</script>";
		}
	}
}	
?>
<?
if(isset($_GET["pi_id"]))
{
	$pi_id = $_GET["pi_id"];
	$sql_sel = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id = '$pi_id' ";
	$result_sel = mysql_query($sql_sel) or die("Error in sql : ".$sql_sel." : ".mysql_errno()." : ".mysql_error());
	while ($row_sel = mysql_fetch_array($result_sel))
	{
		$pi_number = $row_sel['PiNumber'];
		$pi_date = getDateFormate($row_sel['PiDate'],1);
		$buyer = $row_sel['BuyerId'];
		$confirm_flag = $row_sel['ConfirmFlag'];
		$freesample_flag = $row_sel['FreeSampleFlag'];
		$TermsAndCondition = $row_sel['TermsAndCondition'];
		$ReportType = $row_sel['ReportType'];
	}
}
?>
<?
if(isset($_POST['btn_submit_1_x']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$pi_detail_id = $_POST['pi_detail_id'];
		$pi_id = $_POST['pi_id'];
		$product = $_POST['txt_product'];
		$count = $_POST['txt_count'];
		$quantity = $_POST['quantity'];
		$price = $_POST['price'];
		
		if($pi_detail_id=="")
		{
			  $sql_ins = "insert into ".$mysql_adm_table_prefix."pi_detail set
																		PiId = '$pi_id',
																		ProductId = '$product',
																		CountId = '$count',
																		Quantity = '$quantity',
																		Price = '$price'";
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
		
		}
		else
		{
			$sql_up = "update ".$mysql_adm_table_prefix."pi_detail set
																		PiId = '$pi_id',
																		ProductId = '$product',
																		CountId = '$count',
																		Quantity = '$quantity',
																		Price = '$price'
																		where rec_id = '$pi_detail_id'";
			$result_up = mysql_query($sql_up) or die("Error in query:".$sql_up."<br>".mysql_error().":".mysql_errno());
		}	
		$_SESSION['no_refresh'] = $_POST['no_refresh'];	
	}
}		
?>
<?
$pi_detail_id = "";
$prdid = "";
$quantity = "";
$price = "";
$countid = "";
if(isset($_GET['pi_detail_id']))
{
	$pi_detail_id = $_GET["pi_detail_id"];
	$sql = "select * from ".$mysql_adm_table_prefix."pi_detail where rec_id = '$pi_detail_id' ";
	$result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
	while ($row=mysql_fetch_array($result))
	{
		$pi_id = $row['PiId'];
		$quantity = $row['Quantity'];
		$price = $row['Price'];
		$prdid = $row['ProductId'];
		$countid = $row['CountId'];
	}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Purchase Invoice</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:5px;">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                         </tr>
                                        <tr>
                                            <td align="center" valign="top" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                <table align="center" width="70%" cellpadding="0" cellspacing="0" border="0">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_addpi" id="frm_addpi" action="" method="post" onsubmit="return validate_form(this);">
                                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0">
                                                                <!--<tr>
                                                                    <td align="left" style="padding-left:25px;">PI No</td>
                                                                    <td align="left"><input type="text" name="txt_pino" id="txt_pino" value="<?=$pi_number?>" /></td>
                                                                </tr>-->
                                                                <tr>
                                                                    <td width="11%" align="left" class="text_1"><b>PI Date</b></td>
                                                                  <td width="31%" align="left">
                                                                    <input type="text" name="txt_pidate" id="txt_pidate" value="<?=$pi_date?>" style="width:150px; height:22px;"/>
                                                                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_addpi.txt_pidate);return false;" HIDEFOCUS>
                                                                          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>                                            						</td>
                                                                  <td width="13%" align="left" class="text_1"><b>Buyer Name</b></td>
                                                                  <td width="45%" align="left"><input type="text" name="txt_buyer" id="txt_buyer" value="<?=getBuyer('BuyerName','rec_id',$buyer)?>" onkeyup="ajax_showOptions(this,'getBuyerByLetters',event)" onblur="show_reporttype('div_report','txt_buyer_type_hidden')"  autocomplete="off" style="width:150px; height:22px;"/>
                                                                    <input type="hidden" id="txt_buyer_hidden" name="txt_buyer_hidden" value="<?=$buyer?>">
                                                                    <input type="hidden" id="txt_buyer_type_hidden" name="txt_buyer_type_hidden" value="<?=$buyer_type?>">
						                                            </td>
                                                              </tr>
                                                                <tr>
                                                                	<td align="center" class="text_1" colspan="4"><b>Confirmed</b>&nbsp;&nbsp;<input type="checkbox" name="chk_cnfrm" id="chk_cnfrm" value="1" <? if($confirm_flag=='1'){?> checked="checked"<? } ?> />&nbsp;&nbsp;<b>Free Sample</b>&nbsp;&nbsp;<input type="checkbox" name="chk_freesample" id="chk_freesample" value="1" <? if($freesample_flag=='1'){?> checked="checked"<? } ?> /></td>
                                                                </tr> 
                                                                <tr>
                                                                	<td align="center" class="text_1" colspan="4">
                                                                    <div id="div_report" style="display:none;">
                                                                    <b>Exmill</b>	<input type="radio" name="report_type" id="report_type" value="exmill" <? if($ReportType=='exmill'){?> checked="checked"<? }?> />&nbsp;<b>Net</b><input type="radio" name="report_type" id="report_type" value="net" <? if($ReportType=='net'){?> checked="checked"<? }?>/>
                                                                   
                                                                    </div>
                                                                    </td>
                                                                </tr>    
                                                                <tr>
                                                                	<td colspan="3" align="center" class="text_1" valign="top">
                                                                    	<b>Terms & Condition  </b>
                                                                    </td>
                                                                    <td>    
                                                                    	<textarea id="TermsAndCondition" name="TermsAndCondition" cols="50" rows="5"><?=$TermsAndCondition?></textarea>
                                                                    </td>
                                                                </tr>   
                                                                <tr>
                                                                    <td colspan="4" align="center">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input name="pi_id" type="hidden" id="pi_id" value="<?=$pi_id?>" />
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="Next" />
						                                            </td>
                                                                </tr>      
                                                            </table>
                                                            </form>
						                                </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        	<?
											if(isset($_GET["pi_id"]))
											{
												$pi_id = $_GET["pi_id"];
											?>
                                        <tr>
                                        	<td align="center" valign="top" style="padding-top:5px;">
                                            	<table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #CCCCCC;">
                                                    <tr>
                                                        <td align="center">
                                                            <form name="frm_pidetail" id="frm_pidetail" action="add_pi.php?pi_id=<?=$pi_id?>" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" style="border:#CCCCCC solid 1px;" border="0">
                                                                <tr bgcolor="#EAE3E1" class="text_1">
                                                                    <td width="22%" style="padding-left:10px;"><b>Product</b></td>
                                                                    <td width="21%"><b>Count</b></td>
                                                                    <td width="19%"><b>Quantity</b></td>
                                                                    <td width="20%"><b>Price</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left" style="padding-left:10px" width="22%">
                                                                        <div id="div_product">
																		<?    
                                                                            $sql_prd = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
                                                                            $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());
                                                                        ?>    
                                                                            <select name="txt_product" id="txt_product" style="width:150px;" onChange="get_frm('get_pi_count.php',this.value,'div_count','txt_count');">
                                                                                <option value="">--select--</option>
                                                                            <? 
                                                                            while ($row_prd = mysql_fetch_array($result_prd))
                                                                            {
                                                                            ?>
                                                                                <option value="<?=$row_prd['rec_id']?>"<? if($row_prd['rec_id']==$prdid){?> selected="selected"<? }?>>
                                                                                <?=$row_prd["ProductName"]?>
                                                                                </option>
                                                                            <?
                                                                            }
                                                                            ?>
                                                                            </select> 
                                                                        </div>                                            
                                                                    </td>
                                                                    <td align="left" width="21%">
                                                                        <div id="div_count">
                                                                    <?
                                                                        $sql_count = "select * from ".$mysql_adm_table_prefix."count_master where ProductId = '$prdid'";
                                                                        $result_count = mysql_query ($sql_count) or die ("Error in : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
                                                                    ?>    
                                                                        <select name="txt_count" id="txt_count" style="width:150px;">
                                                                                <option value="">--select--</option>
                                                                                <? 
                                                                                while ($row_count = mysql_fetch_array($result_count))
                                                                                {
                                                                                ?>
                                                                                    <option value="<?=$row_count['rec_id']?>"<? if($row_count['rec_id']==$countid){?> selected="selected"<? } ?>>
                                                                                    <?=$row_count["Count"]?>
                                                                                    </option>
                                                                                <?
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                     </td>
                                                                     <td align="left" width="19%">
                                                                         <input type="text" name="quantity" id="quantity" value="<?=$quantity?>" style="width:120px;"/>                                             </td>
                                                                     <td align="left" width="20%">
                                                                        <input type="text" name="price" id="price"  value="<?=$price?>" style="width:120px;"/>                                             </td>          
                                                                 </tr>
                                                                 <tr>
                                                                      <td colspan="6" align="center" style="border-top:5px solid #FFFFFF; padding:3px; background-color:#F5F2F1;">
                                                                        <input name="pi_id" type="hidden" id="pi_id" value="<?=$pi_id?>" />
                                                                        <input name="pi_detail_id" type="hidden" id="pi_detail_id" value="<?=$pi_detail_id?>" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit_1" id="btn_submit_1" value="Submit"/>                                              </td>
                                                                 </tr>		         
                                                            </table>
                                                            </form>
                                                        </td>
                                                   </tr>
                                                   <tr>
                                                        <td style="padding-top:10px" align="center">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                              <tr class="gredBg">
                                                                <td width="16%" align="center"><b>Product</b></td>
                                                                <td width="15%" align="center"><b>Count</b></td>
                                                                <td width="12%" align="center"><b>Quantity</b></td>
                                                                <td width="11%" align="center"><b>Price</b></td>
                                                                <td width="12%" align="center"><b>Total</b></td>
                                                                <td width="10%" align="center"><b>Edit</b></td>
                                                                <td width="10%" align="center"><b>Dalete</b></td>
                                                              </tr>
                                                              <?
                                                            $sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '$pi_id'";
                                                            $result_detail = mysql_query($sql_detail) or die("Error in sql : ".$sql_detail." : ".mysql_errno()." : ".mysql_error());
                                                            $total = 0;
                                                                $sno = 1;
                                                            while ($row_detail=mysql_fetch_array($result_detail))
                                                            {    
                                                                    
                                                           ?>
                                                              <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                <td align="center"><?=getProduct('ProductName','rec_id',$row_detail["ProductId"])?></td>
                                                                <td align="center"><?=getCount('Count','rec_id',$row_detail["CountId"])?></td>
                                                                <td align="center"><?=$row_detail["Quantity"]?></td>
                                                                <td style="text-align:right; padding-right:10px;"><?=$row_detail["Price"]?></td>
                                                                <td style="text-align:right; padding-right:10px;"><?=number_format($row_detail["Quantity"] * $row_detail["Price"],2)?></td>
                                                                <td align="center" style="padding-top:5px;">
                                                                <a href="add_pi.php?pi_id=<?=$pi_id?>&pi_detail_id=<?=$row_detail["rec_id"]?>"><img src="images/Modify.png" border="0" /></a>
                                                                </td>
                                                                <td align="center" style="padding-top:5px;">
                                                                	<a href="javascript:;" onclick="overlay(<?=$row_detail["rec_id"]?>);"><img src="images/Delete.png" border="0" /></a>
                                                                </td>
                                                              </tr>
                                                              <?
                                                                $sno++;
                                                                $total = $total + $row_detail["Quantity"] * $row_detail["Price"];
                                                            }
                                                          ?>
                                                              <tr class="text_1">
                                                                <td align="right" colspan="4" style="padding-right:10px;"><strong>Total</strong> </td>
                                                                <td class="Text01" style="text-align:right; padding-right:10px;"><strong>
                                                                  <?=number_format($total,2)?>
                                                                </strong> </td>
                                                                <td>&nbsp;</td>
                                                              </tr>
                                                            </table>
                                                  		</td>
                                                   </tr>            
                                                <?
                                                  }
                                                 ?> 	
                                               </table>
                                          </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                        </table> 
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div id="overlay">
     <div id="msgbox">
          <p>Are you sure to delete Product</p>
		  <form name="frm_del" action="" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>  
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? 
include("inc/footer.php");
?>