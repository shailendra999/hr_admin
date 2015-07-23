<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<script type="text/javascript">
	//document.write(screen.width+'x'+screen.height);
</script>
<?
$widthratio=1;
$heightratio=1;
$screenwidth=1366;
$screenheight=768;

$widthratio=1024/96;
$heightratio=768/96;

$width=360;
$height=472;
?>
<?
if(isset($_POST["print_card"]))
{			
	$emp_check=$_POST["emp_check"];
	$month=$_POST["card_month"];
	$year=$_POST["card_year"];
	$date_month=$year."-".$month."-01";
	$x=ceil(count($emp_check)/2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Card</title>
</head>
<body>
<table border="0" cellspacing="0" cellpadding="0" width="100">
	<?
	$count=0;
    for($z=0;$z<count($emp_check);$z=$z+2)
    {
	$count++;
    ?>
    <tr>
        <td>
            <? 
            $emp_id=$emp_check[$z];
            $off_day=getweeklyoffDetail('off_day',$emp_id,$date_month);
			$sql_prj = "select * from mpc_employee_master where rec_id='$emp_id'";
            $result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
            $row = mysql_fetch_array($result_prj);	
            ?>
            <table align="center" cellpadding="0" cellspacing="0" class="border" border="0" width="<?=$width?>" height="<?=$height?>">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:12px">
                            <tr>
                                <td width="10%" align="center" class="text_1"  style="text-align:left;">
                                 <img src="images/web_logo.png" border="0"/>                               
                                </td>
                              	<td width="90%" style="text-align:center;font-weight:bold;">
                                    <span >Laxyo Solution Soft Pvt. Ltd.</span>
                              </td>
                          </tr>
                            <tr>
                                <td align="center" class="text_1"  style="text-align:center;font-weight:bold;" colspan="2">
                                    Attendence Card
                                </td>
                            </tr>
                      </table>        
                </tr>
                <tr>
                	<td>
                    	<table width="100%" style="font-size:9px;font-weight:bold;">
                        	<tr>
                            	<td>
                                	Month
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=$month?>/<?=$year?>
                                </td>
                                <td>
                                	Shift
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getShiftDetail('shift',$emp_id)?>
                                </td>
                                 <td>
                                	Card No.
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=$row['ticket_no']?>	 	
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Name
                                </td>
                                <td colspan="5" style="border-bottom:1px solid #333333;">
                                	<?=$row['first_name']?>&nbsp;<?=$row['last_name']?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Father's Name
                                </td>
                                <td colspan="5" style="border-bottom:1px solid #333333;">
                                	<?=getfamilyDetail('father_name',$emp_id)?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Off Day.
                                </td>
                                <td style="border-bottom:1px solid #333333;"><?=$off_day?>                                	
                                </td>
                                <td colspan="2">
                                	Department
                                </td>
                                <td colspan="2" style="border-bottom:1px solid #333333;">
                                	<?=getdeptDetail('department_name','rec_id',getdepartmentDetail('dept_id',$row['rec_id'],$date_month))?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Designation
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$row['rec_id'],$date_month));?>
                                </td>
                                <td colspan="2">
                                	Date Of Joining
                                </td colspan="2">
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getDatetime(getofficeDetail('date_joining',$emp_id))?>
                                </td>
                            </tr>
                             <tr>
                            	<td>
                                	PF NO.
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getAccountDetail('pf_number',$emp_id);?>
                                </td>
                                <td colspan="2">
                                	ESI No
                                </td>
                                <td colspan="2" style="border-bottom:1px solid #333333;">
                                	<?=getAccountDetail('esic_number',$emp_id);?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>              
                <tr>
                    <td>
                        <table align="center" border="1"  cellpadding="1" cellspacing="1" class="border" style="font-size:9px" width="100%">
                        <tr  class="text_1">
                        <?
    
                            $start_date="01";
                            
                            $day1 = $start_date; 
                            $month1 = $month;
                            $year1 = $year;
                            
                            $day1 = $day1 + 1;
                            
                            $end_date = date("t", strtotime($year . "-" . $month . "-01"));
                            
                            $day2 = $end_date; 
                            $month2 = $month;
                            $year2 = $year;
                            
                            
                            $start_date = "$year1-$month1-$day1";
                            
                            $end_date = "$year2-$month2-$day2";
                            
                            $date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
                            $date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
                            $difference = $date1-$date; //Calcuates Difference
                            $daysago = $day2; //Calculates Days Old
                            
                            $i = 1;
							$tr="<tr>";
                            while ($i <=31) {
                            if ($i != 1) { $date = $date + 86400; }
                            else { $date = $date - 86400; }
                            $today = date('Y-m-d',$date);
                            //echo "$today ";
                            
                            $yy = date('Y',$date);
                            $mm = date('m',$date);
                            $dd = date('d',$date);
                            echo "<td width=\"10%\">";
                            if($i<=$daysago)
                            {
                                echo $dd;
								$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));
								$date1=$yy."-".$mm."-".$dd;
								if($weekday==$off_day)
								{
									$tr.="<td>(W)</td>";
								}
								else if(getHoliday('rec_id',$date1)!="")
									{
										$tr.="<td>(H)</td>";
									}
								else
								{
									 $tr.="<td>&nbsp;</td>";
								}
							}
							else
							{
								echo "&nbsp;";
							}
                            echo "</td>";
                                if(($i%7)==0)
                                {
                                    echo "</tr>";
                                    echo $tr;
									$tr="<tr>";
									echo "</tr>";
                                    echo "<tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>";
                                }
                                if($i==31)
                                {
									$td="";
									for($k=$i-2;$k<=$i;$k++)
									{
										$weekday = date("l", mktime(0,0,0,$mm,$k,$yy));
										$date1=$yy."-".$mm."-".$k;
										if($weekday==$off_day)
										{
											 $td.="<td>(W)</td>";
										}
										else if(getHoliday('rec_id',$date1)!="")
											{
												$td.="<td>(H)</td>";
											}
										else
										{
											 $td.="<td>&nbsp;</td>";
										}
									}
                                    echo "<td colspan=\"3\">Total Days Worked</td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            ".$td."
                                            <td colspan=\"4\" rowspan=\"2\">
                                                <table width=\"100%\">
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align=\"center\">T.K.</td>
                                                        <td align=\"center\">CTK</td>
                                                        <td align=\"center\">L.O.</td>
                                                    </tr>
                                                </table>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                          </tr>";
                                }
                                $i++;
                            }
                            ?>
                	        
                        </table>
                    </td>
                </tr>
             </table>
        </td>
        <td style="padding:10px; background-image:url(images/background-gradient.jpg); background-position:center; background-repeat:repeat-y; width:1px;">
        	
        </td>
        <td>
            <?
            if(isset($emp_check[$z+1]))
            {
            $emp_id=$emp_check[$z+1];
			$off_day=getweeklyoffDetail('off_day',$emp_id,$date_month);
            $sql_prj = "select * from mpc_employee_master where rec_id='$emp_id'";
            $result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
            $row = mysql_fetch_array($result_prj);	
            ?>
            <table align="center" cellpadding="0" cellspacing="0" class="border" border="0" width="<?=$width?>" height="<?=$height?>">
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%"  style="font-size:12px">
                            <tr>
                                <td align="center" class="text_1"  style="text-align:center;">
                                 <img src="images/company_logo.png" border="0"/>                               
                                </td>
                              	<td width="90%" style="text-align:center;font-weight:bold;">
                                    <span >Mahima Purespun<br/>
                                        (A Unit of Mahima Fibres Ltd.)<br/>
                                    Plot No. 73-74,Sector-II,Pithampur(M.P.)</span>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="text_1" style="text-align:center;font-weight:bold;" colspan="2">
                                    Attendence Card
                                </td>
                            </tr>
                      </table>        
                </tr>
                <tr>
                	<td>
                    	<table width="100%"  style="font-size:9px;font-weight:bold;">
                        	<tr>
                            	<td>
                                	Month
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=$month?>/<?=$year?>
                                </td>
                                <td>
                                	Shift
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getShiftDetail('shift',$emp_id)?>
                                </td>
                                 <td>
                                	Card No.
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=$row['ticket_no']?>	 	
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Name
                                </td>
                                <td colspan="5" style="border-bottom:1px solid #333333;">
                                	<?=$row['first_name']?>&nbsp;<?=$row['last_name']?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Father's Name
                                </td>
                                <td colspan="5" style="border-bottom:1px solid #333333;">
                                	<?=getfamilyDetail('father_name',$emp_id)?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Off Day.
                                </td>
                                <td style="border-bottom:1px solid #333333;"><?=$off_day?>                                	
                                </td>
                                <td colspan="2">
                                	Department
                                </td>
                                <td colspan="2" style="border-bottom:1px solid #333333;">
                                	<?=getdeptDetail('department_name','rec_id',getdepartmentDetail('dept_id',$row['rec_id'],$date_month))?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	Designation
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$row['rec_id'],$date_month));?>
                                </td>
                                <td colspan="2">
                                	Date Of Joining
                                </td>
                                <td colspan="2" style="border-bottom:1px solid #333333;">
                                	<?=getDatetime(getofficeDetail('date_joining',$emp_id))?>
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	PF NO.
                                </td>
                                <td style="border-bottom:1px solid #333333;">
                                	<?=getAccountDetail('pf_number',$emp_id);?>
                                </td>
                                <td colspan="2">
                                	ESI No
                                </td>
                                <td colspan="2" style="border-bottom:1px solid #333333;">
                                	<?=getAccountDetail('esic_number',$emp_id);?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>                          
						<?
                        echo "<table align=\"center\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" class=\"border\"  style=\"font-size:9px\" width=\"100%\">";
                        echo "<tr  class=\"text_1\">";
                        $start_date="01";
                        
                        $day1 = $start_date; 
                        $month1 = $month;
                        $year1 = $year;
                        
                        $day1 = $day1 + 1;
                        
                        $end_date = date("t", strtotime($year . "-" . $month . "-01"));
                        
                        $day2 = $end_date; 
                        $month2 = $month;
                        $year2 = $year;
                        
                        
                        $start_date = "$year1-$month1-$day1";
                        
                        $end_date = "$year2-$month2-$day2";
                        
                        $date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
                        $date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
                        $difference = $date1-$date; //Calcuates Difference
                        $daysago = $day2; //Calculates Days Old
                        
                        $i = 1;
						$tr="<tr>";
                        while ($i <=31) {
                        if ($i != 1) { $date = $date + 86400; }
                        else { $date = $date - 86400; }
                        $today = date('Y-m-d',$date);
                        //echo "$today ";
                        
                        $yy = date('Y',$date);
                        $mm = date('m',$date);
                        $dd = date('d',$date);
                        
                        
                        echo "<td width=\"10%\">";
                        if($i<=$daysago)
                        {
                            echo $dd;
							$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));
							$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));
							$date1=$yy."-".$mm."-".$dd;
							if($weekday==$off_day)
							{
								$tr.="<td>(W)</td>";
							}
							else if(getHoliday('rec_id',$date1)!="")
								{
									$tr.="<td>(H)</td>";
								}
							else
							{
								 $tr.="<td>&nbsp;</td>";
							}
                        }
                        else
                        {
                            echo "&nbsp;";
                        }
                        echo "</td>";
                            if(($i%7)==0)
                            {
                                echo "</tr>";
                            
                                echo $tr;
									 $tr="<tr>";
								echo "</tr>";
                                echo "<tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>";
                            }
                            if($i==31)
                            {
								$td="";
								for($k=$i-2;$k<=$i;$k++)
								{
									$weekday = date("l", mktime(0,0,0,$mm,$k,$yy));
									$date1=$yy."-".$mm."-".$k;
									if($weekday==$off_day)
									{
										 $td.="<td>(W)</td>";
									}
									else if(getHoliday('rec_id',$date1)!="")
										{
											$td.="<td>(H)</td>";
										}
									else
									{
										 $td.="<td>&nbsp;</td>";
									}
								}
                                
                                echo "<td colspan=\"3\">Total Days Worked</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        ".$td."
                                        <td colspan=\"4\" rowspan=\"2\">
                                            <table width=\"100%\">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align=\"center\">T.K.</td>
                                                    <td align=\"center\">CTK</td>
                                                    <td align=\"center\">L.O.</td>
                                                </tr>
                                            </table>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>";
                            }
                            $i++;
                        }
                        echo "</table>";
                        ?>
                           
                        
                    </td>
                </tr>
             </table>
            <?
            }
            else
            {
                echo "&nbsp;";
            }
            ?>
		</td>
    </tr>
    <tr>
    	<td colspan="3">
        <br />
        <?
		if($count!=2)
			{
				echo "<hr />";
				?>
                <div style="border:0px solid #CC0033;height:20px"></div>
				<?
            }
			else
			{
				$count=0;
			}
		?> 
        <br />
        </td>
    </tr>
	
    <?
    }
    ?>
</table>
<?
}
?>
<script>
    //window.print ();
 </script>
  </body>
</html>
