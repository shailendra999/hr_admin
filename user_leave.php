<?php
    error_reporting(0);
    include("inc/user_header.php");
    include("inc/dbconnection.php");
    require_once ("inc/function.php");
    //echo $_SESSION['mahima_session_user_type']; die;
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>  
    <link href   = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css" />
    <link href   = "css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel = "stylesheet" type = "text/css" />
    <script src  = "js/bootstrap.min.js" type = "text/javascript"></script>
    <script src  = "js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <script src  = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src  = "//code.jquery.com/jquery-1.10.2.js"></script>
    <script src  = "//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <link   rel  = "stylesheet" href="css/BeatPicker.min.css"/>
    <script src  = "js/jquery-1.11.0.min.js"></script>
    <script src  = "js/BeatPicker.min.js"></script>
    <script src  = "http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>

<script>
    function overlay(RecordId)
    {
        e1 = document.getElementById("overlay");
        document.getElementById("hidden_overlay").value = RecordId;
        e1.style.visibility = (e1.style.visibility == "visible") ? "hidden" : "visible";
    }
    function overlay(id) {
        el = document.getElementById("overlay");
        document.getElementById("hidden_overlay").value = id;
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
          document.getElementById("table_id").style.display = "none";
    }
    $(function () {

        $('.footer').hide();
    });
    function leaveDays(leave, emp_id) {//        alert("y");

        $.ajax({
            type: 'POST',
            url: "ajax_drop_leave_days.php",
            cache: false,
            data: {
                leave: leave, emp_id: emp_id
            },
            success: function (response)
            {
                document.getElementById('td_select').innerHTML = response;
                document.getElementById('edit_td_select').innerHTML = response;
            }
        });
    }
</script>
<?php
if (isset($_POST['send'])) {
    $leave_type     =    $_REQUEST['leave_type'];
    $txt_start_date =    $_POST['txt_start_date'];
    $txt_end_date   =    $_POST['txt_end_date'];

    $date1          =    date('Y-m-d', strtotime($txt_start_date));
    $date2          =    date('Y-m-d', strtotime($txt_end_date));
    $date1          =    date_create($date1);
    $date2          =    date_create($date2);
    $apply_days     =    date_diff($date1, $date2);
    $apply_days     =    $apply_days->format("%d");

    $reason         =    trim($_REQUEST['reason']);
    $leave_date     =    date('Y-m-d');

    $leave_addr     =    trim($_POST['leave_addr']);
    $current_date   =    date('Y-m-d');
    $phone_no       =    $_POST['phone_no'];
    $rec_id         =    $_SESSION['id'];
    $query          =    mysql_query("INSERT INTO mpc_leave_application (emp_id, leave_type, start_date, end_date, leave_reason, InsertDate, days, address, leave_date, contarct_no) VALUES ('$rec_id', '$leave_type', '$txt_start_date', '$txt_end_date ', '$reason', '$current_date', '$apply_days', '$leave_addr', '$leave_date', '$phone_no')");
    if (!$query) {
        $msg        = "Your leave is not forwarded plz try again...";
    }
    if ($query) {
        $message    = "Dear sir, \r\n I m " . $a . " and just want to inform u that i \r\n  will  not able to come office from " . $txt_start_date . " to " . $txt_end_date . " so plz approve my \r\n leave so plz mark my " . $typeleave . "  and the reason is that  " . $reason;
        $msg        = mail($email_to, $subject, $message);
    }
}

/* ______________________EDIT_______________________________ */

if (isset($_POST['edit_send'])) {
    $leave_id       =    $_POST['leave_id'];
    $leave_type     =    $_REQUEST['leave_type'];
    $txt_start_date =    $_POST['txt_start_date'];
    $txt_end_date   =    $_POST['txt_end_date'];
    
    $date1          =    date('Y-m-d', strtotime($txt_start_date));
    $date2          =    date('Y-m-d', strtotime($txt_end_date));
    $date1          =    date_create($date1);
    $date2          =    date_create($date2);
    $apply_days     =    date_diff($date1, $date2);
    $apply_days     =    $apply_days->format("%d");

    /*$leave_date     =    date('Y-m-d');
    $current_date   =    date('Y-m-d');*/
    $reason         =    trim($_REQUEST['reason']);
    $leave_addr     =    trim($_POST['leave_addr']);
    $phone_no       =    $_POST['phone_no'];
    $emp_id         =    $_SESSION['id'];
    //echo "UPDATE mpc_leave_application set start_date ='$txt_start_date',end_date ='$txt_end_date', leave_reason = '$reason',InsertDate = '$current_date' Where rec_id = '$leave_id' AND emp_id ='$emp_id '"; die();
     $query_edit    = mysql_query("UPDATE mpc_leave_application set leave_type = '$leave_type',start_date ='$txt_start_date',end_date ='$txt_end_date',days = '$apply_days',leave_reason = '$reason',InsertDate = '$current_date',address='$leave_addr' Where rec_id = '$leave_id' AND emp_id ='$emp_id'");
    if (!$query_edit) {
        $msg        = "Your leave is not forwarded plz try again...";
    }
    if ($query_edit) {
        $message    = "Dear sir, \r\n I m " . $a . " and just want to inform u that i \r\n  will  not able to come office from " . $txt_start_date . " to " . $txt_end_date . " so plz approve my \r\n leave so plz mark my " . $typeleave . "  and the reason is that  " . $reason;
        $msg        = mail($email_to, $subject, $message);
    }
}
?>
<!-- Saving Data in DB-->

