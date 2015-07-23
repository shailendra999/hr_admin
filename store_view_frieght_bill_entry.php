<?
include("inc/store_header.php");
?>
<script type="text/javascript" src="ajax/common_function.js"></script>
<?
$Page = "store_add_frieght_bill_entry.php";
$PageTitle = "Add Frieght Bill";
$PageFor = "Frieght Bill";
$PageKey = "frieght_id";
$PageKeyValue = "";
$Message = "";

$frieght_date='';
$reference_number='';
$reference_date='';
$remarks='';
$total_amount='';
$frieght_transaction_id='';
$item_id='';
$po_number='';$quantity='';$amount='';

$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_frieght_entry_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$PageKeyValue=$row['frieght_id'];
		$frieght_date=getDateFormate($row['frieght_date']);
		$reference_number=$row['reference_number'];
		$reference_date=getDateFormate($row['reference_date']);
		$remarks=$row['remarks'];
		$total_amount=$row['total_amount'];
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
}
if(isset($_GET["frieght_id"]))
{
	$frieght_id = $_GET["frieght_id"];
}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;"  valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Freight Bill Entry</td>
				</tr>
				<tr>
					<td valign="top" style="padding-top:10px;">
						<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="red"><?=$Message?></td>
							</tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
									<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                      	<td align="center" valign="top" class="border" width="100%" bgcolor="#FFFFFF">
                      		<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      			<tr style="line-height:22px;background:#EAE3E1;">
                    					<td align="left"><b>Freight Bill NO.</b></td>
                    					<td align="left"><?= $frieght_id ?></td>
                    				  <td align="left"><b>Freight Bill Date</b></td>
                              <td align="left"><?= $frieght_date ?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>Reference No</b></td>
                              <td align="left"><?= $reference_number ?></td>
                              <td align="left"><b>Reference Date</b></td>
                              <td align="left"><?= $reference_date ?></td>
                          </tr>
                        </table>
                    	</td>
                    </tr>
                    <tr>   
                      <td width="100%">
                      	<div id="myDataBaseDiv">
                        	<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                            <tr class="text_tr" bgcolor="#eedfdc">
                              <td align="center"><b>S. No.</b></td>                               
                              <td align="center"><b>Item Code</b></td>
                              <td align="center"><b>Item Name</b></td>
                              <td align="center"><b>UOM</b></td>
                              <td align="center"><b>PO No.</b></td>
                              <td align="center"><b>Qty</b></td>
                              <td align="center"><b>Amount</b></td>                                                                 
                            </tr>
													<?
                          $sql_trans="SELECT * FROM ms_frieght_entry_master mgm,ms_frieght_entry_transaction mgt WHERE mgm.frieght_id=mgt.frieght_id AND mgm.frieght_id ='".$PageKeyValue."'";
                          $res_trans=mysql_query($sql_trans) or die(mysql_error());
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_trans);
                          if($rc_trans>0)
                          {
                            while($row_g_t=mysql_fetch_array($res_trans))
                            {
                                          
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                            ?>
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center"><?=$countTrans ?></td>
                                <td align="center"><?=$row_g_t['item_id']?></td>
                                <td align="center">                                	
                                  <?
                                  $sql_item="select * from ms_item_master where item_id=$row_g_t[item_id]";
                                  $res_item=mysql_query($sql_item);
                                  $row_item=mysql_fetch_array($res_item);
                                  echo $row_item['name'];
                                  ?>
                                </td>                               
                                <td align="center">
                                   <? 
                                  $id = $row_g_t['item_id'];
                                  $sql = "SELECT * FROM  ms_item_master where item_id = '$id'";
                                  $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                  $uname='';
                                  if(mysql_num_rows($result_item)>0)
                                  {
                                    $row_item = mysql_fetch_array($result_item);
                                    $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."'";
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
                                <td align="center"><?= $row_g_t['po_number']?></td>
                                <td align="center"><?= $row_g_t['quantity']?></td>
                                <td align="center"><?= $row_g_t['amount']?></td>
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
                      <tr>
                        <td align="center" colspan="2" class="border" bgcolor="#FFFFFF">
                        	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                             <tr bgcolor="#EAE3E1">
                                <td align="left" valign="top">Remarks</td>
                                <td align="left"><?= $remarks?></td>   
                                <td align="left">Total Amount</td>
                                <td align="left"><?= $total_amount?></td>
                             </tr> 
                          </table>
                        </td>
                  		</tr>
                  		<tr height="5px">
                        <td align="center" colspan="2"></td>
                  		</tr>
                 		</table>
								</td><!-- End Of Main Content -->
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