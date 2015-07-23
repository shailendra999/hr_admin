<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>

<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				 checkString(form.elements["DespatchAddress"],"Address",false) &&
				 checkString(form.elements["txt_freight"],"Freight",false) &&
				 checkString(form.elements["txt_date"],"Date",false)
				 
		   );
}
</script>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script>
function Despatch_Address()
{
	if(document.getElementById("cbDespatchAddress").checked)
	{
		document.getElementById("DespatchAddress").value = document.getElementById("Address").value;
	}
	else
	{
		document.getElementById("DespatchAddress").value = "";
	}
}
function show_total(qty,rate,total,count)
{
	var quantity = qty;
	var h_total_amount = 0;
	var rate = document.getElementById(rate).value;
	document.getElementById(total).value = quantity * rate;
	document.getElementById('h_total_amount').value = 0;

	for(var i = 1; i<=count; i++)
	{
		if(document.getElementById("txt_total_"+i).value !="")
		{
			document.getElementById('h_total_amount').value = parseFloat(document.getElementById('h_total_amount').value) + parseFloat(document.getElementById("txt_total_"+i).value);
		}
	}
}	
function check_quantity(qty,offeredqty,previous_quantity)
{	
	var var_qty = document.getElementById(qty).value
	var var_offeredqty = document.getElementById(offeredqty).value
	var var_previous_quantity = document.getElementById(previous_quantity).value
	if(var_qty > (var_offeredqty - var_previous_quantity))
	{
		alert("Please Insert Right Quantity");
		document.getElementById(qty).value = "";
		document.getElementById(qty).focus();
	}
}
function show_leftqty(orderqty,nowofferqty,prvqty,leftqty)
{
	var ord_qty = document.getElementById(orderqty).value
	var now_qty = parseInt(document.getElementById(nowofferqty).value)
	var prv_qty = parseInt(document.getElementById(prvqty).value)
	var a = prv_qty+now_qty;
	var b = ord_qty - a;
	document.getElementById(leftqty).value = b;
}
</script>
<script language="javascript">
function openWin (url,w,h,scroll,pos)
{
	if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}

	else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}

	//w = screen.width;
	
	//h = screen.height;

	settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';

	var mywin = window.open(url, "winImage", settings);
}
</script>
<?
$msg = '';

