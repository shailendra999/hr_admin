<?
include("inc/store_header.php");
?>
<?
$Page = "store_view_NRGP_for_GRN.php";
$PageTitle = "View NRGP For GRN";
$PageFor = "NRGP For GRN";
$PageKey = "NRGP_id";
$PageKeyValue = "";
$Message = "";
$mode="";
if(isset($_GET['mode']))
{
	$mode=$_GET['mode'];
}

//////////////////////////////////////////////////////////
$NRGP_id='';$RGP_date='';$supplier_id='';$ref_quot_no='';$ref_quot_date='';
$despatch_through='';$special_instr='';
$item_id='';$remarks='';$quantity='';$value='';$duedate='';
//////////////////////////////////////////////////////////
if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_NRGP_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$NRGP_date=getDateFormate($row['NRGP_date']);
		$supplier_id=$row['supplier_id'];$GRN_id=$row['GRN_id'];
		$ref_quot_no=$row['ref_quot_no'];	
		$ref_quot_date=getDateFormate($row['ref_quot_date']);
		$despatch_through=$row['despatch_through'];
		$special_instr=stripslashes($row['special_instr']);
	}
}
if(isset($_GET["NRGP_id"]))
{
	$NRGP_id = $_GET["NRGP_id"];
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
          	<img src="images/bullet.gif" width="15" height="22"/> &nbsp; View NRGP For GRN
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
                	<a target="_blank" href="store_print_NRGP_for_GRN.php?NRGP_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
							<tr>
								<td valign="top" style="padding-bottom:5px;">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#FFFFFF">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr style="line-height:22px;background:#EAE3E1;">
                            <td align="left"><b>NRGP No.</b></td>
                            <td align="left"><?= $NRGP_id ?></td>
                            <td align="left"><b>NRGP Date</b></td>
                            <td align="left"><?= $NRGP_date ?></td>
                          </tr>
                          <tr style="line-height:22px;background:#FFFFFF;">
                            <td align="left"><b>Supplier</b></td>
                            <td align="left">
                              <?
																$sql_sup="select * from ms_supplier where supplier_id=$supplier_id";
																$res_sup=mysql_query($sql_sup);
																$row_sup=mysql_fetch_array($res_sup);
																echo $row_sup['name'];
															?>
                            </td>
                            <td align="left"><b>GRN No.</b></td>
                            <td align="left"><?= $GRN_id ?></td>
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
                            <td align="center"><b>Item Name</b></td>
                            <td align="center"><b>Remarks</b></td>
                            <td align="center"><b>Quantity</b></td>
                            <td align="center"><b>Rate</b></td>                                  
                          </tr>
													<?
                          $sql_RM="SELECT * FROM ms_NRGP_master mgm,ms_NRGP_GRN_transaction mgt WHERE mgm.NRGP_id=mgt.NRGP_id AND mgm.NRGP_id ='".$PageKeyValue."'";
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
                                  $sql_D="select * from ms_item_master where item_id=$row_RM[item_id]";
                                  $res_D=mysql_query($sql_D);
                                  $row_D=mysql_fetch_array($res_D);
                                  echo $row_D['name'];
                                	?>
                              </td>
                              <td align="left" style="padding-left:5px"><?= $row_RM['remarks']?></td>
                              <td align="center"><?= $row_RM['NRGP_qty']?></td>
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