<? include ("inc/dbconnection.php"); ?>
<?
$id = "";
$id = $_GET["id"];
$sql = "SELECT * FROM  " . $mysql_table_prefix . "city_master where state_id = '$id' order by city_name ";
$result_city = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
if (mysql_num_rows($result_city) > 0) {
    ?>
    <select name="<?= $_GET["str"] ?>" id="<?= $_GET["str"] ?>">
        <option value="">--Select--</option>
        <?
        while ($row_city = mysql_fetch_array($result_city)) {
            ?> 
            <option value="<?= $row_city['rec_id'] ?>"><?= $row_city['city_name'] ?></option>
            <?
        }
        ?>
    </select>
    <?
} else {
    ?>
    <input type="text" name="other_city" id="other_city" value="">	

    <?
}
?>	