if(isset($_GET['id']))
{	
	$id = $_GET['id'];
	$sql_sel = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id = '$id'";  
	$result_sel = mysql_query ($sql_sel) or die ("Invalid query : ".$sql_sel."<br>".mysql_errno()." : ".mysql_error());
	$row_sel = mysql_fetch_array($result_sel);
	$rec_id = $row_sel['rec_id'];
	$pi_no = $row_sel['PiNumber'];
	$pi_date = getDateFormate($row_sel['PiDate'],1);
    $buyer = getBuyer('BuyerName','rec_id',$row_sel['BuyerId']);
	$Address = getBuyer('Address','rec_id',$row_sel['BuyerId']);
	$buyer_id = $row_sel['BuyerId'];
	$ReportType = $row_sel['ReportType'];
}                         
?>
<?
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
		$ip = $_SERVER['REMOTE_ADDR'];
		$buyerd = $_POST['buyer_id'];
		$DespatchAddress = $_POST['DespatchAddress'];
		$despatch_date = getDateFormate($_POST['txt_date'],1);
		$txt_transport = $_POST['txt_transport'];
		$txt_vechile = $_POST['txt_vechile'];
		
		
		$txt_lrdate = isset($_POST['txt_lrdate']) ? getDateFormate($_POST['txt_lrdate'],1) : "";
		$txt_othref = $_POST['txt_othref'];
		$txt_freight = $_POST['txt_freight'];
		$txt_port = isset($_POST['txt_port']) ? $_POST['txt_port'] : "";
		$txt_lrno = isset($_POST['txt_lrno']) ? $_POST['txt_lrno'] : "";
		//$SrNo = isset($_POST['SrNo']) ? $_POST['SrNo'] : "";
		$AgentSealNo = isset($_POST['AgentSealNo']) ? $_POST['AgentSealNo'] : "";
		$HSCode = isset($_POST['HSCode']) ? $_POST['HSCode'] : "";
		$txt_final_net = isset($_POST['txt_final_net']) ? $_POST['txt_final_net'] : "";
	
		$sql = "insert into ".$mysql_adm_table_prefix."dispatch_number set 
		                                                                   BuyerId = '$buyerd',
																		   InsertBy = '$SessionUserType',
																		   InsertDate = now(),
																		   DespatchDate = '$despatch_date',
																		   DespatchAddress = '$DespatchAddress',
																		   TransportNo = '$txt_transport',
																		   VechileNo = '$txt_vechile',
																		   LrNo = '$txt_lrno',
																		   LrDate = '$txt_lrdate',
																		   
																		   AgentSealNo = '$AgentSealNo',
																		   HSCode = '$HSCode',
																		   OtherRef = '$txt_othref',
																		   FreightCharges = '$txt_freight',
																		   Port = '$txt_port',
																		   FinalNetAmount = '$txt_final_net',
																		   IpAddress = '$ip'";
        $result = mysql_query($sql) or die("Error in query:".$sql."<br>".mysql_error().":".mysql_errno());
		$d_no = mysql_insert_id();																	   
		
		$sql_a = "select * from ".$mysql_adm_table_prefix."serial_counter where CounterName = 'Dispatch'";
		$result_a = mysql_query($sql_a) or die("Error in query:".$sql_a."<br>".mysql_error().":".mysql_errno());
		$row_a = mysql_fetch_array($result_a);
		
		$counter_month = $row_a['CounterMonth'];
		$counter_yr = $row_a['CounterYear'];
		$counter_value = $row_a['CounrtValue'];
		
		$counter_yr1 = substr($counter_yr,2,2);
		$counter_yr2 = $counter_yr-1;
		$counter_prv_yr = substr($counter_yr2,2,2);
		$prifix1 = 'MP/';
		$prifix2 = 'DI/';
		$prifix3 = $counter_prv_yr."-".$counter_yr1."/";
		$prifix4 = '1000';
		$prifix5 = $prifix4+$counter_value;
		$dispatchno = $prifix1.$prifix2.$prifix3.$prifix5;
		if($counter_month!=date('n'))
		{
			$counter_month = date('n');
		}
		if($counter_month=='4' and $counter_yr != date('Y'))
		{
			$counter_year = date('Y')+1;
			$counter_value = 1;
			$sql_b = "update ".$mysql_adm_table_prefix."serial_counter set CounrtValue = '$counter_value' , CounterYear = '$counter_year'  where CounterName = 'Dispatch'";
			$result_b = mysql_query($sql_b) or die("Error in query:".$sql_b."<br>".mysql_error().":".mysql_errno());
		}
				
		$sql_1 = "update ".$mysql_adm_table_prefix."dispatch_number set DispatchNumber = '$dispatchno' where rec_id = '$d_no'";
		$result_1 = mysql_query($sql_1) or die("Error in query:".$sql_1."<br>".mysql_error().":".mysql_errno());
		
		$counter_value = $counter_value+1;
		
		$sql_b = "update ".$mysql_adm_table_prefix."serial_counter set CounrtValue = '$counter_value' , CounterMonth = '$counter_month' where CounterName = 'Dispatch'";
		$result_b = mysql_query($sql_b) or die("Error in query:".$sql_b."<br>".mysql_error().":".mysql_errno());
		
		if(isset($_POST['h_count'])){$count=$_POST['h_count'];}
		for($j=1; $j<=$count; $j++)
		{
			$PiDetailId = $_POST["txt_PiDetailId_$j"];
			$product = $_POST["txt_prd_$j"];
			$countid = $_POST["txt_count_$j"];
			$quantity = $_POST["txt_orderedqty_$j"];
			$NowOfferedQty = $_POST["txt_nowoffered_$j"];
			$price = $_POST["txt_price_$j"];
			$prvaccep_qty = $_POST["txt_prvqty_$j"];
			
			$sql_ins = "insert into ".$mysql_adm_table_prefix."dispatch_master set
																			 		DispatchNumberId = '$d_no',
																					PiId = '$pi_id',
																					PiDetailId = '$PiDetailId',
																					ProductId = '$product',
																					CountId = '$countid',
																					Quantity = '$quantity',
																					Price = '$price',
																					NowOfferedQty = '$NowOfferedQty',
																					PrevioslyAcceptedQty = '$prvaccep_qty',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
																					
		  	$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
			
			$DispatchMasterId = mysql_insert_id();
			
			
			
			for($k = 0; $k < $_SESSION["session_count_".$PiDetailId]; $k++)
			{
				if(isset($_SESSION["session_StockId_".$PiDetailId][$k]))
				{
					$aStockId = $_SESSION["session_StockId_".$PiDetailId][$k];
					
					//if($StockId == $aStockId)
					{
						$LotNumber = $_SESSION["session_LotNumber_".$PiDetailId][$k];
						//echo "<br>";
						$NoOfPck = $_SESSION["session_NoOfPck_".$PiDetailId."_".$aStockId][$k];
						//echo "<br>";
						$StockTotalKgs = $_SESSION["session_TotalKgs_".$PiDetailId."_".$aStockId][$k];
						//echo "<br>";
						$IdentificationMarks = $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$k];
						//echo "<br>";
						$arr_IdentificationMarks_used = explode(",", $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$k]);
						//$TotalNoOfPck = $TotalNoOfPck +  $NoOfPck;
						//echo "<br>";
						//$TotalTotalKgs = $TotalTotalKgs + $StockTotalKgs;
						//echo "<br>";
						
						$sql = "insert into ".$mysql_adm_table_prefix."lot_master set
																			PiDetailId = '$PiDetailId',
																			StockId = '$aStockId',
																			DispatchMasterId = '$DispatchMasterId', 
																			LotNumber = '$LotNumber',
																			NoOfPck = '$NoOfPck',
																			TotalKgs = '$StockTotalKgs',
																			IdentificationMarks = '$IdentificationMarks',
																			IsDispatched = 1,
																			InsertBy = '$SessionUserType',
																			InsertDate = now(),
																			IpAddress = '$ip'
																			";
				
						//echo $sql."<br><br>";
						mysql_query($sql) or die("Error in Query : ".$sql."<br>".mysql_error()." : ".mysql_errno());
						
						//unset($_SESSION["session_StockId"]);
						//unset($_SESSION["session_PiDetailId"]);
					}
				}
			}
			unset($_SESSION["session_StockId_".$PiDetailId]);
			
			/*$sql_ins = "insert into ".$mysql_adm_table_prefix."stock_master  set
																				CountId = '$countid',
																				StockInKgs = '$quantity',
																				StockInBale = '0',
																				DispatchNumber = '$dispatchno',
																				Date = '".date('Y-m-d')."',
																				InsertBy = '$SessionUserType',
																				InsertDate = now(),
																				IpAddress = '$ip'";
			$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());*/
			
			$_SESSION['no_refresh'] = $_POST['no_refresh'];
			$msg = 'successfully inserted';
			?>
			<?
            if(getBuyer('BuyerType','rec_id',$buyerd)=='Export')
            { 
            ?>
				<script>
                	openWin('priview_export_dispatch.php?id=<?=$d_no?>','850','800','yes','center');
                </script>
            <?
            }
            else if(getBuyer('BuyerType','rec_id',$buyerd)=='Domestic')
            {
            ?>
				<script>
                	openWin('priview_domestic_dispatch.php?id=<?=$d_no?>','850','800','yes','center');
                </script>		  	    
            <?
			}
		}
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Despatch</td>
                </tr>
                <tr>
                	<td valign="top">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                             </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <form name="frm_dispatch" id="frm_dispatch" action="dispatch.php?id=<?=$id?>" method="post" onSubmit="return validate_form(this);">
                                                	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td style="padding-top:5px;">
                                                                <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                                                    <tr>
                                                                        <td width="40%" class="text_1" style="padding-left:20px;"><B>PI Number :</B>&nbsp;&nbsp;<?=$pi_no?></td>
                                                                        <td width="30%" class="text_1"><b>PI Date :</b>&nbsp;&nbsp;<?=$pi_date?></td>
                                                                        <td width="30%" class="text_1"><b>Buyer :</b>&nbsp;&nbsp;<?=$buyer?>
                                                                            <input type="hidden" name="buyer_id" id="buyer_id" value="<?=$buyer_id?>" />
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        	<td style="padding-top:5px;">
                                                                <table cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1" width="100%">
                                                                    <tr class="text_1">
                                                                        <td align="center"><b>Same As Buyer Address</b></td>
                                                                        <td align="center">
                                                                            <input type="checkbox" id="cbDespatchAddress" name="cbDespatchAddress" value="0" onClick="Despatch_Address()" />
                                                                            <input type="hidden" name="Address" id="Address" value="<?=$Address?>" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <textarea id="DespatchAddress" name="DespatchAddress" rows="2" cols="25"></textarea>
                                                                        </td>
                                                                        <td align="center"><b>Freight Charges</b></td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_freight" id="txt_freight" style="width:100px; height:20px;"/>
                                                                        </td>
                                                                        <td align="center"><b>Despatch Date :</b></td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_date" id="txt_date" value="" style="width:100px; height:20px;"/>
                                                                            <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_dispatch.txt_date);return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>
                                                                        </td>
                                                                        <?
                                                                        if(getBuyer('BuyerType','rec_id',$buyer_id)=='Export')
                                                                        {
                                                                        ?>	       
                                                                        <td align="center"><b>Port</b></td>
                                                                        <td align="center"><input type="text" name="txt_port" id="txt_port" style="width:100px;" /></td>
                                                                        <?
                                                                        }
                                                                        ?>      
                                                                    </tr>   
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                        	<td style="padding-top:5px;">
                                                                <table cellpadding="0"  cellspacing="0" border="0" align="center" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1" width="100%" height="50">
                                                                    <?
																	if(getBuyer('BuyerType','rec_id',$buyer_id)=='Export')
																	{
																		$Lot_no ="";
																		$lotsr_no = "";
																		$lot_master_id = "";
																		$lot_number = "";
																		$IdentificationMarks = "";
																		if(isset($_GET["mode"]))
                                                                        {
																			//$lot_master_id = $_GET["lot_master_id"];
																			$sql_lot1 = "select rec_id from mo_adm_pi_detail where PiId = '".$_GET['id']."'";
																			$result_lot1 = mysql_query($sql_lot1) or die("Error in Query :".$sql_lot1."<br>".mysql_error().":".mysql_errno());
																			$row_lot1 = mysql_fetch_array($result_lot1);
																			$pi_detail_id = $row_lot1['rec_id'];
																			
																			$sql_lot2 = "select LotNumber,IdentificationMarks,PiDetailId from mo_adm_lot_master where PiDetailId = '$pi_detail_id' and DispatchMasterId = ''";
																			$result_lot2 = mysql_query($sql_lot2) or die("Error in Query :".$sql_lot2."<br>".mysql_error().":".mysql_errno());
																			
																			while($row_lot2 = mysql_fetch_array($result_lot2))
																			{
																				$lot_number[] = $row_lot2['LotNumber'];
																				$IdentificationMarks[] = $row_lot2['IdentificationMarks'];
																			}
																			if($lot_number!="")
																			{
																				$Lot_no = implode(",",$lot_number);
																			}
																			if($IdentificationMarks!="")
																			{
																				$lotsr_no = implode(",",$IdentificationMarks);
																			}
																		}	
																	?>
                                                                    <tr class="text_1">
                                                                        <td align="center"><b>Container No</b> &nbsp; <input type="text" name="txt_transport" id="txt_transport" /></td>
                                                                        <td align="center"><b>Seal No</b> &nbsp; <input type="text" name="txt_vechile" id="txt_vechile" /></td>
                                                                        <!--<td align="center"><b>Lot No</b> &nbsp; <input type="text" name="txt_lrno" id="txt_lrno" style="width:80px;" value="<?=$Lot_no?>"/></td>
                                                                        <td align="center"><b>Sr. No.</b> &nbsp; 
                                                                        <input type="text" name="SrNo" id="SrNo" value="<?=$lotsr_no?>" style="width:80px; height:22px;"/>
                                                                        
                                                                        </td>--> 
                                                                        <td align="center"><b>Agent Seal No.</b> &nbsp; 
                                                                        <input type="text" name="AgentSealNo" id="AgentSealNo" value="" style="width:80px; height:22px;"/>
                                                                        </td>
                                                                        <td align="center"><b>HS CODE</b> &nbsp; 
                                                                        <input type="text" name="HSCode" id="HSCode" value="" style="width:80px; height:22px;"/>
                                                                        <!--<input type="hidden" id="lot_master_id" name="lot_master_id" value="<?=$lot_master_id?>" />-->
                                                                        </td> 
                                                                        <td align="center"><b>Other Ref</b> &nbsp; <input type="text" name="txt_othref" id="txt_othref" /></td>
                                                                    </tr>
                                                                    <?
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                    <tr class="text_1">
                                                                        <td align="center"><b>Transport</b> &nbsp; <input type="text" name="txt_transport" id="txt_transport" /></td>
                                                                        <td align="center"><b>Vechile No</b> &nbsp; <input type="text" name="txt_vechile" id="txt_vechile" /></td>
                                                                        <td align="center"><b>LR No</b> &nbsp; <input type="text" name="txt_lrno" id="txt_lrno" style="width:80px;" /></td>
                                                                        <td align="center"><b>LR Date</b> &nbsp; 
                                                                            <input type="text" name="txt_lrdate" id="txt_lrdate" value="" style="width:80px; height:22px;"/>
                                                                            <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_dispatch.txt_lrdate);return false;" HIDEFOCUS>
                                                                                <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt="">
                                                                            </a>
                                                                        </td> 
																	<?
                                                                    if($ReportType=='net')
                                                                    {
                                                                    ?>
                                                                        <td align="center"><b>Final Total Value</b>&nbsp;<input type="text" name="txt_final_net" id="txt_final_net" value="" style="width:70px;" /></td>
                                                                    <?
																	 }
																	 ?>    
                                                                        <td align="center"><b>Other Ref</b> &nbsp; <input type="text" name="txt_othref" id="txt_othref" /></td>
                                                                    </tr>
                                                                    <?
																	}
																	?>
                                                                </table>            
                                                            </td>
                                                        </tr>        
                                                        <tr>
                                                            <td style="padding-top:5px;">
                                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" class="border">
                                                                    <tr>
                                                                        <td width="11%" class="gredBg">Product</td>
                                                                        <td width="12%" class="gredBg">Count</td>
                                                                        <td width="10%" class="gredBg">Ordered Qty</td>
                                                                        <td width="12%" class="gredBg">Prev. Sent Qty</td>
                                                                        <td width="12%" class="gredBg">Now Sent Qty</td>
                                                                        <td width="10%" class="gredBg"> Qty Left</td>
                                                                        <td width="11%" class="gredBg">Price</td>
                                                                        <td width="12%" class="gredBg">Total Amount</td>
                                                                        <td width="10%" class="gredBg">Lot Number</td>
                                                                    </tr>
                                                                    <?
                                                                    $sql_detail = "select * from ".$mysql_adm_table_prefix."pi_detail where PiId = '".$_GET['id']."'";
                                                                    $result_detail = mysql_query ($sql_detail) or die ("Invalid query : ".$sql_detail."<br>".mysql_errno()." : ".mysql_error());
                                                                    if(mysql_num_rows($result_detail)>0)
                                                                    {
                                                                        $i=1;
                                                                        while($row_detail = mysql_fetch_array($result_detail))
                                                                        {	
                                                                            $pi_id = $row_detail['PiId'];
																			$PiDetailId = $row_detail['rec_id'];
                                                                            $product_id = $row_detail['ProductId'];
                                                                            $count_id = $row_detail['CountId'];
                                                                            
                                                                            $sql_prv = "select * from ".$mysql_adm_table_prefix."dispatch_master where PiId = '$pi_id' and ProductId = '$product_id' and CountId = '$count_id'";
                                                                            $result_prv = mysql_query ($sql_prv) or die ("Invalid query : ".$sql_prv."<br>".mysql_errno()." : ".mysql_error());
                                                                            $previous_quantity = 0;
                                                                            
                                                                            if(mysql_num_rows($result_prv)>0)
                                                                            {
                                                                                while($row_prv = mysql_fetch_array($result_prv))
                                                                                {
                                                                                    $previous_quantity = $previous_quantity + $row_prv["NowOfferedQty"];
                                                                                }
                                                                            }
                                                                            
                                                                           	$sql_lot = "select sum(TotalKgs) from ".$mysql_adm_table_prefix."lot_master where PiDetailId = '".$row_detail["rec_id"]."'";
                                                                            $result_lot = mysql_query($sql_lot) or die("Error in Query: ".$sql_lot."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                            $row_lot = mysql_fetch_array($result_lot);
                                                                            $tnowsentqty = "";
                                                                            $leftqty = $row_detail['Quantity'] - $previous_quantity;
                                                                            $total = "";
                                                                            
                                                                            if(isset($_GET["mode"]))
                                                                            {
                                                                                //if($_GET["mode"] == "lot" and $_GET["id"]==$row_detail["rec_id"])
                                                                                {
                                                                                    $tnowsentqty = $row_lot['sum(TotalKgs)'] - $previous_quantity;
                                                                                    $total = $tnowsentqty * $row_detail['Price'];
                                                                                    $leftqty =$row_detail['Quantity'] - ( $previous_quantity + $tnowsentqty);
                                                                                }
                                                                            }
																			$TotalNoOfPck = 0;
																			$TotalTotalKgs = 0;
																			if(isset($_SESSION["session_count_".$PiDetailId]))
																			{
																				for($k = 0; $k < $_SESSION["session_count_".$PiDetailId]; $k++)
																				{
																					if(isset($_SESSION["session_StockId_".$PiDetailId][$k]))
																					{
																						$aStockId = $_SESSION["session_StockId_".$PiDetailId][$k];
																						
																						//if($StockId == $aStockId)
																						{
																							$LotNumber = $_SESSION["session_LotNumber_".$PiDetailId][$k];
																							//echo "<br>";
																							$NoOfPck = $_SESSION["session_NoOfPck_".$PiDetailId."_".$aStockId][$k];
																							//echo "<br>";
																							$StockTotalKgs = $_SESSION["session_TotalKgs_".$PiDetailId."_".$aStockId][$k];
																							//echo "<br>";
																							$IdentificationMarks = $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$k];
																							//echo "<br>";
																							$arr_IdentificationMarks_used = explode(",", $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$k]);
																							$TotalNoOfPck = $TotalNoOfPck +  $NoOfPck;
																							//echo "<br>";
																							$TotalTotalKgs = $TotalTotalKgs + $StockTotalKgs;
																							//echo "<br>";
																						}
																					}
																				}
																				$tnowsentqty = $TotalTotalKgs;
																				$total = $TotalTotalKgs * $row_detail['Price'];
																				$leftqty = $row_detail['Quantity'] - ( $previous_quantity + $tnowsentqty);
																			}
                                                                    ?>
                                                                    <tr class="text_1" <? if ($i%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                                                                        <td align="center"><?=getProduct('ProductName','rec_id',$row_detail['ProductId'])?>
                                                                            <input type="hidden" name="txt_prd_<?=$i?>" id="txt_prd_<?=$i?>" value="<?=$row_detail['ProductId']?>" />
                                                                        </td>
                                                                        <td align="center"><?=getCount('Count','rec_id',$row_detail['CountId'])?>
                                                                            <input type="hidden" name="txt_count_<?=$i?>" id="txt_count_<?=$i?>" value="<?=$row_detail['CountId']?>" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_orderedqty_<?=$i?>" id="txt_orderedqty_<?=$i?>" value="<?=$row_detail['Quantity']?>" readonly="readonly" style="width:70px;" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_prvqty_<?=$i?>" id="txt_prvqty_<?=$i?>" value="<?=$previous_quantity?>" readonly="readonly" style="width:70px;" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" readonly="readonly" name="txt_nowoffered_<?=$i?>" id="txt_nowoffered_<?=$i?>" value="<?=$tnowsentqty?>" style="width:70px;" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_leftqty_<?=$i?>" id="txt_leftqty_<?=$i?>" value="<?=$leftqty?>" readonly="readonly" style="width:70px;" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_price_<?=$i?>" id="txt_price_<?=$i?>" value="<?=$row_detail['Price']?>" readonly="readonly" style="width:70px;" />
                                                                        </td>
                                                                        <td align="center">
                                                                            <input type="text" name="txt_total_<?=$i?>" id="txt_total_<?=$i?>" value="<?=round($total,2)?>" readonly="readonly" style="width:70px;" />
                                                                            <input type="hidden" name="txt_PiDetailId_<?=$i?>" id="txt_PiDetailId_<?=$i?>" value="<?=$row_detail['rec_id']?>"  />
                                                                        </td>
                                                                        <td align="center" valign="middle">
                                                                        <?
                                                                        if($row_detail['Quantity']>$previous_quantity)
                                                                        {
                                                                        ?>
                                                                        	<a href="javascript:;" onClick="openWin('lotnumber_3.php?detailid=<?=$row_detail['rec_id']?>&pi_id=<?=$_GET['id']?>&CountId=<?=$row_detail['CountId']?>&leftqty=<?=$leftqty?>','850','800','yes','center');"><img src="images/lot_number_icon.png" border="0" /></a>
                                                                        <?
                                                                        }
                                                                        ?>
                                                                        </td>
                                                                    </tr>
                                                                <?
                                                                    $i++;
                                                                    }
                                                                }
                                                                ?> 		                   
                                                                </table>
                                                                <input type="hidden" id="h_total_amount" name="h_total_amount" value="" />
                                                                <input type="hidden" id="h_count" name="h_count" value="<?=mysql_num_rows($result_detail)?>" />        
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td align="center" style="padding-top:5px;">
                                                                <input name="pi_id" type="hidden" id="pi_id" value="<?=$_GET['id']?>" />
                                                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="Submit"/> 
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
        </td>
    </tr>
</table>
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
<? include ("inc/footer.php"); ?>                                    