<?
include("inc/maint_header.php");

$Page = "maint_view_machines.php";
$PageTitle = "View Service";
$PageFor = "Service";
$PageKey = "service_id";
$PageKeyValue = "";
$Message = "";
$mode = "";
if(isset($_GET["mode"]))
{
	$mode = $_GET["mode"];
}


if(isset($_GET[$PageKey]))
{
	$sql = "select * from maint_services where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$service_id= $row["service_id"];
		$PageKeyValue = $row[$PageKey];
		$service_code = $row["service_code"];$s_code = $row["s_code"];
		$name = $row["name"];
		$department_id = $row["department_code"];
		$duration_type = $row["duration_type"];
		$duration = $row["duration"];
		$tolerance = $row["tolerance"];
		$ex_service_req = $row["ex_service_req"];
		$company_name = $row["company_name"];	
		$company_charges = $row["company_charges"];
		$work_to_do = stripslashes($row["work_to_do"]);
				
	}
}

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
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Service</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
              <tr>
                <td align="center" valign="top" class="border" width="50%" bgcolor="#EAE3E1">
                  <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Service No</b></td>
                      <td align="left"><?= $service_id ?></td>
                      <td align="left"><b>Service Code</b></td>
                      <td align="left"><?= $service_code ?></td>
                    </tr>
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left"><b>Service Name</b></td>
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
                    <tr style="line-height:22px;background:#EAE3E1;">
                      <td align="left"><b>Tolerance</b></td>
                      <td align="left"><?= $tolerance ?>&nbsp;<b>(Days)</b></td>
                      <td align="left"><b>Duration</b></td>
                      <td align="left">
                        <? 
                        if($duration_type=='M') echo $duration."Months";
                        if($duration_type=='D') echo $duration."Days";
                        ?>
                      </td>
                    </tr>                          
                    <tr style="line-height:22px;background:#FFFFFF;">
                      <td align="left" valign="top"><b>External Service Req.</b></td>
                      <td align="left" valign="top">
                        <? if($ex_service_req=='N') 	echo "No";
                           if($ex_service_req=='Y') echo "Yes";
                        ?>
                      </td>
                      <td align="left" valign="top"><b>Work To Do</b></td>
                      <td align="left">
												<?
													$wtd=explode("\n",$work_to_do);
													foreach($wtd as $i)
													{	
														echo $i.'<br />';
													}
												?>
                      </td>
                    </tr>
                    <?
                    if($ex_service_req=="Y" )
                    {
                    ?>
                      <tr style="line-height:22px;background:#EAE3E1;">
                        <td align="left"><b>Company Name</b></td>
                        <td align="left"><?=$company_name?>
                        </td>
                        <td align="left"><b>Charges</b></td>
                        <td align="left"><?=$company_charges?></td>
                      </tr>
                      <?
                      }
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
<? 
include("inc/hr_footer.php");
?>