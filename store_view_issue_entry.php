<?
include("inc/store_header.php");
?>
<?
$Page = "store_add_issue_entry.php";
$PageTitle = "Add Issue Entry";
$PageFor = "Issue Entry";
$PageKey = "IE_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}
//////////////////////////////////////////////////////////
$issue_id='';$purpose='';$issue_date='';
$item_id='';$stk_qty='';$req_qty='';$iss_qty='';$godown='';$department_id='';$machinary_id='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_IE_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$purpose=stripslashes($row['purpose']);
		$issue_date=getDateFormate($row['IE_date']);		
	}
}

if(isset($_GET["IE_id"]))
{
	$issue_id = $_GET["IE_id"];
}

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
				<tr>
					<td align="center" class="gray_bg">
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Issue Entry
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
                   <a target="_blank" href="store_print_issue_entry.php?IE_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                	<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#FFFFFF">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Issue EntryNo.</b></td>
                            <td align="left"><?= $issue_id ?></td>
                            <td align="left"><b>Issue Entry Date</b></td>
                            <td align="left"><?= $issue_date?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>Purpose</b></td>
                            <td align="left" colspan="3"><?= $purpose?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>   
                      <td width="100%">
                        <div id="myDataBaseDiv">
                          <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                            <tr class="text_tr" height="25px" bgcolor="#eedfdc">
                              <td align="center" width="10%"><b>S. No. </b></td>                               
                              <td align="center" width="10%"><b>Item No.</b></td>
                              <td align="center" width="60%"><b>Item Name</b></td>
                              <td align="center" width="10%"><b>UOM</b></td>
                              <td align="center" width="10%"><b>Iss. Qty</b></td>                                  
                            </tr>
                          <?
                          $sql_IE_trans="SELECT * FROM ms_IE_master mgm,ms_IE_transaction mgt WHERE mgm.IE_id=mgt.IE_id AND mgm.IE_id ='".$PageKeyValue."'";
                          $res_IE_trans=mysql_query($sql_IE_trans);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_IE_trans);
                          if($rc_trans>0)
                          {
                            while($row_IE_t=mysql_fetch_array($res_IE_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                            ?>
                              <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                <td align="center"><?=$countTrans ?></td>
                                <td align="center"><?=$row_IE_t['item_id']?></td>
                                <td align="left" style="padding-left:5px">
                                    <?
                                    $sql_item="select * from ms_item_master where item_id=$row_IE_t[item_id]";
                                    $res_item=mysql_query($sql_item);
                                    $row_item=mysql_fetch_array($res_item);
                                    echo $row_item['name'].';Drg No.: '.$row_item['drawing_number'].';Cat No.: '.$row_item['catelog_number'];
                                  ?>
                                </td>                               
                                <td align="center">
                                <? 
                                  $id = $row_IE_t['item_id'];
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
                                <td align="center"><?= $row_IE_t['iss_qty']?></td>
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