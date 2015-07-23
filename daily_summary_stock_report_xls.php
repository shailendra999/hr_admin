<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=domestic_dispatch_excel.xls");
?>
<?
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style type="text/css">
.headingSmallPrint
{
 	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:15px;
	color:#666666;
	text-align:center;
	line-height:15px;
	vertical-align:top;
	padding-right:10px;
	padding-top:thin;
	font-weight:bold;
}
.print_text {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#000000;
	text-align:left;
	padding-left:5px;
	line-height:15px;
}
.print_smalltext {
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#000000;
	text-align:left;
	padding-left:5px;
	line-height:15px;
}
.print_border {
	border:#000000 solid thin;
}
.left_padding {
 padding-left:5px;
 }
</style>
<body>

<?
$msg = "";
//////////////****************** Select For PI Listing *****************//////////		
?>
<?
$Date = isset($_GET["Date"]) ? $_GET["Date"] : "";

$prdid = isset($_GET["prdid"]) ? $_GET["prdid"] : "";


//	$Date = getDateFormate($_POST["Date"],1);
?>
<table align="center" width="100%" border="1" class="border">
    <tr>
        <td colspan="10" class="gredBg" align="center">
            <b>REPORT SUMMARY AS ON <?=$Date?></b></td>
    </tr>
    <tr>
        <td rowspan="3" align="center" valign="middle">
            <b><?=getProduct("ProductName", "rec_id", $prdid)?></b>
        </td>
         <td rowspan="3" align="center" valign="middle">
            <b>Lot No.</b>
        </td>
        <td colspan="2" class="gredBg" align="center">
            <b>Op. Stock</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Received</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Issued/Mixing</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Closing Stock</b></td>
    </tr>
    <tr>
        <td class="gredBg" align="center">
            <b>Kgs</b></td>
        <td class="gredBg" align="center">
            <b>Packs</b></td>
        <td class="gredBg" align="center">
            <b>Kgs</b></td>
        <td class="gredBg" align="center">
            <b>Packs</b></td>
        <td class="gredBg" align="center">
            <b>Kgs</b></td>
        <td class="gredBg" align="center">
            <b>Packs</b></td>
        <td class="gredBg" align="center">
            <b>Kgs</b></td>
        <td class="gredBg" align="center">
            <b>Packs</b></td>
    </tr>
    <tr>
        <td colspan="2" class="gredBg" align="center">
            <b>Op. Stock</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Received</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Issued/Mixing</b></td>
        <td colspan="2" class="gredBg" align="center">
            <b>Closing Stock</b></td>
    </tr>
<?
//$Date="2010-05-03"; 
//$sql = "select * from ".$mysql_adm_table_prefix."stock_master where Date = '$Date'";


/*SELECT * FROM 

mo_adm_stock_master sm, 
mo_adm_lot_master lm, 
mo_adm_pi_detail pd, 
mo_adm_dispatch_master dm, 
mo_adm_dispatch_number dn

WHERE lm.PiDetailId = pd.rec_id
AND pd.CountId = sm.CountId
AND sm.Date = '2010-05-03'
AND dm.PiId = pd.PiId
AND dm.DispatchNumberId = dn.rec_id
And dm.CountId = sm.CountId*/

$sql = "select * from 
                    ".$mysql_adm_table_prefix."stock_master sm , mo_adm_count_master cm 
                        where 
                            sm.CountId = cm.rec_id and
                            cm.ProductId = '$prdid' and
                        sm.Date<='$Date' ";

