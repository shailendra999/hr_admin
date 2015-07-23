<?php
$number = $_REQUEST['number'];
?>
<select name="monthly_applicable" id="monthly_applicable">
    <?php
    for ($i = 0; $i <= $number; $i++) {
        ?>
        <option value='<?= $i ?>'><?= $i ?></option>
        <?php
    }
    ?>
</select>

