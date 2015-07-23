<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$leave=0;
$start_date =$_GET["id"];
$end_date =$_GET["str"];
$reason =$_POST["str4"];
$emp_id =$_POST["str5"];
$leave_type=$_POST["str6"];
?>
<p class="form_msg">Review Of Application</p>
<form name="frm_del" action="" method="post">
    <input name="emp_id" id="emp_id" type="hidden" value="<?=$emp_id?>"/>
    <input name="leave_type" id="leave_type" type="hidden" value="<?=$leave_type?>"/>
    <input name="start_date" id="start_date" type="hidden" value="<?=$start_date?>"/>
    <input name="end_date" id="end_date" type="hidden" value="<?=$end_date?>"/>
<table width="30%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td>
            <table width="100%" cellpadding="5" cellspacing="5" border="0">
            <tr>
                <td>Date</td>
                <td>Status</td>
             <?
/////////  change date format dd/mm/yyyy into yyyy-mm-dd ////////////////
			$day1 = substr($start_date,0,2); 
			$month1 = substr($start_date,3,2);
			$year1 = substr($start_date,6,4);
			
			$day1 = $day1 + 1;
			
			$day2 = substr($end_date,0,2); 
			$month2 = substr($end_date,3,2);
			$year2 = substr($end_date,6,4);
            
            
            $start_date = "$year1-$month1-$day1";
            
            $end_date = "$year2-$month2-$day2";
            
            $date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
            $date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
            $difference = $date1-$date; //Calcuates Difference
            $daysago = floor($difference /60/60/24); //Calculates Days Old
            
            $i = 0;
            while ($i <= $daysago +1) {
            if ($i != 0) { $date = $date + 86400; }
            else { $date = $date - 86400; }
            $today = date('Y-m-d',$date);
            //echo "$today ";
            
            $yy = date('Y',$date);
            $mm = date('m',$date);
            $dd = date('d',$date);
            
            echo "<tr c>";
            echo "<td>";
            echo "$dd-$mm-$yy";
            echo "</td>";
            echo "<td>";
            
            $data_date=$yy."-".$mm."-".$dd;
            
            $check_day  = mktime(0, 0, 0,$mm,$dd,$yy);
            $holiday=getHoliday('holiday_name',$data_date);
            
			$check_cl_pl=getTakenLeave($emp_id,$data_date);
            
			$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));
			if($check_cl_pl!="")
            {
                echo $check_cl_pl; 
            }
/*			else if(getweeklyoffDetail('off_day',$emp_id,$data_date)==$weekday)
			{	

				$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
				$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
				if(getTakenLeave($emp_id,$date_before)!="" and getTakenLeave($emp_id,$date_after!=""))
				{
					    echo "Leave";
						?>
							<input name="leave_date[]" id="leave_date[]" value="<?=$data_date?>" type="hidden"/>
						<?
						$leave++;
				}
				else if(strtotime($start_date) <= strtotime($data_date) and strtotime($data_date) <= strtotime($end_date))
				{
						echo "Leave";
						?>
						<input name="leave_date[]" id="leave_date[]" value="<?=$data_date?>" type="hidden"/>
						<?
						$leave++;
				}
				else
				{
					echo "WeekOff(".$weekday.")";
				}
			}
            else if($holiday!="")
            {
                if(strtotime($start_date) <= strtotime($data_date) and strtotime($data_date) <= strtotime($end_date))
				{
						echo "Leave";
						?>
						<input name="leave_date[]" id="leave_date[]" value="<?=$data_date?>" type="hidden"/>
						<?
						$leave++;
				}
				else
				{
					echo "Holiday(".$holiday.")";
				}
            }*/
            else
            {
                echo "Leave";
            ?>
                <input name="leave_date[]" id="leave_date[]" value="<?=$data_date?>" type="hidden"/>
            <?
                $leave++;
            }
            echo "</td>";
            echo "</tr>";
            $i++;
            }
            ?>
            </table> 
		</td>
        <td>
        	<textarea id="reason" name="reason" readonly="readonly" rows="3" cols="25"><?=$reason?></textarea>
        </td>
    </tr>    
    <tr>
    	<td>
        	Total leave:<?=$leave?>
        </td>
    </tr>
</table>
<p class="form_msg">Do you want to Continue</p>
<input type="submit" class="btn_bg1" name="btn_submit" id="btn_submit" value="Yes" />
<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
<input type="button" class="btn_bg1" onClick="overlay();" name="btn_close" value="No" />
</form>