$result = mysql_query($sql) or die("Error in sql : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
     
?>
    <!--<tr >
        <td class="gredBg" style="width:20%">
            <strong>Count Name</strong>
        </td>
        <td class="gredBg">
           <strong> Lot No</strong>
        </td>
        <td class="gredBg">
            <strong>Bag Sr. No</strong>
        </td>
        <td class="gredBg">
            <strong>No. of Bags</strong>
        </td>
        <td class="gredBg">
            <strong>Total Wt</strong>
        </td>
        <td class="gredBg">
            <strong>Desp. Bag No</strong>
        </td>
        <td class="gredBg">
            <strong>No. of Bags</strong>
        </td>
        <td class="gredBg">
            <strong>Dispatch Wt</strong>
        </td>
        <td class="gredBg">
            <strong>Closing Bal</strong>
        </td>
        
        <td class="gredBg">
            <strong>Closing Bags</strong>
        </td>
        
    </tr>-->
<?
    $sno = 1;
    while($row = mysql_fetch_array($result))
    {
        $CountId = $row["CountId"];
?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td class="text_1">
            <?=getCount('Count','rec_id',$CountId)?>                                                                    </td>
        <td class="text_1">
            <?=$row["LotNumber"];?>                                                                    </td>
        
        
        <td class="text_1">
            <?=$row["StockInKgs"];?>                                                                    </td>
        <td class="text_1">
            <?=$row["NumberOfBags"];?>                                                                    </td>
        
        <td class="text_1">
            <?
            $TodayStockInKgs = "0";
            $sql_today_stock_kgs = "SELECT sum(StockInKgs) as TodayStockInKgs FROM mo_adm_stock_master where CountId = '$CountId' and Date = '$Date'";
            $result_today_stock_kgs = mysql_query ($sql_today_stock_kgs) or die ("Error in : ".$sql_today_stock_kgs."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result_today_stock_kgs)>0)
            {
                $row_today_stock_kgs=mysql_fetch_array($result_today_stock_kgs);
                $TodayStockInKgs = $row_today_stock_kgs["TodayStockInKgs"];
            }
            ?>
            <?=$TodayStockInKgs?>                                                                    </td>
        <td class="text_1">
            <?
            $TodayNumberOfBags = "0";
            $sql_today_stock_bags = "SELECT sum(NumberOfBags) as TodayNumberOfBags FROM mo_adm_stock_master where CountId = '$CountId' and Date = '$Date'";
            $result_today_stock_bags = mysql_query ($sql_today_stock_bags) or die ("Error in : ".$sql_today_stock_bags."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result_today_stock_bags)>0)
            {
                $row_today_stock_bags=mysql_fetch_array($result_today_stock_bags);
                $TodayNumberOfBags = $row_today_stock_bags["TodayNumberOfBags"];
            }
            ?>
            <?=$TodayNumberOfBags?>                                                                    </td>
        
        
        <td class="text_1">
            <?
            $TodayDispatchNumberOfKgs = "0";
            $sql_today_lot_kgs = "SELECT sum(lm.TotalKgs) as TodayDispatchNumberOfKgs FROM mo_adm_lot_master lm, mo_adm_pi_detail pd where lm.PiDetailId = pd.rec_id and pd.CountId = '$CountId'";
            $result_today_lot_kgs = mysql_query ($sql_today_lot_kgs) or die ("Error in : ".$sql_today_lot_kgs."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result_today_lot_kgs)>0)
            {
                $row_today_lot_kgs=mysql_fetch_array($result_today_lot_kgs);
                $TodayDispatchNumberOfKgs = $row_today_lot_kgs["TodayDispatchNumberOfKgs"];
            }
            if($TodayDispatchNumberOfKgs == "")
            {
                $TodayDispatchNumberOfKgs = 0;
            }
            ?>
            <?=$TodayDispatchNumberOfKgs?>&nbsp;                                                                    </td>
        <td class="text_1">
            <?
            $TodayDispatchNumberOfBags = "0";
            $sql_today_lot_bags = "SELECT sum(NoOfPck) as TodayDispatchNumberOfBags FROM mo_adm_lot_master lm, mo_adm_pi_detail pd where lm.PiDetailId = pd.rec_id and pd.CountId = '$CountId'";
            $result_today_lot_bags = mysql_query ($sql_today_lot_bags) or die ("Error in : ".$sql_today_lot_bags."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result_today_lot_bags)>0)
            {
                $row_today_lot_bags=mysql_fetch_array($result_today_lot_bags);
                $TodayDispatchNumberOfBags = $row_today_lot_bags["TodayDispatchNumberOfBags"];
            }
            if($TodayDispatchNumberOfBags == "")
            {
                $TodayDispatchNumberOfBags = 0;
            }
            ?>
            <?=$TodayDispatchNumberOfBags?>                                                                    </td>
        
        <td class="text_1">
            <?=$row["StockInKgs"] + $TodayStockInKgs - $TodayDispatchNumberOfKgs;?>                                                                    </td>
        <td class="text_1">
            <?=$row["NumberOfBags"] + $TodayNumberOfBags - $TodayDispatchNumberOfBags;?>                                                                    </td>
    </tr>			
<?
        $sno++;   
    }
    ?>
    <!--<tr>
        <td colspan="11">
            <div class="AddMore">
                <a href="daily_summary_stock_report_xls.php?Date=<?=$Date?>">Export To XLS</a>                                                                        </div>                                                                    </td>
    </tr>-->
    <?
}
?>
</table>
    </body>
</html>