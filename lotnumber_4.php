<?
include('inc/check_session.php');
include('inc/dbconnection.php');
include("inc/adm_function.php");
?>
<html>
<head>
<link href="style/adm0_style.css" type="text/css" rel="stylesheet">
<script language="javascript">
function openWin (url,w,h,scroll,pos)
{
	
	if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}

	else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}

	settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';

	var mywin = window.open(url, "winImage1", settings);
}
</script>
<script type="text/javascript"> 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}
function checkAll() 
{ 
	var count = 1;
	var packnumbers = "";
	for(var i=0; i<document.frm_dispatch.cbNumberOfBags.length; i++)
	{
		if(document.frm_dispatch.cbAllNumberOfBags.checked)
		{
			document.frm_dispatch.cbNumberOfBags[i].checked = true;
			document.getElementById("NoOfPck").value = count;
			
			document.getElementById("TotalKgs").value = (document.getElementById("BoxKgs").value * count).toFixed(2);
			packnumbers += document.frm_dispatch.cbNumberOfBags[i].value + ",";
			count++;
		}
		else
		{
			document.frm_dispatch.cbNumberOfBags[i].checked = false;
			document.getElementById("NoOfPck").value = "";
			
			document.getElementById("TotalKgs").value = "";
			document.getElementById("IdentificationMarks").value = "";
			
		}
		
	}
	
	document.getElementById("IdentificationMarks").value =  rtrim(packnumbers,",");
	
}

function validate() 
{ 
	var count = 1;
	var packnumbers = "";
	for(var i=0; i<document.frm_dispatch.cbNumberOfBags.length; i++)
	{
		
		//alert(document.frm_dispatch.cbNumberOfBags[i].value);
		if(document.frm_dispatch.cbNumberOfBags[i].checked)
		{
			//alert(i+" checked");
			document.getElementById("NoOfPck").value = count;
			//alert(document.getElementById("BoxKgs").value * count);
			document.getElementById("TotalKgs").value = (document.getElementById("BoxKgs").value * count).toFixed(2);
			packnumbers += document.frm_dispatch.cbNumberOfBags[i].value + ",";
			count++;
		}
		document.getElementById("IdentificationMarks").value =  rtrim(packnumbers,",");
	}

//return false;
}
function checkQuantity(leftqty)
{
	if(document.getElementById("TotalKgs").value >= leftqty)
	{
		alert("Quantity Exceeded");
		return false;
	}

	return true;
}

</script>

</head>
<body>

<?
$LotMasterId = "";
$TotalKgs = "";
$NoOfPck = "";
$IdentificationMarks = "";
$PiDetailId = $_GET["detailid"];
$pi_id = $_GET["pi_id"];
$CountId = $_GET["CountId"];

$leftqty = $_GET["leftqty"];


if(isset($_POST["btn_submit"]))
{
	$LotMasterId = $_POST["LotMasterId"];
	$LotNumber = $_POST["LotNumber"];
	$NoOfPck = $_POST["NoOfPck"];
	$PiDetailId = $_POST["PiDetailId"];
	$TotalKgs = $_POST["TotalKgs"];
	$IdentificationMarks = $_POST["IdentificationMarks"];
	
	$InsertBy = "";
	$InsertDate = "";
	$IpAddress = $_SERVER["REMOTE_ADDR"];
	
	if($LotMasterId=="")
	{
		$sql = "insert into ".$mysql_adm_table_prefix."lot_master set
																		PiDetailId = '$PiDetailId',
																		LotNumber = '$LotNumber',
																		NoOfPck = '$NoOfPck',
																		TotalKgs = '$TotalKgs',
																		IdentificationMarks = '$IdentificationMarks',
																		InsertBy = '$SessionUserType',
																		InsertDate = now(),
																		IpAddress = '$IpAddress'
																		";
		mysql_query($sql) or die("Error in Query :".$sql."<br>".mysql_error().":".mysql_errno());
		
		$LotMasterId = mysql_insert_id();
	}
	else
	{
		$sql = "update ".$mysql_adm_table_prefix."lot_master set
																		PiDetailId = '$PiDetailId',
																		LotNumber = '$LotNumber',
																		NoOfPck = '$NoOfPck',
																		TotalKgs = '$TotalKgs',
																		IdentificationMarks = '$IdentificationMarks'

																		where rec_id = '$LotMasterId'
																		";
		mysql_query($sql) or die("Error in Query :".$sql."<br>".mysql_error().":".mysql_errno());
	}
	
	?>
    
	<script type="text/javascript">
		window.opener.location.href = 'dispatch.php?id=<?=$pi_id?>&mode=lot';
	</script>
    <?
}
$sql_prj = "select * from ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' order by Date";
$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());

