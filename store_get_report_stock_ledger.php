<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

$value=(isset($_REQUEST['str']))?$_REQUEST['str'] : "";
//echo $val;
if($value!='')
{
	$val=explode(",",$value);
	$SearchIEDate="";
	$SearchDepartment="";
	$SearchMachinary="";
	$SearchItem="";
	if($val[0]!= "" and $val[1]!="")
	{
		$FromDate=getDateFormate($val[0]);$ToDate=getDateFormate($val[1]);
		$SearchGRNDate = "and ms_GRN_master.GRN_date between '".$FromDate."' and '".$ToDate."'";
		$SearchIEDate = "and ms_IE_master.IE_date between '".$FromDate."' and '".$ToDate."'";
	}
	if($_REQUEST['byControl']=='Department' and $val[2]!="")
	{
		$SearchDepartment=" and ms_department.department_id='".$val[2]."' ";
	}
	if($_REQUEST['byControl']=='Item' and $val[2]!="")
	{
		$SearchItem=" and ms_item_master.item_id='".$val[2]."' ";
	}
	

}
$sql="SELECT 
ms_department.department_id as department_id,
SUM(ms_item_master.opening_quantity) as OpeningQty,
SUM(ms_item_master.closing_stock) as ClosingQty,
ms_department.name as Department
FROM
ms_item_master,ms_department
WHERE
 ms_department.department_id = ms_item_master.department_id
 $SearchDepartment
GROUP BY ms_item_master.department_id
ORDER BY ms_department.name";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
?>
<div class="AddMore" style="padding-top:10px">
<form action="store_print_report_stock_ledger.php" name="test" id="test" method="post" target="_blank"> 
	<input type="hidden" name="value" id="value" value="<?=$value ?>" />
  <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 </form>
</div>
<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Department</td>
    <td class="gredBg">Opening Qty.</td>
    <td class="gredBg">Purchase Qty.</td>
    <td class="gredBg">Issue Qty.</td>
    <td class="gredBg">Closing Qty.</td> 
  </tr>
  <?  
	if(mysql_num_rows($result)>0)
	{
		$sno = 1;$oldid="";$flag=0;$flag1=0;$deptId='';$count=0;
		$totalQty=0;$totalUnitRate=0;$totalValue=0;
		while($row=mysql_fetch_array($result))
		{	
		
		$sql_G="select sum(ms_GRN_transaction.rec_qty) as PurchaseQty 
							from ms_GRN_transaction,ms_item_master,ms_department,ms_GRN_master where 
							ms_GRN_transaction.item_id = ms_item_master.item_id 
							and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id
							and ms_department.department_id=ms_item_master.department_id
							$SearchDepartment
							$SearchGRNDate";
		$res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
		$PurchaseQty=0;$IssueQty=0;
		if(mysql_num_rows($res_G)>0)
		{
			$row_G=mysql_fetch_array($res_G);
			$PurchaseQty= $row_G['PurchaseQty'];
		}
		else
			$PurchaseQty=0;		
		
		$sql_I="select sum(ms_IE_transaction.iss_qty) as IssueQty 
							from ms_IE_transaction,ms_item_master,ms_department,ms_IE_master where 
							ms_IE_transaction.item_id = ms_item_master.item_id 
							and ms_IE_master.IE_id=ms_IE_transaction.IE_id
							and ms_department.department_id=ms_item_master.department_id
							$SearchDepartment
							$SearchIEDate";
		$res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
		
		
		if(mysql_num_rows($res_I)>0)
		{
			$row_I=mysql_fetch_array($res_I);
			$IssueQty= $row_I['IssueQty'];
		}
		else 
			$IssueQty=0;
		
    //if(($PurchaseQty!=''||$PurchaseQty!=0) && ($IssueQty!=''||$IssueQty!=0) && ($row['OpeningQty']!='0' && $row['ClosingQty']!=0) )
		
		?>	<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
				<td align="center"><?=$sno?></td>
				<td align="left" style="padding-left:5px"><?= $row['Department']?></td>
				<td align="center"><?=$row['OpeningQty']?></td>
				<td align="center"><?=$PurchaseQty?></td>
				<td align="center"><?=$IssueQty	?></td>
				<td align="center"><?=$row['OpeningQty']+$PurchaseQty-$IssueQty?></td>
			</tr>
			<?
			$totalQty+='';
			$totalUnitRate+='';
			$totalValue+='';
			$sno++; 
		}
	}
	else
	{
	?>
		<tr>
			<td colspan="6" align="center"><b>No Records Found</b></td>
		</tr>
	<?    
	}
	?> 
</table>
