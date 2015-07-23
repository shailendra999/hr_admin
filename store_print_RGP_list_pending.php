<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

$WhereCondition = "";

$WhereCondition .= ($_POST["RGP_id"] != "") ? " and mm.RGP_id = '".$_POST["RGP_id"]."'" : "";

$WhereCondition .= ($_POST["supplier_id"] != "") ? " and mm.supplier_id = '".$_POST["supplier_id"]."'" : "";

$WhereCondition .= ($_POST["RGPDate"] != "") ? " and mm.RGP_date = '".getDateFormate($_POST["RGPDate"])."'" : "";

$WhereCondition .= ($_POST["item_id"] != "") ? " and mt.item_name like '%".$_POST["item_id"]."%'" : "";

$WhereCondition .= ($_POST["department_id"] != "") ? " and mt.department_id = '".$_POST["department_id"]."'" : "";


$sql="select 
			mm.RGP_id,
			mm.RGP_date,
			mm.supplier_id,
			mt.item_name,
			mt.quantity,
			mt.pend_qty 
		from 
			ms_RGP_master mm,
			ms_RGP_transaction mt 
		where 
			mm.RGP_id=mt.RGP_id  
			".$WhereCondition." and mt.pend_qty>0
		order by 
			mm.RGP_id 
			asc";

//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());;


/*$numrows = mysql_num_rows($result);
$no_of_rec_show=35;
$count = ceil($numrows/$no_of_rec_show);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print List RGP</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
height:30px;
text-align:center;
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
.break { page-break-before: always; }
</style>

</head>

<body onload="print();">
  <div style="margin:0 auto;width:740px;padding:2px">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr height="70px">
            <td align="center">
              <b><u>MAHIMA PURESPUN</u></b><br />
              
              
              	<?
                $TypeName='';
				if($_REQUEST['department_id'] != "")
                {
					$sql_D="select name from ms_department where department_id='".$_POST["department_id"]."'";
					$res_D=mysql_query($sql_D) or die("Error in : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($res_D)>0)
					{
						$row_D=mysql_fetch_array($res_D);
						$TypeName=' Of Department - '.$row_D['name'];
					}
                }
				
                else if($_POST["supplier_id"] != "")
                {
					$sql_S="select name from ms_supplier where supplier_id='".$_POST["supplier_id"]."'";
					$res_S=mysql_query($sql_S) or die("Error in : ".$sql_S."<br>".mysql_errno()." : ".mysql_error());
					if(mysql_num_rows($res_S)>0)
					{
						$row_S=mysql_fetch_array($res_S);
						$TypeName='Of Supplier - <u>'.$row_S['name'].'</u>';
					}
                }
                else if($_POST["item_id"] != "")
                {
                    $TypeName='Of Item Name Like - <u>'.$_POST["item_id"].'</u>';
                }
				else if($_POST["RGPGRNDate"] != "")
                {
                    $TypeName='On Date - <u>'.getDateFormate($_POST["RGPGRNDate"]).'</u>';
                }
				else if($_POST["RGP_id"] != "")
                {
                    $TypeName='Of RGP GRN No. - <u>'.$_POST["RGP_id"].'</u>';
                }
              ?>
              RGP Pending Report <b><?=$TypeName?></b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                  <td>S.No.</td>
                  <td>RGP No.</td>
                  <td>RGP Date</td>
                  <td>Supplier</td>
                  <td>Item Name</td>
                  <td>RGP Qty.</td>
                  <td>Pend Qty.</td>
               </tr>	
                <?  
                if(mysql_num_rows($result)>0)
                {
                  $sno = 1;$oldid = "";$count =1;$flag=0;
                  while($row=mysql_fetch_array($result))
                  {	
                   $sql_idate="select * from ms_RGP_master where insert_date='".date('Y-m-d')."' and RGP_id='".$row['RGP_id']."'";
                    $res_idate=mysql_query($sql_idate);	
                    $row_idate=mysql_fetch_array($res_idate);
                    $insert_date=$row_idate['insert_date'];
                    ?>
                    <tr class="particulars">
                      <td align="center"><?=$sno?></td>
                      <td align="center"><?= $row['RGP_id']?></td>
                      <td align="center"><?=getDateFormate($row['RGP_date']);?></td>
                      <td align="left" style="padding-left:3px">
                      <?
                        $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
                        $res_sup = mysql_query ($sql_sup) or die ("Invalid query : ".$sql_sup."<br>".mysql_errno()." : ".mysql_error());
                        $row_sup = mysql_fetch_array($res_sup);
                        echo $row_sup['name'];
                       ?>
                      </td>
                      <td align="left" style="padding-left:3px"><?= $row['item_name']?></td>
                      <td align="center"><?= $row['quantity']?></td>
                      <td align="center"><?= $row['pend_qty']?></td>
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
        </tbody>
      </table>
  </div>  
</body>
</html>
