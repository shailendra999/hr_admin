<?
include("inc/maint_header.php");
?>

<?
$Page = "maint_view_item_received.php";
$PageTitle = "View Item Recieved";
$PageFor = "Item Recieved";
$PageKey = "IR_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
$IR_date='';
$IR_transaction_id = "";

$item_id='';$req_qty='';$rec_qty='';$pend_qty='';$maint_stock='';

?>
<?


if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_item_received_master where $PageKey = '".$_GET[$PageKey]."'";
	$result=mysql_query ($sql) or die("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$IR_id = $row[$PageKey];
		$IR_date = getDateFormate($row['IR_date']);
	}
}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Item Recieved
          </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td width="19%" align="left"><b>Item Rec. No</b></td>
                            <td width="81%" colspan="3" align="left"><?= $IR_id ?></td>
                          </tr>
                          <tr>
                            <td align="left"><b>Date Of Item Recieved</b></td>
                            <td align="left"><?= $IR_date ?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div id="myDataBaseDiv">
                        	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="border">
                            <tr bgcolor="#eedfdc" class="text_tr">
                              <td align="center" style="font-weight:bold;">SNo.</td>
                              <td align="center" style="font-weight:bold;">Item Desc</td>
                              <td align="center" style="font-weight:bold;">Req. Qty</td>
                              <td align="center" style="font-weight:bold;">Rec. Qty</td>
                              <td align="center" style="font-weight:bold;">Pend. Qty</td>
                              <td align="center" style="font-weight:bold;">Stock</td>
                            </tr>
													<?
                          $sql_item_trans="SELECT * 
                          FROM 
                          maint_item_received_master mim, 
                          maint_item_received_transaction mit 
                          WHERE 
                          mim.IR_id = mit.IR_id AND mit.IR_id ='".$PageKeyValue."' ";
                           
                          $res_item_trans=mysql_query($sql_item_trans) or die(mysql_error());
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_item_trans);
                          if($rc_trans>0)
                          {
                            while($row_i_t=mysql_fetch_array($res_item_trans))
                            {
                              if($countTrans%2==0)
                              $tableColor="#eedfdc";
                              else
                              $tableColor="#f8f1ef";
                              ?>
                                
                                  <tr class="text_tr" bgcolor="<?= $tableColor?>">
                                    <td align="center"><?= $countTrans?></td>
                                    <td align="left" style="padding-left:3px">
                                    <?
                                    $sql_S="select 
                                        ms_item_master.name as ItemName, 
                                        ms_item_master.item_id, 
                                        ms_item_master.drawing_number, 
                                        ms_item_master.catelog_number, 
                                        ms_uom.name as UOM
                                        from 
                                        ms_item_master, ms_uom	
                                        where 
                                        ms_uom.uom_id = ms_item_master.uom_id
                                        and ms_item_master.item_id='".$row_i_t['item_id']."'
                                        order by ms_item_master.name asc";
                                      $res_S=mysql_query($sql_S) or die(mysql_error());
                                    ?>
                                      <?
                                      if(mysql_num_rows($res_S)>0)
                                      {
                                        while($row_S=mysql_fetch_array($res_S))
                                        {
                                        echo$row_S['ItemName']." ; ".$row_S['drawing_number']." ; ".$row_S['catelog_number']." ; ".$row_S['UOM'];
                                        }
                                      }
                                      ?>
                                    </td>
                                    <td align="center"><?=$row_i_t['req_qty']?></td>
                                    <td align="center"><?=$row_i_t['rec_qty']?></td>
                                    <td align="center"><?=$row_i_t['pend_qty']?></td>
                                    <td align="center">
                                    <?
                                    $sql_stk = "select * from maint_item_stock where item_id = '".$row_i_t['item_id']."' ";
                                    $result_stk = mysql_query ($sql_stk) or die ("Invalid query : ".$sql_stk."<br>".mysql_errno()." : ".mysql_error());
                                    if(mysql_num_rows($result_stk)>0)
                                    {
                                      $row_stk = mysql_fetch_array($result_stk);
                                      $maint_stock = $row_stk['maint_stock'];
                                      echo $maint_stock;
                                    }
                                    ?>
                                    </td>
                                  </tr>
                                
                             <?			
                              $countTrans++; 													 
                            } // end of while
                        	}// end if	
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
  	</td>
  </tr>
</table>
<? 
include("inc/hr_footer.php");
?>