<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/store_function.php");
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
	

}
$sql="SELECT 
ms_department.department_id as department_id,
ms_department.name as Department,
ms_item_master.item_id,
ms_item_master.name as ItemName,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_uom.name as UOM,
ms_item_master.opening_quantity as OpeningQty,
ms_item_master.closing_stock as ClosingQty,
ifnull((select sum(ms_IE_transaction.iss_qty) from ms_IE_transaction where ms_IE_transaction.item_id = ms_item_master.item_id) , 0) as  IssueQty,
ifnull((select sum(ms_GRN_transaction.rec_qty) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , 0) as PurchaseQty
FROM
ms_item_master,ms_department,ms_uom
WHERE
  ms_item_master.closing_stock!=0
  and ms_department.department_id = ms_item_master.department_id 
	$SearchDepartment
 and ms_uom.uom_id=ms_item_master.uom_id
ORDER BY ms_department.name,ms_item_master.name asc";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
?>
<div class="AddMore" style="padding-top:10px">
<form action="store_print_report_stock_ledger_qty.php" name="test" id="test" method="post" target="_blank"> 
	<input type="hidden" name="value" id="value" value="<?=$value ?>" />
  <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>" />
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 </form>
</div>
<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
  <tr>
    <td class="gredBg" width="5%">S.No.</td>
    <td class="gredBg" width="45%">Description</td>
    <td class="gredBg" width="10%">UOM</td>
    <td class="gredBg" width="10%">Opening Qty.</td>
    <td class="gredBg" width="10%">Purchase Qty.</td>
    <td class="gredBg" width="10%">Issue Qty.</td>
    <td class="gredBg" width="10%">Closing Qty.</td> 
  </tr>
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;$oldid="";$flag=0;$flag1=0;$deptId='';$count=0;
    $totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalClosing=0;
    while($row=mysql_fetch_array($result))
    {	
      if($row['department_id']!=$oldid)
      {
        $oldid = $row['department_id'];
        $flag=1;$sno=1;
      }
      else
      {
        $flag=0;
      }
			
			$sql_G="select sum(ms_GRN_transaction.rec_qty) as PurchaseQty 
							from ms_GRN_transaction,ms_item_master,ms_department,ms_GRN_master where 
							ms_GRN_transaction.item_id = ms_item_master.item_id 
							and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id
							and ms_department.department_id=ms_item_master.department_id
							and ms_item_master.item_id='".$row['item_id']."'
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
							and ms_item_master.item_id='".$row['item_id']."'
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
			
      if($count!=0 && $flag==1)
      {
       $totalOpening=0;
       $totalPurchase=0;
       $totalIssue=0;
       $totalClosing=0;
       $count++;
      }
      else
        $count++;
      if($flag==1)
      {
       
       ?>
       <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td colspan="8" align="left" style="color:#03F;font-size:14px;padding-left:15px">
          <b><?= $row['Department']?></b>
        </td>
       </tr>
       <?
      }
			if($PurchaseQty!='' || $PurchaseQty!='0' && $IssueQty!='' || $IssueQty!='0')
			{
      ?>
    
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="left" style="padding-left:5px"><?=$row['Description']?></td>
        <td align="center"><?= $row['UOM'];?></td>
        <td align="right" style="padding-right:2px"><?= $row['OpeningQty'];?></td>
        <td align="right" style="padding-right:2px"><?= $PurchaseQty;?></td>
        <td align="right" style="padding-right:2px"><?= $IssueQty;?></td>
        <td align="right" style="padding-right:2px"><?=$row['OpeningQty']+$PurchaseQty-$IssueQty?></td>
      </tr>
      <?
			}
      $totalOpening+=$row['OpeningQty'];
      $totalPurchase+=$PurchaseQty;
      $totalIssue+=$IssueQty;
      $totalClosing+=$row['OpeningQty']+$PurchaseQty-$IssueQty;
      $sno++; 
    }
    if($count==mysql_num_rows($result))
    {
    ?>
       <tr bgcolor="#D0C9C1">
        <td colspan="3"><b>Total</b></td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalOpening,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalPurchase,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalIssue,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalClosing,2,'.','')?>
        </td>
       </tr>
    <?
    }
  }
  else
  {
  ?>
    <tr>
      <td colspan="8" align="center"><b>No Records Found</b></td>
    </tr>
  <?    
  }
  ?> 
</table>