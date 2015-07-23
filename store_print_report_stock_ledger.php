<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

$value=(isset($_REQUEST['DateRange']))?$_REQUEST['DateRange'] : "";
//echo $val;
$SearchGRNDate='';
$SearchIEDate='';
$from='';
$to='';
if($value!='')
{
	$val=explode(',',$value);
	$from=$val[0];
	$to=$val[1];
	$SearchGRNDate="  and ms_GRN_master.GRN_date between '".$from."' and '".$to."'";
	$SearchIEDate="  and ms_IE_master.IE_date between '".$from."' and '".$to."'";
}
$sql="SELECT department_id,name from ms_department ORDER BY name";

$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());




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
			$row_func=mysql_fetch_array($result_func);
			$grnQtyleft=$row_func['rec_qty'];
			$grntRateleft=$row_func['net_rate'];
			$grnQtyleftCheck=$row_func['rec_qty'];									
						
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Stock Ledger Report</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
height:30px;
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
<div style="margin:0 auto;width:740px;padding:2px">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          STOCK LEDGER REPORT BETWEEN <b><?=getDateFormate($from) ?></b> And <b><?=getDateFormate($to)?></b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <table align="center" width="100%" border="1" cellpadding="" class="tblborder">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Department</td>
              <td align="center">Opening Value</td>
              <td align="center">Purchase Value</td>
              <td align="center">Issue Value</td>
              <td align="center">Closing Value</td> 
            </tr>
						<?  
              if(mysql_num_rows($result)>0)
              {
                $count=1;$snoDep=1;
								$GrossOpening=0;$GrossPurchase=0;$GrossIssue=0;$GrossClosing=0;
                while($row=mysql_fetch_array($result))
                {
                  $sql_sub="SELECT 
                                  ms_item_master.item_id as ITEMID,ms_item_master.name as ItemName,
                                  ms_item_master.opening_quantity as OpeningQty,ms_item_master.opening_rate as OpeningRate
                                  FROM
                                  ms_item_master,ms_department
                                  WHERE
                                  ms_department.department_id = ms_item_master.department_id
                                  and ms_item_master.department_id='".$row['department_id']."'
                                  ORDER BY ms_department.name";	
                  $result_sub=mysql_query($sql_sub) or die("Error in : ".$sql_sub."<br>".mysql_errno()." : ".mysql_error());
                  if(mysql_num_rows($result_sub)>0)
                  {
                    $totalOpening=0;$totalPurchase=0;$totalIssue=0;$totalRate=0;
                    while($row_sub=mysql_fetch_array($result_sub))
                    {	
                      $totalOpeningQuantity=$row_sub['OpeningQty'];
                      $totalOpeningRate=$row_sub['OpeningRate'];
                      $ORate=$row_sub['OpeningQty']*$row_sub['OpeningRate'];
                      //echo number_format($ORate,2,'.','');
                      
                      $sql_G="select sum(ms_GRN_transaction.rec_qty*ms_GRN_transaction.net_rate) as GRate from ms_GRN_master,ms_GRN_transaction,ms_item_master where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row_sub['ITEMID']."' $SearchGRNDate";
                      $res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
                      if(mysql_num_rows($res_G)>0)
                      {
                        while($row_G=mysql_fetch_array($res_G))
                        {
                          $GRate=$row_G['GRate'];
                          //echo number_format($GRate,2,'.','');*$row_G['net_rate']
                          $totalPurchase+=number_format($GRate,2,'.','');
                          //$totalRate+=$GRate;
                        }
                      }
                      $sql_I="select sum(ms_IE_transaction.iss_qty) as iss_qty from ms_IE_master,ms_IE_transaction,ms_item_master where ms_IE_master.IE_id=ms_IE_transaction.IE_id and ms_IE_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row_sub['ITEMID']."' $SearchIEDate GROUP BY ms_IE_transaction.item_id";
                  
                      $res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." :".mysql_error());
                      if(mysql_num_rows($res_I)>0)
                      {
                        $leftQty=$row_sub['OpeningQty'];
                        $leftRate=$row_sub['OpeningRate'];
                        $start=0;
                        $grnQtyleftCheck=0;
                        while($row_I=mysql_fetch_array($res_I))
                        {
                          $issueRate=0;
                          $issueRate=IssueRate(number_format($row_I['iss_qty'],2,'.',''),$row_sub['ITEMID']);				
                          
                          $totalIssue+=number_format($issueRate,2,'.','');
                        }
                      }

                      $totalRate+=number_format($ORate,2,'.','');
											
                    }
                      ?>
                        <tr class="particulars">
                          <td align="center"><?=$snoDep++?></td>
                          <td align="left" style="padding-left:3px"><?= $row['name']?></td>
                          <td align="right" style="padding-right:3px"><?= number_format($totalRate,2,'.','')?></td>
                          <td align="right" style="padding-right:3px"><?= number_format($totalPurchase,2,'.','')?></td>
                          <td align="right" style="padding-right:3px"><?= number_format($totalIssue,2,'.','')?></td>
                          <td align="right" style="padding-right:3px"><?= number_format(($totalRate+$totalPurchase-$totalIssue),2,'.','')?></td>
                        </tr>
                     <?
                     $GrossOpening+=$totalRate;
										 $GrossPurchase+=$totalPurchase;
										 $GrossIssue+=$totalIssue;
										 $GrossClosing+=($totalRate+$totalPurchase-$totalIssue);
                  }
										
             		}   
						 		?>
                 <tr class="note">
                    <td align="right" style="padding-right:3px" colspan="2">Total:</td>
                    <td align="right" style="padding-right:3px"><?= number_format($GrossOpening,2,'.','')?></td>
                    <td align="right" style="padding-right:3px"><?= number_format($GrossPurchase,2,'.','')?></td>
                    <td align="right" style="padding-right:3px"><?= number_format($GrossIssue,2,'.','')?></td>
                    <td align="right" style="padding-right:3px"><?= number_format(($GrossClosing),2,'.','')?></td>
                 </tr>
                <?
                
								
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
        </td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
