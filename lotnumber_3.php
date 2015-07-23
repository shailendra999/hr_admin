<?
include('inc/check_session.php');
include('inc/dbconnection.php');
include("inc/adm_function.php");
?>
<html>
<head>
<link href="style/adm0_style.css" type="text/css" rel="stylesheet">
<script type="text/javascript"> 
function rtrim(str, chars) 
{
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
function checkAll(lot_id) 
{ 
	var count = 1;
	var packnumbers = "";
	var TotalKgs = 0;
	
	var cbAllNumberOfBags = document.frm_dispatch["cbAllNumberOfBags_" + lot_id];
	var cbNumberOfBags = document.frm_dispatch["cbNumberOfBags_" + lot_id];
	var BoxWeight = document.frm_dispatch["BoxWeight_" + lot_id];
	
	for(var i=0; i<cbNumberOfBags.length; i++)
	{
		if(cbAllNumberOfBags.checked)
		{
			if(!cbNumberOfBags[i].disabled)
			{
				cbNumberOfBags[i].checked = true;
				document.getElementById("NoOfPck_"+ lot_id).value = count;
				TotalKgs = parseFloat(TotalKgs) + parseFloat(BoxWeight[i].value);
				packnumbers += cbNumberOfBags[i].value + ",";
				count++;
			}
		}
		else
		{
			cbNumberOfBags[i].checked = false;
			document.getElementById("NoOfPck_"+ lot_id).value = "";
			document.getElementById("StockTotalKgs_"+ lot_id).value = "";
			document.getElementById("IdentificationMarks_"+ lot_id).value = "";
		}
	}
	document.getElementById("StockTotalKgs_"+ lot_id).value = TotalKgs.toFixed(2);
	document.getElementById("IdentificationMarks_"+ lot_id).value =  rtrim(packnumbers,",");
	
	var FinalTotal = 0;
	if(document.frm_dispatch["testid"].length)
	{
		for(var i=0; i<document.frm_dispatch["testid"].length; i++)
		{
			if(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"][i].value).value != "")
			{
				FinalTotal = FinalTotal + parseFloat(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"][i].value).value);
			}
		}
	}
	else
	{
		FinalTotal = FinalTotal + parseFloat(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"].value).value);
	}
	document.getElementById("TotalKgs").value = FinalTotal.toFixed(2);

	var BoxNumber = 0;
	
	if(document.frm_dispatch["testid"].length)
	{
		for(var i=0; i<document.frm_dispatch["testid"].length; i++)
		{
			if(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"][i].value).value != "")
			{
				BoxNumber = BoxNumber + parseInt(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"][i].value).value);
			}
		}
	}
	else
	{
		if(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"].value).value!="")
		{
			BoxNumber = BoxNumber + parseInt(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"].value).value);
		}
		
	}
	
	document.getElementById("NoOfPck").value = BoxNumber;
}

function validate(lot_id) 
{ 
	var count = 1;
	var packnumbers = "";
	var TotalKgs = 0;
	
	var cbNumberOfBags = document.frm_dispatch["cbNumberOfBags_" + lot_id];
	var BoxWeight = document.frm_dispatch["BoxWeight_" + lot_id];
	document.getElementById("NoOfPck_"+lot_id).value = "";
	for(var i=0; i<cbNumberOfBags.length; i++)
	{
		if(cbNumberOfBags[i].checked)
		{
			document.getElementById("NoOfPck_"+lot_id).value = count;
			TotalKgs = parseFloat(TotalKgs) + parseFloat(BoxWeight[i].value);
			packnumbers += cbNumberOfBags[i].value + ",";
			count++;
		}
		
		document.getElementById("StockTotalKgs_"+ lot_id).value = TotalKgs.toFixed(2);
		document.getElementById("IdentificationMarks_"+ lot_id).value =  rtrim(packnumbers,",");
	}
	
	var FinalTotal = 0;
	if(document.frm_dispatch["testid"].length)
	{
		for(var i=0; i<document.frm_dispatch["testid"].length; i++)
		{
			if(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"][i].value).value != "")
			{
				FinalTotal = FinalTotal + parseFloat(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"][i].value).value);
			}
		}
	}
	else
	{
		FinalTotal = FinalTotal + parseFloat(document.getElementById("StockTotalKgs_"+ document.frm_dispatch["testid"].value).value);
	}
	document.getElementById("TotalKgs").value = FinalTotal.toFixed(2);
	
	var BoxNumber = 0;
	if(document.frm_dispatch["testid"].length)
	{
		for(var i=0; i<document.frm_dispatch["testid"].length; i++)
		{
			if(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"][i].value).value != "")
			{
				BoxNumber = BoxNumber + parseInt(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"][i].value).value);
			}
		}
	}
	else
	{
		if(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"].value).value!="")
		{
			BoxNumber = BoxNumber + parseInt(document.getElementById("NoOfPck_"+ document.frm_dispatch["testid"].value).value);
		}
		
	}
	document.getElementById("NoOfPck").value = BoxNumber;
	//return false;
}

function checkQuantity(leftqty)
{
	if(document.getElementById("TotalKgs").value > leftqty)
	{
		alert("Quantity Not Matched");
		return false;
	}
	return true;
}
</script>
</head>
<body>
<?
$StockTotalKgs = "";
$TotalKgs = "";
$NoOfPck = "";
$IdentificationMarks = "";
$PiDetailId = $_GET["detailid"];
$pi_id = $_GET["pi_id"];
$CountId = $_GET["CountId"];
$leftqty = $_GET["leftqty"];
$LotNumber = "";
if(isset($_POST["btn_submit_x"]))
{
	$StockId = $_POST["StockId"];
	$LotNumber = $_POST["LotNumber"];
	$PiDetailId = $_POST["PiDetailId"];

	$InsertBy = "";
	$InsertDate = "";
	$IpAddress = $_SERVER["REMOTE_ADDR"];
	$lot_master_id = "";
	//echo count($_POST["testid"]);
	unset($_SESSION["session_StockId"]);
	unset($_SESSION["session_PiDetailId"]);
	for($i = 0; $i < count($_POST["testid"]); $i++)
	{
		$j = 0;
		if(isset($_POST["testid"][$i]))
		{
			if(isset($_POST["cbNumberOfBags_".$_POST["testid"][$i]]))
			{
				$StockId = $_POST["testid"][$i];
				$LotNumber = $_POST["LotNumber"][$i];
				$NoOfPck = $_POST["NoOfPck_".$_POST["testid"][$i]];
				$TotalKgs = $_POST["StockTotalKgs_".$_POST["testid"][$i]];
				$IdentificationMarks = $_POST["IdentificationMarks_".$_POST["testid"][$i]];
				
				/*$sql_delete = "delete from ".$mysql_adm_table_prefix."lot_master where 
																				PiDetailId = '$PiDetailId' and
																				StockId = '$StockId' and
																				LotNumber = '$LotNumber'
																				and IsDispatched = 0
																				";
				
				mysql_query($sql_delete) or die("Error in Query : ".$sql_delete."<br>".mysql_error()." : ".mysql_errno());
				
				$sql = "insert into ".$mysql_adm_table_prefix."lot_master set
																			
																			PiDetailId = '$PiDetailId',
																			StockId = '$StockId',
																			LotNumber = '$LotNumber',
																			NoOfPck = '$NoOfPck',
																			TotalKgs = '$TotalKgs',
																			IdentificationMarks = '$IdentificationMarks',
																			IsDispatched = 0,
																			InsertBy = '$SessionUserType',
																			InsertDate = now(),
																			IpAddress = '$IpAddress'
																			";
				
				//echo $sql."<br><br>";
				mysql_query($sql) or die("Error in Query : ".$sql."<br>".mysql_error()." : ".mysql_errno());
				$lot_master_id.=mysql_insert_id().",";*/
				
				$_SESSION["session_PiDetailId"] = $PiDetailId;
				$_SESSION["session_StockId_".$PiDetailId][$i] = $StockId;
				$_SESSION["session_LotNumber_".$PiDetailId][$i] = $LotNumber;
				$_SESSION["session_NoOfPck_".$PiDetailId."_".$StockId][$i] = $NoOfPck;
				$_SESSION["session_TotalKgs_".$PiDetailId."_".$StockId][$i] = $TotalKgs;
				$_SESSION["session_IdentificationMarks_".$PiDetailId."_".$StockId][$i] = $IdentificationMarks;
				$_SESSION["session_count_".$PiDetailId] = count($_POST["testid"]);
			}
		}
	}
	
	$NoOfPck = "";
	$TotalKgs = "";
	$IdentificationMarks = "";
	?>
	<script type="text/javascript">
		window.opener.location.href = 'dispatch.php?id=<?=$pi_id?>&mode=lot';
		this.close();
	</script>
    <?
}
?>

<?
$sql_prj = "select * from ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' order by Date";
$result_prj = mysql_query($sql_prj) or die("Error in Query : ".$sql_prj."<br>".mysql_error()." : ".mysql_errno());
if(mysql_num_rows($result_prj)>0)
{
	$sno = 1;
?>
<form id="frm_dispatch" name="frm_dispatch" action="" method="post">
<table align="center" width="100%" border="1" class="table1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10%" class="gredBg">S. No.</td>
        <td width="20%" class="gredBg">Product</td>
        <td width="20%" class="gredBg">Count</td>
        <td width="15%" class="gredBg">LotNumber</td>
        <td width="10%" class="gredBg">Bags</td>
        <td width="10%" class="gredBg">Stock</td>
        <td width="25%" class="gredBg">Date</td>
    </tr>
<?
	$TotalNoOfPck = "";
	$TotalTotalKgs = "";
	while($row=mysql_fetch_array($result_prj))
	{	
		$StockId = $row["rec_id"];
		
		$sql_check_stock_box = "select * from ".$mysql_adm_table_prefix."stock_box where StockId = '".$StockId."' order by rec_id";
		$result_check_stock_box = mysql_query($sql_check_stock_box) or die("Error in Query : ".$sql_check_stock_box."<br>".mysql_error()." : ".mysql_errno());
	
		if(mysql_num_rows($result_check_stock_box)>0)
		{
		
			
			$arr_IdentificationMarks = array();
			$arr_IdentificationMarks_used = array();
			
			/*$sql_lot_used = "select * from ".$mysql_adm_table_prefix."lot_master where StockId  = '".$StockId."' and PiDetailId  != '".$PiDetailId."' order by rec_id";*/						
			
			$sql_lot_used = "select * from ".$mysql_adm_table_prefix."lot_master where StockId  = '".$StockId."' and IsDispatched = 1 order by rec_id";

			$result_lot_used = mysql_query($sql_lot_used) or die("Error in Query : ".$sql_lot_used."<br>".mysql_error()." : ".mysql_errno());
			
			if(mysql_num_rows($result_lot_used)>0)
			{
				while($row_lot_used=mysql_fetch_array($result_lot_used))
				{
					$IdentificationMarksUsed = $row_lot_used['IdentificationMarks'];
					$arr_IdentificationMarks_used = explode(",",$IdentificationMarksUsed);
				}
			}
			$flag = 0;
			$LotNumber = "";
			$NoOfPck = "";
			$StockTotalKgs = "";
			if(isset($_SESSION["session_count_".$PiDetailId]))
			{
				for($i = 0; $i < $_SESSION["session_count_".$PiDetailId]; $i++)
				{
					if(isset($_SESSION["session_StockId_".$PiDetailId][$i]))
					{
						$aStockId = $_SESSION["session_StockId_".$PiDetailId][$i];
						
						if($StockId == $aStockId)
						{
							$LotNumber = $_SESSION["session_LotNumber_".$PiDetailId][$i];
							$NoOfPck = $_SESSION["session_NoOfPck_".$PiDetailId."_".$aStockId][$i];
							$StockTotalKgs = $_SESSION["session_TotalKgs_".$PiDetailId."_".$aStockId][$i];
							$IdentificationMarks = $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$i];
							$arr_IdentificationMarks_used = explode(",", $_SESSION["session_IdentificationMarks_".$PiDetailId."_".$aStockId][$i]);
							$TotalNoOfPck = $TotalNoOfPck +  $NoOfPck;
							$TotalTotalKgs = $TotalTotalKgs + $StockTotalKgs;
						}
					}
				}
			}
			
			//echo $sql_lot = "select * from ".$mysql_adm_table_prefix."lot_master where PiDetailId  = '".$PiDetailId."' and LotNumber = '".$row['LotNumber']."' and IsDispatched = 1 order by rec_id";
			
			$sql_lot = "select * from ".$mysql_adm_table_prefix."lot_master where LotNumber = '".$row['LotNumber']."' and IsDispatched = 1 order by rec_id";
			$result_prj1 = mysql_query($sql_lot) or die("Error in Query : ".$sql_lot."<br>".mysql_error()." : ".mysql_errno());
			
			if(mysql_num_rows($result_prj)>0)
			{
				
				while($row_1=mysql_fetch_array($result_prj1))
				{
					$PiDetailId = $row_1['PiDetailId'];
					$LotNumber = $row_1['LotNumber'];
					//$NoOfPck = $row_1['NoOfPck'];
					//$StockTotalKgs = $row_1['TotalKgs'];
					$TotalKgs = $row_1['TotalKgs'];
					$IdentificationMarks .= $row_1['IdentificationMarks'].",";
					$arr_IdentificationMarks_used = explode(",",$IdentificationMarks);
					
					//$flag = 1;
				}
			}
?>
<?
			if($flag == 0)
			{
?>
    <tr bgcolor="#F5F2F1" class="text_1">
        <td align="center"><b><?=$sno?></b></td>
        <td align="center"><b><?=getProduct('ProductName','rec_id',getCount("ProductId","rec_id", $row["CountId"]))?></b></td>
        <td align="center"><b><?=getCount("Count","rec_id", $row["CountId"]);?></b></td>
        <td align="center"><b><?=$row['LotNumber']?></b></td>
        <td align="center"><b><?=$row['NumberOfBags']?></b></td>
        <td align="center"><b><?=$row['StockInKgs']?>&nbsp;Kg</b></td>
        <td align="center"><b><?=getDateFormate($row["Date"],1)?></b></td>
    </tr>
    <tr>
    	<td colspan="9" style="padding-bottom:20px;">
        	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
                <tr>
                    <td>
                        
                        
                        <div class="text_1">
                        
                            Check ALL - <input type="checkbox" id="cbAllNumberOfBags_<?=$row["rec_id"]?>" name="cbAllNumberOfBags_<?=$row["rec_id"]?>" value="" onClick="checkAll(<?=$row["rec_id"]?>)">
                            <input type="hidden" id="LotNumber" name="LotNumber[]" value="<?=$row['LotNumber']?>">
                            <input type="hidden" id="NumberOfBags" name="NumberOfBags[]" value="<?=$row['NumberOfBags']?>">
                        </div>
                       
						<?
						
                        $sql_prj = "select * from ".$mysql_adm_table_prefix."stock_box where StockId = '".$StockId."' order by rec_id";
                        $result_prj2 = mysql_query($sql_prj) or die("Error in Query : ".$sql_prj."<br>".mysql_error()." : ".mysql_errno());
                        
                        if(mysql_num_rows($result_prj2)>0)
                        {
							$i = 1;
							$j = 1;	
							$k = 1;
							$bgcolor = "#DBDAD7";
                            while($row_1=mysql_fetch_array($result_prj2))
                            {
								if(!in_array($i,$arr_IdentificationMarks_used))
								{
								
                       		?>
	                    		
                            <div style="float:left; background-color:<?=$bgcolor?>; width:105px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;color:#666666; text-align:left; border:#333333 0px solid">	
                                <div style="float:left; width:20px; border:#333333 0px solid">
									<input type="checkbox" id="cbNumberOfBags_<?=$row["rec_id"]?>" name="cbNumberOfBags_<?=$row["rec_id"]?>[]" value="<?=$i?>" onClick="validate(<?=$row["rec_id"]?>)" <? if(in_array($i,$arr_IdentificationMarks_used)){?>checked="checked"<? } ?>>
                                </div>
                                <div style="float:left; width:80px; text-align:right;border:#333333 0px solid">
                                    <?=$i?> <input type="text" readonly="readonly" id="BoxWeight_<?=$row["rec_id"]?>" name="BoxWeight_<?=$row["rec_id"]?>[]" value="<?=$row_1['BoxWeight']?>" style="width:50px;">
                                </div>
                            </div>
							<?
								}
								
								
								if(!in_array($i,$arr_IdentificationMarks_used))
								{
									//echo $i%7;
									if($k%7==0)
									{
										echo "<br>";
										echo "<br>";
										$bgcolor = "#DBDAD7";
										$j++;
									}
									//echo $j%2;
									if($j%2==0)
									{
										$bgcolor = "#FFFFFF";
										
									}
									$k++;
								}
								$i++;
                       		}
                        }
                        ?>
                    </td>
                </tr>
            </table>
            
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td class="text_1"><b>No. of Pck</b> &nbsp;&nbsp;
                        <input type="text" id="NoOfPck_<?=$row["rec_id"]?>" name="NoOfPck_<?=$row["rec_id"]?>" value="<?=$NoOfPck?>" readonly="readonly">
                    </td>
                    <td class="text_1"><b>Total Kgs</b> &nbsp;&nbsp;
                        <input type="text" id="StockTotalKgs_<?=$row["rec_id"]?>" name="StockTotalKgs_<?=$row["rec_id"]?>" value="<?=$StockTotalKgs?>" readonly="readonly">
                    </td>
                </tr>
			</table>
            <input type="hidden" id="testid" name="testid[]" value="<?=$row["rec_id"]?>">
            <input type="hidden" id="IdentificationMarks_<?=$row["rec_id"]?>" name="IdentificationMarks_<?=$row["rec_id"]?>" value="<?=$IdentificationMarks?>">
            
        </td>
    </tr>
<?
			}
			$sno++;
		}
	}	
?>         
</table>
<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#EAE3E1">
    <tr>
        <td class="text_1" style="padding-left:10px;"><b>No. of Pck</b></td>
		<td class="text_1"><input type="text" id="NoOfPck" name="NoOfPck" value="<?=$TotalNoOfPck?>" readonly="readonly"></td>
    	<td class="text_1"><b>Left Quantity : <?=$leftqty?></b></td>
        <td class="text_1"><b>Total Kgs</b></td>
        <td><input type="text" id="TotalKgs" name="TotalKgs" value="<?=$TotalTotalKgs?>" readonly="readonly"></td>
    </tr>
    <tr>
        <td colspan="5" align="center" style="padding-top:10px;">
			<input type="hidden" id="PiDetailId" name="PiDetailId" value="<?=$detailid?>">
			<input type="hidden" id="StockId" name="StockId" value="<?=$StockId?>">
			<input type="image" src="images/btn_submit.png" id="btn_submit" name="btn_submit" value="Submit" onClick="return checkQuantity(<?=$leftqty?>)">
        </td>
    </tr>
</table>
</form>
<?
}
?>    
</body>
</html>