<?php
    /* _____________DELETE________________ */

    if (isset($_POST["btn_del"])) {
        $PageKeyValue   = $_POST["hidden_overlay"];        
        $Message        = "Can Not Delete This Department Contain Sub department and dept alloted";
        if (isset($_POST["hidden_overlay"])) {
            $sql        =    "delete from mpc_leave_application where rec_id = '" . $PageKeyValue . "'";
            mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
            $Message    = "Leave+ Sucessfully Deleted";
        }
        redirect("user_leave.php?Message=$Message");
    }
    $pgName             =    "";
    $id                 =    $_GET["id"];
    $username           =    $_SESSION['user_mahima_session_user_name'];
    $query_emp_master   =    mysql_query("select ticket_no,rec_id from mpc_employee_master where username='$username'");
    $row_emp_master     =    mysql_fetch_array($query_emp_master);
    $emp_ticket_no      =    $row_emp_master['ticket_no'];
    $emp_rec_id         =    $row_emp_master['rec_id'];
    $_SESSION['id']     =    $emp_rec_id;
    $sql_emp_details    =   "SELECT mpc_employee_master.*,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail,mpc_official_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$emp_ticket_no' order by first_name";
    $result_emp_details =    mysql_query($sql_emp_details) or die("Error in : " . $sql_emp_details . "<br>" . mysql_errno() . " : " . mysql_error());
    $row_emp_details    =    mysql_fetch_array($result_emp_details);
    $emp_designation    =    $row_emp_details['designation'];
?>

<div style="float:left" >
    <table width="20%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snbuser.php"); ?></td>
        </tr>
    </table>
</div>
<table width="78%" cellpadding="0" cellspacing="0" align="center" border="0" >
    <tr>
        <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
    </tr>
    <tr>
        <td> 
            <p>
                <a  data-target="#applyLeaveModel" data-toggle="modal" href="#"  class="small-box-footer btn btn-warning" title="Apply for leave" >
                    Apply For Leave
                </a>
            </p>
        </td>
    </tr>
</table>
<div id="list" width="79%">
    <?= $_REQUEST['Message']; ?>
    <table width="79%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
        <thead class="blackHead" style="text-align: center">
            <tr>
                <th>S.No.</th>
                <th>No. of Days</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Leave Reason</th>
                <th>Leave Type</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody bgcolor="#F8F8F8" class="tableTxt" style="text-align: center">
            <?php
            $query_leave_details    =   "select mpc_leave_master.*,mpc_leave_application.rec_id as r_id,mpc_leave_application.* from mpc_leave_application,mpc_leave_master
                              where emp_id = '$emp_rec_id' AND mpc_leave_master.id =mpc_leave_application.leave_type";
            $sql_leave_details      =    mysql_query("$query_leave_details");
            $g                      =    1;
            $tot_leave_days         =    '';
            while ($row_leave_details = mysql_fetch_array($sql_leave_details)) {
                $app_id  =   $row_leave_details["r_id"];
                ?>
                <tr>
                    <td>
                        <?php
                        echo $g;
                        ?>
                    </td>
                    <td> <?php
                        echo $row_leave_details['days'];
                        $tot_leave_days +=   $row_leave_details['days'];
                        ?> </td>
                    <td><?php echo $row_leave_details['start_date']; ?></td>
                    <td><?php echo $row_leave_details['end_date']; ?></td>
                    <td><?php echo $row_leave_details['leave_reason']; ?></td>
                    <td><?php echo $row_leave_details['leave_name']; ?></td>
                    <td><?php
                        if ($row_leave_details['approved'] == 0) {
                            ?><b><?php echo "Not Approved"; ?></b><br>
                            <?php
                            echo $row_leave_details['cancle_reason'];
                        } else {
                            ?><b><?php echo "Approved"; ?></b><?php
                        }
                        ?></td>
                    <td>
                        <a  class="leave_id" data-target="#editLeaveModel<?php $g ?>" data-toggle="modal" href="" data-id = "<?php echo $row_leave_details['rec_id'];?>" class="small-box-footer btn btn-success" title="Edit leave application form" >
                            Edit
                        </a>
                        <a href="javascript:;" onClick="overlay(<?= $row_leave_details['rec_id'] ?>);">Delete</a>
                        <?php
                     $g++;
                  }
                ?>
                        <!--Edit model-->
                        <div class="modal fade" id="editLeaveModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel" align="center">EDIT LEAVE APPLICATION FORM</h4>

                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <table class="border" id = 'rep' cellspacing="2" cellpadding="2" border="0" align="center" style="padding-top:10px; width:100%; margin:5px;">          
                                              </table>  
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <table width="79%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
                    <tr>
                    <td>
                        <div id="overlay">
                            <div>
                                <p class="form_msg">Are you sure to delete this Leave</p>
                                <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                    <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
                                    <input type="submit" class="btn_bg1" name="btn_del" id="btn_del" value="Yes" />
                                    <input type="button" class="btn_bg1" onClick="overlay();" name="btn_close" value="No" />
                                </form>
                            </div>
                        </div>
                        
                    </td>
                </tr>
                </table>
         </table>
