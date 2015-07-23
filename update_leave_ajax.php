<?php
   include("inc/dbconnection.php");
?>
<?php
	$rec_id = $_POST['leave_id'];
    $emp_id = $_POST['emp_id'];
	$query_select   = "SELECT * FROM mpc_leave_application WHERE rec_id= $rec_id AND emp_id =$emp_id";
	$result         =  mysql_query($query_select);
	$row_leave_details  =  mysql_fetch_array($result);
    
    $select1 = '';
    $select2 = '';
    $select3 = '';
    $select4 = '';
    $select5 = '';
    if($row_leave_details['leave_type'] == 8)
    {
        $select1 = "selected";
    }
    if($row_leave_details['leave_type'] == 9)
    {
        $select2 = "selected";
    }
    if($row_leave_details['leave_type'] == 10)
    {
        $select3 = "selected";
    }
    if($row_leave_details['leave_type'] == 13)
    {
        $select4 = "selected";
    }
    if($row_leave_details['leave_type'] == 14)
    {
        $select5 = "selected";
    }
?>
<!--here type html for edit options-->
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
        <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id ?>"/>
        <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_id; ?>"/>
        Name 
    </td>  
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
        <?php
        $select_name = mysql_query("Select first_name,last_name from mpc_employee_master where rec_id = $emp_id");
        $fetch_name  = mysql_fetch_array($select_name);
        ?>
        <input type="text"  name="emp_name" id="emp_name" value="<? echo $fetch_name['first_name'] . " " . $fetch_name['last_name' ]; ?>" readonly/>
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
     Employee Code
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td id="td_select">
        <?php
            $select_code    = mysql_query("Select ticket_no from mpc_employee_master where rec_id = $emp_id");
            $fetch_code     = mysql_fetch_array($select_code);
        ?>
        <input type="text" name="emp_code" id="emp_code"  value="<? echo $fetch_code['ticket_no']; ?>" readonly/>
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
    Designation
    </td><td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td id="td_select">
        <?php
            $select_des = mysql_query("Select designation from mpc_employee_master where rec_id = $emp_id");
            $fetch_des  = mysql_fetch_array($select_des);
        ?>
       <input type="text" name="emp_des" id="emp_des" value="<? echo $fetch_des['designation']; ?>" readonly/>
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
        Department
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td id="td_select">
    <?php
                                                        $select_dept    = mysql_query("Select department from mpc_employee_master where rec_id = $emp_id");
                                                        $fetch_dept     = mysql_fetch_array($select_dept);
                                                        ?>
                                                        <input type="text" name="emp_dept" id="emp_dept" value="<? echo $fetch_dept['department'];?>" readonly/>
                                                    </td>
                                                </tr>
<tr>
    <td>
        <input type="hidden" value="<?php echo $rec_id;?>" name="leave_id">
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
        Nature of Leave
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    
    <td id="td_select">
        <select name="leave_type" id="leave_type" style="font-size:12px;">
            <option value="-1">Select Leave</option>
            <option value="8"  <?php echo $select1 ?> >Pl</option>
            <option value="9"  <?php echo $select2 ?> >Cl</option>                                                            
            <option value="10" <?php echo $select3 ?> >Sl</option>
            <option value="13" <?php echo $select4 ?> >El</option>
            <option value="14" <?php echo $select5 ?> >C-Off</option>
        </select>    
    </td>
</tr>
<tr class="focus" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
    <td id="td_select" style="font-size:12px">Period of Leave</td>
</tr>
<tr class="focus">
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
    From
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
        <!--input type="date" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_start_date" id="txt_start_date" value="" /-->
        <input type="text" value ="<?php echo $row_leave_details['start_date'];?>"style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_start_date" id="txt_start_date"  data-beatpicker="true" value="" data-beatpicker-format="['YYYY','MM','DD']" />
    </td>
<tr class="focus">
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
        To
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
        <input type="text" value ="<?php  echo $row_leave_details['end_date'];?>"style="border:solid 1px #333; font-size:12px border-radius:5px; height:25px;" name="txt_end_date" id="txt_end_date" data-beatpicker="true" value="" data-beatpicker-format="['YYYY','MM','DD']"/>
        <!--input type="date" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_end_date" id="txt_end_date" value=""/-->
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
    Reason
    </td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
        <textarea style="border: 1px solid rgb(51, 51, 51); font-size:12px border-radius: 5px; width: 172px; height: 68px;" name="reason">
            <?php echo $row_leave_details['leave_reason']; ?>
        </textarea>
    </td>
</tr>
<tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">Address during Leave</td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
        <textarea style="border: 1px solid rgb(51, 51, 51); border-radius: 5px; width: 172px; height: 68px; font-size:12px" name="leave_addr">
            <?php echo $row_leave_details['address']; ?>
        </textarea>
    </td>
</tr>
 <tr>
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">Telephone No.</td>
    <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
    <td>
       <?php
            $select_tel = mysql_query("Select phone_no from mpc_employee_master where rec_id = $emp_id ");
            $fetch_tel  = mysql_fetch_array($select_tel);
        ?>
          <input type="text" id="edit_phone_no" name="phone_no" value="<?php echo $fetch_tel['phone_no']; ?>" />
   </td>
</tr>
<tr>
    <td align="center" colspan="4">
       <input type="hidden" name="ss" id="ss" value="<?php echo $id; ?>">
       <input type="submit" style="border:solid 1px #333; border-radius:5px; height:25px;" value="SEND" id="edit_send" name="edit_send">
   </td>
</tr>
