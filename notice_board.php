<?
	include("inc/hr_header.php");
?>

<style>
span.validate  {color:#FF0000;padding-left:8px;font-style:italic;cursor:text;font-size:12px;}
span.validate1  {color:#4db84d;padding-left:8px;font-style:italic;cursor:text;font-size:12px;}
.btn { 
	background: none repeat scroll 0 0 #f87340;
    border: 1px solid #ff3300;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-weight: bolder;
	padding:5px 10px;
}
.dlt { 
	background: none repeat scroll 0 0 #CCCCCC; border: 1px solid #323232; border-radius: 3px; color: #000;  font-weight: bolder; padding:0 5px; text-align:center; text-decoration:none;
}
table{ margin-top:10px;}
.tbnoticeboard{ margin:0; padding:0;}
.tbnoticeboard tr td,th{padding:10px 0; font:normal 13px/16px "Lucida Sans Unicode", "Lucida Grande", sans-serif !important;font-size:15px;color:#333;border:1px solid #d6d6d6;}
.tbnoticeboard tr td{ text-align:left; padding-left:10px; padding-right:10px;}
.tbnoticeboard tr th{ background:#205790; color:#fff !important;}
.tbnoticeboard tr:nth-child(2n+1){ background:#eef7c8;}
.tbnoticeboard tr:nth-child(2n+2){ background:#e2ebbe;}
</style>

<?
	if(isset($_POST['Submit_notice']))
	{ 
		$noticeDate = date("Y.m.d");
		$notices = $_POST['notices'];
		$insertNotice = "INSERT INTO notice_board (notices, date) VALUES ('".$notices."', '".$noticeDate."')";
		$result = mysql_query($insertNotice) or die("Error in query:".$insertNotice."<br>".mysql_error()."<br>".mysql_errno());
	}
	
	$selectNotice = "SELECT * FROM notice_board";
	$data = array();
	$result = mysql_query ($selectNotice) or die ("Error in : ".$selectNotice."<br>".mysql_errno()." : ".mysql_error());
	while($row = mysql_fetch_assoc($result))
	{
		
		$data[] = $row;
	}
	
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$deleteNotice = "delete from notice_board WHERE id = ".$id;
		$result = mysql_query($deleteNotice) or die("Error in query:".$deleteNotice."<br>".mysql_error()."<br>".mysql_errno());
	}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#f3fbd2">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px; float:left !important;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg" style="border-bottom: 6px solid #fff;">Notice board
                    </td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                     <form id="frm_notices" name="frm_notices" method="post" action="notice_board.php" style="background:#f3fbd2;">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="left" bgcolor="#f3fbd2">
                            <tr>
                            <td align="left" style="padding:0 0 0 20px;">
                            <h1 style="margin:0; font-size:15px; color:#554d47; padding-bottom:10px;">Notice</h1>
                            <p style=" margin:0; padding:0;">
                            	<span class="val_1"></span>
                                <span class="val_2"></span>
                                <span class="val_3"></span>
                                
                            </p>
                            <textarea name="notices" id="notice_board" ROWS="8" COLS="50" style="border:1px solid #ff3300;border-radius:5px; padding:10px;"></textarea>
                            <br />
                            <div id="textarea_notice" style="text-align:left;color:#554d47;font-size:13px;width:715px;"></div>
                            <br />
                            <input type="submit" value="Submit" name="Submit_notice" id="Submit_notice" class="btn_bg"/>
                            </td>
                            </tr>
                        </table>
						</form>
                    </td>
                </tr>
            </table>
            <table bgcolor="#f3fbd2" style="border:1px solid #d6d6d6; margin-left:20px; margin-bottom:10px; border-collapse:collapse; margin-top:10px;" cellpadding="0" cellspacing="0" class="tbnoticeboard">
            	<thead>
                <tr>
                	<th width="5%" style="font-size:16px;color:#333;text-align:center; border:1px solid #d6d6d6;"><strong> S. No </strong></th>
                    <th width="75%" style="font-size:16px;color:#333;text-align:center;border:1px solid #d6d6d6;"><strong> Notice </strong></th>
                    <th width="15%" style="font-size:16px;color:#333;text-align:center;border:1px solid #d6d6d6;"><strong> Date </strong></th>
                    <th width="10%" style="font-size:16px;color:#333;text-align:center;border:1px solid #d6d6d6;"><strong> Delete </strong></th>
                </tr>
                </thead>
                <tbody>
				<? 
				$i = 1;
				foreach($data as $d) { ?>
                <tr>
                	<td> <? echo $i; ?> </td>
                    <td> <? echo $d['notices']; ?> </td>
                    <td> <? echo $d['date']; ?> </td>
                    <td style="text-align:center !important; padding-left:0 !important; padding-right:0 !important;">
                    <a href="notice_board.php?id=<? echo $d['id']; ?>" id="<? echo $d['id']; ?>"><img src="images/delete.png" /></a>
                    </td>
                </tr>
                <? $i++; } ?> 
                </tbody>
            </table>
        </td>
    </tr>
</table>

<? include ("inc/hr_footer.php"); ?>	
<script type="text/javascript" src="//code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function(){
   	var max = 1000;
    $('#notice_board').keypress(function(e) {
        if (e.which < 0x20)
		{
            return;
        }
        if (this.value.length == max)
		{
            e.preventDefault();
        }
		else if (this.value.length > max)
		{
            this.value = this.value.substring(0, max);
        }
    });
});
</script>
<script>
$(document).ready(function(){
    var text_max = 1000;
    $('#textarea_notice').html(text_max + ' characters remaining');
	var text_length = $('#notice_board').val().length;
    var text_remaining = text_max - text_length;
	$('#textarea_notice').html(text_remaining + ' characters remaining');
	
    $('#notice_board').keyup(function() {
        var text_length = $('#notice_board').val().length;
        var text_remaining = text_max - text_length;
        $('#textarea_notice').html(text_remaining + ' characters remaining');
    });
});
</script>
<script>
$(document).ready(function(){
	 $('#Submit_notice').click(function() {
	 	var notice = $('#notice_board').val();
		if(notice == '')
		{
			$("span.val_1").html("* This field is required.").addClass('validate');
			return false;
		}
		else
		{
			$("span.val_2").html("* Data insert successfull.").addClass('validate1');
		}
	 });
});
</script>

<script>
$(document).ready(function(){
	$('.dlt').click(function(){
		var id = $(this).attr('id');
		if(id != '')
		{
			$("span.val_3").html("* Record deleted successfull.").addClass('validate');
			location.reload();
		}
	});
});
</script>

<script>
    $(document).ready(function() {
        $ ('tr:even').css({'background-color':''});
    });
</script>