<?php

include("inc/check_session.php");
include("inc/adm_function.php");

session_start();
if (session_destroy()) {
    header("Location: index.php");
}
if (session_register("mahima_session_user_type")) {
    $lower_user_type = $_SESSION["mahima_session_user_type"];
    session_unregister($lower_user_type . '_mahima_session_rec_id');
    session_unregister($lower_user_type . '_mahima_session_user_name');
    session_unregister($lower_user_type . '_mahima_session_user_type');

    session_unset();
    session_destroy();
    redirect("index.php");
}
?>
