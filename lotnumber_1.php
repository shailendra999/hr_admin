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


</head>
<body>

<?
$detailid = $_GET["detailid"];
$pi_id = $_GET["pi_id"];
$CountId = $_GET["CountId"];

$sql_prj = "select * from ".$mysql_adm_table_prefix."stock_master where CountId = '$CountId' order by Date";
$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());

if(mysql_num_rows($result_prj)>0)
{
	$sno = 1;
?>
<table align="center" width="100%" border="1" class="table1" cellpadding="0" cellspacing="0">
    <tr>
        <td width="6%" class="gredBg">S. No.</td>
        <td width="16%" class="gredBg">Product</td>
        <td width="20%" class="gredBg">Count</td>
        <td width="20%" class="gredBg">LotNumber</td>
        <td width="20%" class="gredBg">NumberOfBags</td>
        <td width="17%" class="gredBg">Stock In Kg</td>
        <td width="18%" class="gredBg">Stock In Bale</td>
        <td width="18%" class="gredBg">Date</td>
        <td width="10%" class="gredBg">Box Number</td>
        
    </tr>
<?
	while($row=mysql_fetch_array($result_prj))
	{	
?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center" class="tableText"><?=$sno?></td>
        <td align="center" class="tableText"><?=getProduct('ProductName','rec_id',getCount("ProductId","rec_id", $row["CountId"]))?></td>
        <td align="center" class="tableText"><?=getCount("Count","rec_id", $row["CountId"]);?></td>
        <td align="center" class="tableText"><?=$row['LotNumber']?></td>
        <td align="center" class="tableText"><?=$row['NumberOfBags']?></td>
        <td align="center" class="tableText"><?=$row['StockInKgs']?>&nbsp;Kg</td>
        <td align="center" class="tableText"><?=$row['StockInBale']?>&nbsp;Bale</td>
        <td align="center" class="tableText"><?=$row["Date"]?></td>
        <td align="center" valign="middle"><a href="javascript:;" onclick="openWin('lotnumber_2.php?detailid=<?=$detailid?>&StockId=<?=$row['rec_id']?>&pi_id=<?=$_GET['pi_id']?>&CountId=<?=$row['CountId']?>','850','500','yes','center');"><img src="images/lot_number_icon.png" border="0" /></a></td>
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