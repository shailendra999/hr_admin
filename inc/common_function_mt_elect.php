<?
function redirect($page_name)
{
	echo "<script language='javascript'>";
	echo "document.location='".$page_name."';";
    echo "</script>";
}
?>
<?
function addDataIntoTable($tableName,$tableData)
{
	$generateQuery="";
	$generateQuery="insert into ".$tableName." values(";
	for($i=0;$i<sizeof($tableData);$i++)
	{
		if($i==sizeof($tableData)-1)
			$generateQuery.=$tableData[$i];
		else
			$generateQuery.=$tableData[$i].', ';
	}
	$generateQuery.=")";
	$result=mysql_query($generateQuery) or die ("Error in : ".$generateQuery."<br>".mysql_errno()." : ".mysql_error());
	//echo $generateQuery."<br />";////
	return $result;//1;//
}
?>
<?
function updateDataIntoTable($tableName,$columNames,$tableData)
{
	$generateQuery="";
	$generateQuery="update ".$tableName." set ";
	for($i=1;$i<sizeof($tableData);$i++)
	{
		if($i==sizeof($tableData)-1)
			$generateQuery.=$columNames[$i]."=".$tableData[$i];
		else
			$generateQuery.=$columNames[$i]."=".$tableData[$i].', ';
	}
	$generateQuery.=" where ".$columNames[0]."=".$tableData[0];
	$result=mysql_query($generateQuery)  or die ("Error in : ".$generateQuery."<br>".mysql_errno()." : ".mysql_error());
	//echo $generateQuery."<br />";
	return $result;//1;//
}
?>

<?
///////////Get MM/DD/YYY date Format///////////
function getDateFormate($date)
{
	$getDate="";
	if($date!="")
	{
		$date = explode("-", $date);
		$getDate = $date[2]."-".$date[1]."-".$date[0];
	}
	return $getDate;
}
?>