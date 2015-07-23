<?
include("inc/store_header.php");
?>
<?
$Page = "store_view_RGP.php";
$PageTitle = "View RGP";
$PageFor = "RGP";
$PageKey = "RGP_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}

//////////////////////////////////////////////////////////
$RGP_id='';$RGP_date='';$supplier_id='';$RGP_type='';$ref_quot_no='';$ref_quot_date='';
$despatch_through='';$special_instr=''
;
$item_id='';$remarks='';$quantity='';$value='';$duedate='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_RGP_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$RGP_date=getDateFormate($row['RGP_date']);
		$supplier_id=$row['supplier_id'];
		$ref_quot_no=$row['ref_quot_no'];	
		$ref_quot_date=getDateFormate($row['ref_quot_date']);
		$despatch_through=$row['despatch_through'];
		$special_instr=stripslashes($row['special_instr']);
	}
}
if(isset($_GET["RGP_id"]))
{
	$RGP_id = $_GET["RGP_id"];
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View RGP
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
                	<a target="_blank" href="store_print_RGP.php?RGP_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#FFFFFF">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>RGP No.</b></td>
                            <td align="left"><?= $RGP_id ?></td>
                            <td align="left"><b>RGP Date</b></td>
                            <td align="left"><?= $RGP_date ?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>Supplier</b></td>
                            <td align="left" colspan="3">
                              <?
																$sql_sup="select * from ms_supplier where supplier_id=$supplier_id";
																$res_sup=mysql_query($sql_sup);
																$row_sup=mysql_fetch_array($res_sup);
																echo $row_sup['name'];
															?>
                            </td>
                            
                          </tr>
                           <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Ref. Quot. No.</b></td>
                            <td align="left"><?= $ref_quot_no ?></td>
                            <td align="left"><b>Ref. Quot. Date</b></td>
                            <td align="left"><?= $ref_quot_date ?></td>
                           </tr>
                           <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>Despatch Through</b></td>
                            <td align="left"><?= $despatch_through ?></td>
                            <td align="left"><b>Special Instructions</b></td>
                            <td align="left"><?= $special_instr?></td>
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
                            <td align="center"><b>Department</b></td>
                            <td align="center"><b>Item Name</b></td>
                            <td align="center"><b>UOM</b></td>
                            <td align="center"><b>Remarks</b></td>
                            <td align="center"><b>Quantity</b></td>
                            <td align="center"><b>Rate</b></td>                                  
                          </tr>
													<?
                          $sql_RM="SELECT * FROM ms_RGP_master mgm,ms_RGP_transaction mgt WHERE mgm.RGP_id=mgt.RGP_id AND mgm.RGP_id ='".$PageKeyValue."'";
                          $res_RM=mysql_query($sql_RM);
                          $countTrans=1;
                          $rc_trans=mysql_num_rows($res_RM);
                          if($rc_trans>0)
                          {
                            while($row_RM=mysql_fetch_array($res_RM))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                            ?>
                          
                            <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <td align="center"><?=$countTrans ?></td>
                              <td align="left" style="padding-left:5px">                                	
                                  <?
                                  $sql_D="select * from ms_department where department_id=$row_RM[department_id]";
                                  $res_D=mysql_query($sql_D);
                                  $row_D=mysql_fetch_array($res_D);
                                  echo $row_D['name'];
                                	?>
                              </td>
                              <td align="left" style="padding-left:5px"><?=$row_RM['item_name']?></td>
                              <td align="left" style="padding-left:5px">
                              <? 
															  $uname='';
                                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id=$row_RM[uom_id]";
                                $result_uom = mysql_query ($sql_uom) or die (mysql_error());
                                  if(mysql_num_rows($result_uom)>0)
                                  {
                                    $row_uom = mysql_fetch_array($result_uom);
                                    $uname= $row_uom['uname'];
                                  }
																	echo $uname;
                                ?>
                              </td>
                              <td align="left" style="padding-left:5px"><?= $row_RM['remarks']?></td>
                              <td align="center"><?= $row_RM['quantity']?></td>
                              <td align="center"><?= $row_RM['rate']?></td>
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