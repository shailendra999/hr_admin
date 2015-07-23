<?
session_start();
include('inc/dbconnection.php');
include('inc/adm_function.php');
$result_current =array(); 
if(isset($_GET['pi_id']))
{
	$pi_id = $_GET['pi_id'];
	
	$sql = "select * from ".$mysql_adm_table_prefix."pi_master where rec_id = '$pi_id'";
	$result = mysql_query($sql) or die("Error in Query: ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
	$row = mysql_fetch_array($result);
	$pi_number = $row['PiNumber'];
	$pi_date = getDateFormate($row['PiDate'],1);
	$buyername = getBuyer('BuyerName','rec_id',$row['BuyerId']);
	$buyercountry = getCountry(getBuyer('CountryId','rec_id',$row['BuyerId']));

	$strContent = '<HTML>
    <body>
		 <table align="center" width="100%" cellspacing="0" cellpadding="0" class="border">
            <tr>
				<td align="center" colspan="2" style="border-bottom:#000000 solid 1px;"><span><b>PROFORMA INVOICE</b></span></td>
			</tr>
			<tr>
				<td width="60%" valign="top" style="border-right:#000000 solid 1px">
				</td>
				<td valign="top">
				</td>			
			</tr>											
	    </table>
	</body>
	</html>	';
	
}
?>
<?	
if(isset($_GET['pdf']))
	{
		require('pdf/html2fpdf.php');
		$pdf=new HTML2FPDF();
		$pdf->AddPage();
		$pdf->WriteHTML($strContent);
		$pdf->Output("pdf/pi_pdf.pdf",'D');
	}
?>	