</div>

<!-- model-->
<div class="modal fade" id="applyLeaveModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" align="center">LEAVE APPLICATION FORM</h4>

            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <table class="border" cellspacing="2" cellpadding="2" border="0" align="center" style="padding-top:10px; width:100%; margin:5px;">          

                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
                                <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_rec_id; ?>"/>
                                Name 
                            </td>  
                            <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td>
                                <?php
                                //echo $squery = "Select first_name,last_name from mpc_employee_master where rec_id = $emp_rec_id";
                                $select_name    = mysql_query("Select first_name,last_name from mpc_employee_master where rec_id = $emp_rec_id");
                                $fetch_name     = mysql_fetch_array($select_name);
                                ?>
                                <input type="text"  name="emp_name" id="emp_name" value="<?php echo $fetch_name['first_name'] . " " . $fetch_name['last_name']; ?>" readonly/>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
                                Employee Code
                            </td>
                            <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td id="td_select">
                                <?php
                                $select_code    =    mysql_query("Select ticket_no from mpc_employee_master where rec_id = $emp_rec_id");
                                $fetch_code     =    mysql_fetch_array($select_code);
                                ?>
                                <input type="text" name="emp_code" id="emp_code"  value="<? echo $fetch_code['ticket_no']; ?>" readonly/>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
                                Designation
                            </td><td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td id="td_select">
                                <?php
                                $select_des = mysql_query("select designation from mpc_employee_master where rec_id = $emp_rec_id");
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
                                $select_dept    = mysql_query("select department from mpc_employee_master where rec_id = $emp_rec_id");
                                $fetch_dept     = mysql_fetch_array($select_dept);
                                ?>
                                <input type="text" name="emp_dept" id="emp_dept" value="<? echo $fetch_dept['department'];?>" readonly/>
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
                                    <option value="8">Pl</option>
                                    <option value="9">Cl</option>
                                    <option value="10">Sl</option>
                                    <option value="13">EL</option>
                                    <option value="14">C-Off</option>
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
                                <input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_start_date" id="txt_start_date"  data-beatpicker="true" value="" data-beatpicker-format="['YYYY','MM','DD']" />
                            </td>
                        <tr class="focus">
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
                                To

                            </td>
                            <td style="font-family:Verdana, Geneva, sans-serif;">
                                :
                            </td>
                            <td>
                                <input type="text" style="border:solid 1px #333; font-size:12px border-radius:5px; height:25px;" name="txt_end_date" id="txt_end_date" data-beatpicker="true" value="" data-beatpicker-format="['YYYY','MM','DD']"/>
                                <!--input type="date" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_end_date" id="txt_end_date" value=""/-->
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">
                                Reason
                            </td>
                            <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td>
                                <textarea style="border: 1px solid rgb(51, 51, 51); font-size:12px border-radius: 5px; width: 172px; height: 68px;" name="reason"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">Address during Leave</td>
                            <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td>
                                <textarea style="border: 1px solid rgb(51, 51, 51); border-radius: 5px; width: 172px; height: 68px; font-size:12px" name="leave_addr"></textarea></td>
                        </tr>
                        <tr>
                            <td style="font-family:Verdana, Geneva, sans-serif; font-size:12px">Telephone No.</td>
                            <td style="font-family:Verdana, Geneva, sans-serif;">:</td>
                            <td>
                                <?php
                                $select_tel = mysql_query("Select phone_no from mpc_employee_master where rec_id = $emp_rec_id");
                                $fetch_tel  = mysql_fetch_array($select_tel);
                                ?>
                                <input type="text" id="phone_no" name="phone_no" value="<?php echo $fetch_tel['phone_no']; ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="4">
                                <input type="hidden" name="ss" id="ss" value="<?php echo $id; ?>">
                                <input type="submit" style="border:solid 1px #333; border-radius:5px; height:25px;" value="Send" id="send" name="send">
                            </td>
                        </tr>
                        <br/>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php include("inc/hr_footer.php"); ?>
<script type="text/javascript">

   $(document).ready(function(){
    $('.leave_id').click(function(){
        var leave_id = $(this).attr('data-id');
        //$('.edit_id').text(leave_id);
        var emp_id = <?php  echo $_SESSION['id'];?>;
        $.ajax({
         url:"update_leave_ajax.php",
         type:'POST',
         data:{leave_id:leave_id,emp_id:emp_id},
         success:function(data){
            $('#rep').html(data);
         },
         error:function(e){
            alert("error");
         }

            });
        });
   });
</script>