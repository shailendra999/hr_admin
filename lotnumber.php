<?
include('inc/check_session.php');
include('inc/dbconnection.php');
?>
<link href="style/adm0_style.css" rel="stylesheet" type="text/css" />
<script>
function addElement() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = "<table align='center' width='100%' border ='0' cellpadding='1' cellspacing='1'><tr><td align='center'><input type='text' name='txt_lotno[]' id='txt_lotno[]'></td><td align='center'><input type='text' name='txt_nopck[]' id='txt_nopck[]'></td><td align='center'><input type='text' name='txt_totalkgs[]' id='txt_totalkgs[]'></td><td align='center'><input type='text' name='txt_idmarks[]' id='txt_idmarks[]'></td><td class='delete'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
  ni.appendChild(newdiv);

}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
	d.removeChild(olddiv);
}
</script>
<?
if(isset($_GET['detailid']))
{
	
	$detailid = $_GET['detailid'];
}
?>
<SCRIPT language=JavaScript>
<!-- 
function win(){
window.opener.location.href="dispatch.php?id=<?=$_GET['pi_id']?>&mode=lot&detailid=<?=$detailid?>";
self.close();
//-->
}
</SCRIPT>

<?
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$edit_id = $_POST['edit_id'];
		if($edit_id == '')
		{
			if(isset($_POST['txt_nopck'])){$count=count($_POST['txt_nopck']);}
			for($i=0; $i<$count; $i++)
			{	
				$lotno = $_POST['txt_lotno'][$i];
				$noofpck = $_POST['txt_nopck'][$i];
				$totalkgs = $_POST['txt_totalkgs'][$i];
				$idmarks = $_POST['txt_idmarks'][$i];
				
				$sql_ins = "insert into ".$mysql_adm_table_prefix."lot_master set 
																					PiDetailId = '$detailid',
																					LotNumber = '$lotno',
																					NoOfPck = '$noofpck',
																					TotalKgs = '$totalkgs',
																					IdentificationMarks = '$idmarks',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
			   $result_ins = mysql_query($sql_ins) or die("Error in Query : ".$sql_ins."<br/>".mysql_error()."<br/>".mysql_errno());
			   $_SESSION['no_refresh'] = $_POST['no_refresh'];	
			  /* echo "<script language='javascript'>";
				echo "win()";
				echo "</script>";	*/																
			}
		}
		else
		{
			 $sql_del = "delete from ".$mysql_adm_table_prefix."lot_master where PiDetailId = '$edit_id' ";
		   	 $result_del = mysql_query($sql_del) or die("Error in Query: ".$sql_del."<br/>".mysql_error()."<br/>".mysql_errno());
			 
			 if(isset($_POST['txt_nopck'])){$count=count($_POST['txt_nopck']);}
			 for($i=0; $i<$count; $i++)
			 {	
				$lotno = $_POST['txt_lotno'][$i];
				$noofpck = $_POST['txt_nopck'][$i];
				$totalkgs = $_POST['txt_totalkgs'][$i];
				$idmarks = $_POST['txt_idmarks'][$i];
				
				if($lotno!='' and $noofpck!='' and $totalkgs!='' and $idmarks!='')
				{
					echo $sql_up= "insert into ".$mysql_adm_table_prefix."lot_master set 
																					PiDetailId = '$edit_id',
																					LotNumber = '$lotno',
																					NoOfPck = '$noofpck',
																					TotalKgs = '$totalkgs',
																					IdentificationMarks = '$idmarks',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
					mysql_query($sql_up) or die("Error in query".mysql_errno().":".mysql_error());
					 $_SESSION['no_refresh'] = $_POST['no_refresh'];
					 
					/*echo "<script language=javascript>";
					echo "win()";
					
					echo "</script>";*/

				}
		    }
		
		}	
	}
}
?>	
<form action="" method="post" name="frm_lot" id="frm_lot">
<table align="center" width="98%" cellpadding="1" cellspacing="1" style="border:#DFEAF7 solid 1px;">
    <tr class="gredBg">
    	<td>Lot Number</td>
        <td>No Of Packs</td>
        <td>Total Kgs</td>
        <td>Identification Marks</td>
        <td></td>
    </tr>
		<?
        $lot_no = '';
        $no_pck = '';
        $total_kgs = '';
        $id_marks = '';
        if($_GET['detailid'])
        {
            $sql_1 = "select * from ".$mysql_adm_table_prefix."lot_master where PiDetailId  = '".$_GET["detailid"]."' ";
            $result_1 = mysql_query($sql_1) or die("Error in sql : ".$sql_1." : ".mysql_errno()." : ".mysql_error());
            if(mysql_num_rows($result_1)>0)
            {
                while($row_1 = mysql_fetch_array($result_1))
                {
                    $lot_no = $row_1['LotNumber'];
                    $no_pck = $row_1['NoOfPck'];
                    $total_kgs = $row_1['TotalKgs'];
                    $id_marks = $row_1['IdentificationMarks'];
        ?>
	 <tr>
    	<td align="center"><input type="text" name="txt_lotno[]" id="txt_lotno[]" value="<?=$lot_no?>"></td>
        <td align="center"><input type="text" name="txt_nopck[]" id="txt_nopck[]" value="<?=$no_pck?>"></td>
        <td align="center"><input type="text" name="txt_totalkgs[]" id="txt_totalkgs[]" value="<?=$total_kgs?>"></td>
        <td align="center"><input type="text" name="txt_idmarks[]" id="txt_idmarks[]" value="<?=$id_marks?>"></td>
     </tr>
		<?
                }
            }
        }
        ?>		
       
    <tr>
    	<td align="center"><input type="text" name="txt_lotno[]" id="txt_lotno[]"></td>
        <td align="center"><input type="text" name="txt_nopck[]" id="txt_nopck[]"></td>
        <td align="center"><input type="text" name="txt_totalkgs[]" id="txt_totalkgs[]"></td>
        <td align="center"><input type="text" name="txt_idmarks[]" id="txt_idmarks[]"></td>
        <td align="center">
         <input type="hidden" name="h_hidden" id="h_hidden"/> 
        <a href="javascript:;"  onclick="addElement();"><img src="images/add_icon.jpg" border="0"/></a>
        </td>
    </tr>
    <tr>
        <td colspan="5">
            <div id="myDiv1"></div>
        </td>
    </tr>
    <tr>
    	<td colspan="5" align="center">
        	<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
            <input type="hidden" name="edit_id" id="edit_id" value="<?=$_GET['detailid']?>" />
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit"/>
        </td>
    </tr>          
</table>      
</form>  