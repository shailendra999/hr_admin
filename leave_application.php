<? 	error_reporting(0);
	include ("inc/hr_header.php"); ?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
            $(document).ready(function () {
        ('#save').click(function () {
            ('#txt').hide();
        });
    });
</script>
<script>
    function overlay(id) {
        el = document.getElementById("overlay");
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
    }

</script>  

<script>
    function app(value, dis_res, id) {
//        var id = document.getElementById('id').value;
//alert(id);
        $.ajax({
            type: 'POST',
            url: "ajax_app_save.php",
            cache: false,
            data: {
                value: value, id: id, dis_res: dis_res
            },
            success: function (response)
            {
                document.getElementById('message').innerHTML = response;
                $("#message").fadeIn();
                setTimeout(function () {
                    $("#message").fadeOut(1500);
                }, 5000)
                $('#txt').hide();
            }
        });

    }

</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>
        <td style="vertical-align: top; padding-top: 10px;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0" align="cent">
                <tr>
                    <td align="center" class="gray_bg">
                        <img src="images/bullet.gif" width="15" height="22"/> &nbsp;Leave Applications</td>
                </tr>
                <tr>
                <div id="message" style=" padding-left:315px">
                </div>
                <div id="txt" style="padding-left: 315px">
                </div>
                <td class="heading" valign="" height="33px">
                    <div id="div_message"><?= $Message = $_REQUEST['Message'] ?></div>
                    <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
                        <tr class="blackHead">
                            <td>
                                
                            </td>
                        </tr>
                        <tr class="blackHead">
                            <td align="center">Employee Id</td>
                            <td align="center">Employee Name</td>
                            <td align="center">Department</td>
                            <td align="center">Leave</td>
                            <td align="center">From Date</td>
                            <td align="center">To Date</td>
                            <td align="center">Status</td>
                        </tr>

                        <?php
						
                        $select_query = mysql_query("Select mpc_employee_master.*, mpc_designation_master.*, mpc_leave_application.*, mpc_leave_master.*, mpc_leave_application.rec_id  as application_id From mpc_leave_application, mpc_employee_master, mpc_designation_master, mpc_leave_master where mpc_employee_master.emp_id = mpc_leave_application.emp_id AND mpc_designation_master.rec_id = mpc_employee_master.designation AND mpc_leave_master.id = mpc_leave_application.leave_type");
							if(!$select_query){
							echo mysql_error()."error report";
							}							
							
                        while ($fetch_row = mysql_fetch_array($select_query)) {

$application_id = $fetch_row['application_id'];
                            $date = date('m-d-Y');
 
                            if ($date < date('m-d-Y', strtotime($fetch_row['end_date']))) {
								
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        echo $fetch_row['ticket_no'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $fetch_row['first_name'] . " " . $fetch_row['last_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $fetch_row['designation_name']; ?>
                                    </td>
                                    <td>
                                        <?php echo $fetch_row['leave_name']; ?>
                                    </td>

                                    <td>
                                        <?php echo $fetch_row['start_date']; ?>
                                    </td>

                                    <td>
                                        <?php echo $fetch_row['end_date']; ?>
                                    </td>
                                    <td>
                                        <form name="leave_approve" action="" method="post">
                                            <input type="hidden" name="id" id="id" value="<?= $application_id ?>"/>
                                            <table>
                                                <tr>
                                                    <?php
                                                    $status = $fetch_row['approved'];
                                                    ?>
                                                    <td>
                                                        <input onclick="app('1', 'approved','<?php echo $application_id ?>')" type = "radio" name = "app_status" id = "approved" value = "1" <?php
                                                        if ($status == 1) {
                                                            echo 'checked';
                                                        }
                                                        ?>/>
                                                        Approved
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <input type="radio" name="app_status" id="approved" value="0" <?php
                                                        if ($status == 0) {
                                                            echo "checked";
                                                        }
                                                        ?>
                                                               onclick="textShow('<?php echo $application_id ?>');"/>
                                                        Cancel
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </td>
    </tr>
</table>
</td>
</tr>
</table>
<?php
/*
  if (isset($_REQUEST['submit'])) {
  $page = "leave_application.php";
  $value = $_REQUEST['submit'];
  $id = $_REQUEST['id'];
  if ($value == "Approve") {
  $Message = "Successfully Leave Approved";
  $update = mysql_query("update mpc_leave_application set approved='1' where rec_id = '$id' ");
  redirect("$Page?Message=$Message");
  }
  if ($value == "Disapprove") {
  $Message = "Successfully Leave Disapproved";
  $update = mysql_query("update mpc_leave_application set approved='0' where rec_id = '$id' ");
  redirect("$Page?Message=$Message");
  }
  } */
?>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<div id="overlay">
    <div id="leave_comform" style="width:30%;height:auto;text-align:center;">
    </div>
</div>


<? include ("inc/hr_footer.php"); ?>	
<script>

    function textShow(value) {
        if (value != 0)
        {
            document.getElementById('txt').innerHTML = "<textarea name='dis_res' rows='5' cols='40' id='dis_res'></textarea><input type='submit' name='save' id='save' value='Save' onClick='app(0,dis_res.value,<?= $application_id; ?>)'/>"; 
			
        }
       // else
        //{
         //   app('1', 'approved');
        //}
    }

</script>