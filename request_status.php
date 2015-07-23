<?php
include ("inc/hr_header.php");
$con = @mysql_connect('localhost', 'ssofts_lss', 'ssoftslss')or die("Couldn't connect to server.");
$db = mysql_select_db('ssofts_adminlss', $con)or die("Couldn't select database.");
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <?php include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
                            <thead class="blackHead" style="text-align: center">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Request Reason</th>
                                    <th>Request Description</th>
                                    <th>Date Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                $self = $_SERVER['PHP_SELF'];
                                $self = explode("/", $self);
                                $select_req = mysql_query("Select * From request where status = 1 AND edit_status = 0 AND plant_name = '$self[1]'");
                                while ($fetch_req = mysql_fetch_array($select_req)) {
                                    if ($fetch_req['status'] == 1) {
                                        $sql = "select *,plant_hr.rec_id as plant_id from plant_hr,plant where plant_hr.plant_id = plant.rec_id AND plant.plant_name = '$fetch_req[plant_name]'";
                                        $result = mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                        $row = mysql_fetch_array($result);
                                        ?>
                                        <tr>
                                            <td class="Text01"><?= $sno ?></td>
                                            <td class="Text01"><?= $fetch_req['request_reason'] ?></td>
                                            <td class="Text01"><?= $fetch_req['request_description'] ?></td>
                                            <td class="Text01"><?= $fetch_req['request_date'] ?></td>
                                            <td class="Text01">
                                                <?php
                                                $page = $fetch_req['request_page'];
                                                $url = $page;
                                                ?> 
                                                <form name="request_form" id="request_form" method="post" action="<?= $url . '&re=1' ?>" >
                                                    <input type="hidden" name="rec_id" id="rec_id" value="<?= $fetch_req['rec_id'] ?>"/>
                                                    <input type="hidden" name="url" id="url" value="<?= $url ?>"/>
                                                    <button type="button" name="editReq" id="edit" value="Edit" onclick="changeStatus('<?= $fetch_req['rec_id'] ?>')">Edit</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                        $sno++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr> 
</table>
<script>
    function changeStatus(val) {
        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request")
            return
        }
        var url = "change_status.php?id=" + val;
        xmlHttp.onreadystatechange = function ()
        {
            if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
            {
//                alert(xmlHttp.responseText);
                if (xmlHttp.responseText == '') {
                    document.getElementById("request_form").submit();
                }

            }
        };

        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }

</script>    