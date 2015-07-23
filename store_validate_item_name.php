<?
include("inc/dbconnection.php");

if(isset($_REQUEST['value'])) 
	$value=$_REQUEST['value'] ;
else 
  $value="" ;
if(isset($_REQUEST['byControl']))
	$byControl=$_REQUEST['byControl'] ;
else	
	$byControl= "" ;
$Name='';
$DrawingNumber='';
$CatelogNumber='';
if($value!="")
{
	if($byControl=="Name")
		$Name="where name='".$value."'";
	if($byControl=="DrawingNumber")
		$DrawingNumber="where drawing_number='".$value."'";
	if($byControl=="CatelogNumber")
		$CatelogNumber="where catelog_number='".$value."'";
	$sql="select * from ms_item_master $Name $DrawingNumber $CatelogNumber";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0)
		echo "Value Already Exists.<br />Please Change This Value To Save Item. ";
}
?>