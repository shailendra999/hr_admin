<?
include("inc/store_header.php");
?>
<?
$Page = "store_add_issue_return.php";
$PageTitle = "Add Issue Return";
$PageFor = "Issue Return";
$PageKey = "IR_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}
//////////////////////////////////////////////////////////
$IR_id='';$remarks='';$IR_date='';$returned_by='';
$item_id='';$return_qty='';$return_type='';$godown='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_IR_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$remarks=stripslashes($row['remarks']);
		$returned_by=$row['returned_by'];
		$IR_date=getDateFormate($row['IR_date']);		
	}
}

if(isset($_GET["IR_id"]))
{
	$IR_id = $_GET["IR_id"];
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px;padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Issue Return
          </td>
				</tr>
				<tr>
					<td valign="top" style="padding-top:10px;">
						<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="red"><?=$Message?></td>
							</tr>
              <tr>
                <td class="AddMore">
                   <a target="_blank" href="store_print_issue_return.php?IR_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#FFFFFF">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Issue Return No.</b></td>
                            <td align="left"><?= $IR_id ?></td>
                            <td align="left"><b>Issue Return Date</b></td>
                            <td align="left"><?= $IR_date ?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>Returned By</b></td>
                            <td align="left"><?= $returned_by?></td>
                            <td align="left"><b>Remarks</b></td>
                            <td align="left"><?= $remarks?></td>
                          </tr>
                        </table>
                      </td>
                  </tr>
                  <tr>   
                    <td width="100%">
                      <div id="myDataBaseDiv">
                      	<table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                          <tr class="text_tr" bgcolor="#eedfdc">
                            <td align="center"><b>S. No. </b></td>                               
                            <td align="center"><b>Item No.</b></td>
                            <td align="center"><b>Item Name</b></td>
                            <td align="center"><b>UOM</b></td>
                            <td align="center"><b>Ret. Qty</b></td>
                            <td align="center"><b>Ret. Type</b></td>
                          </tr>
												<?
                        $sql_IR="SELECT * FROM ms_IR_master mgm,ms_IR_transaction mgt WHERE mgm.IR_id=mgt.IR_id AND mgm.IR_id ='".$PageKeyValue."'";
                        $res_IR=mysql_query($sql_IR);
                        $countTrans=1;
                        $rc_trans=mysql_num_rows($res_IR);
                        if($rc_trans>0)
                        {
                          while($row_IR=mysql_fetch_array($res_IR))
                          {
                            if($countTrans%2==0)
                              $tableColor="#eedfdc";
                            else
                              $tableColor="#f8f1ef";
                          ?>
                            <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <td align="center"><?=$countTrans ?></td>
                              <td align="center"><?=$row_IR['item_id']?></td>
                              <td align="left" style="padding-left:5px"> 
                                  <?
                                  $sql_item="select * from ms_item_master where item_id=$row_IR[item_id]";
                                  $res_item=mysql_query($sql_item);
																	$row_item=mysql_fetch_array($res_item);
                                  echo $row_item['name'];
                                	?>
                              </td>                               
                              <td align="center">
                              <? 
                                $id = $row_IR['item_id'];
                                $sql = "SELECT * FROM  ms_item_master where item_id = '$id'";
                                $result_item = mysql_query ($sql) or die (mysql_error());
                                $uname='';
                                if(mysql_num_rows($result_item)>0)
                                {
                                  $row_item = mysql_fetch_array($result_item);
                                  $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."'";
                                  $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                  if(mysql_num_rows($result_uom)>0)
                                  {
                                    $row_uom = mysql_fetch_array($result_uom);
                                    $uname= $row_uom['uname'];
                                  }
                                }
                                echo $uname;
															?>
                              </td>
                              <td align="center"><?= $row_IR['return_qty']?></td>
                              <td align="center">
																<?
                              		$sql="select * from ms_return_type where return_type_id=$row_IR[return_type_id]";
                                  $res=mysql_query($sql);
																	$row=mysql_fetch_array($res);
                                  echo $row['return_type'];
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