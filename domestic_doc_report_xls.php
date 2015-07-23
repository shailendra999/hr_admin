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
	$search = isset($_SESSION["session_search"]) ? $_SESSION["session_search"] : "";
	
	$sql_prj = "select * from ".$mysql_adm_table_prefix."dispatch_master dm, ".$mysql_adm_table_prefix."dispatch_number dn, ".$mysql_adm_table_prefix."buyer_master bm, ".$mysql_adm_table_prefix."pi_master pm where dm.rec_id!='' and dm.DispatchNumberId = dn.rec_id and dn.BuyerId = bm.rec_id and dm.PiId = pm.rec_id and bm.BuyerType = 'Domestic' $search";
	//echo $sql_prj;
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
?>
<?  
if(mysql_num_rows($result_prj)>0)
{
	$sno = 1;
?>
		<table align="center" width="100%" border="0" class="border">
			<tr bgcolor="#FFFFFF">
				<td width="6%" class="headingSmallPrint" align="center">Invoice No</td>
				<td width="27%" class="headingSmallPrint" align="center">Invoice Dt.</td>
				<td width="27%" class="headingSmallPrint" align="center">Buyer</td>
				<td width="20%" class="headingSmallPrint" align="center">port</td>
				<td width="8%" class="headingSmallPrint" align="center">Country</td>
				<td width="6%" class="headingSmallPrint" align="center">Item</td>
				<td width="6%" class="headingSmallPrint" align="center">Quantity Net in kg</td>
				<td width="6%" class="headingSmallPrint" align="center">Invoice Amt. in USD</td>
				<?
				$sql_doc = "select * from ".$mysql_adm_table_prefix."document_master where DocumentFor='Domestic'";
				$result_doc = mysql_query($sql_doc) or die("Error in Query :".$sql_doc."<br>".mysql_error().":".mysql_errno());
				
				if(mysql_num_rows($result_doc)>0)
				{
					while($row_doc=mysql_fetch_array($result_doc))
					{
					?>
					<td width="6%" class="headingSmallPrint"  align="center">
						<b><?=$row_doc["DocumentName"]?></b>
					</td>
					<?
					}
				}
				?>
			</tr>
<?
	while($row=mysql_fetch_array($result_prj))
	{	
?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
				<td align="center"><?=getDispatchNumber("DispatchNumber","rec_id",$row['DispatchNumberId'])?></td>
				<td align="center"><?=getDateFormate(getDispatchNumber("DespatchDate","rec_id",$row['DispatchNumberId']),1)?></td>
				<td align="center"><?=getBuyer('BuyerName','rec_id',getDispatchNumber("BuyerId","rec_id",$row['DispatchNumberId']))?></td>
				<td align="center"><?=$row['Port']?></td>
				<td align="center"><?=getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']))?></td>
				<td align="center">
					<?=getProduct("ProductName","rec_id",$row['ProductId'])?>
				</td>
				<td align="center">
					<?=$row['Quantity']?>
				</td>
				<td align="center">
					<?=$row['Price']?>
				</td>
				<?
				$sql_doc = "select * from ".$mysql_adm_table_prefix."document_master where DocumentFor='Domestic'";
				$result_doc = mysql_query($sql_doc) or die("Error in Query :".$sql_doc."<br>".mysql_error().":".mysql_errno());
				
				if(mysql_num_rows($result_doc)>0)
				{
					while($row_doc=mysql_fetch_array($result_doc))
					{
						$OtherDetail = $row_doc["OtherDetail"];
						$field_name = "";
						if($OtherDetail== "Date")
						{
							$field_name = "DocDate";
						}
						if($OtherDetail== "Amount")
						{
							$field_name = "Amount";
						}
						if($OtherDetail== "Number")
						{
							$field_name = "Number";
						}
						
						
						
						?>
						<td align="center">
						<?
						$sql_dispatch_doc = "select * from ".$mysql_adm_table_prefix."despatch_doclist where DispatchMasterId='".$row[0]."' and DocId = '".$row_doc["rec_id"]."'";
						$result_dispatch_doc = mysql_query($sql_dispatch_doc) or die("Error in Query :".$sql_dispatch_doc."<br>".mysql_error().":".mysql_errno());
						
						if(mysql_num_rows($result_dispatch_doc)>0)
						{
							while($row_dispatch_doc=mysql_fetch_array($result_dispatch_doc))
							{
								echo $row_dispatch_doc[$field_name];
							}
						}
						?>
						&nbsp;
						</td>
						<?
					}
				}
				?>
				
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