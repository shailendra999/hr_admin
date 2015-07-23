<?
include("inc/check_session.php");
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");


$PageFor = "Indent";
$PageKey = "indent_id";

$date = '';
$indent_id='';
$indent_department = '';$approved_by = '';$authorised_status = '';
$authorised_by = '';$authorised_date = '';$indent_transaction_id = '';$item_id = '';
$stock = '';$required_quantity = '';$approval_status = '';$rate = '';
$approved_quantity = '';$due_date = '';$remark = '';$purpose = '';
$PageKeyValue = "";
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_indent_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$indent_id = $row[$PageKey];
		$date = getDateFormate($row["indent_date"]);
		$department_id = $row["department_id"];
		$approved_by = $row["approved_by"];
	}
}
$sql_count = "select count(*) as count from ms_indent_master,ms_indent_transaction 
where ms_indent_master.indent_id=ms_indent_transaction.indent_id and ms_indent_master.indent_id='".$indent_id."'";
$result_count = mysql_query($sql_count) or die ("Invalid query : ".$sql_count."<br>".mysql_errno()." : ".mysql_error());
$row_count = mysql_fetch_array($result_count);
$numrows = $row_count['count'];
$no_of_rec_show=13;
$count = ceil($numrows/$no_of_rec_show);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Purchase Indent</title>
<style>
.note
{
font: Arial, Helvetica, sans-serif;
font-size:13px;
}
.particulars
{
font: Arial, Helvetica, sans-serif;
font-size:12px;
height:42px;
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
.padding_left
{
	padding-left:2px;
}
.break { page-break-before: always; }
</style>
</head>

<body onload="print();">
<? 
	for($i=0,$countTrans=1;$i<$count;$i++)
	{
	?>
    <div style="width:740px;margin:0 auto;font:Arial, Helvetica, sans-serif;border:1px solid #000">
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      	<thead> 
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2" height="100%">
              <tr>
                <td align="center" colspan="2"><b style="font-size:24px;">MAHIMA PURESPUN</b></td>
              </tr>
              <tr>
                <td colspan="2" align="center">
                  (A UNIT OF MAHIMA FIBRES PVT. LTD.)<br />
                  Factory : PLOT No. 73 - 74 SECTOR-II, PITHAMPUR, DISTT. DHAR<br />
                  Phones : 07292 416300-328 Fax :07292 252985
                </td>
              </tr>
            </table>    
            </td>
          </tr>
					<tr>
            <td align="center" class="borderTop">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
              	<tr>
                    <td align="center" class="borderBottom" colspan="2">
                      <b style="font-size:20px">Purchase Indent</b>
                    </td>
                  </tr>
                <tr>
                  <td width="60%" class="borderRight" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2" style="padding-top:4px; padding-bottom:4px;">
                      <tr>
                        <td align="left"><b>Department :</b></td>
                        <td align="left">
                          <?
                          $res_D=mysql_query("select name from ms_department where department_id='".$department_id."'");
                          $row_D=mysql_fetch_array($res_D);
                          echo $row_D['name'];
                          ?>
                        </td>
                      </tr>
                      <!--<tr>
                        <td align="left"><b>Purchase Order No. :</b></td>
                        <td colspan="3" align="left">&nbsp;___________</td>
                      </tr>-->
                    </table>
                  </td>
                  <td width="40%" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>
                        <td align="left"><b>Indent No. :</b></td>
                        <td align="left"><?= $PageKeyValue ?></td>
                      </tr>
                      <tr>
                        <td align="left"><b>Indent Date</b></td>
                        <td align="left"><?= $date?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
      		</tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <table align="center" width="100%" border="0" cellspacing="0" cellpadding="1" class="tblborder">
                 <tr style="font-size:13px" class="borderBottom borderTop">
                  <td align="center" class="borderRight" width="6%">S.No.</td>
                  <td align="center" class="borderRight" width="8%">Item No.</td>
                  <td align="center" class="borderRight" width="41%">Particulars</td>
                  <td align="center" class="borderRight" width="8%">UOM</td>
                  <td align="center" class="borderRight" width="7%">Ind. Qty.</td>
                  <td align="center" class="borderRight" width="15%">Purpose</td>
                  <td align="center" width="15%">Remark</td>
                </tr>
                <?
                $sql_order_trans="SELECT * FROM ms_indent_master mom, ms_indent_transaction mot WHERE mom.indent_id = mot.indent_id AND mom.indent_id ='".$PageKeyValue."'";
                $res_order_trans=mysql_query($sql_order_trans);
                $rc_trans=mysql_num_rows($res_order_trans);
                if($rc_trans>0)
                {
									
									$j=$i*$no_of_rec_show;
									mysql_data_seek($res_order_trans,$j);
									$k=0;
                  while($row_t=mysql_fetch_array($res_order_trans))
                  {
                  ?>
                  <tr class="particulars">
                    <td align="center" class="borderRight" valign="top"><?= $countTrans++?></td>
                    <td align="center" class="borderRight" valign="top"><?=$row_t['item_id']?></td>
                    <td align="left" style="padding-left:5px;" class="borderRight" valign="top">
                      <div style="height:40px;overflow:hidden">
											<?
                      $sql_item="select * from ms_item_master where item_id='".$row_t['item_id']."' ";
                      $res_item=mysql_query($sql_item);
                      $row_item=mysql_fetch_array($res_item);
                      echo "<div style='height:14px;overflow:hidden;padding:0px'>".$row_item['name']."</div>";
                      echo "<div style='height:13px;overflow:hidden;padding:0px'><b>Draw. No. :</b> " .$row_item['drawing_number']."</div>";
                      echo "<div style='height:13px;overflow:hidden;padding:0px'><b>Cat. No. :</b> " .$row_item['catelog_number']."</div>";
                      ?>
                      </div>
                    </td>
                    <td align="center" class="borderRight" valign="top">
                    <? 
                      $id = $row_t['item_id'];
                      $sql = "SELECT * FROM  ms_item_master where item_id = '$id' order by name ";
                      $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                      $uname='';
                      if(mysql_num_rows($result_item)>0)
                      {
                        $row_item = mysql_fetch_array($result_item);
                        $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
                        $result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                        if(mysql_num_rows($result_uom)>0)
                        {
                          $row_uom = mysql_fetch_array($result_uom);
                          $uname= $row_uom['uname'];
                        }
                      }
                      echo $uname;
                      ?>
                    </td>
                    <td align="center" class="borderRight" valign="top"><?=$row_t['required_quantity']?></td>
                    <td align="left" class="borderRight padding_left" valign="top"><?=$row_t['purpose']?></td>
                    <td align="left" class="padding_left" valign="top"><?=$row_t['remark']?></td>
                  </tr>
                  <?
                  if($k==($no_of_rec_show-1))
                  {
                    break;
                  }
                  $k++;
                }
              }
              for($l=$k;$l<=$no_of_rec_show;$l++)
              {
              ?>
              <tr style="height:42px">
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td class="borderRight" align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
              </tr>
							<?
               }
              ?>
              </table>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td align="left" class="borderTop" style="padding-top:5px;padding-bottom:5px">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                     <tr>
                      <td align="right" height="80px" colspan="4"><b>For MAHIMA PURESPUN</b>&nbsp;&nbsp;&nbsp;&nbsp;<br />
                      (A Unit Of Mahima Fibres Pvt. Ltd.)&nbsp;&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="left">&nbsp;Dept. Head</td>
                        <td align="center">Store Incharge</td>
                        <td align="center"><table cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="left"></td>
                            <td align="left">DGM</td>
                          </tr>
                        </table></td>
                        <td align="right">GM</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </tfoot>
			</table>
  	 </div>
		<p class="break"></p>
   <?
   	}
   ?>
</body>
</html>
