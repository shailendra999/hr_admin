<?
include("inc/store_header.php");
?>
<script>
function checkData() {
  var bdFrom = document.getElementById("PendingDateFrom").value;
	var bdTo = document.getElementById("PendingDateTo").value;
	if(bdFrom=='' || bdTo=='')
	{
		alert("Select Date Range");
		return false;
	}
	else
	{
		document.getElementById('byControl').value='PendingDateRange';
		return true;
	}
}

</script>
<?
$Page = "store_list_bill_passing_pending.php";
$PageTitle = "List Bill Passing Pending";
$PageFor = "Bill Passing Pending";
$PendingDateFrom="";$PendingDateTo="";
$byControl='';
$sql="";
?>
<?

if(isset($_POST['btn_ok']))
{
	if($_POST['byControl']!='')
	{
		$byControl='PendingDateRange';
		$PendingDateFrom=getDateFormate($_POST['PendingDateFrom']);
		$PendingDateTo=getDateFormate($_POST['PendingDateTo']);
		$sql="select ms_GRN_master.*,ms_GRN_transaction.* from ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_master.GRN_date BETWEEN '".$PendingDateFrom."' AND '".$PendingDateTo."' and ms_GRN_master.GRN_id NOT IN (select GRN_id from ms_bill_pass_master_new) order by ms_GRN_master.GRN_id";
	}
}
else
	$sql="select ms_GRN_master.*,ms_GRN_transaction.* from ms_GRN_master,ms_GRN_transaction where ms_GRN_master.GRN_id=ms_GRN_transaction.GRN_id and ms_GRN_master.GRN_id NOT IN (select GRN_id from ms_bill_pass_master_new) order by ms_GRN_master.GRN_id";
	
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());	
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
  <td align="left" valign="top" width="230px" style="padding-top:5px;">
  	<? include ("inc/store_snb.php"); ?>
  </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
   		<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        	<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; <?=$PageTitle?>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
              	<td>
                	<form method="post" action="" onsubmit="return checkData();">
                  	<table width="80%" align="center" border="1" cellspacing="2" cellpadding="2" class="table1 text_1">
                      <tr>
                        <td align="center" colspan="4"><b>Search Items</b></td>
                      </tr>
                      <tr>
                        <td align="left"><b>Pending Date</b></td>
                        <td align="left">
                        	<input type="text" name="PendingDateFrom" id="PendingDateFrom" readonly="readonly"/>
                          <a hidefocus="" onclick="gfPop.fPopCalendar(document.getElementById('PendingDateFrom'));return false;" href="javascript:void(0)">
                          	<img height="22" border="0" align="absbottom" width="34" alt="" src="./calendar/calbtn.gif" name="popcal">
                          </a>
                        </td>
                        <td align="left">
                        	<input type="text" name="PendingDateTo" id="PendingDateTo" readonly="readonly"/>
                          <a hidefocus="" onclick="gfPop.fPopCalendar(document.getElementById('PendingDateTo'));return false;" href="javascript:void(0)">
                          	<img height="22" border="0" align="absbottom" width="34" alt="" src="./calendar/calbtn.gif" name="popcal">
                          </a>
                        </td>
                        <td  align="center">
                          <input type="hidden" name="byControl" id="byControl" value=""/>
                          <input type="submit" name="btn_ok" id="btn_ok" value="Ok"/>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="button" name="btn_reset" id="btn_reset" value="Reset" onclick="location.href='store_list_bill_passing_pending.php';"/>
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            	<tr>
                <td align="center" class="border" valign="top">
                  <?
									if($byControl!='')
									{
									?>
                  	<div class="AddMore" style="padding-top:10px">
                    <form action="store_print_bill_passing_pending.php" name="test" id="test" method="post" target="_blank"> 
                    	<input type="hidden" name="byControl" id="byControl" value="<?=$byControl ?>" />
                      <input type="hidden" name="PendingDateFrom" id="PendingDateFrom" value="<?=$PendingDateFrom ?>" />
                      <input type="hidden" name="PendingDateTo" id="PendingDateTo" value="<?=$PendingDateTo ?>" />
                        <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
                     </form>
                    </div>
                  <?
									}
									?>
                  <div style="height:850px;overflow:auto">
                    <table align="center" width="100%" border="1" class="table1 text_1">
                      <tr>
                        <td class="gredBg" width="6%">S.No.</td>
                        <td class="gredBg" width="6%">GRN No.</td>
                        <td class="gredBg" width="10%">GRN Date</td>
                        <td class="gredBg" width="6%">Inv. No.</td>
                        <td class="gredBg" width="10%">Inv. Date</td>
                        <td class="gredBg" width="20%">Supplier</td>
                        <td class="gredBg" width="20%">ItemName</td>
                        <td class="gredBg" width="7%">ItemQty</td>
                        <td class="gredBg" width="7%">NetRate</td>
                        <td class="gredBg" width="8%">Total Amt.</td>
                      </tr>
                      <?  
                      if(mysql_num_rows($result)>0)
                      {
                        $sno = 1;$totalQty=0;$totalNetRate=0;$totalValue=0;
                        while($row=mysql_fetch_array($result))
                        {	
                         
                        ?>
                        <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
                          <td align="center"><?=$sno?></td>
                          <td align="center"><?=$row['GRN_id']?></td>
                          <td align="center"><?= getDateFormate($row['GRN_date'])?></td>
                          <td align="center"><?=$row['inv_number']?></td>
                          <td align="center"><?=getDateFormate($row['inv_date']);?></td>
                          <td align="left" style="padding-left:2px">
                            <?
                            $sql_S="select name from ms_supplier where supplier_id='".$row['supplier_id']."'";
                            $result_S = mysql_query($sql_S) or die (mysql_error());;
                            $row_S = mysql_fetch_array($result_S);
                            echo $row_S['name'];
                            ?>
                          </td>
                          <td align="left" style="padding-left:2px">
                            <?
                            $sql_I="select name,CONCAT(name,';Drg No. ',drawing_number,';Cat No. ',catelog_number) as ItemDescription from ms_item_master,ms_GRN_transaction where ms_GRN_transaction.item_id=ms_item_master.item_id and ms_item_master.item_id='".$row['item_id']."'";
                            $result_I = mysql_query($sql_I) or die (mysql_error());;
                            $row_I = mysql_fetch_array($result_I);
                            echo $row_I['ItemDescription'];
                            ?>
                          </td>
                          <td align="right" style="padding-right:2px">
                            <?
                            echo number_format($row['rec_qty'],2,'.','');
                            $totalQty+=number_format($row['rec_qty'],2,'.','');
                            $totalNetRate+=number_format($row['net_rate'],2,'.','');
                            ?>
                          </td>
                          <td align="right" style="padding-right:2px"><?=number_format($row['net_rate'],2,'.','');?></td>
                          <td align="right" style="padding-right:2px">
                            <?
                            echo number_format($row['total_amount'],2,'.','');
                            $totalValue+=number_format($row['total_amount'],2,'.','');
                            ?>
                          </td>
                        </tr>
                        <?
                        $sno++;
                        }	
                        ?>
                          <tr>
                            <td align="right" colspan="7" style="padding-right:10px"><b>Total : </b></td>
                            <td align="right" style="padding-right:2px"><?=number_format($totalQty,2,'.','')?></td>
                            <td align="right" style="padding-right:2px"><?=number_format($totalNetRate,2,'.','')?></td>
                            <td align="right" style="padding-right:2px"><?=number_format($totalValue,2,'.','')?></td>
                          </tr>
                        <?
                      }
                      else
                      {
                        ?>
                        <tr><td align="center" colspan="10"><b>No Record Found.</b></td></tr>
                        <?
                      }
                      ?>  
                    </table>      
                  </div>
    						</td>
    					</tr>
    				</table>
    			</td>
    		</tr>  
    	</table> 
    </td>
	</tr>
</table> 
<iframe scrolling="no" height="172" frameborder="0" width="168" style="border: 2px ridge; visibility: hidden; z-index: 999; position: absolute; left: 502px; top: 216px;" src="calendar/ipopeng.htm" id="gToday:normal:agenda.js" name="gToday:normal:agenda.js">
</iframe>
<? 
include("inc/hr_footer.php");
?>