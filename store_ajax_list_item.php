<? include("inc/dbconnection.php");?>
<? //include("inc/check_session.php");?>

<?
if(isset($_GET['letters'])){
	$letters = $_GET['letters'];
	//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "select ms_item_master.item_id,ms_item_master.name as ItemName,ms_item_master.drawing_number,
					ms_item_master.catelog_number,ms_item_master.closing_stock,
					ms_item_master.opening_quantity,ms_uom.name as UOM 
					from ms_item_master,ms_uom
					where ms_item_master.name like '".$letters."%' and ms_item_master.name!=''
					and ms_item_master.uom_id=ms_uom.uom_id 
					order by ms_item_master.name asc";
	#$sql = "select ms_item_master.item_id, ms_item_master.name as ItemName, ms_item_master.department_id as dep, ms_item_master.machinary_id as mac, ms_item_master.drawing_number, ms_item_master.catelog_number, ms_item_master.closing_stock, ms_item_master.opening_quantity, ms_uom.name as UOM from ms_item_master, ms_uom where ms_item_master.name like '".$letters."%' and ms_item_master.name!='' and ms_item_master.uom_id=ms_uom.uom_id order by ms_item_master.name asc";
	$res = mysql_query($sql) or die("Error in Query : ".$sql."<br/>".mysql_errno()."<br/>".mysql_error());
	?>
    
	<table border='1' cellpadding='0' cellspacing='0' width='600px' class='table1 text_1 innerTable'>
    <?
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	if(mysql_num_rows($res)>0)
	{
		
		echo "<tr><td class='gredBg' width='7%'>S No.</td>";
		echo "<td class='gredBg' width='9%'>Item Id</td><td class='gredBg' width='40%'>Name</td>";
		echo "<td class='gredBg' width='7%'>UOM</td><td class='gredBg' width='11%'>Drg No.</td>";
		echo "<td class='gredBg' width='10%'>Cat No.</td><td class='gredBg' width='8%'>Op.Stk</td>";
		echo "<td class='gredBg' width='8%'>Stock</td></tr>";
		$i=1;
		$n=mysql_num_rows($res);
		while($inf = mysql_fetch_array($res))
		{
			$Name=$inf["ItemName"];
			$ItemName=$Name;
			if($Name!="")
			{
				$pos = strpos($ItemName, "\"");
				if($pos>0)
					$ItemName=htmlspecialchars($Name);
				$pos1 = strpos($ItemName, '\'');
				if($pos1>0)
					$ItemName=addslashes($Name);
			}
			//$ItemName=addslashes($ItemName);
			?>
			<tr class="normalROW" 
      onclick="setItemId(<?=$inf["item_id"]?>,'<?=$ItemName?>','<?=$inf["UOM"]?>','<?=$inf["drawing_number"]?>','<?=$inf["catelog_number"]?>','<?=$inf["opening_quantity"]?>','<?=$inf["closing_stock"]?>')">
			<? /* mouseoverTR(this.id,<?=$n?>)var current_row='<?=$i?>'*/ ?>
        <td align='center' width="50px"><?=$i?></td>
        <td align='center' width="50px"><?=$inf["item_id"]?></td>
        <td align='left' style='padding-left:3px;'>
        	<div style="overflow:hidden;"><?=$ItemName?></div>
        </td>
        <td align='center'  width="50px"><?=$inf["UOM"]?></td>
        <td align='center' width="100px"><?=$inf["drawing_number"]?></td>
        <td align='center' width="100px"><?=$inf["catelog_number"]?></td>
        <td align='center' width="50px"><?=$inf["opening_quantity"]?></td>
        <td align='center' width="50px"><?=$inf["closing_stock"]?></td>
			</tr>
			<?
				$i++;
		}	
		
	}
	else
	{
		echo "<tr><td align='center' colspan='6'><b>No Record Found</b></td></tr>";
	}	
	?>
    </table>
    <?
}
?>