<?php
if(isset($_GET['last_msg_id']))
{
	$last_msg_id=$_GET['last_msg_id'];
	$action=$_GET['action'];
}
if($action == "get")
{

	include('load__releaved_second.php');		
}
?>