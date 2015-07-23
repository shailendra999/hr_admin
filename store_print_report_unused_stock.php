<? include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/store_function.php");
set_time_limit(0);
$SearchByDepartmentId='';
$SearchInGRNDate='and ms_GRN_master.GRN_date < CAST(now() as DATE)';
	$department_id=$_POST['department_name'];
	$fromDate=getDateFormate($_POST['FromDate']);
	$toDate=getDateFormate($_POST['ToDate']);
	/*if($toDate == ''){
		$toDate = date('Y-m-d');
	}*/
	if($department_id != ''){
		$SearchByDepartmentId=" and ms_department.department_id= ".$department_id;
	}
	if($fromDate != '' && $toDate !=''){
		$SearchInGRNDate="and ms_GRN_master.GRN_date  between '".$fromDate."' and '".$toDate."'";
	}

$sql="SELECT 
ms_department.department_id as DeptId,
ms_department.name as Department,
ms_item_master.item_id as ItemId,
CONCAT(ms_item_master.name,' Drg No . ',ms_item_master.drawing_number) as Description
FROM
ms_item_master,ms_department
WHERE
 ms_department.department_id = ms_item_master.department_id
 $SearchByDepartmentId
ORDER BY ms_department.name asc,ms_item_master.name";//and ms_department.department_id=3
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Unused Stock Report</title>
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
<div style="margin:0 auto;width:740px;border:1px dotted #000000;padding:2px">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr height="70px">
        <td align="center">
          <b><u>MAHIMA PURESPUN</u></b><br />
          UNUSED STOCK REPORT BETWEEN <b><?=getDateFormate($fromDate)?></b> AND <b><?=getDateFormate($toDate)?></b>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<table align="center" width="100%" border="1" cellpadding="0" class="tblborder">
            <tr>
              <td align="center" width="12%">S.No.</td>
              <td align="center" width="60%">Description</td>
              <td align="center" width="15%">GRN Date</td>
              <td align="center" width="13%">Purchase Qty.</td>
            </tr>
          <?  
            if(mysql_num_rows($result)>0)
            {
              $sno = 1;$oldid="";$flag=0;$flag1=0;$deptId='';
              $totalValue=0;$count=0;
              while($row=mysql_fetch_array($result))
              {	
                //$totalValue=0;
                $sql_G="select ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty as PurchaseQty from 
                             ms_GRN_master,ms_GRN_transaction,ms_item_master where
                             ms_GRN_transaction.item_id NOT IN
                             (select ms_IE_transaction.item_id from ms_IE_master,ms_IE_transaction,ms_item_master 
                             where ms_IE_master.IE_id=ms_IE_transaction.IE_id 
                             and ms_IE_transaction.item_id=ms_item_master.item_id)
                             and ms_GRN_transaction.item_id = ms_item_master.item_id 
                             and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id
                             $SearchInGRNDate
                             and ms_item_master.item_id='".$row['ItemId']."'
                            ";			//(DATEDIFF(CAST(now() as DATE),(ms_GRN_master.GRN_date))>=45)
                $res_G=mysql_query($sql_G) or die("Error in : ".$sql_G."<br>".mysql_errno()." : ".mysql_error());
                if(mysql_num_rows($res_G)>0)
                {
                  $row_G=mysql_fetch_array($res_G);
                  if($row['DeptId']!=$oldid)
                  {
                    $checkSql="select ms_GRN_master.GRN_date,ms_GRN_transaction.rec_qty as PurchaseQty from 
                             ms_GRN_master,ms_GRN_transaction,ms_item_master,ms_department where
                             ms_GRN_transaction.item_id NOT IN
                             (select ms_IE_transaction.item_id from ms_IE_master,ms_IE_transaction,ms_item_master 
                             where ms_IE_master.IE_id=ms_IE_transaction.IE_id 
                             and ms_IE_transaction.item_id=ms_item_master.item_id)
                             and ms_GRN_transaction.item_id = ms_item_master.item_id 
                             and ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id
                             and ms_item_master.department_id='".$row['DeptId']."'
                             and ms_department.department_id=ms_item_master.department_id
                             $SearchInGRNDate";
                    $res_Check=mysql_query($checkSql) or die("Error in : ".$checkSql."<br>".mysql_errno()." : ".mysql_error());
                    $remain=mysql_num_rows($res_Check);
                    $oldid = $row['DeptId'];
                    $flag=1;$sno=1;$totalValue=0;
                  }
                  else
                  {
                    $flag=0;
                  }
                  
                  if($flag==1)
                  {
                   ?>
                   <tr>
                    <td colspan="4" align="left" style="font-size:14px;padding-left:15px">
                      <b><?= $row['Department']?></b>
                    </td>
                   </tr>
                   <?
                  }
                  ?>
                  <tr>
                    <td align="center"><?=$sno?></td>
                    <td align="left" style="padding-left:5px"><?= $row['Description']?></td>
                    <td align="center"><b><?=getDateFormate($row_G['GRN_date']);?></b></td>
                    <td align="right" style="padding-right:5px" >
                    <?
                      echo number_format($row_G['PurchaseQty'],2,'.','');
                      $totalValue+=$row_G['PurchaseQty'];
                    ?>
                    </td>
                  </tr>
                  <? $sno++;$count++;$remain--;
                  if($remain==0)
                  {
                  ?>
                     <tr>
                      <td colspan="3"><b>&nbsp;Total</b></td>
                      <td align="right" style="padding-right:2px">
                        <?= number_format($totalValue,2,'.','')?>
                      </td>
                     </tr>
                  <?
                  
                  }//End Of If For Total 
                  
                }//End of Inner Count
                
                
              }//End Of While
            }// End Of Outer If
            else
            {
            ?>
              <tr>
                <td colspan="4" align="center"><b>No Records Found</b></td>
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
