<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$url = "list_department_employee.php";
$basic ="";
$from_date ="";
$to_date ="";
echo "<pre>";
print_r($_GET);
if(isset($_GET["id"]))
{
	$emp_id=$_GET["id"];
	//$dept_id = $_GET["id"];
	
	echo "####".$sql = "select * from mpc_employee_master where ticket_no = '$emp_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);
	$row = mysql_fetch_array($result);
	echo "department_id="."<br>".$dept_id=$row['department'];
   	$rec_id=$row['emp_id'];
	
	
	echo $sql = "select * from mpc_department_employee where emp_id = '$rec_id'";
	$result = mysql_query($sql) or die("Error in sql : ".mysql_errno()." : ".mysql_error()." : ".$sql);	
	echo $row = mysql_fetch_array($result);
	echo "<pre>";
	print_r($row);
	echo "hello";
	echo "<br><br><br><br>";
	
	// $emp_id = $row["emp_id"];
	echo "dept_sub_id"."<br>".$dept_sub_id = $row["dept_id"]."<br>";
	echo "main_dept_id"."<br>".$main_dept_id=getdeptDetail('reference_id','rec_id',$dept_sub_id);
	echo "from date"."<br>".$from_date = getDatetime($row["from_date"]);
	if($row["to_date"]=='0000-00-00')
		{
			$to_date = date('d/m/Y');
		}
		else
		{
			$to_date = getDatetime($row["to_date"]);
		}
	echo "****Rec_id".$rec_id = $row["rec_id"];
}
?>
<form name="frm" action="<?=$url?>" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td align="center" valign="middle">
			<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Department</b></td>
                    <td align="left">
					<?
						 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
						 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
						 ?>
						<select name="department" id="department" style="width:150px; height:25px;" onChange="get_frm('change_sub_department.php',this.value+'&old_dept_id=<?=$dept_sub_id?>','div_sub_department_edit','<?=$emp_id?>');">
							<option value="">Select</option>
							 <?
						  while ($row=mysql_fetch_array($result))
							{	?>
								   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$main_dept_id){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
							<?  }	?>
						</select>
                    </td>
                    <td align="left" class="text_1" style="padding-left:15px;"><b>Sub Department</b></td>
                    <td align="left">
                    <div id="div_sub_department_edit">
					   <?
                     $sql = "SELECT * FROM  mpc_department_master where reference_id = '$main_dept_id' order by department_name";
                        $result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                        if(mysql_num_rows($result_city)>0)
                        {
                        ?>
                            <select name="sub_department" id="sub_department">
                                    <option value="">--Select--</option>
                        <?
                            while($row_city = mysql_fetch_array($result_city))
                            {
                        ?> 
                                    <option value="<?=$row_city['rec_id']?>"  <? if($row_city['rec_id']==$dept_sub_id){?> selected="selected" <? } ?>><?=$row_city['department_name']?></option>
                        <?
                            }
                        ?>
                            </select>
                        <?    	
                        }
                        ?>	
                        </div>
                    </td>
                    <td align="left" class="text_1"><b>From</b></td>
                    <td align="left"><input type="text" name="txt_from_date" id="txt_from_date" value="<?=$from_date?>" style="width:100px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="left" class="text_1"><b>To</b></td>
                    <td align="left"><input type="text" name="txt_to_date" id="txt_to_date" value="<?=$to_date?>" style="width:100px; height:20px;"/><a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm.txt_to_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a>
            		</td>
                    <td align="center" style="padding-top:5px;">
                                                                        
                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                            <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
                            <input type="hidden" name="dept_id" id="dept_id" value="<?=$dept_id?>" />
                            <span style="padding-top:0px;">
                                <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Department" title="Edit Department">&nbsp;
                                <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="document.getElementById('div_edit').innerHTML='';">
                            </span>
						</td>
	            	</tr>
            	</table>
    	</td>
	</tr>
</table>
</form>