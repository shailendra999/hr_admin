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


//	$Date = getDateFormate($_POST["Date"],1);
?>
<table align="center" width="100%" border="0" class="border">
<?
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
					".$mysql_adm_table_prefix."stock_master sm, 
					".$mysql_adm_table_prefix."lot_master lm, 
					".$mysql_adm_table_prefix."pi_detail pd
						where 
					lm.PiDetailId = pd.rec_id and 
					pd.CountId=sm.CountId and 
					sm.rec_id = lm.StockId and
					sm.Date='$Date'";
					
$result = mysql_query($sql) or die("Error in sql : ".$sql."<br>".mysql_errno()." : ".mysql_error());
if(mysql_num_rows($result)>0)
{
?>
    <tr>
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
            <strong>No. of Pking</strong>
        </td>
        <td class="gredBg">
            <strong>Total Wt</strong>
        </td>
        <td class="gredBg">
            <strong>Desp. Bag No</strong>
        </td>
        <td class="gredBg">
            <strong>No. of Pking</strong>
        </td>
        <td class="gredBg">
            <strong>Total Wt</strong>
        </td>
        <td class="gredBg">
            <strong>Closing Bal</strong>
        </td>
        
        <td class="gredBg">
            <strong>Bal Pking</strong>
        </td>
        
    </tr>
<?
    while($row = mysql_fetch_array($result))
    {
        $CountId = $row["CountId"];
?>
    <tr>
        <td class="text_1">
            <?=getCount('Count','rec_id',$CountId)?>
        </td>
        <td class="text_1">
            <?=$row["LotNumber"];?>
        </td>
        <td class="text_1">
            1 to <?=$row["NumberOfBags"];?>
        </td>
        <td class="text_1">
            <?=$row["NumberOfBags"];?>
        </td>
        <td class="text_1">
            <?=$row["StockInKgs"];?>
        </td>
        <td class="text_1">
            1 to <?=$row["NoOfPck"];?>
        </td>
        <td class="text_1">
            <?=$row["NoOfPck"];?>
        </td>
        <td class="text_1">
            <?=$row["TotalKgs"];?>
        </td>
        <td class="text_1">
            <?=$row["StockInKgs"] - $row["TotalKgs"];?>
        </td>
        <td class="text_1">
            <?=$row["NumberOfBags"] - $row["NoOfPck"];?>
        </td>
       
    </tr>			
<?
    }
}
?>
</table>
    </body>
</html>