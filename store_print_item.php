<?
include("inc/dbconnection.php");
include("inc/store_function.php");
$WhereCondition="";
$TypeName="";
if(($_REQUEST['item_name'])!="")
{
	$WhereCondition .="and item_id='".$_REQUEST['item_name']."'";
	
	$sql_I="select name from ms_item_master where item_id='".$_REQUEST['item_name']."'";
	$res_I=mysql_query($sql_I) or die("Error in : ".$sql_I."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($res_I)>0)
	{
		$row_I=mysql_fetch_array($res_I);
		$TypeName.=' Item - '.$row_I['name'].",";
	}
}
if(($_REQUEST['drawingNo'])!="")
{
	$WhereCondition .="and drawing_number like '".$_REQUEST['drawingNo']."' ";
}
if(($_REQUEST['catelogNo'])!="")
{
	$WhereCondition .="and catelog_number like '".$_REQUEST['catelogNo']."' ";
}
if(($_REQUEST['department_id'])!="")
{
	 $WhereCondition .="and id.department_id='".$_REQUEST['department_id']."' ";
	 
	$sql_D="select name from ms_department where department_id='".$_REQUEST['department_id']."'";
	$res_D=mysql_query($sql_D) or die("Error in : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($res_D)>0)
	{
		$row_D=mysql_fetch_array($res_D);
		$TypeName.=' Department - '.$row_D['name'].",";
	}
}
if(($_REQUEST['machinary_id'])!="")
{
	 $WhereCondition .="and mac.machinary_id='".$_REQUEST['machinary_id']."' ";
	 
	  $sql_M="select name from ms_machinary where machinary_id='".$_REQUEST['machinary_id']."'";
	  $res_M=mysql_query($sql_M) or die("Error in : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
	  if(mysql_num_rows($res_M)>0)
	  {
		$row_M=mysql_fetch_array($res_M);
		$TypeName.=' Machinary - '.$row_M['name'].",";
	  }
}
$TypeName=rtrim($TypeName,",");
 $sql="select im.* from ms_item_master im,ms_machinary mac,ms_department id where im.department_id=id.department_id and im.machinary_id=mac.machinary_id $WhereCondition order by im.name asc";
 
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

$numrows = mysql_num_rows($result);
$no_of_rec_show=35;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Item Report</title>
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
.break { page-break-before: always; }
</style>

</head>

<body onload="print();">
<? 
	for($i=0,$countTrans=1;$i<$count;$i++)
	{
	?>
    <div style="margin:0 auto;width:750px;padding:2px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr height="70px">
            <td align="center">
              <b><u>MAHIMA PURESPUN</u></b><br />
              Item Report Of <b><?=$TypeName?></b>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="1" class="tblborder">
                <tr class="note">
                  <td align="center" width="7%">S.No.</td>
                  <td align="center" width="40%">Name</td>
                  <?
                 if(($_REQUEST['department_id'])=="")
                  {
                  ?>
                    <td align="center" width="23%">Department</td>
                  <?
                  }
                  if(($_REQUEST['machinary_id'])=="")
                  {
                  ?>
                    <td align="center" width="23%">Machinary</td>
                  <?
                  }
                  ?>
                  <td align="center" width="10%">Dr. No.</td>
                  <td align="center" width="10%">Cat.No.</td>
                  <td align="center" width="10%">Location</td>
                </tr>
                 <?  
                  if(mysql_num_rows($result)>0)
                  {
                    $sno=1;
										$j=$i*$no_of_rec_show;
										mysql_data_seek($result,$j);
										$k=0;

                    while($row=mysql_fetch_array($result))
                    {	
                    ?>
                    <tr class="particulars">
                      <td align="center"><?=$countTrans++?></td>
                      <td align="left" style="padding-left:2px"><?=$row['name']?></td>
                      <?
                       if(($_REQUEST['department_id'])=="")
                      {
                      ?>
                        <td align="left" style="padding-left:2px">
                          <?
                          $sql_D= "select * from ms_department where department_id='".$row['department_id']."'";
                          $res_D = mysql_query ($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
                          $row_D = mysql_fetch_array($res_D);
                          echo $row_D['name'];
                          ?>
                        </td>
                      <?
                      }
                       if(($_REQUEST['machinary_id'])=="")
                      {
                      ?>
                        <td align="left" style="padding-left:2px">
                          <?
                          $sql_M= "select * from ms_machinary where machinary_id='".$row['machinary_id']."' ";
                          $res_M = mysql_query ($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
                          $row_machinary = mysql_fetch_array($res_M);
                          echo $row_machinary['name'];
                          ?>
                        </td>
                     <?
                     }
                     ?>
                     <td align="left" style="padding-left:2px"><?=$row['drawing_number']?></td>
                     <td align="left" style="padding-left:2px"><?=$row['catelog_number']?></td>
                     <td align="left" style="padding-left:2px"><?=$row['location']?></td>
                    </tr>
                    <?
											if($k==($no_of_rec_show-1))
											{
												break;
											}
											$k++;
                     
                      $sno++;
                    }	
                  }
                  else
                  {
                  ?>
                  <tr>
                    <td colspan="6" align="center" style="font-weight:bold">No Records Found</td>
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
  	<p class="break"></p>
  <?
  }
 ?>
</body>
</html>
