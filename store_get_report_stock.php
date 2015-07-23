<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

$value=(isset($_REQUEST['str']))?$_REQUEST['str'] : "";

if($value!='')
{
	$val=explode(",",$value);
	
	
	$SearchIEDate="";
	$SearchDepartment="";
	$SearchMachinary="";
	$SearchItem="";
	
	/*if($val[0]!= "" and $val[1]!="")
	{
		$val1=getDateFormate($val[0]);
		$val2=getDateFormate($val[1]);
		$SearchGRNDate = "and ms_GRN_master.GRN_date between'".$val1."' and '".$val2."'";
	}*/
	if($_REQUEST['byControl']=='Department' and $val[0]!="")
	{
		$SearchDepartment=" and ms_department.department_id='".$val[0]."' ";
	}
	else if($_REQUEST['byControl']=='Machinary' and $val[0]!="")
	{
		$SearchMachinary=" and ms_machinary.machinary_id='".$val[0]."' ";
	}
	else if($_REQUEST['byControl']=='ItemId' and $val[0]!="")
	{
		$SearchItem=" and ms_item_master.item_id='".$val[0]."' ";
	}
}

$sql = "SELECT 
ms_item_master.item_id as ItemId,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_item_master.location as Location,ms_uom.name as UOM,
ms_item_master.opening_quantity as OStockQty,ms_item_master.closing_stock as CStockQty,
ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , ms_item_master.opening_rate) as UnitRate,
ifnull((select avg(ms_GRN_transaction.net_rate)*(ms_item_master.closing_stock) from ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id),ms_item_master.opening_rate*(ms_item_master.closing_stock)) as Value,
ms_department.name as Department,ms_machinary.name as Machinary,ms_department.department_id,ms_machinary.machinary_id FROM
ms_item_master,ms_department,ms_machinary,ms_uom
WHERE
ms_department.department_id = ms_item_master.department_id
and ms_machinary.machinary_id = ms_item_master.machinary_id
and ms_uom.uom_id = ms_item_master.uom_id
and (ms_item_master.opening_quantity!=0 OR ms_item_master.closing_stock!=0 OR ms_item_master.opening_rate!=0)
$SearchDepartment
$SearchMachinary
$SearchItem

ORDER BY ms_department.name,ms_item_master.name asc";
/*$sql = "SELECT 
ms_item_master.item_id as ItemId,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,ms_item_master.location as Location,ms_uom.name as UOM,
ms_item_master.opening_quantity as OStockQty,ms_item_master.closing_stock as CStockQty,
ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction where ms_GRN_transaction.item_id = ms_item_master.item_id) , ms_item_master.opening_rate) as UnitRate,
ifnull((select avg(ms_GRN_transaction.net_rate)*(ms_item_master.closing_stock) from ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id),ms_item_master.opening_rate*(ms_item_master.closing_stock)) as Value,ms_department.name as Department,ms_department.department_id FROM
ms_item_master,ms_department,ms_machinary,ms_uom,ms_GRN_master,ms_GRN_transaction
WHERE
ms_department.department_id = ms_item_master.department_id
and ms_machinary.machinary_id = ms_item_master.machinary_id
and ms_uom.uom_id = ms_item_master.uom_id
and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id
and ms_GRN_transaction.item_id=ms_item_master.item_id
$SearchDepartment
$SearchMachinary
$SearchItem
$SearchGRNDate
ORDER BY ms_department.name";*/
//echo $sql; 
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
?> 
<div class="AddMore" style="padding-top:10px">
<form action="store_print_report_stock.php" name="test" id="test" method="post" target="_blank"> 
	<input type="hidden" name="value" id="value" value="<?=$value ?>" />
  <input type="hidden" name="byControl" id="byControl" value="<?=$_REQUEST['byControl'] ?>"/>
    <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 </form>
</div>
<table align="center" width="100%" border="1" cellpadding="" class="table1 text_1">
  <tr>
    <td class="gredBg" width="5%">S.No.</td>
    <td class="gredBg" width="5%">Item Id</td>
    <td class="gredBg" width="45%">Description</td>
    <td class="gredBg" width="7%">UOM</td>
    <td class="gredBg" width="10%">Location</td>
    <td class="gredBg" width="7%">Op.StockQty.</td>
    <td class="gredBg" width="7%">C.StockQty.</td>
    <td class="gredBg" width="7%">Unit Rate</td> 
    <td class="gredBg" width="7%">Value</td>
  </tr>
<?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;$oldid="";$oldMid="";$flag=0;$flag1=0;$deptId='';$count=0;
    $totalQty=0;$totalUnitRate=0;$totalValue=0;$totalOQty=0;
    while($row=mysql_fetch_array($result))
    {	
			if($_REQUEST['byControl']=="Department")
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
			}
			if($_REQUEST['byControl']=="Machinary")
			{
      	if($row['machinary_id']!=$oldMid)
      	{
        	$oldMid = $row['machinary_id'];
        	$flag=1;$sno=1;
      	}
      	else
      	{
        	$flag=0;
      	}
			}
      if($count!=0 && $flag==1)
      {
      ?>
       <tr bgcolor="#D0C9C1">
        <td colspan="5"><b>Total</b></td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalOQty,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalQty,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalUnitRate,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalValue,2,'.','')?>
        </td>
       </tr>
       <?
       $totalQty=0;$totalOQty=0;
        $totalUnitRate=0;
        $totalValue=0;$count++;
      }
      else
        $count++;
      if($flag==1)
      {
       
       ?>
       <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td colspan="9" align="left" style="color:#03F;font-size:14px;padding-left:15px">
          <?
					 if($_REQUEST['byControl']=="Machinary")
					 	echo $row['Machinary'];
					 if($_REQUEST['byControl']=="Department")
					 	echo $row['Department'];
					?>
        </td>
       </tr>
       <?
      }
      ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="center"><?= $row['ItemId']?></td>
        <td align="left" style="padding-left:5px">
          <?=$row['Description']?>
        </td>
        <td align="center"><?=$row['UOM']?></td>
        <td align="center"><?=$row['Location']?></td>
        <td align="right" style="padding-right:2px">
          <?=number_format($row['OStockQty'],2,'.','');?>
        </td>
        <td align="right" style="padding-right:2px">
          <?=number_format($row['CStockQty'],2,'.','');?>
        </td>
        <td align="right" style="padding-right:2px">
          <?=number_format($row['UnitRate'],2,'.','');?>
        </td>
        <td align="right" style="padding-right:2px">
        <?

        if($row['Value']==0 and $row['OStockQty']!=0)
        {
          $value=$row['UnitRate']*$row['OStockQty'];
          $totalValue+=$value;
          echo number_format($value, 2, '.','');
        }
        else
        {
          echo number_format($row['Value'], 2, '.','');
          $totalValue+=$row['Value'];
        }
        ?>
        </td>
      </tr>
      <?
      $totalOQty+=$row['OStockQty'];
      $totalQty+=$row['CStockQty'];
      $totalUnitRate+=$row['UnitRate'];
      
      $sno++; 
    }
    if($count==mysql_num_rows($result))
    {
      ?>
       <tr bgcolor="#D0C9C1" style="font-size:13px;font-weight:bold;">
        <td colspan="5">Total</td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalOQty,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalQty,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalUnitRate,2,'.','')?>
        </td>
        <td align="right" style="padding-right:2px">
          <?= number_format($totalValue,2,'.','')?>
        </td>
       </tr>
      <?
    }
  }
  else
  {
  ?>
    <tr>
      <td colspan="9" align="center"><b>No Records Found</b></td>
    </tr>
  <?    
  }
  ?> 
</table>