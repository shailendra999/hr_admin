<?
include("inc/maint_header.php");
?>

<?
$Page = "maint_view_machines.php";
$PageTitle = "View Machine";
$PageFor = "Machine";
$PageKey = "machine_code";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}

if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_machine_master where machine_code = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row["machine_code"];
		$machine_code = $row["machine_code"];
		$name = $row['name'];$department_id = $row['department_code'];
		$model = $row['model'];
		$errected_by = $row['errected_by'];
		$machine_serial_no = $row['machine_serial_no'];
		$make_machine = $row["make_machine"];
		$machine_price = $row['machine_price'];	
		$manufacture_year = $row['manufacture_year'];
		$install_date = getDateFormate($row['install_date']);
		$commissioning_date = getDateFormate($row['commissioning_date']);
				
	}
}

?>
<?
if(isset($_GET["Message"]))
{
	$Message = $_GET["Message"];
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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Machine</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="border">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                  <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0">
                    <tr>
                      <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                        <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                          <tr>
                            <td align="left"><b>Sno. No</b></td>
                            <td align="left" colspan="3"><?= $PageKeyValue ?></td>
                          </tr>
                          <tr>
                            <td align="left"><b>Machine Name</b></td>
                            <td align="left"><?= $name ?></td>
                            <td align="left"><b>Department</b></td>
                            <td align="left">
                              <?
                              $sql_d= "select * from maint_department where department_code=$department_id";
                              $res_d = mysql_query ($sql_d) or die ("Invalid query : ".$sql_d."<br>".mysql_errno()." : ".mysql_error());
                              $row_d = mysql_fetch_array($res_d);
															echo $row_d['name'];		
                              ?>
                            </td>
                           </tr>                          
                          <tr>
                            <td align="left"><b>Model</b></td>
                            <td align="left"><?= $model ?></td>
                            <td align="left"><b>Errected By</b></td>
                            <td align="left"><?= $errected_by ?></td>
                          </tr>
                          <tr>
                            <td align="left"><b>Machine Serial No.</b></td>
                            <td><?= $machine_serial_no ?></td>
                            <td align="left"><b>Make Of Machine</b></td>
                            <td align="left"><?= $make_machine ?></td>
                          </tr>
                          <tr>
                            <td align="left"><b>Price Of Machine</b></td>
                            <td align="left"><?= $machine_price ?></td>
                            <td align="left"><b>Manufacture Year</b></td>
                            <td align="left"><?= $manufacture_year ?></td>
                          </tr>
                          <tr>
                            <td align="left"><b>Date Of Installation</b></td>
                            <td align="left"><?= $install_date ?></td>
                            <td align="left"><b>Date Of Commissioning</b></td>
                            <td><?= $commissioning_date ?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="0" class="border text_1">
                          <tr bgcolor="#eedfdc" class="text_1">
                            <td align="center" style="font-weight:bold;">SNo.</td>
                            <td align="center" style="font-weight:bold;">Service</td>
                            <td align="center" style="font-weight:bold;">Duration</td>
                            <td align="center" style="font-weight:bold;">Maint. Date</td>
                          </tr>
                        <?
                        $sql_item_trans="SELECT * FROM maint_machine_master mim, maint_machine_transaction mit WHERE mim.machine_code = mit.machine_id AND mit.machine_id ='".$PageKeyValue."'";
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
                              
                                <tr bgcolor="<?= $tableColor?>">
                                  <td align="center"><?= $countTrans?></td>
                                  <td align="left" style="padding-left:5px">
                                  <?
                                    $sql_S="select * from maint_services where s_code='".$row_i_t['service_id']."'";
                                    $res_S=mysql_query($sql_S) or die(mysql_error());
                                    if(mysql_num_rows($res_S)>0)
                                    {
                                      $row_S=mysql_fetch_array($res_S);
                                      echo $row_S['name'];
																			$duration= $row_S['duration'];
																			$dt= $row_S['duration_type'];
																			 if($dt=="M")
                                        $duration_type='Month(s)';
                                      if($dt=="D")
                                        $duration_type='Day(s)';
                                    }
                                    ?>
                                  </td>
                                  <td align="center"><?= $duration.' '.$duration_type?>
                                  </td>
                                  <td align="center"><?= getDateFormate($row_i_t['maint_date'])?></td>
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