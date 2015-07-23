<? include ("inc/dbconnection.php"); ?>
<?
$id = "";
//echo "test";
$id = $_GET["id"];
$sql = "SELECT * FROM mpc_state_master where country_id = '$id' order by state_name";

$result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
if (mysql_num_rows($result) > 0) {
    ?>

                            <!--select name="<?= $_GET["str"] ?>" id="<?= $_GET["str"] ?>" onchange="getCity('get_city_reg.php', this.value, 'div_city', 'city_select');"-->
    <select name="state" id="state" onchange="getCity(this.value);">
        <option value="">--select state--</option>
        <?
        while ($row = mysql_fetch_array($result)) {
            ?>
            <option value="<?= $row['rec_id'] ?>">
                <?= $row["state_name"] ?>
            </option>
            <?
        }
        ?>
    </select>

    <?
} else {
    ?>
    <input type="text" name="txt_other_state" id="txt_other_state" value="">	
    <?
}
?>
<script>

</script>																				