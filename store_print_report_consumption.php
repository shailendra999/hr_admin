<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/store_function.php");

$value=(isset($_REQUEST['value']))?$_REQUEST['value'] : "";

if($value!='')
{
	$val=explode(",",$value);
	
	
	$SearchIEDate="";
	$SearchDepartment="";
	$SearchMachinary="";
	$SearchItem="";
	$FromDate="";
	$ToDate="";
	if($val[0]!= "" and $val[1]!="")
	{
		$FromDate=getDateFormate($val[0]);
		$ToDate=getDateFormate($val[1]);
		$SearchIEDate = "and ms_IE_master.IE_date between'".$FromDate."' and '".$ToDate."'";
	}
	if($_REQUEST['byControl']=='Department' and $val[2]!="")
	{
		$SearchDepartment=" and ms_department.department_id='".$val[2]."' ";
		
	}
	else if($_REQUEST['byControl']=='Machinary' and $val[2]!="")
	{
		$SearchMachinary=" and ms_machinary.machinary_id='".$val[2]."' ";
		
	}
	else if($_REQUEST['byControl']=='ItemId' and $val[2]!="")
	{
		$SearchItem=" and ms_item_master.item_id='".$val[2]."' ";
		
	}
}


function IssueRate($issueQuantity,$itemId)
		{
			global $totalOpeningQuantity;
			global $totalOpeningRate;
			global $issueRate;
			global $grnQtyleftCheck;
			global $grntRateleft;
			global $start;
			
			$leftQuanity=number_format($issueQuantity,2,'.','');
			if($totalOpeningQuantity>0)
			{
				if($totalOpeningQuantity>$issueQuantity)
				{
					$issueRate=$totalOpeningRate*$issueQuantity;
					$totalOpeningQuantity=$totalOpeningQuantity-$issueQuantity;
					$leftQuanity=$leftQuanity-$issueQuantity;
				}
				else
				{
					$leftQuanity=$leftQuanity-$totalOpeningQuantity;
					$issueRate=$totalOpeningRate*$totalOpeningQuantity;
					$totalOpeningQuantity=0;
				}
			}
			else if($grnQtyleftCheck>0)
			{
				
				if($grnQtyleftCheck < $leftQuanity)
				{
					
					$leftQuanity=$leftQuanity-$grnQtyleftCheck;
					$issueRate=$grntRateleft*$grnQtyleftCheck;
					$grnQtyleftCheck=0;
				}
				else
				{
					$issueRate=$grntRateleft*$leftQuanity;
					$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
					$leftQuanity=0;				
				}
			}
			else
			{
				  $sql_func="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty,ms_GRN_transaction.net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_GRN_transaction.item_id='".$itemId."' order by ms_GRN_transaction.GRN_transaction_id ASC limit $start,1 ";
			 
			$result_func=mysql_query($sql_func) or die("Error in : ".$sql_func."<br>".mysql_errno()." : ".mysql_error());	
			//if(mysql_num_rows($result_func)>0)
			{
					$row_func=mysql_fetch_array($result_func);

					$grnQtyleft=$row_func['rec_qty'];
					$grntRateleft=$row_func['net_rate'];
					$grnQtyleftCheck=$row_func['rec_qty'];									
			}
			
			
								
					if($leftQuanity<$grnQtyleft)
					{
						$issueRate=$issueRate+$grntRateleft*$leftQuanity;
						$grnQtyleftCheck=$grnQtyleftCheck-$leftQuanity;
					}
					else
					{
						$issueRate=$issueRate+$grntRateleft*$grnQtyleft;
						$grnQtyleftCheck=0;
					}
					
					$leftQuanity=$leftQuanity-$grnQtyleft;
					
					$start++;
												
			}			
			if($leftQuanity>0  and $leftQuanity>$issueQuantity)
			{				
				IssueRate($leftQuanity,$itemId);
			}
			//echo $issueRate.' : '.$leftQuanity;
			return $issueRate;
		}
