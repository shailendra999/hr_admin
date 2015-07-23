<?
$mysql_server="192.168.1.5:8802";						///  MYSQL Server host name
$mysql_server_login = "mahimagroup";							///	 MYSQL Server Login ID
$mysql_server_password = "Mahima123";					///	 MYSQL Server Password
$mysql_database = "mahimagroup";	

$mysqlConnection = mysql_connect($mysql_server, $mysql_server_login, $mysql_server_password, true);
$mysqlDB = mysql_select_db($mysql_database, $mysqlConnection);


$qry = 'select * from mpc_attendence_master';
$rs = mysql_qury($qry, $mysqlConnection);
while($row = mysql_fetch_array($rs)){
	print_r($row);
}die;



?>