if(mysql_num_rows($result_prj)>0)
{
	$sno = 1;
?>
<table align="center" width="100%" border="1" class="table1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="10%" class="gredBg">S. No.</td>
        <td width="20%" class="gredBg">Product</td>
        <td width="20%" class="gredBg">Count</td>
        <td width="15%" class="gredBg">LotNumber</td>
        <td width="15%" class="gredBg">Bags</td>
        <td width="15%" colspan="2" class="gredBg">Stock</td>
        
        <td width="20%" class="gredBg">Date</td>
        <!--<td width="10%" class="gredBg">Box Number</td>-->
        
    </tr>
<?
	while($row=mysql_fetch_array($result_prj))
	{	
	
		$StockId = $row["rec_id"];
?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center" class="tableText"><?=$sno?></td>
        <td align="center" class="tableText"><?=getProduct('ProductName','rec_id',getCount("ProductId","rec_id", $row["CountId"]))?></td>
        <td align="center" class="tableText"><?=getCount("Count","rec_id", $row["CountId"]);?></td>
        <td align="center" class="tableText"><?=$row['LotNumber']?></td>
        <td align="center" class="tableText"><?=$row['NumberOfBags']?></td>
        <td align="center" class="tableText"><?=$row['StockInKgs']?>&nbsp;Kg</td>
        <td align="center" class="tableText"><?=$row['StockInBale']?>&nbsp;Bale</td>
        <td align="center" class="tableText"><?=getDateFormate($row["Date"],1)?></td>
<!--        <td align="center" valign="middle"><a href="javascript:;" onClick="openWin('lotnumber_2.php?detailid=<?=$detailid?>&StockId=<?=$row['rec_id']?>&pi_id=<?=$_GET['pi_id']?>&CountId=<?=$row['CountId']?>','850','500','yes','center');"><img src="images/lot_number_icon.png" border="0" /></a></td>
-->    </tr>
    <tr>
    	<td colspan="9">
        	<table>
                <tr>
                    <td>
                        <form id="frm_dispatch" name="frm_dispatch" action="" method="post">
                        <div>
                        Check ALL - <input type="checkbox" id="cbAllNumberOfBags" name="cbAllNumberOfBags" value="" onClick="checkAll()">
                        
                        <input type="hidden" id="LotNumber" name="LotNumber" value="<?=$row['LotNumber']?>">
                        
                        <input type="hidden" id="NumberOfBags" name="NumberOfBags" value="<?=$row['NumberOfBags']?>">
                        </div>
                        <?
                        $arr_IdentificationMarks = array();
                        $sql_prj = "select * from ".$mysql_adm_table_prefix."lot_master where LotNumber = '".$row['LotNumber']."' and PiDetailId = '$PiDetailId'";
                        $result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
                        
                        if(mysql_num_rows($result_prj)>0)
                        {
                            while($row_1=mysql_fetch_array($result_prj))
                            {
                                $PiDetailId = $row_1['PiDetailId'];
                                $LotNumber = $row_1['LotNumber'];
                                $NoOfPck = $row_1['NoOfPck'];
                                $NoOfPck = $row_1['NoOfPck'];
                                $TotalKgs = $row_1['TotalKgs'];
                                $IdentificationMarks = $row_1['IdentificationMarks'];
                                $arr_IdentificationMarks = explode(",",$IdentificationMarks);
                            }
                        }
                
                        for($i=1; $i<=$row['NumberOfBags']; $i++)
                        {
                        ?>
                            <div style="float:left; width:80px;">	
                                <div style="float:left;">
                                    <input type="checkbox" id="cbNumberOfBags" name="cbNumberOfBags" value="<?=$i?>" onClick="validate()" <? if(in_array($i,$arr_IdentificationMarks)){?>checked="checked"<? }?>>
                                </div>
                                <div style="float:left; width:50px; text-align:right">
                                    <?=$i?>
                                </div>
                            </div>
                        <?
                            if($i%10==0)
                            {
                                echo "<br>";
                            }
                        }
                        ?>
                            <table>
                                <tr>
                                    <td class="tableText">
                                        NoOfPck
                                    </td>
                                    <td>
                                        <input type="text" id="NoOfPck" name="NoOfPck" value="<?=$NoOfPck?>">
                                    </td>
                                    <td class="tableText">
                                        TotalKgs
                                    </td>
                                    <td>
                                        <!--<input type="text" id="StockInKgs" name="StockInKgs" value="<?=$row['StockInKgs']?>">
                                        <input type="text" id="NumberOfBags" name="NumberOfBags" value="<?=$row['NumberOfBags']?>">-->
                                        <input type="hidden" id="BoxKgs" name="BoxKgs" value="<?=$row['StockInKgs']/$row['NumberOfBags']?>">
                                        Left Quantity : <?=$leftqty?> : <input type="text" id="TotalKgs" name="TotalKgs" value="<?=$TotalKgs?>">
                                        
                                    </td>
                               </tr>
                               <tr>
                               
                                    <td class="tableText">
                                        Bag Numbers
                                    </td>
                                    <td>
                                        <textarea id="IdentificationMarks" name="IdentificationMarks" rows="5" cols="50"><?=$IdentificationMarks?></textarea>
                                    </td>
                                        
                                    <td>
                                        <input type="hidden" id="LotMasterId" name="LotMasterId" value="<?=$LotMasterId?>">
                                        <input type="hidden" id="PiDetailId" name="PiDetailId" value="<?=$detailid?>">
                                        <input type="hidden" id="StockId" name="StockId" value="<?=$row['rec_id']?>">
                                        <input type="submit" id="btn_submit" name="btn_submit" value="Submit" onClick="return checkQuantity(<?=$leftqty?>)">
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
		$sno++;
		
	}	
?>         
</table>
<?
}
?>    
</body>
</html>