$sql="SELECT
ms_item_master.item_id as ItemId,CONCAT(ms_item_master.name,';Drg No. ',ms_item_master.drawing_number,';Cat No. ',ms_item_master.catelog_number) as Description,
ms_item_master.opening_quantity as OpeningQty,
ms_item_master.opening_rate as OpeningRate,
ms_uom.name as UOM,
sum(ms_IE_transaction.iss_qty) as Qty
FROM
ms_IE_master,ms_IE_transaction,ms_item_master,ms_department,ms_machinary,ms_uom 
WHERE
ms_IE_master.IE_id = ms_IE_transaction.IE_id
and ms_item_master.item_id = ms_IE_transaction.item_id
and ms_department.department_id = ms_item_master.department_id
and ms_machinary.machinary_id = ms_item_master.machinary_id
and ms_uom.uom_id = ms_item_master.uom_id
$SearchDepartment
$SearchMachinary
$SearchItem

$SearchIEDate

GROUP BY ms_IE_transaction.item_id
Order by ms_item_master.name asc";
//echo $sql; 
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Consumption Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:11px;
height:25px;
}
.tblborder
{
 border-collapse:collapse;border-color:1px solid #000;
}
.borderTop
{
	border-top:1px solid #000;
}
.borderBottom
{
	border-bottom:1px solid #000;
}
.borderRight
{
	border-right:1px solid #000;
}
.padding_right
{
padding-right:2px;
}
</style>

</head>

<body onload="print();">
<div style="margin:0 auto;width:740px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          STOCK CONSUMPTION REPORT 
					<? if($val[0]!= "" and $val[1]!="") {?> BETWEEN <b><?=getDateFormate($FromDate) ?></b> And <b><?=getDateFormate($ToDate)?></b><? } ?>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" cellpadding="0" class="tblborder">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Item Id</td>
              <td align="center">Description</td>
              <td align="center">UOM</td>
              <td align="center">Qty.</td>
              <td align="center">Unit Rate</td> 
              <td align="center">Value</td>
            </tr>
          <?  
            if(mysql_num_rows($result)>0)
            {
              $sno = 1;      
							$TotalQuantity=0;$TotalValue=0;//$TotalQuantityValue=0;                   
              while($row=mysql_fetch_array($result))
              {	
								$totalOpeningQuantity=$row['OpeningQty'];
								$totalOpeningRate=$row['OpeningRate'];
								$leftQty=$row['OpeningQty'];
								$leftRate=$row['OpeningRate'];
								$start=0;
								$grnQtyleftCheck=0;
								$issueRate=0;
								$issueRate=IssueRate(number_format($row['Qty'], 2, '.', ''),$row['ItemId']);
              ?>
                <tr class="particulars">
                  <td align="center"><?=$sno?></td>
                  <td align="center"><?= $row['ItemId']?></td>
                  <td align="left" style="padding-left:5px"><?= $row['Description']?></td>
                  <td align="center"><?= $row['UOM']?></td>
                  <td align="right" style="padding-right:2px"><?=number_format($row['Qty'], 2, '.', '');?></td>
				  <?
                  if($row['Qty']!=0)
                     $IssueRatePerQuantity=$issueRate/$row['Qty'];
                  else
                     $IssueRatePerQuantity='';
                  ?>
                  <td align="right" style="padding-right:2px"><?= number_format($IssueRatePerQuantity, 2, '.', '');?></td>
                  <td align="right" style="padding-right:2px"><?= number_format($issueRate, 2, '.', '');?></td>
                </tr>
              <?
                $TotalQuantity+=$row['Qty'];
				$TotalValue+=$issueRate;
				//$TotalQuantityValue+=$IssueRatePerQuantity;
				$sno++;
			}	
			?>
				<tr class="note">
					<td align="right" style="padding-right:3px;" colspan="4">Total</td>
					<td align="right" style="padding-right:2px"><?=number_format($TotalQuantity, 2, '.', '');?></td>
					<td align="center">&nbsp;</td>
					<td align="right" style="padding-right:2px"><?= number_format($TotalValue, 2, '.', '');?></td>
				</tr>
			<?
            }
            else
            {
            ?>
              <tr>
                <td colspan="7" align="center" style="font-weight:bold">No Records Found</td>
              </tr>
            <?    
            }
            ?> 
          </table>      
        </td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
