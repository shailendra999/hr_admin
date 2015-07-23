<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
$conn=odbc_connect('mahima','','');
if (!$conn)
  {exit("Connection Failed: " . $conn);}
$sql="SELECT * FROM LedgerMas";
$rs=odbc_exec($conn,$sql);
if (!$rs)
  {exit("Error in SQL");}
echo "<table><tr>";
echo "<th>LedgerCode/th>";
echo "<th>LedgerName</th></tr>";
while (odbc_fetch_row($rs))
{
  $compname=odbc_result($rs,"LedgerCode");
  $conname=odbc_result($rs,"LedgerName");
  echo "<tr><td>$compname</td>";
  echo "<td>$conname</td></tr>";
}
odbc_close($conn);
echo "</table>";

?>
</body>
</html>
