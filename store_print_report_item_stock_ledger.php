<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/store_function.php");
$value=(isset($_REQUEST['value']))?$_REQUEST['value'] : "";
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
ms_item_master.item_id as ITEMID,
ms_item_master.opening_quantity as OpeningQty,
ms_item_master.opening_rate as OpeningRate,
ms_department.name as Department,
ms_item_master.name as ItemName
FROM
ms_item_master,ms_department
WHERE
 ms_department.department_id = ms_item_master.department_id

 $SearchDepartment
 $SearchItem
ORDER BY ms_department.name";
function IssueRate($issueQuantity,$itemId,$SearchGRNDate)
		{
			global $totalOpeningQuantity;
			global $totalOpeningRate;
			global $issueRate;
			global $grnQtyleftCheck;
			global $grntRateleft;
			global $start;
			
			$leftQuanity=$issueQuantity;
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
			if($leftQuanity>0 and $leftQuanity>$issueQuantity)
			{				
				IssueRate($leftQuanity,$itemId,$SearchGRNDate);
			}
			//echo $issueRate.' : '.$leftQuanity;
			return $issueRate;
		}	
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Stock Item Ledger Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
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
          STOCK ITEM LEDGER REPORT BETWEEN <b><?=getDateFormate($FromDate) ?></b> And <b><?=getDateFormate($ToDate)?></b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" cellpadding="1" class="tblborder">
            <tr class="note">
              <td align="center" width="12%">Date</td>
              <td align="center" width="10%">Type</td>
              <td align="center" width="10%">Type No.</td>
              <td align="center" width="12%">Rec Qty.</td>
              <td align="center" width="12%">Rec Rate.</td>
              <td align="center" width="10%">Issue Qty.</td>
              <td align="center" width="10%">Issue Rate.</td>
              <td align="center" width="12%">Total. Qty.</td>
              <td align="center" width="12%">Total. Rate.</td> 
            </tr>
            <?
            if(mysql_num_rows($result)>0)
            {
              $sno = 1;$oldid="";$flag=0;$deptId='';$count=0;
              $totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalRate=0;
              while($row=mysql_fetch_array($result))
              {	
                $totalOpening=0;
                $totalPurchase=0;
                $totalIssue=0;
                $totalRate=0;
                if($row['department_id']!=$oldid)
                {
                  $oldid = $row['department_id'];
                  $flag=1;$sno=1;
                }
                else
                {
                  $flag=0;
              
                }
                if($flag==1)
                {
             
                 ?>
                 <tr class="particulars">
                  <td colspan="9" align="left" style="font-size:14px;padding-left:15px">
                    <b><?= $row['Department']?></b>
                  </td>
                 </tr>
                 <?
                }
                $totalOpeningQuantity=$row['OpeningQty'];
                $totalOpeningRate=$row['OpeningRate'];
                ?>
                <tr class="particulars">
                  <td colspan="9" align="left" style="font-size:12px;padding-left:55px">
                    <b><?= $row['ItemName']?></b>
                  </td>
                </tr>
                <tr class="particulars">
                  <td align="center"></td>
                  <td>&nbsp;<b>Opening</b></td><td>&nbsp;</td>
                  <td align="center"><?= $row['OpeningQty']?></td>
                  <td align="center"><?= $row['OpeningRate']?></td>
                  <td colspan="2" align="center"></td>
                  <td align="right" style="padding-right:2px"><?= $row['OpeningQty']?></td>
                  <td align="right" style="padding-right:2px">
                  <?
                  $ORate=$row['OpeningQty']*$row['OpeningRate'];
                  echo number_format($ORate,2,'.','');
                  $totalRate+=$ORate;
                  ?>
                  </td>
                </tr>
                <?
                $sql_G="select ms_GRN_master.GRN_id,ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty,ms_GRN_transaction.net_rate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."' $SearchGRNDate";
                $res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
                if(mysql_num_rows($res_G)>0)
                {
                  while($row_G=mysql_fetch_array($res_G))
                  {
                    ?>
                    <tr class="particulars">
                      <td align="center"><?= getDateFormate($row_G['GRN_date'])?></td>
                      <td>&nbsp;<b>GRN</b></td><td align="center"><?= $row_G['GRN_id']?></td>
                      <td align="center"><?= $row_G['rec_qty']?></td>
                      <td align="center"><?= $row_G['net_rate']?></td>
                      <td colspan="2" align="center"></td>
                      <td align="right" style="padding-right:2px"><?= $row_G['rec_qty']?></td>
                      <td align="right" style="padding-right:2px">
                        <?
                        $GRate=$row_G['rec_qty']*$row_G['net_rate'];
                        echo number_format($GRate,2,'.','');
                        ?>
                      </td>
                    </tr>
                    <?
                    $totalPurchase+=$row_G['rec_qty'];
                    $totalRate+=$GRate;
                  }
                }
                ?>
                 <tr>
                  <td colspan="7" align="right">&nbsp;<b>Total</b></td>
                  <td align="right" style="padding-right:2px"><b><?= $row['OpeningQty']+$totalPurchase?></b></td>
                  <td align="right" style="padding-right:2px"><b><?= number_format($totalRate,2,'.','');?></b></td>
                </tr>
                <?
                        
                    
                $sql_I="select ms_IE_master.IE_id,ms_IE_master.IE_date,ms_IE_transaction.iss_qty,ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction,ms_item_master where ms_GRN_transaction.item_id = ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."') , ms_item_master.opening_rate) as avg_rate from ms_IE_master,ms_IE_transaction,ms_item_master where ms_IE_master.IE_id=ms_IE_transaction.IE_id and ms_IE_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."' $SearchIEDate";
                //$sql_I="select ms_IE_master.IE_id,ms_IE_master.IE_date,ms_IE_transaction.iss_qty,ifnull((select avg(ms_GRN_transaction.net_rate) from ms_GRN_transaction,ms_item_master where ms_GRN_transaction.item_id = ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."') , ms_item_master.opening_rate) as avg_rate from ms_IE_master,ms_IE_transaction,ms_item_master where ms_IE_master.IE_id=ms_IE_transaction.IE_id and ms_IE_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['ITEMID']."' $SearchIEDate";
                $res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." :".mysql_error());
                if(mysql_num_rows($res_I)>0)
                {
                  $leftQty=$row['OpeningQty'];
                  $leftRate=$row['OpeningRate'];
                  $start=0;
                  $grnQtyleftCheck=0;
                  while($row_I=mysql_fetch_array($res_I))
                  {
                    $issueRate=0;
                    $issueRate=IssueRate($row_I['iss_qty'],$row['ITEMID'],$SearchGRNDate);			
                    ?>
                    <tr class="particulars">
                      <td align="center"><?= getDateFormate($row_I['IE_date'])?></td>
                      <td>&nbsp;<b>Issue</b></td>
                      <td align="center"><?= $row_I['IE_id']?></td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                      <td align="center"><?= $row_I['iss_qty']?></td>
                      <td align="center"><? $IssueRatePerQty=$issueRate/$row_I['iss_qty'];?><?= number_format($IssueRatePerQty,4,'.','')?><? //number_format($row_I['avg_rate'],2,'.','')?></td>
                      <td align="right" style="padding-right:2px"><?= $row_I['iss_qty']?></td>
                      <td align="right" style="padding-right:2px">
                      <?
                        $IRate=$issueRate;
                        echo number_format($issueRate,3,'.','');
                      ?>
                      </td>
                    </tr>
                    <?
                    $totalIssue+=$row_I['iss_qty'];
                    $totalRate-=$IRate;
                  }
                }
                
                $totalOpening+=$row['OpeningQty'];
                ?>
                <tr class="particulars">
                  <td align="center" colspan="7"></td>
                  <td align="right" style="padding-right:2px"><?=($totalOpening+$totalPurchase-$totalIssue)?></td>
                  <td align="right" style="padding-right:2px"><?=number_format($totalRate,2,'.','')?></td>
                </tr>
                <?
                
                $sno++; 
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


        </td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
