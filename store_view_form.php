<?
include("inc/store_header.php");
?>
<?
$Page = "store_view_form.php";
$PageTitle = "View Form";
$PageFor = "Form";
$PageKey = "form_id";
$PageKeyValue = "";
$Message = "";
$form_id = '';
$supplier_id = '';
$GRN_no = '';
$GRN_date = '';
$book_no = '';
$form_type = '';
$form_no = '';


if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_form_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];
		$supplier_id = $row["supplier_id"];$form_no = $row["form_no"];
		$form_date = getDateFormate($row["form_date"]);			
	}
}

?>
<?
if(isset($_GET["form_id"]))
{
	$form_id = $_GET["form_id"];
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
        	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Form</td>
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
											<td align="center" valign="top" class="border" width="34%" bgcolor="#FFFFFF">
                      	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                      		<tr style="line-height:22px;background:#EAE3E1;">
                      			<td align="left"><b>Form No.</b></td>
                      			<td align="left"><?=$form_id?></td>
                      			<td align="left"><b>Form Date.</b></td>
                      			<td align="left"><?=$form_date?></td>
                      		</tr>       
                          <tr style="line-height:22px;background:#FFFFFF;">
                          	<td align="left"><b>Form No..</b></td>
                      			<td align="left"><?=$form_no?></td>
                            <td align="left"><b>Supplier Name</b></td>
                            <td align="left">
															<?  $sql_sup="select * from ms_supplier where supplier_id = '".$row["supplier_id"]."' ";
                              $res_sup=mysql_query($sql_sup) or die(mysql_error()); 
                              $row_sup=mysql_fetch_array($res_sup);
                              echo $row_sup['name'];
                              ?>
                            </td>
                          </tr>
                      	</table>
										</td>
                  </tr>
                  <tr>
                    <td width="100%">
                      <table width="100%" border="0" cellspacing="1" cellpadding="1" class="border">
                        <tr bgcolor="#eedfdc" class="text_tr">
                          <td align="center" style="font-weight:bold;">SNo.</td>
                          <td align="center" style="font-weight:bold;">GRN No.</td>
                          <td align="center" style="font-weight:bold;">GRN Date</td>
                          <td align="center" style="font-weight:bold;">Book No.</td>
                          <td align="center" style="font-weight:bold;">Form Type</td>
                        </tr>
                        <?
                        $sql_form_trans="SELECT * FROM ms_form_master mim, ms_form_transaction mit WHERE mim.form_id = mit.form_id AND mit.form_id ='".$PageKeyValue."'";
                        $res_form_trans=mysql_query($sql_form_trans) or die(mysql_error());
                        $countTrans=1;
                        $rc_trans=mysql_num_rows($res_form_trans);
                        if($rc_trans>0)
                        {
                          while($row_i_t=mysql_fetch_array($res_form_trans))
                          {
                            if($countTrans%2==0)
                            $tableColor="#eedfdc";
                            else
                            $tableColor="#f8f1ef";
                            ?>
                            <tr class="text_tr" bgcolor="<?=$tableColor?>">
                              <td align="center"><?= $countTrans?></td>
                              <td align="center"><?= $row_i_t['GRN_no']?></td>
                              <td align="center"><?= getDateFormate($row_i_t['GRN_date'])?></td>
                              <td align="center"><?= $row_i_t['book_no']?></td>
                              <td align="center"><?= $row_i_t['form_type']?></td>
                            </tr>
                            <?			
                            $countTrans++; 													 
                          } // end of while
                        }// end if	
                        ?>
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
		</td>
	</tr>
</table>
<? 
include("inc/hr_footer.php");
?>