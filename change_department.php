<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
    $url = "list_employee.php";
    $main_dept_id = "";
    $dept_id = "";
    $dept_id = "";
    $date ="";
    $emp_id = "";
    if($_POST["str6"])
    {
        $emp_id = $_POST["str6"];
    }else
    {
        $emp_id =$_POST["str4"];
    }
    if(isset($_POST["str1"]))
    {
    	$dept_id = $_POST["str1"];
    	$main_dept_id=$_POST["str3"];
    	$date = $_POST["str5"];   	
    }
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
    <tr>
        <td class="text_1">Department</td>
        <td align="left" colspan="3">
          <?
			 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
			 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
			 ?>
            <select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('change_sub_department.php',this.value+'&old_dept_id=<?=$dept_id?>','div_sub_department_edit','<?=$emp_id?>');">
                <option value="">Select</option>
                 <?
              while ($row=mysql_fetch_array($result))
                {	?>
                       <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$main_dept_id){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
                <?  }	?>
            </select>
         </td>
    </tr>
    <tr>
        <td class="text_1">Sub Department</td>
        <td align="left" colspan="3">
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
						<option value="<?=$row_city['rec_id']?>"  <? if($row_city['rec_id']==$dept_id){?> selected="selected" <? } ?>><?=$row_city['department_name']?></option>
			<?
				}
			?>
				</select>
			<?    	
			}
			?>	
            </div>
         </td>
    </tr>
    <tr>
        <td class="text_1">Effective From</td>
        <td align="left">
            <form id="frm_emp_list" name="frm_emp_list">
            <input type="text" name="depart_from_date" id="depart_from_date" style="width:130px; height:20px;" value="<?=$date?>"/>	 <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.depart_from_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""/></a></form>
         </td>
        <td><!-- This is insertion of departmanet and cancel of dept-->
          <input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Department" title="Edit Department" onclick="get_frm('change_department_edit.php',document.getElementById('sub_department').value+'&date='+document.getElementById('depart_from_date').value,'div_department_edit','<?=$emp_id?>')"  />&nbsp;
        </td>
 		<td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="get_frm('dept_designation.php','<?=$emp_id ?>','div_detail','')">
        </td>    
    </tr>
</table>