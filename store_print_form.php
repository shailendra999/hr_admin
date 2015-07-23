<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$byControl=$_POST['byControl'];
	if($byControl=="FormDate")
	{
		$byControlValue=$_POST['byControlValue'];
		$formDate=getDateFormate($_POST['byControlValue']);
		$sql="select *,ms_form_master.form_id as Id from ms_form_master left join ms_form_transaction on  ms_form_master.form_id=ms_form_transaction.form_id where  ms_form_master.form_date='".$formDate."'";
	}
	if($byControl=="FormId")
	{
		$byControlValue=$_POST['byControlValue'];
		$formId=$_POST['byControlValue'];
		$sql="select *,ms_form_master.form_id as Id from ms_form_master left join ms_form_transaction on  ms_form_master.form_id=ms_form_transaction.form_id ms_form_master.form_id='".$formId."'";
	}
$result=mysql_query($sql)or die("Error In : ".$sql."<br />".mysql_errno());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Form Entry</title>

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
</style>
</head>

<body onload="print();">
<div style="width:740px;margin:0 auto">
<table width="100%" border="0" class="tblborder" cellspacing="0" cellpadding="0">
  <thead>
    <tr height="70px">
      <td align="center">
        <b> MAHIMA PURESPUN</b><br />
        <?
          if($_POST['byControl']=='FormDate')
            echo 'Form Entry As On <b>'.getDateFormate($formDate).'</b>';
          else if($_POST['byControl']=='FormId')
          {
            echo 'Form Entry Of <b>'.$formId.'</b>';
          }
          /*else if($_POST['byControl']=='supplier_id')
          {
            $sql_S="select name from ms_supplier where supplier_id='".$supplier_id."'";
            $res_S=mysql_query($sql_S) or die("Error in : ".$sql_S."<br>".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($res_S)>0)
            {
              $row_S=mysql_fetch_array($res_S);
              echo 'Bill Passing Of <b>Supplier - <u>'.$row_S['name'].'</u></b>';
            }
          }*/
        ?>
      </td>
    </tr>
  </thead>
  <tr>
    <td>
    	<table align="center" width="100%" border="1" class="tblborder" cellpadding="0">
            <tr class="note">
              <td align="center">S.No.</td>
              <td align="center">Form Id.</td>
              <td align="center">Form Date.</td>
              <td align="center">Form No.</td>
              <td align="center">GRN No.</td>
              <td align="center">GRN Date.</td>
              <td align="center">Supplier Name</td>
            </tr>
            <?  
            if(mysql_num_rows($result)>0)
            {
              $sno = 1;
              while($row=mysql_fetch_array($result))
              {	
              ?>
                <tr class="particulars">
                  <td align="center"><?=$sno?></td>
                  <td align="center"><?=$row['Id']?></td>
                  <td align="center"><?=getDateFormate($row['form_date'])?></td>
                  <td align="left" style="padding-left:2px"><?=$row['form_no']?></td>
                  <td align="center"><?=$row['GRN_no']?></td>
                  <td align="center"><?=getDateFormate($row['GRN_date'])?></td>
                  <td align="left" style="padding-left:2px">
                    <?
                    $select_supp= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
                    $result_supp = mysql_query ($select_supp) or die (mysql_error());
                    $row_supp = mysql_fetch_array($result_supp);
                    echo $row_supp['name'];
                    ?>
                  </td>
                </tr>
              <?
              $sno++;
              }	
            }
            else
            {
              ?>
                <tr><td align="center" colspan="7"><b>No Record Found.</b></td></tr>
              <?
            }
            ?> 
          </table>
    </td>
  </tr>
</table>

 
  
</div>
                    
</body>
</html>
